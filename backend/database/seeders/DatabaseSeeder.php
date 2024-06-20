<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(5)->create();

        User::factory()->create([
            'name' => 'Test',
            'email' => 'test@test',
            'password' => 'admin',
        ]);
        Client::factory(10)->create();
        Client::factory()->create([
            'name' => 'Test david',
            'lastname' => 'testing',
            'email' => 'david@tes',
            'phone' => '1234567890',
            'address' => 'Quillacollo'
        ]);
    }
}
