<?php

namespace App\Filters;

use App\Models\Tour\Tour;
use App\Models\Tour\TourOrder;
use Carbon\Carbon;

class ObjectsFilter
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

  public function name($value)
  {
    if (!$value) return;
    $this->builder->where('name', 'like', "%$value%");
  }

  public function city_id($value)
  {
    if (!$value) return;
    $this->builder->where('city_id', $value);
  }
}
