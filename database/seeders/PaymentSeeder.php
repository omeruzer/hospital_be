<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Payment::create([
            'name'=>'Ömer Uzer',
            'bank_name'=>'Ziraat Bankası',
            'iban'=>'TR2342344121241414334234'
        ]);
        Payment::create([
            'name'=>'Ömer Uzer',
            'bank_name'=>'İş Bankası',
            'iban'=>'TR2342344121241414334234'
        ]);
        Payment::create([
            'name'=>'Ömer Uzer',
            'bank_name'=>'Garanti Bankası',
            'iban'=>'TR2342344121241414334234'
        ]);
        Payment::create([
            'name'=>'Ömer Uzer',
            'bank_name'=>'Halkbank',
            'iban'=>'TR2342344121241414334234'
        ]);
    }
}
