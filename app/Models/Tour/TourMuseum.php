<?php

namespace App\Models\Tour;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\UsedByTeams;

class TourMuseum extends Model
{
    use UsedByTeams;

    protected $fillable = ['name', 'city_id', 'description', 'price'];

    protected $casts = [
        'price' => 'float',
    ];
}
