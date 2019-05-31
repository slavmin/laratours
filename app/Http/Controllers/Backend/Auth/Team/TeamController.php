<?php

namespace App\Http\Controllers\Backend\Auth\Team;

use App\Exceptions\GeneralException;
use App\Models\Auth\Team;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Auth\Team\ManageTeamRequest;
use App\Http\Requests\Backend\Auth\Team\StoreTeamRequest;
use App\Http\Requests\Backend\Auth\Team\UpdateTeamRequest;
use App\Models\Auth\User;
use App\Repositories\Backend\Auth\RoleRepository;
use App\Repositories\Backend\Auth\TeamRepository;
use Illuminate\Support\Collection;


/**
 * Class TeamController
 * @package App\Http\Controllers\Backend\Auth\Team
 */
class TeamController extends Controller
{

    /**
     * @var TeamRepository
     */
    protected $teamRepository;

    /**
     * TeamController constructor.
     * @param TeamRepository $teamRepository
     */
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
        $profiles = $team->getProfilesAttribute();

        return view('backend.auth.team.show')
            ->with('profiles', $profiles)
            ->withTeam($team);
    }

    /**
     * @param RoleRepository $roleRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(RoleRepository $roleRepository)
    {
        return view('backend.auth.team.create')
            ->withRoles($roleRepository->whereIn('name', [config('access.teams.operator_role'), config('access.teams.agent_role')])->get())
            ->withTeamRoles([]);
    }


    /**
     * @param Team $team
     * @param RoleRepository $roleRepository
     * @return mixed
     */
    public function edit(Team $team, RoleRepository $roleRepository)
    {
        $profiles = $team->getProfilesAttribute();

        $operators = new Collection();

        if($team->hasRole(config('access.teams.agent_role'))) {
            $operators = Team::whereHas("roles", function ($q) {
                $q->where('name', config('access.teams.operator_role'));
            })->get();
        }

        return view('backend.auth.team.edit')
            ->with('operators', $operators)
            ->with('profiles', $profiles)
            ->withTeam($team)
            ->withRoles($roleRepository->whereIn('name', [config('access.teams.operator_role'), config('access.teams.agent_role')])->get())
            ->withTeamRoles($team->roles->pluck('name')->all())
            ->withTeamSubscriptions($team->subscriptions->pluck('id')->toArray());
    }


    /**
     * @param UpdateTeamRequest $request
     * @param Team $team
     * @return mixed
     * @throws GeneralException
     */
    public function update(UpdateTeamRequest $request, Team $team)
    {
        $profile = $request->get('profile');
        $profile_type = $request->get('profile_type');
        $company_name = $profile[$profile_type]['company_name'];

        // Team must have at least one role
        if (!isset($profile_type) && !is_array($request->get('roles'))) {
            throw new GeneralException(__('exceptions.backend.access.users.role_needed_create'));
        }

        // Update company profile
        $team->profiles()->updateOrCreate([
                'type' => $profile_type,
            ],
            [
                'type' => $profile_type,
                'content' => $profile[$profile_type],
            ]);

        // Update team name
        if ($profile_type == 'formal') {
            $team->update([
                'name' => $company_name,
            ]);
        }

        if (is_array($request->get('roles'))) {
            // Add selected roles/permissions
            $team->syncRoles($request->get('roles'));
            $team->syncPermissions($request->get('permissions'));
        }

        // Add selected subscriptions
        $team->subscriptions()->sync($request->get('subscriptions'));

        return redirect()->route('admin.auth.team.index')->withFlashSuccess(__('alerts.backend.teams.updated'));
    }


    /**
     * @param StoreTeamRequest $request
     * @return mixed
     * @throws GeneralException
     */
    public function store(StoreTeamRequest $request)
    {
        $team_name = $request->name;

        // Team must have at least one role
        if (!is_array($request->get('roles'))) {
            throw new GeneralException(__('exceptions.backend.access.users.role_needed_create'));
        }

        $team = $this->teamRepository->create([
            'name' => $team_name,
        ]);

        // Add selected roles/permissions
        $team->syncRoles($request->get('roles'));
        $team->syncPermissions($request->get('permissions'));

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

        User::where('current_team_id', $team->id)->update(['active' => false]);

        return redirect()->route('admin.auth.team.deleted')->withFlashSuccess(__('alerts.backend.teams.deleted'));
    }


}