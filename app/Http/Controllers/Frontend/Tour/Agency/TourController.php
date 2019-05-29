<?php

namespace App\Http\Controllers\Frontend\Tour\Agency;

use App\Models\Auth\Team;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tour\Tour;
use App\Models\Tour\TourType;
use App\Models\Tour\TourCity;

class TourController extends Controller
{
    protected $tour;
    protected $city_id;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $subscriptions = [];
        $operators = [];

        $team = Team::whereId(auth()->user()->current_team_id)->first();

        if($team && $team->hasRole(config('access.teams.agent_role'))){
            $subscriptions = $team->subscriptions->pluck('id')->toArray();
            $operators = $team->subscriptions->pluck('name','id')->toArray();
        }

        $operator_id = $this->getOperatorId($request, $subscriptions);
        $city_id = $this->getCityId($request, $subscriptions);
        $type_id = $this->getTourTypeId($request, $subscriptions);

        $orderBy = 'id';
        $sort = 'desc';

        $model_alias = Tour::getModelAliasAttribute();


        if (!is_null($operator_id) && !is_null($type_id)) {

            $items = Tour::whereIn('team_id', [$operator_id])->where('tour_type_id', $type_id)->orderBy($orderBy, $sort)->AllTeams()->paginate();

        } elseif (!is_null($operator_id)) {

            $items = Tour::whereIn('team_id', [$operator_id])->orderBy($orderBy, $sort)->AllTeams()->paginate();

        } else {

            $items = Tour::whereIn('team_id', [$operator_id])->orderBy($orderBy, $sort)->AllTeams()->paginate();
        }

        // Form filters
        $cities_names = TourCity::withoutGlobalScope('team')->whereIn('team_id', $subscriptions)->get()->pluck('name','id')->toArray();

        $tour_types = TourType::withoutGlobalScope('team')->whereIn('team_id', $subscriptions)->get()->pluck('name','id')->toArray();
        $types_options = [0 => __('validation.attributes.frontend.general.select')];
        $tour_types = array_replace($types_options, $tour_types);

        return view('frontend.tour.agency.index', compact('items','operators', 'cities_names', 'tour_types'))
            ->with('operator_id', (int)$operator_id)
            ->with('city_id', (int)$city_id)
            ->with('type_id', (int)$type_id)
            ->with('route', route('frontend.agency.tour-list'))
            ->with('cancel_route', route('frontend.agency.tour-list'))
            ->with('model_alias', $model_alias);
    }


    public function show($id)
    {
        //
    }

    public static function getOperatorId(Request $request, $subscriptions)
    {
        if(!empty($subscriptions)) {
            return $request->has('operator_id') && in_array($request->query('operator_id'), $subscriptions) ?
                (int)$request->query('operator_id') : $subscriptions[0];
        } else {
            return null;
        }
    }

    public static function getCityId(Request $request, $subscriptions)
    {
        $city_ids = TourCity::withoutGlobalScope('team')->whereIn('team_id', $subscriptions)->pluck('id')->all();
        return $request->has('city_id') && $request->query('city_id') != 0
        && in_array($request->query('city_id'), $city_ids) ? $request->query('city_id') : null;
    }

    public static function getTourTypeId(Request $request, $subscriptions)
    {
        $type_ids = TourType::withoutGlobalScope('team')->whereIn('team_id', $subscriptions)->pluck('id')->all();
        return $request->has('type_id') && $request->query('type_id') != 0
        && in_array($request->query('type_id'), $type_ids) ? $request->query('type_id') : null;
    }
}
