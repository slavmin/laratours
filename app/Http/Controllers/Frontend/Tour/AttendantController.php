<?php

namespace App\Http\Controllers\Frontend\Tour;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tour\TourAttendant;

class AttendantController extends Controller
{
    protected $guide;


    public function index()
    {
        $items = TourAttendant::all();
        return view('frontend.tour.attendant.index', compact('items'));
    }

    public function show($id)
    {
        //
    }

    public function create()
    {
        return view('frontend.tour.attendant.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            //'description'=> '',
        ]);

        $guide = new TourAttendant($request->only('name', 'description', 'price'));

        $guide->save();

        return redirect()->route('frontend.tour.attendant.index')->withFlashSuccess(__('alerts.general.created'));
    }


    public function edit($id)
    {
        $item = TourAttendant::findOrFail($id);

        return view('frontend.tour.attendant.edit', compact('item'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            //'description'=> '',
        ]);

        $guide = TourAttendant::findOrFail($id);

        $guide->update($request->only('name', 'description', 'price'));

        return redirect()->route('frontend.tour.attendant.index')->withFlashSuccess(__('alerts.general.updated'));
    }


    public function destroy($id)
    {
        $guide = TourAttendant::findOrFail($id);
        $guide->delete();

        return redirect()->route('frontend.tour.attendant.index')->withFlashWarning(__('alerts.general.deleted'));
    }
}
