<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Auth\Team;
use App\Models\Tour\Tour;
use App\Models\Tour\TourOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TourOrderController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        //dd(TourOrder::where('customer_id', auth()->user()->id)->AllTeams()->get());
        return view('frontend.tour.order.public.form');
    }


    public function store(Request $request)
    {
//        TourOrder::whereId($request->get('tour_id'))->AllTeams()->update(['discount' => '7.00']);
//
//        $tour_order = TourOrder::whereId($request->get('tour_id'))->AllTeams()->first();
//
//        return $tour_order;

        $request->validate([
            'tour_id' => 'required|exists:tours,id',
        ]);

        $item = Tour::whereId($request->get('tour_id'))->AllTeams()->first();

        if($item) {
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

            $order_id = DB::table('tour_orders')->insertGetId(
                [
                    'tour_id' => $item->id,
                    'team_id' => $team_id,
                    'customer_id' => $customer_id,
                    'operator_id' => $operator_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

        }

        return redirect()->back()->withFlashSuccess(__('alerts.frontend.contact.sent'));
    }
}
