<?php

namespace App\Models\Auth;

use App\Events\Backend\Auth\Team\TeamDeleted;
use App\Models\Auth\Traits\Attribute\TeamAttribute;
use App\Models\Auth\Traits\Method\TeamMethod;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mpociot\Teamwork\TeamworkTeam;
use App\Models\Traits\HasExtendedFields;
//use Mpociot\Teamwork\Facades\Teamwork;
//use Mpociot\Teamwork\TeamInvite;

/**
 * Class Team.
 */
class Team extends TeamworkTeam
{
    use TeamAttribute, TeamMethod, HasExtendedFields, SoftDeletes;

    /**
     * @var array
     */
    protected $dispatchesEvents = [
        'forceDeleted' => TeamDeleted::class,
    ];

//    protected $with = ['extendedFields'];

    /**
     * @return array
     */
    public function getFormalProfileAttribute()
    {
        $raw = $this->extendedFields()->where(['name'=>config('teamwork.extra_field_name'), 'type'=>'formal'])->get()->pluck('content');
        $raw_out = isset($raw[0]) ? $raw[0] : [];
        $out['formal'] = $raw_out;

        return $out;
    }

    /**
     * @return array
     */
    public function getRealProfileAttribute()
    {
        $raw = $this->extendedFields()->where(['name'=>config('teamwork.extra_field_name'), 'type'=>'real'])->get()->pluck('content');
        $raw_out = isset($raw[0]) ? $raw[0] : [];
        $out['real'] = $raw_out;

        return $out;
    }

}
