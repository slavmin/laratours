<?php

namespace App\Models\Tour;

use App\Models\Traits\HasProfile;
use App\Models\Traits\UsedByTeams;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasPagination;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Tour\Traits\UsedByCity;
use App\Models\Tour\Traits\HasObjectAttributes;

class TourTransport extends Model
{
    use SoftDeletes, UsedByTeams, UsedByCity, HasPagination, HasProfile, HasObjectAttributes;

    protected $fillable = ['name', 'city_id', 'description', 'qnt'];
}
