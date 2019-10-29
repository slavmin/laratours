<?php


namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class HasCustomFields
 */
trait HasCustomFields
{
    /**
     * @return mixed
     */
    public function customFields()
    {
        return $this->morphMany('App\Models\CustomField', 'fieldable');
    }

    protected static function bootHasCustomFields()
    {
        //parent::boot();

        static::deleted(function (Model $model) {
            DB::transaction(function () use ($model) {
                // Force Delete extended fields
                if ($model->isForceDeleting()) {
                    $model->customFields()->forceDelete();
                } else {
                    // Delete extended fields
                    if(!$model->trashed()){
                        $model->customFields()->delete();
                    }
                }
            });
        });
    }
}