<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vehicle;

class VehiclesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vehicle::create([
            'name' => 'BYD Atto 3',
            'description' => 'Electric SUV with modern design and long range',
            'type_id' => 2,
            'model' => '2023',
            'fuel_id' => 3, 
            'transmission_id' => 2,
            'price_per_day' => 65.00,
            'image' => 'vehicles/atto3.jpg',
            'is_available' => true
        ]);

        Vehicle::create([
            'name' => 'Hyundai Creta',
            'description' => 'Popular compact SUV with advanced infotainment',
            'type_id' => 2,
            'model' => '2022',
            'fuel_id' => 1, // Petrol
            'transmission_id' => 2,
            'price_per_day' => 50.00,
            'image' => 'vehicles/creta.jpg',
            'is_available' => true
        ]);

        Vehicle::create([
            'name' => 'Ford Raptor',
            'description' => 'High-performance pickup truck built for off-road',
            'type_id' => 3,
            'model' => '2023',
            'fuel_id' => 1, // Petrol
            'transmission_id' => 2,
            'price_per_day' => 80.00,
            'image' => 'vehicles/raptor.jpg',
            'is_available' => true
        ]);
    
    }
}
