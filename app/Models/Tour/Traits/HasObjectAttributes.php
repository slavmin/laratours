<?php


namespace App\Models\Tour\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class HasExtendedFields
 */
trait HasObjectAttributes
{
    /**
     * @return mixed
     */
    public function objectables()
    {
        return $this->morphMany('App\Models\Tour\TourObjectAttributes', 'objectable');
    }


    protected static function bootHasObjectAttributes()
    {
        static::deleted(function (Model $model) {
            DB::transaction(function () use ($model) {
                // Force Delete objectables
                if ($model->isForceDeleting()) {
                    $model->objectables()->forceDelete();
                } else {
                    // Delete objectables
                    if(!$model->trashed()){
                        $model->objectables()->delete();
                    }
                }
            });
        });
    }
}