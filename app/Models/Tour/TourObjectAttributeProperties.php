<?php

namespace App\Models\Tour;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\UsedByTeams;

class TourObjectAttributeProperties extends Model
{
  use UsedByTeams;

  protected $table = 'tour_object_attribute_properties';

  protected $fillable = [
    'name',
    'description',
    'value',
    'duration',
    'tour_id',
    'tour_price_type_id',
    'object_attribute_id',
    'days_array',
    'days'
  ];
}
