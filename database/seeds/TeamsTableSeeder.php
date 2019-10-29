<?php

use App\Models\Auth\Team;
use App\Models\Auth\User;
use Illuminate\Database\Seeder;

class TeamsTableSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();

        $operator_user = User::create([
            'first_name' => 'Operator',
            'last_name' => 'Member',
            'email' => 'user1@user.com',
            'password' => 'secret',
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
            'confirmed' => true,
        ]);

        $agent_user = User::create([
            'first_name' => 'Agent',
            'last_name' => 'Member',
            'email' => 'user2@user.com',
            'password' => 'secret',
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
            'confirmed' => true,
        ]);


        // Create team for operator company
        $operator_team = Team::create([
            'name' => 'Operator company',
            'owner_id' => $operator_user->id,
        ]);

        // Attach user to team
        $operator_user->attachTeam($operator_team);

        // Create and fill company profile
        $operator_team->profiles()->create([
            'type' => 'formal',
            'content' => null,
        ]);


        // Create team for agent company
        $agent_team = Team::create([
            'name' => 'Agent company',
            'owner_id' => $agent_user->id,
        ]);

        // Attach user to team
        $agent_user->attachTeam($agent_team);

        // Create and fill company profile
        $agent_team->profiles()->create([
            'type' => 'formal',
            'content' => null,
        ]);

        $operator_team->assignRole(config('access.teams.operator_role'));

        $agent_team->assignRole(config('access.teams.agent_role'));

        $agent_team->subscriptions()->sync($operator_team->id);

        $this->enableForeignKeys();
    }
}
