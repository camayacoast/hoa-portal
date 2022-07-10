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

        $admin =  User::create([
            'hoa_member_lname'=>'Admin',
            'hoa_member_fname'=>'Admin',
            'hoa_member_mname'=>'Admin',
            'email'=>'admin@camayacoast.com',
            'password'=>bcrypt('secret'),
            'hoa_admin'=>1
        ]);


        $jinky =  User::create([
            'hoa_member_lname'=>'Ulijan',
            'hoa_member_fname'=>'Jinky',
            'hoa_member_mname'=>'Mozo',
            'email'=>'jinky.ulijan@camayacoast.com',
            'password'=>bcrypt('Camaya123'),
            'hoa_admin'=>1
        ]);

        $patricia =  User::create([
            'hoa_member_lname'=>'Basa',
            'hoa_member_fname'=>'Patricia',
            'hoa_member_mname'=>'',
            'email'=>'patricia.basa@camayacoast.com',
            'password'=>bcrypt('Camaya123'),
            'hoa_admin'=>1
        ]);

        $creatives =  User::create([
            'hoa_member_lname'=>'Creatives',
            'hoa_member_fname'=>'Camaya',
            'hoa_member_mname'=>'',
            'email'=>'creatives@camayacoast.com',
            'password'=>bcrypt('Camaya123'),
            'hoa_admin'=>1
        ]);

        $homer =  User::create([
            'hoa_member_lname'=>'Sobrevega',
            'hoa_member_fname'=>'Homer',
            'hoa_member_mname'=>'',
            'email'=>'homer.sobrevega@camayacoast.com',
            'password'=>bcrypt('Camaya123'),
            'hoa_admin'=>1
        ]);
    }
}
