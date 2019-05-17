<?php

namespace App\Models\Tour;

use App\Models\Tour\TourCity;
use App\Models\Tour\TourCountry;
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


//    public function getCityAttribute()
//    {
//        $cities = TourCity::all()->pluck('name', 'id')->toArray();
//
//        if (in_array($this->city_id, array_keys($cities))) {
//            return ucwords($cities[$this->city_id]);
//        }
//
//        return 'N/A';
//    }

}
