<?php


namespace App\Models\Traits;


use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

/**
 * Class UsedByTeams
 */
trait UsedByTeams
{
    /**
     * Boot the global scope
     */
    protected static function bootUsedByTeams()
    {
        static::addGlobalScope('team', function (Builder $builder) {
            static::teamGuard();

            if (auth()->user()->can(config('access.teams.operator_permission')) && $builder->getQuery()->from == 'tour_orders') {
                $builder->where($builder->getQuery()->from . '.operator_id', auth()->user()->currentTeam->getKey());
            } else {
                $builder->where($builder->getQuery()->from . '.team_id', auth()->user()->currentTeam->getKey());
            }
        });

        static::saving(function (Model $model) {
            static::teamGuard();

            if (!isset($model->team_id)) {
                $model->team_id = auth()->user()->currentTeam->getKey();
            }
        });
    }

    /**
     * @param Builder $query
     * @return mixed
     */
    public function scopeAllTeams(Builder $query)
    {
        return $query->withoutGlobalScope('team');
    }

    /**
     * @return mixed
     */
    public function team()
    {
        return $this->belongsTo(Config::get('teamwork.team_model'));
    }

    /**
     * @throws Exception
     */
    protected static function teamGuard()
    {
        if (auth()->guest() || !auth()->user()->currentTeam) {
            throw new Exception('No authenticated user with selected team present.');
        }
    }
}