<?php

namespace App\Http\Controllers\Frontend\Tour;

use App\Exceptions\GeneralException;
use App\Models\Tour\TourCity;
use App\Models\Tour\TourHotelCategory;
use App\Models\Tour\TourCustomerType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tour\TourHotel;

class HotelController extends Controller
{
    protected $tour_hotel;


    public function index(Request $request)
    {
        $city_id = $this->getCityId($request);

        $city_name = TourHotel::getCityName($city_id, __('labels.frontend.tours.all_cities'));

        $city_param = !is_null($city_id) ? 'city_id=' . $city_id : '';

        $items = [];

        if (!is_null($city_id)) {

            $city = TourCity::where('id', $city_id)->firstOrfail();
            $items[] = $city->hotels->sortBy('name');

        } else {

            $cities = TourCity::with(['hotels' => function ($query) {
                $query->orderBy('name', 'asc');
            }])->orderBy('name', 'asc')->get()->flatten();

            foreach ($cities as $city) {
                $items[] = $city->hotels;
            }

        }
        $deleted = TourHotel::onlyTrashed()->get();

        $cities_names = TourHotel::getCitiesAttribute();

        $cities_select = TourHotel::getCitiesOptgroupAttribute(__('validation.attributes.frontend.general.select'));

        return view('frontend.tour.hotel.index', compact('items','cities_names', 'cities_select','deleted'))
            ->with('city_id', (int)$city_id)
            ->with('city_name', $city_name)
            ->with('city_param', $city_param)
            ->with('object', 'hotel');
    }

    public function show($id)
    {
        //
    }

    public function create(Request $request)
    {
        $city_id = $this->getCityId($request);
        $cities_options = TourHotel::getCitiesOptgroupAttribute(__('validation.attributes.frontend.general.select'));

        $hotel_categories = TourHotelCategory::getHotelCategoriesAttribute(__('validation.attributes.frontend.general.select'));

        return view('frontend.tour.hotel.create', compact('cities_options', 'hotel_categories'))->with('city_id', (int)$city_id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'city_id' => 'exists:tour_cities,id',
            'category_id' => 'exists:tour_hotel_categories,id',
        ]);

        $tour_hotel = new TourHotel($request->all());

        $tour_hotel->save();

        return redirect()->route('frontend.tour.hotel.index')->withFlashSuccess(__('alerts.general.created'));
    }


    public function edit($id)
    {
        $item = TourHotel::findOrFail($id);

        $attributes = $item->objectables->toArray();

        $attributes = !empty($attributes) ? $attributes : [0 => ['id' => 0]];

        $cities_options = TourHotel::getCitiesOptgroupAttribute(__('validation.attributes.frontend.general.select'));

        $customer_type_options = TourCustomerType::getCustomerTypesAttribute(__('validation.attributes.frontend.general.select'));

        $hotel_categories = TourHotelCategory::getHotelCategoriesAttribute(__('validation.attributes.frontend.general.select'));

        return view('frontend.tour.hotel.edit', compact('item', 'cities_options', 'hotel_categories', 'customer_type_options', 'attributes'));
    }


    public function update(Request $request, $id)
    {
        if($request->get('attribute')){
            $request->validate([
                'attribute.*.name' => 'required|min:3',
                'attribute.*.price'=> 'required',
                'attribute.*.customer_type_id' => 'nullable|exists:tour_customer_types,id',
            ]);
        } else {
            $request->validate([
                'name' => 'required',
                'city_id' => 'exists:tour_cities,id',
                'category_id' => 'exists:tour_hotel_categories,id',
            ]);
        }

        $tour_hotel = TourHotel::findOrFail($id);

        $tour_hotel->update($request->all());

        $tour_hotel->saveObjectAttributes($request->get('attribute'));

        return redirect()->back()->withFlashSuccess(__('alerts.general.updated'));
    }


    public function destroy($id)
    {
        $tour_hotel = TourHotel::findOrFail($id);
        $tour_hotel->delete();

        return redirect()->route('frontend.tour.hotel.index')->withFlashWarning(__('alerts.general.deleted'));
    }


    public function restore($id)
    {
        $tour_hotel = TourHotel::withTrashed()->find($id);

        if ($tour_hotel->deleted_at === null) {
            throw new GeneralException(__('exceptions.frontend.tours.cant_restore'));
        }

        if ($tour_hotel->restore()) {
            return redirect()->route('frontend.tour.hotel.index')->withFlashSuccess(__('alerts.general.restored'));
        }

        throw new GeneralException(__('exceptions.frontend.tours.restore_error'));
    }

    public function delete($id)
    {
        $tour_hotel = TourHotel::withTrashed()->find($id);

        if ($tour_hotel->deleted_at === null) {
            throw new GeneralException(__('exceptions.frontend.tours.cant_restore'));
        }

        $tour_hotel->forceDelete();

        return redirect()->route('frontend.tour.hotel.index')->withFlashSuccess(__('alerts.general.deleted_permanently'));
    }


    public function getCityId(Request $request)
    {
        $city_ids = TourHotel::getCityIds();
        return $request->has('city_id') && $request->query('city_id') != 0
        && in_array($request->query('city_id'), $city_ids) ? $request->query('city_id') : null;
    }
}
