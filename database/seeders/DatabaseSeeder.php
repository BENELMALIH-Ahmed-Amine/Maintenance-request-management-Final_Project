<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Hash;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Role::insert([
            [
                'name' => 'admin',
                'guard_name' => 'web'
            ],
            [
                'name' => 'technician',
                'guard_name' => 'web'
            ],
            [
                'name' => 'client',
                'guard_name' => 'web'
            ]
        ]);

        $admin = User::create([
            'name' => 'admin name',
            'email' => 'mousaa@gmail.com',
            'password' => Hash::make('moul lmou9f'),
            'address' => '20202 sejour',
            'profil' => '',
            'rate' => 100,
            'category_id' => '1'
        ]);

        $admin->assignRole("admin");
    }
}
