<?php

namespace Database\Seeders;

use App\Models\Services;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i <10 ; $i++) { 
            $faker = \Faker\Factory::create(); 

            Services::create([
                'status_id'=>rand(1,4),
                'service_no'=>'R-'.$i+1,
                'patient_id'=>$i+1,
                'desc'=>$faker->sentence(20),
                'service_date'=>Carbon::now()
            ]);
        }
    }
}
