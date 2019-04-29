<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Events\Frontend\Auth\InvitedUserRegistered;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Repositories\Frontend\Auth\UserRepository;
use Mpociot\Teamwork\Facades\Teamwork;
use Mpociot\Teamwork\TeamInvite;

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
        if (!is_null($token)) {
            $invite = \Teamwork::getInviteFromAcceptToken($token);
        }

        abort_unless(isset($invite), 404);

        session(['invite_token' => $token]);

        return view('frontend.auth.register-invited')->withEmail($invite->email);
    }


    /**
     * @param RegisterRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Throwable
     */
    public function register(RegisterRequest $request)
    {
        abort_unless(config('access.registration'), 404);

        $token = session('invite_token');
        $invite = \Teamwork::getInviteFromAcceptToken($token);

        $request->merge(['email' => $invite->email]);

        $user = $this->userRepository->create($request->only('first_name', 'last_name', 'email', 'password'));

        $user->active = true;
        $user->confirmed = true;
        $user->save();

        auth()->login($user);

        \Teamwork::acceptInvite($invite);

        //event(new InvitedUserRegistered($user));

        return redirect($this->redirectPath());
    }
}
