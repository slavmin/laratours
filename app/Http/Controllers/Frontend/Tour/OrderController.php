<?php

namespace App\Http\Controllers\Frontend\Tour;

use App\Events\Frontend\Order\OrderDeleted;
use App\Exceptions\GeneralException;
use App\Filters\ToursFilter;
use App\Models\Auth\Team;
use App\Models\Tour\Tour;
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
    public function index(Request $request)
    {
        $agencies = Team::getTeamSubscriptions();
        $subscribers = array_keys($agencies);

        $orderBy = 'id';
        $sort = 'desc';

        $model_alias = TourOrder::getModelAliasAttribute();

        $statuses = TourOrder::getStatusesAttribute();
        $tour_names = TourOrder::getTourNames();

        $items = TourOrder::with('profiles');

        $items = (new ToursFilter($items, $request))->apply()->orderBy($orderBy, $sort)->AllTeams()->paginate();

        $deleted = TourOrder::where('team_id', auth()->user()->current_team_id)->onlyTrashed()->get();

        if ($request->expectsJson()) {
            return response()->json($items->toArray());
        }

        return view('frontend.tour.order.private.index', compact('items', 'agencies', 'deleted', 'tour_names'))
            ->with('statuses', $statuses)
            ->with('model_alias', $model_alias);
        // ->with('all_items', $all_items);
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

        $tour = Tour::whereId($item->tour_id)->first();

        if (!$tour) {
            session()->put('flash_danger', __('alerts.general.not_found'));
        }

        $profiles = $item->profiles()->get()->pluck('content')->first();

        if (!is_array($profiles)) {
            $profiles = [0 => []];
        }

        $statuses = TourOrder::getStatusesAttribute();

        $audits = $item->audits->sortByDesc('created_at');

        $documents = $item->getSharedDocuments($item->id);

        return view('frontend.tour.order.private.edit', compact('item', 'tour', 'profiles', 'statuses', 'audits', 'documents'))
            ->with('method', 'PATCH')
            ->with('action', 'edit')
            ->with('route', route('frontend.tour.' . $model_alias . '.update', [$item->id]))
            ->with('cancel_route', route('frontend.tour.' . $model_alias . '.index'))
            ->with('model_alias', $model_alias);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'customer.*.first_name' => 'required|min:3|max:191',
            'customer.*.last_name' => 'required|min:3|max:191',
            'customer.*.email' => 'required|email|max:191',
            //'customer.*.phone'=> 'required|regex:/\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/',
        ]);

        $profile = $request->get('customer');

        $tour_order = TourOrder::findOrFail($id);

        $tour_order->update($request->all());

        // Update or Create customer profile
        $tour_order->profiles()->updateOrCreate(
            ['type' => 'customer'],
            ['type' => 'customer', 'content' => $profile]
        );

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

        event(new OrderDeleted($tour_order));

        $tour_order->forceDelete();

        return redirect()->route('frontend.tour.order.index')->withFlashSuccess(__('alerts.general.deleted_permanently'));
    }
}
