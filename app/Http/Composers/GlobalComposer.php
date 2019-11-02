<?php

namespace App\Http\Composers;

use Illuminate\View\View;
use App\Repositories\Backend\Auth\UserRepository;
use App\Repositories\Backend\Auth\TeamRepository;

/**
 * Class GlobalComposer.
 */
class GlobalComposer
{

    /**
     * GlobalComposer constructor.
     * @param UserRepository $userRepository
     * @param TeamRepository $teamRepository
     */
    public function __construct(UserRepository $userRepository, TeamRepository $teamRepository)
    {
        $this->userRepository = $userRepository;
        $this->teamRepository = $teamRepository;
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        $view
            ->with('logged_in_user', auth()->user())
            ->with('pending_approval', $this->userRepository->getUnconfirmedCount())
            ->with('count_inactive_users', $this->userRepository->getInactiveCount())
            ->with('count_deleted_users', $this->userRepository->getDeletedCount())
            ->with('count_deleted_teams', $this->teamRepository->getDeletedCount())
        ;
    }
}
