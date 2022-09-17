<?php

namespace Database\Seeders;

use App\Models\ServiceStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ServiceStatus::create([
            'status_name'=>'Randevu Onaylandı'
        ]);
        ServiceStatus::create([
            'status_name'=>'Hasta Gelmedi'
        ]);
        ServiceStatus::create([
            'status_name'=>'Hasta Muaynede'
        ]);
        ServiceStatus::create([
            'status_name'=>'Muayne tamamlandı'
        ]);
        ServiceStatus::create([
            'status_name'=>'Randevu İptal Edildi'
        ]);
    }
}
