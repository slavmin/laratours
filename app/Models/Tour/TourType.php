<?php

namespace App\Models\Tour;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mpociot\Teamwork\Traits\UsedByTeams;

class TourType extends Model
{
    use SoftDeletes, UsedByTeams;

    protected $fillable = ['name', 'description'];
}
