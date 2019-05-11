<?php

namespace App\Http\Controllers\Frontend\Tour;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tour\TourMuseum;
use App\Models\Tour\TourCity;

class MuseumController extends Controller
{
    protected $museum;


    public function index()
    {
        $items = TourMuseum::all();

        $cities_options = TourMuseum::getCitiesAttribute();

        return view('frontend.tour.museum.index', compact('items','cities_options'));
    }

    public function show($id)
    {
        //
    }

    public function create()
    {
        $cities_options = TourMuseum::getCitiesAttribute(__('validation.attributes.frontend.general.select'));

        return view('frontend.tour.museum.create', compact('cities_options'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'city_id' => 'exists:tour_cities,id',
            //'description'=> '',
        ]);

        $museum = new TourMuseum($request->only('name', 'city_id', 'description', 'price'));

        $museum->save();

        return redirect()->route('frontend.tour.museum.index')->withFlashSuccess(__('alerts.general.created'));
    }


    public function edit($id)
    {
        $item = TourMuseum::findOrFail($id);

        $cities_options = TourMuseum::getCitiesAttribute(__('validation.attributes.frontend.general.select'));

        return view('frontend.tour.museum.edit', compact('item', 'cities_options'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'city_id' => 'exists:tour_cities,id',
            //'description'=> '',
        ]);

        $museum = TourMuseum::findOrFail($id);

        $museum->update($request->only('name', 'city_id', 'description', 'price'));

        return redirect()->route('frontend.tour.museum.index')->withFlashSuccess(__('alerts.general.updated'));
    }


    public function destroy($id)
    {
        $museum = TourMuseum::findOrFail($id);
        $museum->delete();

        return redirect()->route('frontend.tour.museum.index')->withFlashWarning(__('alerts.general.deleted'));
    }
}
