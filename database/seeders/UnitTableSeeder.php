<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $schedule1=Unit::create([
            'name'=>'SQM'
        ]);
        $schedule2=Unit::create([
            'name'=>'LOT'
        ]);
        $schedule3=Unit::create([
            'name'=>'Per Person'
        ]);
    }
}
