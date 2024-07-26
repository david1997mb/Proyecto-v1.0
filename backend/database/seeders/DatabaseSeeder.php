<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Client;
use App\Models\Event;
use App\Models\Pay;
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
        Event::factory(10)->create();
        Pay::factory(10)->create();
        Area::factory(5)->create();
        // Event::factory()->create([
        //     'reserve_date' => '',
        //     'type',
        //     'event_day',
        //     'start',
        //     'finish',
        //     'guests',
        //     'total_cost',
        //     'status',
        //     'client_id'
        //     ]);
    }
}
