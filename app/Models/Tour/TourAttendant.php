<?php

namespace App\Models\Tour;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\UsedByTeams;

class TourAttendant extends Model
{
    use UsedByTeams;

    protected $fillable = ['name', 'description', 'price'];

    protected $casts = [
        'price' => 'float',
    ];
}
