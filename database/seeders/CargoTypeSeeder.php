<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CargoType;

class CargoTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CargoType::create([
            'name' => 'Bag',
            'description' => 'Bag is a type of cargo that is used to transport goods.',
            'status' => 'active',
        ]);
        CargoType::create([
            'name' => 'Parcel',
            'description' => 'Parcel is a type of cargo that is used to transport goods.',
            'status' => 'active',
        ]);
    }
}
