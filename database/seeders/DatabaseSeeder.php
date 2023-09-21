<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $admin = \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $admin_role = Role::create(['name' => 'admin']);
        $b2b_customer_role = Role::create(['name' => 'b2b_customer']);
        $b2c_customer_role = Role::create(['name' => 'b2c_customer']);

        Permission::create(['name' => 'view dashboard']);
        Permission::create(['name' => 'access b2b']);
        Permission::create(['name' => 'access b2c']);
        Permission::create(['name' => 'view users']);

        $b2b_customer_role->givePermissionTo(['view dashboard', 'access b2b']);
        $b2c_customer_role->givePermissionTo(['view dashboard', 'access b2c']);
        $admin_role->givePermissionTo('view users');

        $admin->assignRole($admin_role);
    }
}
