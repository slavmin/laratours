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
            ->with('model_alias', $model_alias);
    }

    public function show($id)
    {
        //
    }

    public function create()
    {
        $model_alias = TourType::getModelAliasAttribute();

        return view('frontend.tour.type.create')
            ->with('method', 'POST')
            ->with('action', 'create')
            ->with('route', route('frontend.tour.'.$model_alias.'.store'))
            ->with('cancel_route', route('frontend.tour.'.$model_alias.'.index'))
            ->with('item', [])
            ->with('model_alias', $model_alias);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            //'description'=> '',
        ]);

        $tour_type = new TourType($request->all());

        $tour_type->save();

        return redirect()->route('frontend.tour.type.index')->withFlashSuccess(__('alerts.general.created'));
    }


    public function edit($id)
    {
        $model_alias = TourType::getModelAliasAttribute();

        $item = TourType::findOrFail($id);

        return view('frontend.tour.type.edit', compact('item'))
            ->with('method', 'PATCH')
            ->with('action', 'edit')
            ->with('route', route('frontend.tour.'.$model_alias.'.update', [$item->id]))
            ->with('cancel_route', route('frontend.tour.'.$model_alias.'.index'))
            ->with('model_alias', $model_alias);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            //'description'=> '',
        ]);

        $tour_type = TourType::findOrFail($id);

        $tour_type->update($request->all());

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
