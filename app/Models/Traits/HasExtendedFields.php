<?php


namespace App\Models\Traits;


//use Exception;
//use Illuminate\Database\Eloquent\Builder;
//use Illuminate\Database\Eloquent\Model;
//use Illuminate\Support\Facades\Config;

/**
 * Class HasExtendedFields
 */
trait HasExtendedFields
{
    /**
     * @return mixed
     */
    public function extendedFields()
    {
        return $this->morphMany('App\Models\Extend', 'extendable');
    }
}