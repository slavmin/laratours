<?php

namespace App\Http\Controllers\Frontend\Tour;

use App\Events\Frontend\Order\OrderDeleted;
use App\Exceptions\GeneralException;
use App\Filters\OrdersFilter;
use App\Models\Auth\Team;
use App\Models\Tour\Tour;
use App\Models\Tour\TourOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tour\TourCity;
use App\Models\Tour\TourCustomerType;
use App\Models\Tour\TourDate;
use App\Models\Tour\TourObjectAttributeProperties;
use App\Models\Tour\TourObjectAttributes;
use App\Models\Tour\TourPrice;

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

        $tour_infos = TourOrder::getTourInfos();

        $items = TourOrder::with(['profiles', 'tour:id,name']);

        $items = (new OrdersFilter($items, $request))->apply()->orderBy($orderBy, $sort)->paginate();

        $cities_names = TourCity::withoutGlobalScope('team')->get()->pluck('name', 'id')->toArray();

        $deleted = TourOrder::where('team_id', auth()->user()->current_team_id)->onlyTrashed()->get();

        // if ($request->expectsJson()) {
        //     return response()->json($items->toArray());
        // }

        $req_params = $request->all();

        return view('frontend.tour.order.private.index', compact('items', 'agencies', 'deleted', 'tour_names', 'tour_infos', 'cities_names', 'req_params'))
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

        $tour = Tour::whereId($item->tour_id)->first();

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
            session()->put('flash_danger', __('alerts.general.not_found'));
        }

        $profiles = $item->profiles()->get()->pluck('content')->first();

        if (!is_array($profiles)) {
            $profiles = [0 => []];
        }

        $statuses = TourOrder::getStatusesAttribute();

        $audits = $item->audits->sortByDesc('created_at');

        $documents = $item->getSharedDocuments($item->id);

        return view('frontend.tour.order.private.edit', compact('item', 'tour', 'profiles', 'statuses', 'audits', 'tour_transport', 'prices', 'customer_options', 'documents'))
            ->with('method', 'PATCH')
            ->with('action', 'edit')
            ->with('tour_date', $tour_date)
            ->with('route', route('frontend.tour.' . $model_alias . '.update', [$item->id]))
            ->with('cancel_route', route('frontend.tour.' . $model_alias . '.index'))
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

        return redirect()->route('frontend.tour.order.edit', $tour_order->id)->withFlashSuccess(__('alerts.general.updated'));
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
