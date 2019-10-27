<?php

namespace App\Http\Controllers\frontend\auth;

use App\Helpers\Auth\SocialiteHelper;
use App\Http\Requests\Frontend\Auth\RegisterUserRequest;
use App\Repositories\Frontend\Auth\UserRepository;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SignupController extends Controller
{
    use RegistersUsers;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * SignupController constructor.
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
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        abort_unless(config('access.registration'), 404);

//        return view('frontend.auth.register')
//            ->withSocialiteLinks((new SocialiteHelper)->getSocialLinks());
    }

    /**
     * @param RegisterUserRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Throwable
     */
    public function register(RegisterUserRequest $request)
    {
        abort_unless(config('access.registration'), 404);

        $user = $this->userRepository->create($request->only('first_name', 'last_name', 'email', 'password'));

        // If no manual user activation needed
        // $user->active = true;
        // $user->save();

        return redirect($this->redirectPath());
    }
}
