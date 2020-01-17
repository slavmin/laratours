<?php

namespace App\Filters;

use App\Models\Tour\Tour;
use App\Models\Tour\TourOrder;
use Carbon\Carbon;

class ToursFilter
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

    return $this->builder;
  }

  public function filters()
  {
    return $this->request->all();
  }

  public function tour_name($value)
  {
    $this->builder->where('name', 'like', "%$value%");
  }

  public function type_id($value)
  {
    if (!$value) return;
    $this->builder->where('tour_type_id', $value);
  }

  public function city_id($value)
  {
    $this->builder->where('cities_list', 'like', "%\"$value\"%");
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
    $this->builder->whereIn('id', $filtered_tours);
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
    $this->builder->whereIn('id', $filtered_tours);
  }
}
