<?php

namespace App\Models\Tour;

use App\Models\Tour\TourCity;
use App\Models\Tour\TourCountry;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\UsedByTeams;

class TourMuseum extends Model
{
    use UsedByTeams;

    protected $fillable = ['name', 'city_id', 'description', 'price'];

    protected $casts = [
        'price' => 'float',
    ];

    /**
     * @return string
     */
    public function getCityAttribute()
    {
        $cities = TourCity::all()->pluck('name', 'id')->toArray();

        if (in_array($this->city_id, array_keys($cities))) {
            return ucwords($cities[$this->city_id]);
        }

        return 'N/A';
    }

    public static function getCitiesAttribute($text = '')
    {
        $cities = TourCity::all()->pluck('name','id')->toArray();
        $cities_options = [0 => $text];
        $cities_options = array_replace($cities_options, $cities);

        return $cities_options;
    }

    public static function getCitiesOptgroupAttribute($text = '')
    {
        $out_arr = [0 => $text];
        $arr = TourCountry::whereHas('cities')->with(['cities'])->get()->flatten()->toArray();

        foreach ($arr as $val) {
            $city_arr = [];
            if (is_array($val['cities'])) {
                foreach ($val['cities'] as $city) {
                    $city_arr[$city['id']] = $city['name'];
                }
            }
            $out_arr[$val['name']] = $city_arr;
        }

        return $out_arr;
    }
}
