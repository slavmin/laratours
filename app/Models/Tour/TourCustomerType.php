<?php

namespace App\Models\Tour;

use App\Models\Tour\Traits\Attribute\ActionButtonsAttribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\UsedByTeams;
use App\Models\Traits\HasPagination;

class TourCustomerType extends Model
{
    use SoftDeletes, UsedByTeams, HasPagination, ActionButtonsAttribute;

    protected $fillable = ['name', 'description'];

    protected $appends = ['model_alias'];

    public static function getModelAliasAttribute()
    {
        return 'customer-type';
    }

    public static function getCustomerTypesAttribute($text = '')
    {
        $types = self::orderBy('name', 'asc')->get()->pluck('name','id')->toArray();
        $types_options = ['' => $text];
        $types_options = array_replace($types_options, $types);

        return $types_options;
    }
}
