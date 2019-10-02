<?php

namespace App\Http\Controllers\Frontend\Tour\Agency;

use App\Events\Frontend\Order\OrderCreated;
use App\Exceptions\GeneralException;
use App\Models\Auth\Team;
use App\Models\Tour\Tour;
use App\Models\Tour\TourOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected $tour;
    protected $tour_order;

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $operators = Team::getTeamSubscriptions();
        $subscriptions = array_keys($operators);

        $orderBy = 'id';
        $sort = 'desc';

        $model_alias = TourOrder::getModelAliasAttribute();

        $statuses = TourOrder::getStatusesAttribute();
        $tour_names = Tour::withoutGlobalScopes()->whereIn('team_id', $subscriptions)->pluck('name', 'id')->all();

        $items = TourOrder::with('profiles')->orderBy($orderBy, $sort)->paginate();
        $deleted = TourOrder::onlyTrashed()->get();

        return view('frontend.tour.agency.order.index', compact('items', 'deleted', 'operators', 'tour_names'))
            ->with('statuses', $statuses)
            ->with('model_alias', $model_alias);
    }


    public function show($id)
    {
        //
    }

    public function create(Request $request, $tour_id)
    {
        $model_alias = TourOrder::getModelAliasAttribute();

        $operators = Team::getTeamSubscriptions();
        $subscriptions = array_keys($operators);

        $tour = Tour::whereId($tour_id)->whereIn('team_id', $subscriptions)->AllTeams()->first();

        if (!$tour) {
            return redirect()->back()->withFlashDanger(__('alerts.general.not_found'));
        }

        return view('frontend.tour.agency.order.create')
            ->with('method', 'POST')
            ->with('action', 'create')
            ->with('route', route('frontend.agency.' . $model_alias . '.store'))
            ->with('cancel_route', route('frontend.agency.tour-list'))
            ->with('item', $tour)
            ->with('statuses', [])
            ->with('profiles', [0 => []])
            ->with('model_alias', $model_alias);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tour_id' => 'required|exists:tours,id',
            'operator_id' => 'required|exists:teams,id',
            'customer.*.first_name' => 'required|min:3|max:191',
            'customer.*.last_name'=> 'required|min:3|max:191',
            'customer.*.email'=> 'required|email|max:191',
            //'customer.*.phone'=> 'required|regex:/\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/',
        ]);

        $profile = $request->get('customer');

        $tour_order_id = DB::table('tour_orders')->insertGetId([
            'tour_id' => $request->get('tour_id'),
            'operator_id' => $request->get('operator_id'),
            'team_id' => auth()->user()->currentTeam->getKey(),
            'total_price' => $request->get('total_price'),
            'commission' => $request->get('commission'),
            'total_paid' => $request->get('total_paid'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $tour_order = TourOrder::findOrFail($tour_order_id);

        // Update or Create customer profile
        $tour_order->profiles()->updateOrCreate(
            ['type' => 'customer'],
            ['type' => 'customer', 'content' => $profile]);

        event(new OrderCreated($tour_order));

        return redirect()->route('frontend.agency.order.index')->withFlashSuccess(__('alerts.general.created'));
    }


    public function edit($id)
    {
        $model_alias = TourOrder::getModelAliasAttribute();

        $item = TourOrder::findOrFail($id);

        $profiles = $item->profiles()->get()->pluck('content')->first();

        if(!is_array($profiles)){
            $profiles = [0 => []];
        }

        $statuses = TourOrder::getStatusesAttribute();

        $audits = $item->audits->sortByDesc('created_at');

        return view('frontend.tour.order.private.edit', compact('item', 'profiles', 'statuses', 'audits'))
            ->with('method', 'PATCH')
            ->with('action', 'edit')
            ->with('route', route('frontend.agency.' . $model_alias . '.update', [$item->id]))
            ->with('cancel_route', route('frontend.agency.' . $model_alias . '.index'))
            ->with('model_alias', $model_alias);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'customer.*.first_name' => 'required|min:3|max:191',
            'customer.*.last_name'=> 'required|min:3|max:191',
            'customer.*.email'=> 'required|email|max:191',
            //'customer.*.phone'=> 'required|regex:/\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/',
        ]);

        $profile = $request->get('customer');

        $tour_order = TourOrder::findOrFail($id);
        $tour_order->update($request->all());

        // Update or Create customer profile
        $tour_order->profiles()->updateOrCreate(
            ['type' => 'customer'],
            ['type' => 'customer', 'content' => $profile]);

        return redirect()->route('frontend.agency.order.index')->withFlashSuccess(__('alerts.general.updated'));
    }


    public function destroy($id)
    {
        $tour_order = TourOrder::findOrFail($id);
        $tour_order->delete();

        return redirect()->route('frontend.agency.order.index')->withFlashWarning(__('alerts.general.deleted'));
    }

    public function restore($id)
    {
        $tour_order = TourOrder::withTrashed()->find($id);

        if ($tour_order->deleted_at === null) {
            throw new GeneralException(__('exceptions.frontend.tours.cant_restore'));
        }

        if ($tour_order->restore()) {
            return redirect()->route('frontend.agency.order.index')->withFlashSuccess(__('alerts.general.restored'));
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

        return redirect()->route('frontend.agency.order.index')->withFlashSuccess(__('alerts.general.deleted_permanently'));
    }
}
