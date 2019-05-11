<?php


namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    protected static function boot()
    {
        parent::boot();

        static::deleted(function (Model $model) {
            DB::transaction(function () use ($model) {
                // Force Delete extended fields
                if ($model->isForceDeleting()) {
                    $model->extendedFields()->forceDelete();
                } else {
                    // Delete extended fields
                    if(!$model->trashed()){
                        $model->extendedFields()->delete();
                    }
                }
            });
        });
    }
}