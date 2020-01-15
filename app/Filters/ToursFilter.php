<?php

namespace App\Filters;

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
    // dd($this->request->all(), $this->builder->first());
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
    $this->builder->where('id', 'like', "%$value%");
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
    $this->builder->where('status', $value);
  }
}
