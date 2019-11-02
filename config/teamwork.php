<?php

/**
 * This file is part of Teamwork
 *
 * PHP version 7.1
 * 
 * @category PHP
 * @package  Teamwork
 * @author   Marcel Pociot <m.pociot@gmail.com>
 * @license  MIT 
 * @link     http://github.com/mpociot/teamwork
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Auth Model
    |--------------------------------------------------------------------------
    |
    | This is the Auth model used by Teamwork.
    |
    */
    'user_model' => config('auth.providers.users.model', App\Models\Auth\User::class),

    /*
    |--------------------------------------------------------------------------
    | Teamwork users Table
    |--------------------------------------------------------------------------
    |
    | This is the users table name used by Teamwork.
    |
    */
    'users_table' => 'users',

    /*
    |--------------------------------------------------------------------------
    | Teamwork Team Model
    |--------------------------------------------------------------------------
    |
    | This is the Team model used by Teamwork to create correct relations.  Update
    | the team if it is in a different namespace.
    |
    */
    'team_model' => Mpociot\Teamwork\TeamworkTeam::class,

    /*
    |--------------------------------------------------------------------------
    | Teamwork teams Table
    |--------------------------------------------------------------------------
    |
    | This is the teams table name used by Teamwork to save teams to the database.
    |
    */
    'teams_table' => 'teams',

    /*
    |--------------------------------------------------------------------------
    | Teamwork team_user Table
    |--------------------------------------------------------------------------
    |
    | This is the team_user table used by Teamwork to save assigned teams to the
    | database.
    |
    */
    'team_user_table' => 'team_user',

    /*
    |--------------------------------------------------------------------------
    | User Foreign key on Teamwork's team_user Table (Pivot)
    |--------------------------------------------------------------------------
    */
    'user_foreign_key' => 'id',

    /*
    |--------------------------------------------------------------------------
    | Teamwork Team Invite Model
    |--------------------------------------------------------------------------
    |
    | This is the Team Invite model used by Teamwork to create correct relations.
    | Update the team if it is in a different namespace.
    |
    */
    'invite_model' => Mpociot\Teamwork\TeamInvite::class,

    /*
    |--------------------------------------------------------------------------
    | Teamwork team invites Table
    |--------------------------------------------------------------------------
    |
    | This is the team invites table name used by Teamwork to save sent/pending
    | invitation into teams to the database.
    |
    */
    'team_invites_table' => 'team_invites',


    /*
    |--------------------------------------------------------------------------
    | Teamwork team quotas
    |--------------------------------------------------------------------------
    |
    | This is the team members and invites quotas used by Teamwork.
    |
    */
    'team_members_quota' => 6,



    /*
    |--------------------------------------------------------------------------
    | Teamwork team extra fields names
    |--------------------------------------------------------------------------
    |
    | This is the extra fields names and types used by Teamwork.
    |
    */
    'extra_field_name' => 'profile',
];
