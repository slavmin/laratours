<?php

namespace App\Http\Controllers\Frontend\Tour;

use App\Exceptions\GeneralException;
use App\Filters\ObjectsFilter;
use App\Models\Tour\TourHotelCategory;
use App\Models\Tour\TourCustomerType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tour\TourHotel;

class HotelController extends Controller
{
  protected $tour_hotel;

  protected $city_id;


  public function index(Request $request)
  {
    $city_id = $this->getCityId($request);

    $city_name = TourHotel::getCityName($city_id, __('labels.frontend.tours.all_cities'));

    $city_param = !is_null($city_id) ? 'city_id=' . $city_id : [];

<<<<<<< HEAD
        $name_param = !is_null($request->name) ? $request->name : '';

        $orderBy = 'name';
        $sort = 'asc';
=======
    $name_param = !is_null($request->name) ? $request->name : '';
>>>>>>> dropjs

    $orderBy = 'name';
    $sort = 'asc';

<<<<<<< HEAD
        // if (!is_null($city_id)) {

        //     $items = TourHotel::where('city_id', $city_id)->orderBy($orderBy, $sort)->paginate();
        // } else {

        //     $items = TourHotel::orderBy($orderBy, $sort)->paginate();
        // }
        $items = (new ObjectsFilter(TourHotel::with('objectables'), $request))->apply()->paginate();
=======
    $model_alias = TourHotel::getModelAliasAttribute();

    // if (!is_null($city_id)) {

    //     $items = TourHotel::where('city_id', $city_id)->orderBy($orderBy, $sort)->paginate();
    // } else {

    //     $items = TourHotel::orderBy($orderBy, $sort)->paginate();
    // }
    $items = (new ObjectsFilter(TourHotel::with('objectables'), $request))->apply()->paginate();

    $deleted = TourHotel::onlyTrashed()->get();
>>>>>>> dropjs

    $cities_names = TourHotel::getCitiesAttribute();

    $cities_select = TourHotel::getCitiesOptgroupAttribute(__('validation.attributes.frontend.general.select'));

    $customer_type_options = TourCustomerType::getCustomerTypesAttribute(__('validation.attributes.frontend.general.select'));

<<<<<<< HEAD
        $customer_type_options = TourCustomerType::getCustomerTypesAttribute(__('validation.attributes.frontend.general.select'));

        $cities_ids = TourHotel::select('city_id')->pluck('city_id')->toArray();

        $cities_for_filter = TourHotel::getCitiesForFilterAttribute($cities_ids);

        return view('frontend.tour.object.index', compact('items', 'cities_names', 'cities_select', 'deleted', 'customer_type_options', 'cities_for_filter'))
            ->with('city_id', (int) $city_id)
            ->with('city_name', $city_name)
            ->with('city_param', $city_param)
            ->with('model_alias', $model_alias)
            ->with('customer_type_options', $customer_type_options)
            ->with('name', $name_param);
    }
=======
    $customer_type_options_arrays = TourCustomerType::getCustomerTypesAttributeArrays(__('validation.attributes.frontend.general.select'));
>>>>>>> dropjs

    $cities_ids = TourHotel::select('city_id')->pluck('city_id')->toArray();

    $cities_for_filter = TourHotel::getCitiesForFilterAttribute($cities_ids);

    return view('frontend.tour.object.index', compact('items', 'cities_names', 'cities_select', 'deleted', 'customer_type_options', 'cities_for_filter'))
      ->with('city_id', (int) $city_id)
      ->with('city_name', $city_name)
      ->with('city_param', $city_param)
      ->with('model_alias', $model_alias)
      ->with('customer_type_options', $customer_type_options)
      ->with('customer_type_options_arrays', $customer_type_options_arrays)
      ->with('name', $name_param);
  }

  public function show($id)
  {
    //
  }

<<<<<<< HEAD
        return view('frontend.tour.object.create', compact('cities_options', 'hotel_categories'))
            ->with('method', 'POST')
            ->with('action', 'create')
            ->with('route', route('frontend.tour.' . $model_alias . '.store'))
            ->with('cancel_route', route('frontend.tour.' . $model_alias . '.index'))
            ->with('item', [])
            ->with('city_id', (int) $city_id)
            ->with('model_alias', $model_alias);
    }
