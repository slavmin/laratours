<?php

namespace App\Models\Tour;

use App\Models\Traits\UsedByTeams;
use Illuminate\Database\Eloquent\Model;

class TourPrice extends Model
{
<<<<<<< HEAD
    use UsedByTeams;

    protected $fillable = [
        'period_start',
        'period_end',
        'price',
        'tour_customer_type_id'
    ];

    public function priceable()
    {
        return $this->morphTo();
    }
=======
  use UsedByTeams;

  protected $fillable = [
    'period_start',
    'period_end',
    'price',
    'tour_customer_type_id'
  ];

  public function priceable()
  {
    return $this->morphTo();
  }
>>>>>>> dropjs
}
