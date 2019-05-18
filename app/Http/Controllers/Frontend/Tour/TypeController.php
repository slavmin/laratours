<?php

namespace App\Http\Controllers\Frontend\Tour;

use App\Exceptions\GeneralException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tour\TourType;

class TypeController extends Controller
{
    protected $tour_type;

    protected $deleted;


    public function index()
    {
        $orderBy = 'name';
        $sort = 'asc';

        $model_alias = TourType::getModelAliasAttribute();

        $items = TourType::orderBy($orderBy, $sort)->paginate();
        $deleted = TourType::onlyTrashed()->get();

        return view('frontend.tour.type.index', compact('items','deleted'))
            ->with('object', $model_alias);
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

    public function restore($id)
    {
        $tour_type = TourType::withTrashed()->find($id);

        if ($tour_type->deleted_at === null) {
            throw new GeneralException(__('exceptions.frontend.tours.cant_restore'));
        }

        if ($tour_type->restore()) {
            return redirect()->route('frontend.tour.type.index')->withFlashSuccess(__('alerts.general.restored'));
        }

        throw new GeneralException(__('exceptions.frontend.tours.restore_error'));
    }

    public function delete($id)
    {
        $tour_type = TourType::withTrashed()->find($id);

        if ($tour_type->deleted_at === null) {
            throw new GeneralException(__('exceptions.frontend.tours.cant_restore'));
        }

        $tour_type->forceDelete();

        return redirect()->route('frontend.tour.type.index')->withFlashSuccess(__('alerts.general.deleted_permanently'));
    }
}
