<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Helpers\Auth\SocialiteHelper;
use App\Http\Requests\RegisterRequest;
use App\Events\Frontend\Auth\UserRegistered;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Repositories\Frontend\Auth\UserRepository;
use App\Models\Auth\Team;

/**
 * Class RegisterController.
 */
class RegisterController extends Controller
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
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        abort_unless(config('access.registration'), 404);

        return view('frontend.auth.register')
            ->withSocialiteLinks((new SocialiteHelper)->getSocialLinks());
    }

    /**
     * @param RegisterRequest $request
     *
     * @throws \Throwable
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function register(RegisterRequest $request)
    {
        abort_unless(config('access.registration'), 404);

        $company[config('teamwork.extra_field_name')] = $request->get(config('teamwork.extra_field_name'));

        $company_name = $company[config('teamwork.extra_field_name')]['formal']['company_name'];

        $user = $this->userRepository->create($request->only('first_name', 'last_name', 'email', 'password'));

        // Create team for company
        $team = Team::create([
            'name' => $company_name,
            'owner_id' => $user->id,
        ]);

        // Attach user to team
        $user->attachTeam($team);

        // Create and fill company profile
        $team->profiles()->create([
            'type'    => 'formal',
            'content' => $company[config('teamwork.extra_field_name')]['formal'],
        ]);

        // If the user must confirm their email or their account requires approval,
        // create the account but don't log them in.
        if (config('access.users.confirm_email') || config('access.users.requires_approval')) {
            event(new UserRegistered($user));

            return redirect($this->redirectPath())->withFlashSuccess(
                config('access.users.confirm_email') ?
                    __('exceptions.frontend.auth.confirmation.created_confirm') :
                    __('exceptions.frontend.auth.confirmation.created_pending')
            );
        }

        auth()->login($user);

        event(new UserRegistered($user));

        return redirect($this->redirectPath());
    }
}
