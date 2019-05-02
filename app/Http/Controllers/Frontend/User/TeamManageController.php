<?php

namespace App\Http\Controllers\Frontend\User;

use App\Mail\Team\SendTeamInvite;
use App\Models\Auth\Team;
use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Http\Requests\Frontend\Team\ManageTeamRequest;
use Illuminate\Support\Facades\Mail;
use Mpociot\Teamwork\Facades\Teamwork;
use Mpociot\Teamwork\TeamInvite;


/**
 * Class TeamManageController
 * @package App\Http\Controllers\Frontend\User
 */
class TeamManageController extends Controller
{

    /**
     * TeamManageController constructor.
     */
    public function __construct()
    {
        $this->middleware('teamowner');
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('frontend.user.team.show');
    }


    public function show()
    {
        return false;
    }

    public function create()
    {
        return false;
    }

    public function edit()
    {
        return false;
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public function destroy($user_id)
    {
        $user = User::findOrFail($user_id);

        $user_team_id = $user->current_team_id;

        $team = Team::findOrFail($user_team_id);

        $user->detachTeam($team);

        $user->current_team_id = $user_team_id;

        $user->save();

        User::destroy($user->id);

        return redirect()->route('frontend.user.team')->withFlashSuccess(__('alerts.frontend.teams.users.deleted'));
    }

    /**
     * @param Request $request
     * @param $team_id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function invite(ManageTeamRequest $request, $team_id)
    {
        $team = Team::findOrFail($team_id);

        if (!Teamwork::hasPendingInvite($request->email, $team)) {

            $user_id = User::select('id')->where('email', $request->email)->first();

            if ($user_id) {
                return redirect()->back()->withErrors([
                    'email' => __('alerts.frontend.teams.invite.rejected'),
                ]);
            } else {
                Teamwork::inviteToTeam($request->email, $team, function ($invite) {
                    Mail::send(new SendTeamInvite($invite));
                });
            }

        } else {
            return redirect()->back()->withErrors([
                'email' => __('alerts.frontend.teams.invite.sent_already'),
            ]);
        }

        return redirect()->back()->withFlashSuccess(__('alerts.frontend.teams.invite.sent'));
    }

    /**
     * @param $invite_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resendInvite($invite_id)
    {
        $invite = TeamInvite::findOrFail($invite_id);

        $user_id = User::select('id')->where('email', $invite->email)->first();

        if ($user_id) {
            return redirect()->back()->withErrors([
                'message' => __('alerts.frontend.teams.invite.rejected'),
            ]);
        } else {
            Mail::send(new SendTeamInvite($invite));
        }

        return redirect()->back()->withFlashSuccess(__('alerts.frontend.teams.invite.sent'));
    }


    /**
     * @param $invite_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteInvite($invite_id)
    {
        $invite = TeamInvite::findOrFail($invite_id);

        if ($invite) {
            \Teamwork::denyInvite($invite);
        } else {
            return redirect()->back()->withErrors([
                'message' => __('alerts.frontend.teams.invite.not_found'),
            ]);
        }

        return redirect()->back()->withFlashSuccess(__('alerts.frontend.teams.invite.deleted'));
    }

}