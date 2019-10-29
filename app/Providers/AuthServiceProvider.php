<?php

namespace App\Providers;

use App\Models\Auth\Team;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

/**
 * Class AuthServiceProvider.
 */
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();

        // API Passport tokens configuration
        Passport::routes(function ($router){
            $router->forAccessTokens();
        });
        Passport::tokensExpireIn(now()->addDays(15));
        Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::personalAccessTokensExpireIn(now()->addMonths(2));

        // Implicitly grant "Super Admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        Gate::before(function ($user, $ability) {
            if($ability != config('access.teams.operator_permission') &&
                $ability != config('access.teams.agent_permission')) {
                return $user->hasRole(config('access.users.admin_role')) ? true : null;
            }
        });

        // Implicitly grant team "Operator" role permissions to administer tours
        Gate::define(config('access.teams.operator_permission'), function ($user) {
            $team = Team::whereId($user->current_team_id)->with('roles')->first();
            if(!$team){return null;}
            return $team->roles->contains('name', config('access.teams.operator_role')) ? true : null;
        });

        // Implicitly grant team "Agent" role permissions to administer orders
        Gate::define(config('access.teams.agent_permission'), function ($user) {
            $team = Team::whereId($user->current_team_id)->with('roles')->first();
            if(!$team){return null;}
            return $team->roles->contains('name', config('access.teams.agent_role')) ? true : null;
        });
    }
}
