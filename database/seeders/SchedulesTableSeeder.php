<?php

namespace Database\Seeders;

use App\Models\Schedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchedulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $schedule = Schedule::truncate();
        $schedule->create([
            'hoa_schedule_name'=>'Daily',
            'hoa_schedule_modifiedby'=>1
        ]);
        $schedule->create([
            'hoa_schedule_name'=>'Monthly',
            'hoa_schedule_modifiedby'=>1
        ]);
        $schedule->create([
            'hoa_schedule_name'=>'Annually',
            'hoa_schedule_modifiedby'=>1
        ]);
        $schedule->create([
            'hoa_schedule_name'=>'Quarterly',
            'hoa_schedule_modifiedby'=>1
        ]);
        $schedule->create([
            'hoa_schedule_name'=>'Onetime',
            'hoa_schedule_modifiedby'=>1
        ]);
    }
}
