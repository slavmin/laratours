<?php

namespace App\Filters;

use App\Models\Tour\Tour;
use App\Models\Tour\TourOrder;
use Carbon\Carbon;

class OrdersFilter
{
  protected $builder;
  protected $request;

  public function __construct($builder, $request)
  {
    $this->builder = $builder;
    $this->request = $request;
  }

  public function apply()
  {
    // dd($this->request->all(), $this->builder->get());
    foreach ($this->filters() as $filter => $value) {
      if (method_exists($this, $filter)) {
        $this->$filter($value);
      }
    }
    // dd($this->builder->first());
    return $this->builder;
  }

  public function filters()
  {
    return $this->request->all();
  }

  public function id($value)
  {
    if (!$value) return;
    $this->builder->where('id', $value);
  }

  public function name($value)
  {
    $this->builder->where('name', 'like', "%$value%");
  }

  public function operator_id($value)
  {
    $this->builder->whereIn('team_id', [$value]);
  }

  public function type_id($value)
  {
    if (!$value) return;
    $this->builder->where('tour_type_id', $value);
  }

  public function status($value)
  {
    if ($value === null) return;
    $this->builder->where('status', $value);
  }

  public function city_id($value)
  {
    if (!$value) return;
    $tours_by_city_id = Tour::where('cities_list', 'like', "%\"$value\"%")
      ->get()
      ->pluck('id')
      ->toArray();
    // dd($tours_by_city_id);

    $this->builder->whereIn('tour_id', $tours_by_city_id);
  }

  public function tour_id($value)
  {
    if (!$value) return;

    $this->builder->where('tour_id', $value);
  }

  public function date_start($value)
  {
    if (!$value) return;
    $date = Carbon::parse($value)->timestamp;
    $all_tours = Tour::select('id')
      ->get()
      ->toArray();

    $filtered_tours = [];

    foreach ($all_tours as $tour) {
      if ($tour['tour_dates'] != []) {
        $tour_date_start = Carbon::parse($tour['tour_dates'][0])->timestamp;
      }
      if ($date <= $tour_date_start) {
        array_push($filtered_tours, $tour['id']);
      };
    };
    $this->builder->whereIn('tour_id', $filtered_tours);
  }
  public function date_end($value)
  {
    if (!$value) return;
    $date = Carbon::parse($value)->timestamp;
    $all_tours = Tour::select('id')
      ->get()
      ->toArray();

    $filtered_tours = [];

    foreach ($all_tours as $tour) {
      if ($tour['tour_dates'] != []) {
        $tour_date_start = Carbon::parse($tour['tour_dates'][0])->timestamp;
      }
      if ($date >= $tour_date_start) {
        array_push($filtered_tours, $tour['id']);
      };
    };
    $this->builder->whereIn('tour_id', $filtered_tours);
  }

  public function tourist_name($value)
  {
    if (!$value) return;
    $all_orders = TourOrder::with('profiles')->select('id')->get();

    $filtered_order_ids = [];

    foreach ($all_orders as $order) {

      $profiles = $order->profiles[0]['content'];

      foreach ($profiles as $profile) {

        $full_name = mb_strtolower($profile['first_name'] . ' ' . $profile['last_name']);
        $search_subsr = mb_strtolower($value);
        if (mb_strpos($full_name, $search_subsr) !== false) {
          array_push($filtered_order_ids, $order->id);
        };
      }
    }

    $this->builder->whereIn('id', $filtered_order_ids);
  }
}
