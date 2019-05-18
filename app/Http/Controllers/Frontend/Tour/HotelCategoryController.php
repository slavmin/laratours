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

        $items = TourHotelCategory::orderBy($orderBy, $sort)->paginate();
        $deleted = TourHotelCategory::onlyTrashed()->orderBy('name', 'asc')->get();

        return view('frontend.tour.hotel.category.index', compact('items','deleted'))
            ->with('object', 'hotel-category');
    }

    public function show($id)
    {
        //
    }

    public function create()
    {
        return view('frontend.tour.hotel.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            //'description'=> '',
        ]);

        $hotel_category = new TourHotelCategory($request->only('name', 'description'));

        $hotel_category->save();

        return redirect()->route('frontend.tour.hotel-category.index')->withFlashSuccess(__('alerts.general.created'));
    }


    public function edit($id)
    {
        $hotel_category = TourHotelCategory::findOrFail($id);

        return view('frontend.tour.hotel.category.edit', compact('hotel_category'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            //'description'=> '',
        ]);

        $hotel_category = TourHotelCategory::findOrFail($id);

        $hotel_category->update($request->only('name', 'description'));

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
