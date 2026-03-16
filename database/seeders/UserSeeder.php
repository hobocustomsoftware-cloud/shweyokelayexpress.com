<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::where('email', 'admin@gmail.com')->delete();
        User::create([
            'name' => 'Hein Htet Aung',
            'email' => 'hein@gmail.com',
            'password' => bcrypt('123456')
        ])->assignRole('Admin');
    }
}
