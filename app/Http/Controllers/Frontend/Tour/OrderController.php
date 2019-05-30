<?php

namespace App\Http\Controllers\Frontend\Tour;

use App\Exceptions\GeneralException;
use App\Models\Auth\Team;
use App\Models\Tour\TourOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class OrderController extends Controller
{
    protected $tour;
    protected $tour_order;

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $agencies = [];

        $team = Team::whereId(auth()->user()->current_team_id)->first();

        if($team && $team->hasRole(config('access.teams.operator_role'))){
            $agencies = $team->subscribers->pluck('name','id')->toArray();
        }

        $orderBy = 'id';
        $sort = 'desc';

        $model_alias = TourOrder::getModelAliasAttribute();

        $statuses = TourOrder::getStatusesAttribute();
        $tour_names = TourOrder::getTourNames();

        $items = TourOrder::orderBy($orderBy, $sort)->paginate();
        $deleted = TourOrder::where('team_id', auth()->user()->current_team_id)->onlyTrashed()->get();

        return view('frontend.tour.order.private.index', compact('items', 'agencies', 'deleted', 'tour_names'))
            ->with('statuses', $statuses)
            ->with('model_alias', $model_alias);
    }


    public function show($id)
    {
        //
    }

    public function create(Request $request, $tour_id)
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

        $profiles = $item->profiles()->get()->pluck('content')->first();

        if(!is_array($profiles)){
            $profiles = [0 => []];
        }

        return view('frontend.tour.order.private.edit', compact('item', 'profiles'))
            ->with('method', 'PATCH')
            ->with('action', 'edit')
            ->with('route', route('frontend.tour.'.$model_alias.'.update', [$item->id]))
            ->with('cancel_route', route('frontend.tour.'.$model_alias.'.index'))
            ->with('model_alias', $model_alias);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'customer.*.first_name' => 'required|min:3|max:191',
            'customer.*.last_name'=> 'required|min:3|max:191',
            'customer.*.email'=> 'required|email|max:191',
            'customer.*.phone'=> 'required|regex:/\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/',
        ]);

        $profile = $request->get('customer');

        $tour_order = TourOrder::findOrFail($id);

        $tour_order->update($request->all());

        // Update or Create customer profile
        $tour_order->profiles()->updateOrCreate(
            ['type' => 'customer'],
            ['type' => 'customer', 'content' => $profile]);

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