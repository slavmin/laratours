<?php

namespace App\Http\Controllers\Frontend\Tour;

use App\Exceptions\GeneralException;
use App\Models\Tour\TourOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    protected $tour_order;

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $orderBy = 'id';
        $sort = 'desc';

        $model_alias = TourOrder::getModelAliasAttribute();

        $statuses = TourOrder::getStatusesAttribute();
        $tour_names = TourOrder::getTourNames();

        $items = TourOrder::orderBy($orderBy, $sort)->paginate();
        $deleted = TourOrder::onlyTrashed()->get();

        return view('frontend.tour.order.private.index', compact('items', 'deleted', 'tour_names'))
            ->with('statuses', $statuses)
            ->with('model_alias', $model_alias);
    }


    public function show($id)
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }


    public function edit($id)
    {
        $model_alias = TourOrder::getModelAliasAttribute();

        $item = TourOrder::findOrFail($id);

        return view('frontend.tour.order.private.edit', compact('item'))
            ->with('method', 'PATCH')
            ->with('action', 'edit')
            ->with('route', route('frontend.tour.'.$model_alias.'.update', [$item->id]))
            ->with('cancel_route', route('frontend.tour.'.$model_alias.'.index'))
            ->with('model_alias', $model_alias);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            //'name'=>'required',
            //'description'=> '',
        ]);

        $tour_order = TourOrder::findOrFail($id);

        $tour_order->update($request->all());

        return redirect()->route('frontend.tour.order.index')->withFlashSuccess(__('alerts.general.updated'));
    }


    public function destroy($id)
    {
        $tour_order = TourOrder::findOrFail($id);
        $tour_order->delete();

        return redirect()->route('frontend.tour.order.index')->withFlashWarning(__('alerts.general.deleted'));
    }

    public function restore($id)
    {
        $tour_order = TourOrder::withTrashed()->find($id);

        if ($tour_order->deleted_at === null) {
            throw new GeneralException(__('exceptions.frontend.tours.cant_restore'));
        }

        if ($tour_order->restore()) {
            return redirect()->route('frontend.tour.order.index')->withFlashSuccess(__('alerts.general.restored'));
        }

        throw new GeneralException(__('exceptions.frontend.tours.restore_error'));
    }

    public function delete($id)
    {
        $tour_order = TourOrder::withTrashed()->find($id);

        if ($tour_order->deleted_at === null) {
            throw new GeneralException(__('exceptions.frontend.tours.cant_restore'));
        }

        $tour_order->forceDelete();

        return redirect()->route('frontend.tour.order.index')->withFlashSuccess(__('alerts.general.deleted_permanently'));
    }
}