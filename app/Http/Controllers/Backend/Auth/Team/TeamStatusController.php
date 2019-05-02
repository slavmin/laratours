<?php

namespace App\Http\Controllers\Backend\Auth\Team;

use App\Models\Auth\User;
use App\Exceptions\GeneralException;
use App\Models\Auth\Team;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Auth\Team\ManageTeamRequest;
use App\Repositories\Backend\Auth\TeamRepository;


/**
 * Class TeamStatusController
 * @package App\Http\Controllers\Backend\Auth\Team
 */
class TeamStatusController extends Controller
{
    /**
     * @var TeamRepository
     */
    protected $teamRepository;


    /**
     * TeamStatusController constructor.
     * @param TeamRepository $teamRepository
     */
    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    /**
     * @param ManageTeamRequest $request
     * @param Team $team
     * @return mixed
     */
    public function getDeleted(ManageTeamRequest $request, Team $team)
    {
        return view('backend.auth.team.deleted')
            ->withTeams($this->teamRepository->getDeletedPaginated(25, 'id', 'asc'));
    }


    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function restore($id)
    {
        $team = Team::withTrashed()->find($id);

        if ($team->deleted_at === null) {
            throw new GeneralException(__('exceptions.backend.access.teams.cant_restore'));
        }

        if ($team->restore()) {

            User::whereIn('id', $team->users->pluck('id'))->update(['active' => true, 'current_team_id' => $team->id]);

            //event(new TeamRestored($team));

            return redirect()->route('admin.auth.team.index')->withFlashSuccess(__('alerts.backend.teams.restored'));
        }

        throw new GeneralException(__('exceptions.backend.access.teams.restore_error'));
    }


    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function delete($id)
    {
        $team = Team::withTrashed()->find($id);

        if ($team->deleted_at === null) {
            throw new GeneralException(__('exceptions.backend.access.teams.cant_restore'));
        }

        User::where('current_team_id', $team->id)->update(['current_team_id' => null]);

        $team->forceDelete();

        return redirect()->route('admin.auth.team.deleted')->withFlashSuccess(__('alerts.backend.teams.deleted_permanently'));
    }

}