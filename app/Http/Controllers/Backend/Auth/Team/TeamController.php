<?php

namespace App\Http\Controllers\Backend\Auth\Team;

use App\Models\Auth\User;
use App\Models\Auth\Team;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Auth\Team\ManageTeamRequest;
use App\Http\Requests\Backend\Auth\Team\StoreTeamRequest;
use App\Http\Requests\Backend\Auth\Team\UpdateTeamRequest;
use App\Repositories\Backend\Auth\TeamRepository;
use Illuminate\Support\Str;


/**
 * Class TeamController
 * @package App\Http\Controllers\Backend\Auth\Team
 */
class TeamController extends Controller
{

    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }


    /**
     * @param ManageTeamRequest $request
     * @return mixed
     */
    public function index(ManageTeamRequest $request)
    {
        return view('backend.auth.team.index')
            ->withTeams($this->teamRepository->getActivePaginated(25, 'id', 'asc'));
    }

    /**
     * @param ManageTeamRequest $request
     * @param Team $team
     * @return mixed
     */
    public function show(ManageTeamRequest $request, Team $team)
    {
        return view('backend.auth.team.show')
            ->withTeam($team);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('backend.auth.team.create');
    }


    /**
     * @param StoreTeamRequest $request
     * @param Team $team
     * @return mixed
     */
    public function edit(Team $team)
    {
        return view('backend.auth.team.edit')->withTeam($team);
    }


    /**
     * @param UpdateTeamRequest $request
     * @param Team $team
     * @return mixed
     */
    public function update(UpdateTeamRequest $request, Team $team)
    {
        $team_name = $request->name;
        $team_slug = Str::slug($request->name);

        $this->teamRepository->updateById($team->id, [
            'name' => $team_name,
            'slug' => Str::slug($team_slug)
        ]);

        return redirect()->route('admin.auth.team.index')->withFlashSuccess(__('alerts.backend.teams.updated'));
    }


    /**
     * @param StoreTeamRequest $request
     * @return mixed
     */
    public function store(StoreTeamRequest $request)
    {
        $team_name = $request->name;
        $team_slug = Str::slug($request->name);

        $this->teamRepository->create([
            'name' => $team_name,
            'slug' => Str::slug($team_slug)
        ]);

        return redirect()->route('admin.auth.team.index')->withFlashSuccess(__('alerts.backend.teams.created'));
    }

    /**
     * @param ManageTeamRequest $request
     * @param Team $team
     * @return mixed
     * @throws \Exception
     */
    public function destroy(ManageTeamRequest $request, Team $team)
    {
        $this->teamRepository->deleteById($team->id);

        //event(new TeamDeleted($team));

        return redirect()->route('admin.auth.team.deleted')->withFlashSuccess(__('alerts.backend.teams.deleted'));
    }


}