<?php

namespace App\Models\Tour;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\UsedByTeams;
use App\Models\Traits\HasPagination;

class TourCustomerType extends Model
{
    use SoftDeletes, UsedByTeams, HasPagination;

    protected $fillable = ['name', 'description'];

    public static function getCustomerTypesAttribute($text = '')
    {
        $types = self::orderBy('name', 'asc')->get()->pluck('name','id')->toArray();
        $types_options = ['' => $text];
        $types_options = array_replace($types_options, $types);

        return $types_options;
    }
}
