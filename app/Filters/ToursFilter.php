<?php

namespace App\Filters;

class ToursFilter
{
  protected $builder;
  protected $request;

  public function __construct($builder, $request) 
  {
    $this->builder = $builder->where('published', 1);
    $this->request = $request;
  }

  public function apply() 
  {
    foreach($this->filters() as $filter => $value) {
      if(method_exists($this, $filter)) {
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
}