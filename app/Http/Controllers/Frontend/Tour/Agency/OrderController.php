<?php

namespace App\Http\Controllers\Frontend\Tour\Agency;

use App\Events\Frontend\Order\OrderCreated;
use App\Events\Frontend\Order\OrderDeleted;
use App\Exceptions\GeneralException;
use App\Models\Auth\Team;
use App\Models\Tour\Tour;
use App\Models\Tour\TourOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tour\TourCustomer;
use App\Models\Tour\TourCustomerType;
use App\Models\Tour\TourDate;
use App\Models\Tour\TourObjectAttributeProperties;
use App\Models\Tour\TourObjectAttributes;
use App\Models\Tour\TourPrice;
use App\Models\Tour\TourTransport;
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

        $tour_date = TourDate::where('tour_id', $tour->id)->AllTeams()->first();

        $tour_transport_ids = TourObjectAttributeProperties::where('tour_id', $tour->id)
            ->where('object_type', 'transport')
            ->select('object_attribute_id')
            ->AllTeams()
            ->pluck('object_attribute_id')
            ->toArray();

        $tour_transport = [];

        foreach ($tour_transport_ids as $id) {
            $tour_transport[] = TourObjectAttributes::where('id', $id)->select('id', 'name', 'description', 'extra')->AllTeams()->get();
        }

        $tour_prices = TourPrice::where('priceable_type', 'App\Models\Tour\Tour')
            ->where('priceable_id', $tour->id)
            ->select('price', 'tour_customer_type_id')
            ->AllTeams()
            ->get();

        $customer_options = TourCustomerType::where('team_id', $tour->team_id)
            ->AllTeams()
            ->pluck('name', 'id')
            ->toArray();

        $prices = [];
        foreach ($tour_prices as $tour_price) {
            $prices[] = [
                'value' => $tour_price->price,
                'text'  => $customer_options[$tour_price->tour_customer_type_id]
            ];
        }

        if (!$tour) {
            return redirect()->back()->withFlashDanger(__('alerts.general.not_found'));
        }

        return view('frontend.tour.agency.order.create')
            ->with('method', 'POST')
            ->with('action', 'create')
            ->with('route', route('frontend.agency.' . $model_alias . '.store'))
            ->with('cancel_route', route('frontend.agency.tour-list'))
            ->with('tour', $tour)
            ->with('tour_date', $tour_date['date'])
            ->with('tour_transport', $tour_transport)
            ->with('prices', $prices)
            ->with('customer_options', $customer_options)
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
            'customer.*.last_name' => 'required|min:3|max:191',
            //'customer.*.email'=> 'required|email|max:191',
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
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'contact_name' => $request->get('contact_name'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $tour_order = TourOrder::findOrFail($tour_order_id);

        // Update or Create customer profile
        $tour_order->profiles()->updateOrCreate(
            ['type' => 'customer'],
            ['type' => 'customer', 'content' => $profile]
        );

        event(new OrderCreated($tour_order));

        return redirect()->route('frontend.agency.order.index')->withFlashSuccess(__('alerts.general.created'));
    }


    public function edit($id)
    {
        $model_alias = TourOrder::getModelAliasAttribute();

        $item = TourOrder::findOrFail($id);


        $operators = Team::getTeamSubscriptions();
        $subscriptions = array_keys($operators);

        $tour = Tour::whereId($item->tour_id)->whereIn('team_id', $subscriptions)->AllTeams()->first();

        $tour_date = TourDate::where('tour_id', $tour->id)->AllTeams()->first();

        if (!$tour) {
            return redirect()->back()->withFlashDanger(__('alerts.general.not_found'));
        }

        $profiles = $item->profiles()->get()->pluck('content')->first();

        if (!is_array($profiles)) {
            $profiles = [0 => []];
        }

        $statuses = TourOrder::getStatusesAttribute();

        $audits = $item->audits->sortByDesc('created_at');

        $documents = $item->getSharedDocuments($item->id);

        $tour_transport_ids = TourObjectAttributeProperties::where('tour_id', $tour->id)
            ->where('object_type', 'transport')
            ->select('object_attribute_id')
            ->AllTeams()
            ->pluck('object_attribute_id')
            ->toArray();

        $tour_transport = [];

        foreach ($tour_transport_ids as $id) {
            $tour_transport[] = TourObjectAttributes::where('id', $id)->select('id', 'name', 'description', 'extra')->AllTeams()->get();
        }

        $tour_prices = TourPrice::where('priceable_type', 'App\Models\Tour\Tour')
            ->where('priceable_id', $tour->id)
            ->select('price', 'tour_customer_type_id')
            ->AllTeams()
            ->get();

        $customer_options = TourCustomerType::where('team_id', $tour->team_id)
            ->AllTeams()
            ->pluck('name', 'id')
            ->toArray();

        $prices = [];
        foreach ($tour_prices as $tour_price) {
            $prices[] = [
                'value' => $tour_price->price,
                'text'  => $customer_options[$tour_price->tour_customer_type_id]
            ];
        }

        return view('frontend.tour.order.private.edit', compact('item', 'tour', 'profiles', 'statuses', 'audits', 'documents', 'tour_transport', 'prices'))
            ->with('method', 'PATCH')
            ->with('action', 'edit')
            ->with('tour_date', $tour_date['date'])
            ->with('route', route('frontend.agency.' . $model_alias . '.update', [$item->id]))
            ->with('cancel_route', route('frontend.agency.' . $model_alias . '.index'))
            ->with('model_alias', $model_alias);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'customer.*.first_name' => 'required|min:3|max:191',
            'customer.*.last_name' => 'required|min:3|max:191',
            // 'customer.*.email' => 'required|email|max:191',
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

        event(new OrderDeleted($tour_order));

        $tour_order->forceDelete();

        return redirect()->route('frontend.agency.order.index')->withFlashSuccess(__('alerts.general.deleted_permanently'));
    }
}
