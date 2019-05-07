<?php /** @noinspection ALL */

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\Auth\Team;
use App\Mail\Team\SendTeamInvite;
use App\Events\Frontend\Team\TeamMemberDeleted;
use App\Http\Requests\Frontend\Team\ManageTeamRequest;
use Illuminate\Support\Facades\Mail;
use Mpociot\Teamwork\Facades\Teamwork;
use Mpociot\Teamwork\TeamInvite;
use Illuminate\Support\Str;


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
        $team = Team::findOrFail(auth()->user()->current_team_id);

        $profiles = [];
        $profile_raw = $team->extendedFields;
        $profile_rows = $profile_raw->pluck('content');

        if (!empty($profile_rows)) {
            foreach ($profile_rows as $itemKey => $itemVal) {
                if (!empty($itemVal)) {
                    $profiles[$profile_raw[$itemKey]['type']] = $itemVal;
                }
            }
        }

        return view('frontend.user.team.index')->with('team', $team)->with('profiles', $profiles);
    }


    public function show($team_id)
    {
        return false;
    }

    public function create()
    {
        return false;
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        $team = Team::findOrFail(auth()->user()->current_team_id);

        $profiles = ['formal' => ''];
        $profile_raw = $team->extendedFields;
        $profile_rows = $profile_raw->pluck('content');

        if (!empty($profile_rows)) {
            foreach ($profile_rows as $itemKey => $itemVal) {
                if (!empty($itemVal)) {
                    $profiles[$profile_raw[$itemKey]['type']] = $itemVal;
                }
            }
        }

        return view('frontend.user.team.edit')->with('team', $team)->with('profiles', $profiles);
    }

    /**
     * @param ManageTeamRequest $request
     * @param $team_id
     * @return mixed
     */
    public function update(ManageTeamRequest $request, $team_id)
    {
        $team = Team::findOrFail(auth()->user()->current_team_id);

        $company[config('teamwork.extra_field_name')] = $request->get(config('teamwork.extra_field_name'));
        $profile_type = $request->get('profile_type');
        $company_name = $company[config('teamwork.extra_field_name')][$profile_type]['company_name'];

        // Update company formal profile
        $extended_field = \App\Models\Extend::where('extendable_id', $team->id)
            ->where('type', $profile_type)
            ->where('name', config('teamwork.extra_field_name'))->first();

        $extended_field->update([
            'content' => $company[config('teamwork.extra_field_name')][$profile_type]
        ]);

        // Update team name
        if ($profile_type == 'formal') {
            $team->update([
                'name' => $company_name,
                'slug' => Str::slug($company_name)
            ]);
        }

        return redirect()->route('frontend.user.team')->withFlashSuccess(__('alerts.frontend.teams.updated'));
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public function deleteMember($user_id)
    {
        $user = User::findOrFail($user_id);

        $user_team_id = $user->current_team_id;

        $team = Team::findOrFail($user_team_id);

        event(new TeamMemberDeleted($user));

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

        $quota = config('teamwork.team_members_quota');

        $pending_invites = $team->invites->count();

        $sended_invites = session('sended_invites');

        if ($team->users->count() >= $quota) {
            return redirect()->back()->withErrors([
                'message' => __('alerts.frontend.teams.users.limit'),
            ]);
        }

        if ($sended_invites >= $quota) {
            return redirect()->back()->withErrors([
                'message' => __('alerts.frontend.teams.invite.limit'),
            ]);
        }


        if ($pending_invites >= $quota) {
            return redirect()->back()->withErrors([
                'message' => __('alerts.frontend.teams.invite.limit'),
            ]);
        }


        if (!Teamwork::hasPendingInvite($request->email, $team)) {

            $user_id = User::select('id')->where('email', $request->email)->withTrashed()->first();

            if ($user_id) {
                return redirect()->back()->withErrors([
                    'message' => __('alerts.frontend.teams.invite.rejected'),
                ]);
            } else {
                Teamwork::inviteToTeam($request->email, $team, function ($invite) {
                    Mail::send(new SendTeamInvite($invite));
                });

                // Store quontity sended invites
                session(['sended_invites' => $sended_invites + 1]);
            }

        } else {
            return redirect()->back()->withErrors([
                'message' => __('alerts.frontend.teams.invite.sent_already'),
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

        $team = Team::findOrFail($invite->team_id);

        $quota = config('teamwork.team_members_quota');

        if ($team->users->count() >= $quota) {
            return redirect()->back()->withErrors([
                'message' => __('alerts.frontend.teams.users.limit'),
            ]);
        }

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
            Teamwork::denyInvite($invite);
        } else {
            return redirect()->back()->withErrors([
                'message' => __('alerts.frontend.teams.invite.not_found'),
            ]);
        }

        return redirect()->back()->withFlashSuccess(__('alerts.frontend.teams.invite.deleted'));
    }

}