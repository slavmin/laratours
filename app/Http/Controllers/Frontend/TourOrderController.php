<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Tour\Tour;
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
        $item = Tour::whereId($request->get('tour_id'))->AllTeams()->first();

        $request->validate([
            //'name' => 'required',
            'tour_id' => 'required|exists:tours,id',
        ]);

        $order_id = DB::table('tour_orders')->insertGetId(
            [
                'tour_id' => $item->id,
                'team_id' => $item->team_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        if($order_id)
        {
            DB::table('tour_customers')->insert(
                [
                    'order_id' => $order_id,
                    'customer_id' => auth()->user()->id ?? null,
                    'team_id' => $item->team_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        return redirect()->back()->withFlashSuccess(__('alerts.frontend.contact.sent'));
    }
}
