<?php

namespace App\Http\Controllers\Frontend\Tour;

use App\Exceptions\GeneralException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tour\TourRoomCategory;

class RoomCategoryController extends Controller
{
  protected $room_category;

  protected $deleted;


  public function index()
  {
    $orderBy = 'name';
    $sort = 'asc';

    $model_alias = TourRoomCategory::getModelAliasAttribute();

    $items = TourRoomCategory::orderBy($orderBy, $sort)->paginate();
    $deleted = TourRoomCategory::onlyTrashed()->orderBy('name', 'asc')->get();

    return view('frontend.tour.hotel.room.index', compact('items', 'deleted'))
      ->with('object', $model_alias);
  }

  public function show($id)
  {
    //
  }

  public function create()
  {
    $model_alias = TourRoomCategory::getModelAliasAttribute();

    return view('frontend.tour.hotel.room.create')
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

    $room_category = new TourRoomCategory($request->all());

    $room_category->save();

    return redirect()->route('frontend.tour.room-category.index')->withFlashSuccess(__('alerts.general.created'));
  }


  public function edit($id)
  {
    $model_alias = TourRoomCategory::getModelAliasAttribute();

    $item = TourRoomCategory::findOrFail($id);

    return view('frontend.tour.hotel.room.edit', compact('room_category'), compact('item'))
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

    $room_category = TourRoomCategory::findOrFail($id);

    $room_category->update($request->all());

    return redirect()->route('frontend.tour.room-category.index')->withFlashSuccess(__('alerts.general.updated'));
  }


  public function destroy($id)
  {
    $room_category = TourRoomCategory::findOrFail($id);
    $room_category->delete();

    return redirect()->route('frontend.tour.room-category.index')->withFlashWarning(__('alerts.general.deleted'));
  }

  public function restore($id)
  {
    $room_category = TourRoomCategory::withTrashed()->find($id);

    if ($room_category->deleted_at === null) {
      throw new GeneralException(__('exceptions.frontend.tours.cant_restore'));
    }

    if ($room_category->restore()) {
      return redirect()->route('frontend.tour.room-category.index')->withFlashSuccess(__('alerts.general.restored'));
    }

    throw new GeneralException(__('exceptions.frontend.tours.restore_error'));
  }

  public function delete($id)
  {
    $room_category = TourRoomCategory::withTrashed()->find($id);

    if ($room_category->deleted_at === null) {
      throw new GeneralException(__('exceptions.frontend.tours.cant_restore'));
    }

    $room_category->forceDelete();

    return redirect()->route('frontend.tour.room-category.index')->withFlashSuccess(__('alerts.general.deleted_permanently'));
  }
}
