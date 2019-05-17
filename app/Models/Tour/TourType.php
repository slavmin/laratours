<?php

namespace App\Models\Tour;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\UsedByTeams;
use App\Models\Traits\HasPagination;

class TourType extends Model
{
    use SoftDeletes, UsedByTeams, HasPagination;

    protected $fillable = ['name', 'description'];
}
