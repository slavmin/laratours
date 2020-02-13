<?php

namespace App\Models\Tour;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\UsedByTeams;

class TourObjectAttributes extends Model
{
  use UsedByTeams;

  protected $table = 'tour_object_attributes';

  protected $fillable = ['name', 'description', 'qnt', 'price', 'extra', 'customer_type_id'];

  protected $casts = [
    'price' => 'float',
    'extra' => 'array'
  ];

  protected $appends = ['model_alias'];

  public static function getModelAliasAttribute()
  {
    return 'object-attributes';
  }

  public function objectable()
  {
    return $this->morphTo();
  }

  public function priceable()
  {
    return $this->morphMany('App\Models\Tour\TourPrice', 'priceable');
  }
}
