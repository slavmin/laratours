<?php

namespace App\Http\Controllers\Frontend\Tour;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tour\TourType;

class TypeController extends Controller
{
    protected $tour_type;


    public function index()
    {
        $tour_types = TourType::all();
        return view('frontend.tour.type.index', compact('tour_types'));
    }

    public function show($id)
    {
        //
    }

    public function create()
    {
        return view('frontend.tour.type.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            //'description'=> '',
        ]);

        $tour_type = new TourType($request->only('name', 'description'));

        $tour_type->save();

        return redirect()->route('frontend.tour.type.index')->withFlashSuccess(__('alerts.general.created'));
    }


    public function edit($id)
    {
        $tour_type = TourType::findOrFail($id);

        return view('frontend.tour.type.edit', compact('tour_type'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            //'description'=> '',
        ]);

        $tour_type = TourType::findOrFail($id);

        $tour_type->update($request->only('name', 'description'));

        return redirect()->route('frontend.tour.type.index')->withFlashSuccess(__('alerts.general.updated'));
    }


    public function destroy($id)
    {
        $tour_type = TourType::findOrFail($id);
        $tour_type->delete();

        return redirect()->route('frontend.tour.type.index')->withFlashWarning(__('alerts.general.deleted'));
    }
}
