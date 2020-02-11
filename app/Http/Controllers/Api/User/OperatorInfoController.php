<?php


namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Auth\Team;

class OperatorInfoController extends Controller
{
  public function getOperatorInfo(Request $request)
  {
    $team = Team::whereId(auth()->user()->current_team_id)->with('roles')->first();
    $subscriptions = [];
    $subscribers = [];
    $company_info = [];
    $branding = [];

    if ($team && $team->roles->contains('name', config('access.teams.agent_role'))) {
      $first_operator = $team->subscriptions->first()->id;
      if ($first_operator) {
        $operator_team = Team::whereId($first_operator)->with('roles')->first();
        $operator_profile = $operator_team->getProfilesAttribute()['formal'];
      }
    } elseif ($team && $team->roles->contains('name', config('access.teams.operator_role'))) {
      $operator_team = Team::whereId(auth()->user()->current_team_id)->with('roles')->first();
      $operator_profile = $operator_team->getProfilesAttribute()['formal'];
    }



    $branding = [
      'company_full_name'         => $operator_profile['company_full_name'],
      'company_address'   => $operator_profile['company_address'],
      'company_phone'     => $operator_profile['company_phone'],
      'company_email'     => $operator_profile['company_email'],
    ];

    return response()->json([
      compact('branding')
    ]);
  }
}
