<?php

namespace App\Http\Controllers\Frontend\Tour;

use App\Exceptions\GeneralException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tour\TourHotelCategory;

class HotelCategoryController extends Controller
{
  protected $hotel_category;

  protected $deleted;


  public function index()
  {
    $orderBy = 'name';
    $sort = 'asc';

    $model_alias = TourHotelCategory::getModelAliasAttribute();

    $items = TourHotelCategory::orderBy($orderBy, $sort)->paginate();
    $deleted = TourHotelCategory::onlyTrashed()->orderBy('name', 'asc')->get();

    return view('frontend.tour.hotel.category.index', compact('items', 'deleted'))
      ->with('object', $model_alias);
  }

  public function show($id)
  {
    //
  }

  public function create()
  {
    $model_alias = TourHotelCategory::getModelAliasAttribute();

    return view('frontend.tour.hotel.category.create')
      ->with('method', 'POST')
      ->with('action', 'create')
      ->with('route', route('frontend.tour.' . $model_alias . '.store'))
      ->with('cancel_route', route('frontend.tour.' . $model_alias . '.index'))
      ->with('item', [])
      ->with('model_alias', $model_alias);
  }

  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required',
      //'description'=> '',
    ]);

    $hotel_category = new TourHotelCategory($request->all());

    $hotel_category->save();

    return redirect()->route('frontend.tour.hotel-category.index')->withFlashSuccess(__('alerts.general.created'));
  }


  public function edit($id)
  {
    $model_alias = TourHotelCategory::getModelAliasAttribute();

    $item = TourHotelCategory::findOrFail($id);

    return view('frontend.tour.hotel.category.edit', compact('item'))
      ->with('method', 'PATCH')
      ->with('action', 'edit')
      ->with('route', route('frontend.tour.' . $model_alias . '.update', [$item->id]))
      ->with('cancel_route', route('frontend.tour.' . $model_alias . '.index'))
      ->with('model_alias', $model_alias);
  }


  public function update(Request $request, $id)
  {
    $request->validate([
      'name' => 'required',
      //'description'=> '',
    ]);

    $hotel_category = TourHotelCategory::findOrFail($id);

    $hotel_category->update($request->all());

    return redirect()->route('frontend.tour.hotel-category.index')->withFlashSuccess(__('alerts.general.updated'));
  }


  public function destroy($id)
  {
    $hotel_category = TourHotelCategory::findOrFail($id);
    $hotel_category->delete();

    return redirect()->route('frontend.tour.hotel-category.index')->withFlashWarning(__('alerts.general.deleted'));
  }

  public function restore($id)
  {
    $hotel_category = TourHotelCategory::withTrashed()->find($id);

    if ($hotel_category->deleted_at === null) {
      throw new GeneralException(__('exceptions.frontend.tours.cant_restore'));
    }

    if ($hotel_category->restore()) {
      return redirect()->route('frontend.tour.hotel-category.index')->withFlashSuccess(__('alerts.general.restored'));
    }

    throw new GeneralException(__('exceptions.frontend.tours.restore_error'));
  }

  public function delete($id)
  {
    $hotel_category = TourHotelCategory::withTrashed()->find($id);

    if ($hotel_category->deleted_at === null) {
      throw new GeneralException(__('exceptions.frontend.tours.cant_restore'));
    }

    $hotel_category->forceDelete();

    return redirect()->route('frontend.tour.hotel-category.index')->withFlashSuccess(__('alerts.general.deleted_permanently'));
  }
}
