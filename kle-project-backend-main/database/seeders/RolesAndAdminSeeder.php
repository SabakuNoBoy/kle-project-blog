<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesAndAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // CRUD Permissions
        $permissions = [
            'view_posts',
            'create_posts',
            'edit_posts',
            'delete_posts',
            'view_categories',
            'create_categories',
            'edit_categories',
            'delete_categories',
            'view_comments',
            'approve_comments',
            'delete_comments',
            'view_users',
            'manage_roles',
            'view_agreements',
            'edit_agreements',
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::firstOrCreate(['name' => $permission]);
        }

        // Roles
        $adminRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin']);
        $editorRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'editor']);
        $userRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'user']);

        // Assign all permissions to admin
        $adminRole->syncPermissions(\Spatie\Permission\Models\Permission::all());

        // Assign restricted permissions to editor (view + create only for posts/categories)
        // Note: As per user example, editor might NOT have edit/delete permissions.
        $editorRole->syncPermissions([
            'view_posts',
            'create_posts',
            'view_categories',
            'create_categories',
            'view_comments',
            'approve_comments',
            'view_agreements',
        ]);

        // Users
        $admin = \App\Models\User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
            ]
        );
        $admin->assignRole($adminRole);

        $editor = \App\Models\User::firstOrCreate(
            ['email' => 'editor@example.com'],
            [
                'name' => 'Editor User',
                'password' => bcrypt('password'),
            ]
        );
        $editor->assignRole($editorRole);
    }
}
