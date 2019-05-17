<?php

namespace App\Models\Tour;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\UsedByTeams;
use App\Models\Tour\Traits\UsedByCity;
use App\Models\Tour\Traits\HasObjectAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\HasPagination;

class TourMuseum extends Model
{
    use SoftDeletes, UsedByTeams, UsedByCity, HasPagination, HasObjectAttributes;

    protected $fillable = ['name', 'city_id', 'description', 'qnt'];
}
