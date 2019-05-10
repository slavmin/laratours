<?php

namespace App\Models\Auth;

use App\Events\Backend\Auth\Team\TeamDeleted;
use App\Models\Auth\Traits\Attribute\TeamAttribute;
use App\Models\Auth\Traits\Method\TeamMethod;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mpociot\Teamwork\TeamworkTeam;
//use Mpociot\Teamwork\Facades\Teamwork;
//use Mpociot\Teamwork\TeamInvite;

/**
 * Class Team.
 */
class Team extends TeamworkTeam
{
    use TeamAttribute, TeamMethod, SoftDeletes;

    /**
     * @var array
     */
    protected $dispatchesEvents = [
        'forceDeleted' => TeamDeleted::class,
    ];

//    protected $with = ['extendedFields'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function extendedFields()
    {
        return $this->morphMany('App\Models\Extend', 'extendable');
    }

    /**
     * @return array
     */
    public function getFormalProfileAttribute()
    {
        return $this->extendedFields()->where(['name'=>config('teamwork.extra_field_name'), 'type'=>'formal'])->get()->toArray();
    }

    /**
     * @return array
     */
    public function getRealProfileAttribute()
    {
        return $this->extendedFields()->where(['name'=>config('teamwork.extra_field_name'), 'type'=>'real'])->get()->toArray();
    }

}
