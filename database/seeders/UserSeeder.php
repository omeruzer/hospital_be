<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create(); 

        for ($i = 0; $i < 10; $i++) {
            User::create([
                "name"=>$faker->name(),
                'email'=>$faker->email(),
                'phone'=>rand(145654,2545465),
                'password'=>Hash::make('asd'),
                'role_id'=>2
            ]);
        }

        User::create([
            "name"=>'Ömer Uzer',
            'email'=>'omeruzer@gmail.com',
            'phone'=>rand(145654,2545465),
            'password'=>Hash::make('asd'),
            'role_id'=>1
        ]);
    }
}
