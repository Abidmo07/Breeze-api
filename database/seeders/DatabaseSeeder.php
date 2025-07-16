<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

        /*   User::factory()->create([
              'name' => 'Test User',
              'email' => 'test@example.com',
          ]); */
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);
        User::create([
            'name' => 'Admin',
            'email' => 'abidmo2003@gmail.com',
            'password' => bcrypt('admin0508')
        ])->assignRole('admin');

    }
}
