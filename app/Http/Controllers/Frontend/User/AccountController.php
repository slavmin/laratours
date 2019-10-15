<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Models\Tour\Tour;
use App\Models\Tour\TourOrder;

/**
 * Class AccountController.
 */
class AccountController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $order_ids = TourOrder::where('customer_id', auth()->user()->id)->AllTeams()->get()->pluck('tour_id');
        $order_statuses = TourOrder::getStatusesAttribute();
        $tours = Tour::whereIn('id', $order_ids)->AllTeams()->get();
        $tour_names = $tours->pluck('name', 'id')->toArray();

        return view('frontend.user.account', compact('tour_names','order_statuses'));
    }
}
