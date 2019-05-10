<?php

namespace App\Http\Controllers\Frontend\Tour;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tour\TourMuseum;

class MuseumController extends Controller
{
    protected $guide;


    public function index()
    {
        $items = TourMuseum::all();
        return view('frontend.tour.museum.index', compact('items'));
    }

    public function show($id)
    {
        //
    }

    public function create()
    {
        return view('frontend.tour.museum.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            //'description'=> '',
        ]);

        $guide = new TourMuseum($request->only('name', 'description', 'price'));

        $guide->save();

        return redirect()->route('frontend.tour.museum.index')->withFlashSuccess(__('alerts.general.created'));
    }


    public function edit($id)
    {
        $item = TourMuseum::findOrFail($id);

        return view('frontend.tour.museum.edit', compact('item'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            //'description'=> '',
        ]);

        $guide = TourMuseum::findOrFail($id);

        $guide->update($request->only('name', 'description', 'price'));

        return redirect()->route('frontend.tour.museum.index')->withFlashSuccess(__('alerts.general.updated'));
    }


    public function destroy($id)
    {
        $guide = TourMuseum::findOrFail($id);
        $guide->delete();

        return redirect()->route('frontend.tour.museum.index')->withFlashWarning(__('alerts.general.deleted'));
    }
}
