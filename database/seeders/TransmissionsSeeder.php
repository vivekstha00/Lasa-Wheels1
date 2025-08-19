<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Transmission;

class TransmissionsSeeder extends Seeder
{
  
    public function run(): void
    {
        $transmissions = ['Manual', 'Automatic'];

        foreach ($transmissions as $transmission) {
            Transmission::create(['name' => $transmission]);
        }
    }
}

