<?php

namespace App\Models\Tour;

use App\Models\Traits\UsedByTeams;
use Illuminate\Database\Eloquent\Model;

class TourPrice extends Model
{
  use UsedByTeams;

  protected $fillable = [
    'period_start',
    'period_end',
    'price',
    'tour_customer_type_id',
    'is_extra',
    'name',
    'tour_price_type_id'
  ];

  public function priceable()
  {
    return $this->morphTo();
  }
}
