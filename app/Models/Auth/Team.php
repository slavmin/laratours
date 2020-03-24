<?php

namespace App\Models\Auth;

use App\Events\Backend\Auth\Team\TeamDeleted;
use App\Filters\ToursFilter;
use App\Models\Auth\Traits\Attribute\TeamAttribute;
use App\Models\Auth\Traits\Method\TeamMethod;
use App\Models\Document\Document;
use App\Models\Tour\Tour;
use App\Models\Traits\HasProfile;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mpociot\Teamwork\TeamworkTeam;
use Cviebrock\EloquentSluggable\Sluggable;
use Request;
use Spatie\Permission\Traits\HasRoles;

//use Mpociot\Teamwork\Facades\Teamwork;
//use Mpociot\Teamwork\TeamInvite;

/**
 * Class Team.
 */
class Team extends TeamworkTeam
{
  use HasRoles, TeamAttribute, TeamMethod, HasProfile, Sluggable, SoftDeletes;

  /**
   * @var string
   */
  protected $guard_name = 'web';

  /**
   * @var array
   */
  protected $dispatchesEvents = [
    'forceDeleted' => TeamDeleted::class,
  ];


  /**
   * Return the sluggable configuration array for this model.
   *
   * @return array
   */
  public function sluggable()
  {
    return [
      'slug' => [
        'source'   => 'name',
        'onUpdate' => false,
      ]
    ];
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function subscribers()
  {
    return $this->belongsToMany(self::class, 'team_subscriptions', 'subscribed_id', 'subscriber_id')->withTimestamps();
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function subscriptions()
  {
    return $this->belongsToMany(self::class, 'team_subscriptions', 'subscriber_id', 'subscribed_id')->withTimestamps();
  }

  /**
   * @return mixed
   */
  public static function getTeamSubscriptions()
  {
    $team = Team::whereId(auth()->user()->current_team_id)->with('roles')->first();

    if ($team && $team->roles->contains('name', config('access.teams.agent_role'))) {
      return $team->subscriptions->pluck('name', 'id')->toArray();
    } elseif ($team && $team->roles->contains('name', config('access.teams.operator_role'))) {
      return $team->subscribers->pluck('name', 'id')->toArray();
    }
  }

  /**
   * @return array
   */
  public function getFormalProfileAttribute()
  {
    $raw = $this->profiles()->where(['type' => 'formal'])->get()->pluck('content');
    $raw_out = isset($raw[0]) ? $raw[0] : [];
    $out['formal'] = $raw_out;

    return $out;
  }

  /**
   * @return array
   */
  public function getRealProfileAttribute()
  {
    $raw = $this->profiles()->where(['type' => 'real'])->get()->pluck('content');
    $raw_out = isset($raw[0]) ? $raw[0] : [];
    $out['real'] = $raw_out;

    return $out;
  }

  /**
   * @return array
   */
  public function getProfilesAttribute()
  {
    // return array_merge($this->getFormalProfileAttribute(), $this->getRealProfileAttribute());
    return array_merge($this->getFormalProfileAttribute());
  }

  public function getSharedDocuments()
  {
    $operators = $this->getTeamSubscriptions();
    $documents = [];
    if ($operators) {
      $subscriptions = array_keys($operators);
      $documents = Document::whereIn('team_id', $subscriptions)->where('pdf_for_agent', 1)->AllTeams()->get();
    }
    return $documents;
  }
}
