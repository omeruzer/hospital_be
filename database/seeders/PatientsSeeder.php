<?php

namespace Database\Seeders;

use App\Models\Patients;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i <11 ; $i++) { 
            Patients::create([
                'user_id'=>$i+1
            ]);
        }
    }
}
