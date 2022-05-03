<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        \App\Models\User::factory(10000)->create();
//        \App\Models\Subdivision::factory(1000)->create();
//        \App\Models\Privilege::factory(1000)->create();
//        \App\Models\Agent::factory(1000)->create();
        $this->call(UsersTableSeeder::class);
        $this->call(SchedulesTableSeeder::class);
    }
}
