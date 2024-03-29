<?php

namespace App\Http\Controllers\Frontend\Tour\Agency;

use App\Http\Controllers\Controller;
use App\Models\Auth\Team;
use App\Models\Tour\Tour;
use App\Models\Tour\TourCity;
use App\Models\Tour\TourType;
use Illuminate\Http\Request;
use App\Filters\OrdersFilter;
use App\Models\Tour\TourDate;
use App\Models\Tour\TourPrice;
use Carbon\Carbon;

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
    $operators = Team::getTeamSubscriptions();

    $subscriptions = array_keys($operators);

    $operator_id = $this->getOperatorId($request, $subscriptions);
    $agent_id = auth()->user()->currentTeam->getKey();
    $city_id = $this->getCityId($request, $subscriptions);
    $type_id = $this->getTourTypeId($request, $subscriptions);
    $name = $this->getTourName($request);

    $orderBy = 'id';
    $sort = 'desc';

    $model_alias = Tour::getModelAliasAttribute();

    $items = Tour::whereIn('team_id', $subscriptions)->with(['orderprofiles' => function ($query) {
      $query->select(['profiles.profileable_id as order_id', 'profiles.type', 'profiles.content']);
    }])->where('published', 1)->AllTeams();
    $items = (new OrdersFilter($items, $request))->apply()->orderBy($orderBy, $sort)->paginate();

    foreach ($items as $item) {
      $item['prices'] = TourPrice::where('priceable_type', 'App\Models\Tour\Tour')
        ->where('priceable_id', $item->id)
        ->AllTeams()
        ->get();

      $date = TourDate::where('tour_id', $item->id)->AllTeams()->first();

      $item['start_date'] = Carbon::createFromDate($date->date)
        ->locale('ru')
        ->isoFormat('DD MMMM YYYY');
    }

    $cities_names = TourCity::withoutGlobalScope('team')->whereIn('team_id', $subscriptions)->get()->pluck('name', 'id')->toArray();
    // Form filters
    // Tour types by operator
    $tour_types = TourType::whereIn('team_id', [$operator_id])->orderBy($orderBy, $sort)->AllTeams()->get()->pluck('name', 'id')->toArray();
    $types_options = [0 => __('validation.attributes.frontend.general.select')];
    $tour_types = array_replace($types_options, $tour_types);

    if ($request->expectsJson()) {
      return response()->json($items->toArray());
    }

    return view('frontend.tour.agency.index', compact('items', 'operators', 'cities_names', 'tour_types'))
      ->with('operator_id', (int) $operator_id)
      ->with('city_id', (int) $city_id)
      ->with('type_id', (int) $type_id)
      ->with('name', $name)
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
    if (!empty($subscriptions)) {
      return $request->has('operator_id') && in_array($request->query('operator_id'), $subscriptions) ?
        (int) $request->query('operator_id') : $subscriptions[0];
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

  public static function getTourName(Request $request)
  {
    return $request->has('name') ? $request->query('name') : null;
  }
}
