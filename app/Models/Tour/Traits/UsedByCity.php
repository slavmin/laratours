<?php


namespace App\Models\Tour\Traits;

use App\Models\Tour\TourCity;
use App\Models\Tour\TourCountry;
use Illuminate\Http\Request;

/**
 * Class UsedByCity
 */
trait UsedByCity
{
    // Relation
    public function city()
    {
        return $this->belongsTo('App\Models\Tour\TourCity')->withDefault();
    }

    public static function getCityIds()
    {
        return TourCity::pluck('id')->all();
    }

    public static function getCityName($city_id, $text = '')
    {
        $city_name = TourCity::where('id', $city_id)->pluck('name')->first();
        return !is_null($city_name) ? ucwords($city_name) : $text;
    }

    public static function getCitiesAttribute($text = '')
    {
        $cities = TourCity::orderBy('name', 'asc')->get()->pluck('name','id')->toArray();
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

    public function saveObjectAttributes($attributes)
    {
        if(is_array($attributes)) {
            foreach ($attributes as $attribute) {
                return $this->objectables()->updateOrCreate(
                    ['id' => $attribute['id']],
                    ['name' => $attribute['name'], 'qnt' => $attribute['qnt'] ?? null, 'price' => $attribute['price'] ?? null,
                        'description' => $attribute['description'] ?? null, 'extra' => $attribute['extra'] ?? null, 'customer_type_id' => $attribute['customer_type_id'] ?? null]
                );
            }
        }
    }

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