=======
  public function create(Request $request)
  {
    $model_alias = TourHotel::getModelAliasAttribute();
>>>>>>> dropjs

    $city_id = $this->getCityId($request);
    $cities_options = TourHotel::getCitiesOptgroupAttribute(__('validation.attributes.frontend.general.select'));

    $hotel_categories = TourHotelCategory::getHotelCategoriesAttribute(__('validation.attributes.frontend.general.select'));

    return view('frontend.tour.object.create', compact('cities_options', 'hotel_categories'))
      ->with('method', 'POST')
      ->with('action', 'create')
      ->with('route', route('frontend.tour.' . $model_alias . '.store'))
      ->with('cancel_route', route('frontend.tour.' . $model_alias . '.index'))
      ->with('item', [])
      ->with('city_id', (int) $city_id)
      ->with('model_alias', $model_alias);
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
    $model_alias = TourHotel::getModelAliasAttribute();

    $item = TourHotel::findOrFail($id);

    $attributes = $item->objectables->toArray();

<<<<<<< HEAD
        $hotel_categories = TourHotelCategory::getHotelCategoriesAttribute(__('validation.attributes.frontend.general.select'));

        return view('frontend.tour.object.edit', compact('item', 'cities_options', 'hotel_categories', 'customer_type_options', 'attributes'))
            ->with('method', 'PATCH')
            ->with('action', 'edit')
            ->with('route', route('frontend.tour.' . $model_alias . '.update', [$item->id]))
            ->with('cancel_route', route('frontend.tour.' . $model_alias . '.index'))
            ->with('model_alias', $model_alias);
    }
=======
    $attributes = !empty($attributes) ? $attributes : [0 => ['id' => 0]];
>>>>>>> dropjs

    $cities_options = TourHotel::getCitiesOptgroupAttribute(__('validation.attributes.frontend.general.select'));

<<<<<<< HEAD
    public function update(Request $request, $id)
    {
        if ($request->get('attribute')) {
            $request->validate([
                'attribute.*.name' => 'required|min:3',
                'attribute.*.price' => 'required',
                'attribute.*.customer_type_id' => 'nullable|exists:tour_customer_types,id',
            ]);
        } else {
            $request->validate([
                'name' => 'required',
                'city_id' => 'exists:tour_cities,id',
                'category_id' => 'exists:tour_hotel_categories,id',
            ]);
        }
=======
    $customer_type_options = TourCustomerType::getCustomerTypesAttribute(__('validation.attributes.frontend.general.select'));
>>>>>>> dropjs

    $hotel_categories = TourHotelCategory::getHotelCategoriesAttribute(__('validation.attributes.frontend.general.select'));

    return view('frontend.tour.object.edit', compact('item', 'cities_options', 'hotel_categories', 'customer_type_options', 'attributes'))
      ->with('method', 'PATCH')
      ->with('action', 'edit')
      ->with('route', route('frontend.tour.' . $model_alias . '.update', [$item->id]))
      ->with('cancel_route', route('frontend.tour.' . $model_alias . '.index'))
      ->with('model_alias', $model_alias);
  }


  public function update(Request $request, $id)
  {
    if ($request->get('attribute')) {
      $request->validate([
        'attribute.*.name' => 'required|min:3',
        'attribute.*.price' => 'required',
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

<<<<<<< HEAD
    public static function getCityId(Request $request)
    {
        $city_ids = TourHotel::getCityIds();
        return $request->has('city_id') && $request->query('city_id') != 0
            && in_array($request->query('city_id'), $city_ids) ? $request->query('city_id') : null;
    }
=======
    return redirect()->route('frontend.tour.hotel.index')->withFlashSuccess(__('alerts.general.deleted_permanently'));
  }


  public static function getCityId(Request $request)
  {
    $city_ids = TourHotel::getCityIds();
    return $request->has('city_id') && $request->query('city_id') != 0
      && in_array($request->query('city_id'), $city_ids) ? $request->query('city_id') : null;
  }
>>>>>>> dropjs
}
