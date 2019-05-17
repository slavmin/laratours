<?php

namespace App\Models\Tour;

use App\Models\Traits\UsedByTeams;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasPagination;
use Illuminate\Database\Eloquent\SoftDeletes;

class TourTransport extends Model
{
    use SoftDeletes, UsedByTeams, HasPagination;

    protected $fillable = ['name', 'description'];
}
