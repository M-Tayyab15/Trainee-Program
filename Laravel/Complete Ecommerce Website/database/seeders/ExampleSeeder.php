<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // If you're using query builder
use App\Models\User; // If you're using Eloquent

class ExampleSeeder extends Seeder
{
    public function run()
    {
        // Using Eloquent ORM to create users
        User::create([
            'name' => 'Test Seeder',
            'email' => 'seeder@example.com',
            'password' => bcrypt('P@ssword123'),
        ]);

        // Or using Query Builder for a different approach
        DB::table('users')->insert([
            'name' => 'Seeder Two',
            'email' => 'seeder2@example.com',
            'password' => bcrypt('P@ssword123'),
        ]);
    }
}
