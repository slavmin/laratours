<?php

namespace App\Models\Tour;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\UsedByTeams;

class TourExtra extends Model
{
  use UsedByTeams;

  // protected $table = 'tour_extras';

  protected $fillable = [
    'name',
    'description',
    'tour_id',
    'value',
    'price',
    'margin',
    'commission',
  ];
}
