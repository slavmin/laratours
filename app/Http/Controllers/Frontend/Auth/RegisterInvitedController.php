<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Events\Frontend\Auth\UserLoggedIn;
use App\Events\Frontend\Team\TeamMemberAdded;
use App\Http\Controllers\Controller;
use App\Events\Frontend\Auth\UserInvitedRegistered;
use App\Http\Requests\RegisterInvitedRequest;
use App\Models\Auth\Team;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Repositories\Frontend\Auth\UserRepository;
use Illuminate\Validation\Rule;
use Mpociot\Teamwork\Facades\Teamwork;


/**
 * Class RegisterInvitedController.
 */
class RegisterInvitedController extends Controller
{
    use RegistersUsers;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * RegisterController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Where to redirect users after login.
     *
     * @return string
     */
    public function redirectPath()
    {
        return route(home_route());
    }


    /**
     * @param null $token
     * @return mixed
     */
    public function showRegistrationForm($token = null)
    {
        abort_unless(config('access.registration'), 404);

        if (!is_null($token)) {
            $invite = Teamwork::getInviteFromAcceptToken($token);
        }

        abort_unless(isset($invite), 404);

        $team = Team::findOrFail($invite->team_id);

        $quota = config('teamwork.team_members_quota');

        if ($team->users->count() < $quota) {

            session(['invite_token' => $token]);
            return view('frontend.auth.register-invited')->withEmail($invite->email);

        } else {

            return redirect($this->redirectPath())->withErrors([
                'message' => __('alerts.frontend.teams.users.limit').' '.$invite->team->name,
            ]);

        }
    }


    /**
     * @param RegisterInvitedRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Throwable
     */
    public function register(RegisterInvitedRequest $request)
    {
        abort_unless(config('access.registration'), 404);

        $token = session('invite_token');
        $invite = Teamwork::getInviteFromAcceptToken($token);

        $request->merge(['email' => $invite->email, 'no_need_confirm' => true]);

        $request->validate([
            'email' => ['required', 'string', 'email', 'max:191', Rule::unique('users')],
        ]);

        $user = $this->userRepository->create($request->only('first_name', 'last_name', 'email', 'password', 'no_need_confirm'));

        $user->active = true;
        $user->confirmed = true;
        $user->save();

        auth()->login($user);

        Teamwork::acceptInvite($invite);

        event(new UserInvitedRegistered($user));

        event(new UserLoggedIn($user));

        event(new TeamMemberAdded($user));

        return redirect($this->redirectPath())->withFlashSuccess(__('alerts.frontend.auth.registered'));
    }
}
