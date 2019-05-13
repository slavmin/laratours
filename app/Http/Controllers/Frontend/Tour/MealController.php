<?php

namespace App\Http\Controllers\Frontend\Tour;

use App\Exceptions\GeneralException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tour\TourMeal;

class MealController extends Controller
{
    protected $tour_meal;


    public function index()
    {
        $items = TourMeal::all();
        $deleted = TourMeal::onlyTrashed()->get();

        return view('frontend.tour.meal.index', compact('items','deleted'));
    }

    public function show($id)
    {
        //
    }

    public function create()
    {
        return view('frontend.tour.meal.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            //'description'=> '',
        ]);

        $tour_meal = new TourMeal($request->only('name', 'description', 'price'));

        $tour_meal->save();

        return redirect()->route('frontend.tour.meal.index')->withFlashSuccess(__('alerts.general.created'));
    }


    public function edit($id)
    {
        $item = TourMeal::findOrFail($id);

        return view('frontend.tour.meal.edit', compact('item'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            //'description'=> '',
        ]);

        $tour_meal = TourMeal::findOrFail($id);

        $tour_meal->update($request->only('name', 'description', 'price'));

        return redirect()->route('frontend.tour.meal.index')->withFlashSuccess(__('alerts.general.updated'));
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
}
