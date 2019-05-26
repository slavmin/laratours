<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Tour\Tour;
//use App\Models\Tour\TourOrder;
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

            if(!auth()->guest()){
                $customer_id = auth()->user()->id;
                $agent_id = auth()->user()->hasRole('agent') ? auth()->user()->id : null;
            } else {
                $customer_id = null;
                $agent_id = null;
            }


            $order_id = DB::table('tour_orders')->insertGetId(
                [
                    'tour_id' => $item->id,
                    'team_id' => $item->team_id,
                    'customer_id' => $customer_id,
                    'agent_id' => $agent_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

        }

        return redirect()->back()->withFlashSuccess(__('alerts.frontend.contact.sent'));
    }
}
