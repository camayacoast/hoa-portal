<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'hoa_member_lname'=>'Admin',
            'hoa_member_fname'=>'Admin',
            'hoa_member_mname'=>'Admin',
            'email'=>'admin@camayacoast.com',
            'password'=>bcrypt('secret'),
            'hoa_admin'=>1
        ]);
    }
}
