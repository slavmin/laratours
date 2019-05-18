<?php

namespace App\Http\Controllers\Frontend\Tour;

use App\Exceptions\GeneralException;
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

        $model_alias = TourGuide::getModelAliasAttribute();

        $items = TourGuide::orderBy($orderBy, $sort)->paginate();
        $deleted = TourGuide::onlyTrashed()->get();

        return view('frontend.tour.guide.index', compact('items', 'deleted'))
            ->with('object', $model_alias);
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

    public function restore($id)
    {
        $guide = TourGuide::withTrashed()->find($id);

        if ($guide->deleted_at === null) {
            throw new GeneralException(__('exceptions.frontend.tours.cant_restore'));
        }

        if ($guide->restore()) {
            return redirect()->route('frontend.tour.guide.index')->withFlashSuccess(__('alerts.general.restored'));
        }

        throw new GeneralException(__('exceptions.frontend.tours.restore_error'));
    }

    public function delete($id)
    {
        $guide = TourGuide::withTrashed()->find($id);

        if ($guide->deleted_at === null) {
            throw new GeneralException(__('exceptions.frontend.tours.cant_restore'));
        }

        $guide->forceDelete();

        return redirect()->route('frontend.tour.guide.index')->withFlashSuccess(__('alerts.general.deleted_permanently'));
    }
}
