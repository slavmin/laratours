<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/**
 * Class PermissionRoleTableSeeder.
 */
class PermissionRoleTableSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     */
    public function run()
    {
        $this->disableForeignKeys();

        // Create Roles
        $admin = Role::create(['name' => config('access.users.admin_role')]);
        $executive = Role::create(['name' => 'executive']);
        $operator = Role::create(['name' => config('access.users.operator_role')]);
        $agent = Role::create(['name' => config('access.users.agent_role')]);
        $user = Role::create(['name' => config('access.users.default_role')]);

        // Create Permissions
        $permissions = ['view backend', 'clear-trashed', 'tour-manage', 'order-manage',
            'tour-view',
            'tour-create',
            'tour-edit',
            'tour-delete',
            'order-view',
            'order-cancel',
            'order-create',
            'order-edit',
            'order-delete'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // ALWAYS GIVE ADMIN ROLE ALL PERMISSIONS
        $admin->givePermissionTo(Permission::all());

        // Assign Permissions to other Roles
        $executive->givePermissionTo('view backend');
        $operator->givePermissionTo('tour-manage', 'order-manage');
        $agent->givePermissionTo('order-create', 'order-view', 'order-edit', 'order-cancel');
        $user->givePermissionTo('order-view');

        $this->enableForeignKeys();
    }
}
