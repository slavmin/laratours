<?php

namespace App\Http\Controllers\Backend\Auth\Team;

use App\Models\Auth\Team;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Auth\Team\ManageTeamRequest;
use App\Http\Requests\Backend\Auth\Team\StoreTeamRequest;
use App\Http\Requests\Backend\Auth\Team\UpdateTeamRequest;
use App\Models\Auth\User;
use App\Repositories\Backend\Auth\TeamRepository;
use Illuminate\Support\Str;
use App\Models\Extend;


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

        return view('backend.auth.team.show')
            ->with('profiles', $profiles)
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

        return view('backend.auth.team.edit')
            ->with('profiles', $profiles)
            ->withTeam($team);
    }


    /**
     * @param UpdateTeamRequest $request
     * @param Team $team
     * @return mixed
     */
    public function update(UpdateTeamRequest $request, Team $team)
    {
        $company[config('teamwork.extra_field_name')] = $request->get(config('teamwork.extra_field_name'));
        $profile_type = $request->get('profile_type');
        $company_name = $company[config('teamwork.extra_field_name')][$profile_type]['company_name'];

        // Update company profile
        $extended_field = Extend::where('extendable_id', $team->id)
            ->where('type', $profile_type)
            ->where('name', config('teamwork.extra_field_name'))->first();

        $extended_field->update([
            'content' => $company[config('teamwork.extra_field_name')][$profile_type]
        ]);

        // Update team name
        if ($profile_type == 'formal') {
            $team->update([
                'name' => $company_name,
                'slug' => \Str::slug($company_name)
            ]);
        }

        return redirect()->route('admin.auth.team.index')->withFlashSuccess(__('alerts.backend.teams.updated'));
    }


    /**
     * @param StoreTeamRequest $request
     * @return mixed
     */
    public function store(StoreTeamRequest $request)
    {
        $team_name = $request->name;
        $team_slug = \Str::slug($request->name);

        $this->teamRepository->create([
            'name' => $team_name,
            'slug' => \Str::slug($team_slug)
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

        User::where('current_team_id', $team->id)->update(['active' => false]);

        return redirect()->route('admin.auth.team.deleted')->withFlashSuccess(__('alerts.backend.teams.deleted'));
    }


}