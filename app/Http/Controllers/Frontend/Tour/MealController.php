<?php

namespace App\Http\Controllers\Frontend\Tour;

use App\Exceptions\GeneralException;
use App\Models\Tour\TourCity;
use App\Models\Tour\TourCustomerType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tour\TourMeal;

class MealController extends Controller
{
    protected $tour_meal;


    public function index(Request $request)
    {
        $city_id = $this->getCityId($request);

        $city_name = TourMeal::getCityName($city_id, __('labels.frontend.tours.all_cities'));

        $city_param = !is_null($city_id) ? 'city_id=' . $city_id : '';

        $orderBy = 'name';
        $sort = 'asc';

        if (!is_null($city_id)) {

            $items = TourMeal::where('city_id', $city_id)->orderBy($orderBy, $sort)->paginate();

        } else {

            $items = TourMeal::orderBy($orderBy, $sort)->paginate();

        }

        $deleted = TourMeal::onlyTrashed()->get();

        $cities_names = TourMeal::getCitiesAttribute();

        $cities_select = TourMeal::getCitiesOptgroupAttribute(__('validation.attributes.frontend.general.select'));

        return view('frontend.tour.meal.index', compact('items','cities_names', 'cities_select','deleted'))
            ->with('city_id', (int)$city_id)
            ->with('city_name', $city_name)
            ->with('city_param', $city_param)
            ->with('object', 'meal');
    }

    public function show($id)
    {
        //
    }

    public function create(Request $request)
    {
        $city_id = $this->getCityId($request);
        $cities_options = TourMeal::getCitiesOptgroupAttribute(__('validation.attributes.frontend.general.select'));

        return view('frontend.tour.meal.create', compact('cities_options'))->with('city_id', (int)$city_id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'city_id' => 'exists:tour_cities,id',
        ]);

        $tour_meal = new TourMeal($request->only('name', 'city_id', 'description', 'qnt'));

        $tour_meal->save();

        return redirect()->route('frontend.tour.meal.index')->withFlashSuccess(__('alerts.general.created'));
    }


    public function edit($id)
    {
        $item = TourMeal::findOrFail($id);

        $attributes = $item->objectables->toArray();

        $attributes = !empty($attributes) ? $attributes : [0 => ['id' => 0]];

        $cities_options = TourMeal::getCitiesOptgroupAttribute(__('validation.attributes.frontend.general.select'));

        $customer_type_options = TourCustomerType::getCustomerTypesAttribute(__('validation.attributes.frontend.general.select'));

        return view('frontend.tour.meal.edit', compact('item', 'cities_options', 'customer_type_options', 'attributes'));
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
            ]);
        }

        $tour_meal = TourMeal::findOrFail($id);

        $tour_meal->update($request->only('name', 'city_id', 'description', 'qnt'));

        $tour_meal->saveObjectAttributes($request->get('attribute'));

        return redirect()->back()->withFlashSuccess(__('alerts.general.updated'));
    }


    public function destroy($id)
    {
        $tour_meal = TourMeal::findOrFail($id);
        $tour_meal->delete();

        return redirect()->route('frontend.tour.meal.index')->withFlashWarning(__('alerts.general.deleted'));
    }


    public function restore($id)
    {
        $tour_meal = TourMeal::withTrashed()->find($id);

        if ($tour_meal->deleted_at === null) {
            throw new GeneralException(__('exceptions.frontend.tours.cant_restore'));
        }

        if ($tour_meal->restore()) {
            return redirect()->route('frontend.tour.meal.index')->withFlashSuccess(__('alerts.general.restored'));
        }

        throw new GeneralException(__('exceptions.frontend.tours.restore_error'));
    }

    public function delete($id)
    {
        $tour_meal = TourMeal::withTrashed()->find($id);

        if ($tour_meal->deleted_at === null) {
            throw new GeneralException(__('exceptions.frontend.tours.cant_restore'));
        }

        $tour_meal->forceDelete();

        return redirect()->route('frontend.tour.meal.index')->withFlashSuccess(__('alerts.general.deleted_permanently'));
    }


    public function getCityId(Request $request)
    {
        $city_ids = TourMeal::getCityIds();
        return $request->has('city_id') && $request->query('city_id') != 0
        && in_array($request->query('city_id'), $city_ids) ? $request->query('city_id') : null;
    }
}
