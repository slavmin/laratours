<?php

namespace App\Http\Controllers\Frontend\Tour;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tour\TourAttendant;

class AttendantController extends Controller
{
    protected $attendant;


    public function index()
    {
        $orderBy = 'name';
        $sort = 'asc';

        $items = TourAttendant::orderBy($orderBy, $sort)->paginate();
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

        $attendant = new TourAttendant($request->only('name', 'description', 'price'));

        $attendant->save();

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

        $attendant = TourAttendant::findOrFail($id);

        $attendant->update($request->only('name', 'description', 'price'));

        return redirect()->route('frontend.tour.attendant.index')->withFlashSuccess(__('alerts.general.updated'));
    }


    public function destroy($id)
    {
        $attendant = TourAttendant::findOrFail($id);
        $attendant->delete();

        return redirect()->route('frontend.tour.attendant.index')->withFlashWarning(__('alerts.general.deleted'));
    }
}
