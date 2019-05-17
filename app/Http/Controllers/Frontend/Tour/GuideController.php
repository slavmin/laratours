<?php

namespace App\Http\Controllers\Frontend\Tour;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tour\TourGuide;

class GuideController extends Controller
{
    protected $guide;


    public function index()
    {
        $orderBy = 'name';
        $sort = 'asc';

        $items = TourGuide::orderBy($orderBy, $sort)->paginate();
        return view('frontend.tour.guide.index', compact('items'));
    }

    public function show($id)
    {
        //
    }

    public function create()
    {
        return view('frontend.tour.guide.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            //'description'=> '',
        ]);

        $guide = new TourGuide($request->only('name', 'description', 'price'));

        $guide->save();

        return redirect()->route('frontend.tour.guide.index')->withFlashSuccess(__('alerts.general.created'));
    }


    public function edit($id)
    {
        $item = TourGuide::findOrFail($id);

        return view('frontend.tour.guide.edit', compact('item'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            //'description'=> '',
        ]);

        $guide = TourGuide::findOrFail($id);

        $guide->update($request->only('name', 'description', 'price'));

        return redirect()->route('frontend.tour.guide.index')->withFlashSuccess(__('alerts.general.updated'));
    }


    public function destroy($id)
    {
        $guide = TourGuide::findOrFail($id);
        $guide->delete();

        return redirect()->route('frontend.tour.guide.index')->withFlashWarning(__('alerts.general.deleted'));
    }
}
