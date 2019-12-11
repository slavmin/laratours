<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Models\Auth\Team;

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
    
        return view('frontend.user.dashboard', compact('team'));
    }
}
