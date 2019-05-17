<?php

namespace App\Models\Tour;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\UsedByTeams;
use App\Models\Traits\HasPagination;

class TourHotelCategory extends Model
{
    use SoftDeletes, UsedByTeams, HasPagination;

    protected $fillable = ['name', 'description'];


    public static function getHotelCategoriesAttribute($text = '')
    {
        $categories = self::orderBy('name', 'asc')->get()->pluck('name','id')->toArray();
        $categories_options = ['' => $text];
        $categories_options = array_replace($categories_options, $categories);

        return $categories_options;
    }
}
