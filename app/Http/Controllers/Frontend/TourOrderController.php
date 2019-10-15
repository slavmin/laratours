<?php

namespace App\Http\Controllers\Frontend;

use App\Exceptions\GeneralException;
use App\Models\Auth\Team;
use App\Models\Tour\Tour;
use App\Models\Tour\TourOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Events\Frontend\Order\OrderCreated;

class TourOrderController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('frontend.tour.order.public.form');
    }


    public function store(Request $request)
    {
        $request->validate([
            'tour_id' => 'required|exists:tours,id',
            //'operator_id' => 'required|exists:teams,id',
            'customer.*.first_name' => 'required|min:3|max:191',
            'customer.*.last_name'=> 'required|min:3|max:191',
            'customer.*.email'=> 'required|email|max:191',
            'customer.*.phone'=> 'required|regex:/\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/',
        ]);

        $item = Tour::whereId($request->get('tour_id'))->AllTeams()->first();

        $profile = $request->get('customer');

        if($item) {

            DB::transaction(function () use ($item, $profile) {

                $team_id = $item->team_id;
                $operator_id = $item->team_id;
                $customer_id = null;

                if(!auth()->guest()){
                    if(!$team = Team::whereId(auth()->user()->current_team_id)->first()){
                        $customer_id = auth()->user()->id;
                    } else {
                        $team_id = $team->hasRole(config('access.teams.agent_role')) ? $team->id : null;
                    }
                }

                $tour_order_id = DB::table('tour_orders')->insertGetId(
                    [
                        'tour_id' => $item->id,
                        'team_id' => $team_id,
                        'customer_id' => $customer_id,
                        'operator_id' => $operator_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );

                $tour_order = TourOrder::whereId($tour_order_id)->AllTeams()->first();

                // Update or Create customer profile
                $tour_order->profiles()->updateOrCreate(
                    ['type' => 'customer'],
                    ['type' => 'customer', 'content' => $profile]);

                if(!$tour_order){
                    throw new GeneralException(__('exceptions.frontend.tours.order_error'));
                }

                event(new OrderCreated($tour_order));
            });
        }

        return redirect()->back()->withFlashSuccess(__('alerts.frontend.contact.sent'));
    }
}
