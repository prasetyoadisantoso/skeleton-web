<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_access = [

            /* -------------------------------------------------------------------------- */
            /*                                   Module                                   */
            /* -------------------------------------------------------------------------- */

            // Main
            'main-index',

            // User
            'user-index',
            'user-create',
            'user-store',
            'user-show',
            'user-edit',
            'user-update',
            'user-destroy',

            // Role
            'role-index',
            'role-create',
            'role-store',
            'role-show',
            'role-edit',
            'role-update',
            'role-destroy',

            // Permission
            'permission-index',
            'permission-create',
            'permission-store',
            'permission-show',
            'permission-edit',
            'permission-update',
            'permission-destroy',

            // General
            'general-index',
            'general-update',

            // Meta
            'meta-index',
            'meta-create',
            'meta-store',
            'meta-show',
            'meta-edit',
            'meta-update',
            'meta-destroy',

            // Social Media
            'socialmedia-index',
            'socialmedia-create',
            'socialmedia-store',
            'socialmedia-show',
            'socialmedia-edit',
            'socialmedia-update',
            'socialmedia-destroy',

            /* -------------------------------------------------------------------------- */
            /*                                   Sidebar                                  */
            /* -------------------------------------------------------------------------- */
            'main-sidebar',
            'setting-sidebar',
            'user-sidebar',

        ];

        foreach ($user_access as $value) {
            Permission::create(['name' => $value]);
        }

        $superadmin = Role::create(['name' => 'superadmin']);
        $administrator = Role::create(['name' => 'administrator']);
        $editor = Role::create(['name' => 'editor']);
        $customer = Role::create(['name' => 'customer']);
        $guest = Role::create(['name' => 'guest']);

        $superadmin->givePermissionTo([

            'main-index',

            'user-index',
            'user-create',
            'user-store',
            'user-show',
            'user-edit',
            'user-update',
            'user-destroy',

            'role-index',
            'role-create',
            'role-store',
            'role-show',
            'role-edit',
            'role-update',
            'role-destroy',

            'permission-index',
            'permission-create',
            'permission-store',
            'permission-show',
            'permission-edit',
            'permission-update',
            'permission-destroy',

            'general-index',
            'general-update',

            'meta-index',
            'meta-create',
            'meta-store',
            'meta-show',
            'meta-edit',
            'meta-update',
            'meta-destroy',

            'socialmedia-index',
            'socialmedia-create',
            'socialmedia-store',
            'socialmedia-show',
            'socialmedia-edit',
            'socialmedia-update',
            'socialmedia-destroy',

            'main-sidebar',
            'setting-sidebar',
            'user-sidebar',

        ]);

        $administrator->givePermissionTo([

            'main-index',
            'main-sidebar',

            'setting-sidebar',
            'general-index',
            'general-update',

        ]);

        $editor->givePermissionTo([

            'main-index',
            'main-sidebar',

        ]);

        $customer->givePermissionTo([

            'main-index',
            'main-sidebar'

        ]);

        $guest->givePermissionTo([

        ]);

    }
}
