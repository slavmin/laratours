<?php

namespace App\Models\Tour;

use App\Models\Traits\UsedByTeams;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Tour\Traits\UsedByCity;
use App\Models\Tour\Traits\HasObjectAttributes;
use App\Models\Traits\HasPagination;

class TourMeal extends Model
{
    use SoftDeletes, UsedByTeams, UsedByCity, HasPagination, HasObjectAttributes;

    protected $fillable = ['name', 'city_id', 'description', 'qnt'];
}
