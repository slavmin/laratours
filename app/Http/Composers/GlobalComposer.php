<?php

namespace App\Http\Composers;

use Illuminate\View\View;
use App\Repositories\Backend\Auth\UserRepository;

/**
 * Class GlobalComposer.
 */
class GlobalComposer
{
    /**
     * GlobalComposer constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('logged_in_user', auth()->user());
        if (config('access.users.requires_approval')) {
            //$view->with('pending_approval', $this->userRepository->getUnconfirmedCount());
            $view->with('pending_approval', $this->userRepository->getInactiveCount());
        } else {
            $view->with('pending_approval', 0);
        }
    }
}
