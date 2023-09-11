<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::Create([
            'name' => 'admin',
            'email' => 'admin@iotech.co.id',
            'password' => Hash::make('adminiot')
        ]);
        User::Create([
            'name' => 'user',
            'email' => 'user@iotech.co.id',
            'password' => Hash::make('adminiot')
        ]);
        Permission::create(['name' => 'admin-panel']);
        Permission::create(['name' => 'view-dashboard']);
        Permission::create(['name' => 'create-dashboard']);
        Permission::create(['name' => 'edit-dashboard']);
        Permission::create(['name' => 'delete-dashboard']);
        $adminRole = Role::create(['name' => 'Admin']);
        $userRole = Role::create(['name' => 'User']);
        $adminRole->givePermissionTo([
            'admin-panel',
            'view-dashboard',
            'create-dashboard',
            'edit-dashboard',
            'delete-dashboard',
        ]);
        // $viewerRole->givePermissionTo([
        //     'create-vehicle',
        //     'edit-vehicle',
        // ]);
        $user = User::where('email', 'admin@iotech.co.id')->first();
        $user->assignRole('Admin');
        $user = User::where('email', 'user@iotech.co.id')->first();
        $user->assignRole('User');
    }
}
