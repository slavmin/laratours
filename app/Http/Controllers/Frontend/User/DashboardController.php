<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Models\Auth\Team;
use App\Models\Tour\TourHotelCategory;

/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $team = Team::whereId(auth()->user()->current_team_id)->with('roles')->first();

        $show_fill_demo = false;

        $hotel_categories = TourHotelCategory::where('team_id', $team->id)->get();

        $isOperator = ($team->roles->first()->name == 'operator') ? true : false;

        if ($isOperator && count($hotel_categories) == 0) {
            $show_fill_demo = true;
        }

        return view('frontend.user.dashboard', compact('team', 'show_fill_demo'));
    }
}
