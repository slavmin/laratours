<?php

namespace App\Models\Tour;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\UsedByTeams;
use App\Models\Traits\HasPagination;
use App\Models\Traits\HasProfile;
use Illuminate\Database\Eloquent\SoftDeletes;

class TourAttendant extends Model
{
    use UsedByTeams, HasProfile, HasPagination, SoftDeletes;

    protected $fillable = ['name', 'description', 'price'];

    protected $casts = [
        'price' => 'float',
    ];
}
