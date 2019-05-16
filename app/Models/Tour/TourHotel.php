<?php

namespace App\Models\Tour;

use App\Models\Tour\Traits\HasObjectAttributes;
use App\Models\Tour\Traits\UsedByCity;
use App\Models\Traits\UsedByTeams;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TourHotel extends Model
{
    use SoftDeletes, UsedByTeams, UsedByCity, HasObjectAttributes;

    protected $fillable = ['name', 'city_id', 'category_id', 'description', 'qnt'];
}
