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
        /**
         * List Permissions
         * Main - Blog - User - Settings - SEO - System Management - Sidebar
         */
        $user_access = [

            /* -------------------------------------------------------------------------- */
            /*                                   Module                                   */
            /* -------------------------------------------------------------------------- */

            // Main
            'main-index',

            /* -------------------------------------------------------------------------- */
            /*                                    Blog                                    */
            /* -------------------------------------------------------------------------- */

            // Post
            'post-index',
            'post-create',
            'post-store',
            'post-show',
            'post-edit',
            'post-update',
            'post-destroy',

            // Category
            'category-index',
            'category-create',
            'category-store',
            'category-show',
            'category-edit',
            'category-update',
            'category-destroy',

            // Tag
            'tag-index',
            'tag-create',
            'tag-store',
            'tag-show',
            'tag-edit',
            'tag-update',
            'tag-destroy',

            /* -------------------------------------------------------------------------- */
            /*                               User Management                              */
            /* -------------------------------------------------------------------------- */

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

            /* -------------------------------------------------------------------------- */
            /*                                  Settings                                  */
            /* -------------------------------------------------------------------------- */

            // General
            'general-index',
            'general-update',

            // Social Media
            'socialmedia-index',
            'socialmedia-create',
            'socialmedia-store',
            'socialmedia-show',
            'socialmedia-edit',
            'socialmedia-update',
            'socialmedia-destroy',

            /* -------------------------------------------------------------------------- */
            /*                                    Email                                   */
            /* -------------------------------------------------------------------------- */

            // Message
            'message-index',
            'message-create',
            'message-store',
            'message-show',
            'message-edit',
            'message-update',
            'message-destroy',

            /* -------------------------------------------------------------------------- */
            /*                                     SEO                                    */
            /* -------------------------------------------------------------------------- */

            // Meta
            'meta-index',
            'meta-create',
            'meta-store',
            'meta-show',
            'meta-edit',
            'meta-update',
            'meta-destroy',

            // Canonical
            'canonical-index',
            'canonical-create',
            'canonical-store',
            'canonical-show',
            'canonical-edit',
            'canonical-update',
            'canonical-destroy',

            /* -------------------------------------------------------------------------- */
            /*                              System Management                             */
            /* -------------------------------------------------------------------------- */

            // Activity
            'activity-index',
            'activity-create',
            'activity-store',
            'activity-show',
            'activity-edit',
            'activity-update',
            'activity-destroy',

            // Maintenance
            'maintenance-index',

            /* -------------------------------------------------------------------------- */
            /*                                   Sidebar                                  */
            /* -------------------------------------------------------------------------- */
            'main-sidebar',
            'blog-sidebar',
            'setting-sidebar',
            'seo-sidebar',
            'user-sidebar',
            'system-sidebar',

        ];


        /**
         * Give Permissions to UsersRole
         * Users - Roles - Permissions
         */

        foreach ($user_access as $value) {
            Permission::create(['name' => $value]);
        }

        $superadmin = Role::create(['name' => 'superadmin']);
        $administrator = Role::create(['name' => 'administrator']);
        $editor = Role::create(['name' => 'editor']);
        $customer = Role::create(['name' => 'customer']);
        $guest = Role::create(['name' => 'guest']);

        $superadmin->givePermissionTo([

            /* Main */
            'main-index',

            /* Blog */
            'post-index',
            'post-create',
            'post-store',
            'post-show',
            'post-edit',
            'post-update',
            'post-destroy',

            'category-index',
            'category-create',
            'category-store',
            'category-show',
            'category-edit',
            'category-update',
            'category-destroy',

            'tag-index',
            'tag-create',
            'tag-store',
            'tag-show',
            'tag-edit',
            'tag-update',
            'tag-destroy',

            /* Email */
            'message-index',
            'message-create',
            'message-store',
            'message-show',
            'message-edit',
            'message-update',
            'message-destroy',

            /* User */
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

            /* Settings */
            'general-index',
            'general-update',

            'socialmedia-index',
            'socialmedia-create',
            'socialmedia-store',
            'socialmedia-show',
            'socialmedia-edit',
            'socialmedia-update',
            'socialmedia-destroy',

            /* SEO */
            'meta-index',
            'meta-create',
            'meta-store',
            'meta-show',
            'meta-edit',
            'meta-update',
            'meta-destroy',

            'canonical-index',
            'canonical-create',
            'canonical-store',
            'canonical-show',
            'canonical-edit',
            'canonical-update',
            'canonical-destroy',

            /* System */
            'activity-index',
            'activity-create',
            'activity-store',
            'activity-show',
            'activity-edit',
            'activity-update',
            'activity-destroy',

            'maintenance-index',

            /* Sidebar */
            'main-sidebar',
            'blog-sidebar',
            'setting-sidebar',
            'seo-sidebar',
            'user-sidebar',
            'system-sidebar',

        ]);

        $administrator->givePermissionTo([

            /* Main */
            'main-index',

            /* Blog */
            'tag-index',
            'tag-create',
            'tag-store',
            'tag-show',
            'tag-edit',
            'tag-update',
            'tag-destroy',

            /* Sidebar */
            'main-sidebar',
            'blog-sidebar',
            'setting-sidebar',
            'general-index',
            'general-update',

        ]);

        $editor->givePermissionTo([

            /* Sidebar */
            'main-index',
            'main-sidebar',
            'blog-sidebar',

        ]);

        $customer->givePermissionTo([

            /* Sidebar */
            'main-index',
            'main-sidebar'

        ]);

        $guest->givePermissionTo([

        ]);

    }
}
