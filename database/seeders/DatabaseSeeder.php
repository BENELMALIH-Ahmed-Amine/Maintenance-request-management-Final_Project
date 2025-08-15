<?php

namespace Database\Seeders;

use App\Models\Category;
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
                'name' => 'Technician',
                'guard_name' => 'web'
            ],
            [
                'name' => 'Client',
                'guard_name' => 'web'
            ]
        ]);

        $admin = User::create([
            'name' => 'admin name',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('moul lmou9f'),
            'address' => '20202 sejour',
            'profil' => 'Profils/K2JqCMLAuYlLTXJoqNd3xV0tPOEHjbhpXo6IVgW8.jpg',
            'category_id' => null
        ]);

        $admin->assignRole("admin");

        
        Category::insert([
            ['name' => 'Carreleur - زلّاج'],
            ['name' => 'Charpentier - نجار'],
            ['name' => 'Electicien - كهربائي'],
            ['name' => 'Forgeron - حداد'],
            ['name' => 'Maçon - بناء'],
            ['name' => 'Peintre en Bâtiment - صبّاغ'],
            ['name' => 'Plâtrier - جبّاص'],
            ['name' => 'Plombier - بلومبي'],
            ['name' => 'Serrurier - صانع أقفال'],
        ]);
    }
}
