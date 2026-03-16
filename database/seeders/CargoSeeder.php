<?php

namespace Database\Seeders;

use App\Models\Cargo;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cargo::factory()->count(10)->create();
    }
}
