<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cities')->insert([
            [
                'name_en' => 'Yangon',
                'name_my' => 'ရန်ကုန်',
                'description' => 'The largest city in Myanmar, known for its colonial architecture and vibrant culture.',
                'status' => 'active',
            ],
            [
                'name_en' => 'Mandalay',
                'name_my' => 'မန္တလေး',
                'description' => 'The second-largest city, famous for its historical sites and cultural heritage.',
                'status' => 'active',
            ],
            [
                'name_en' => 'Naypyidaw',
                'name_my' => 'နေပြည်တော်',
                'description' => 'The capital city of Myanmar, known for its modern infrastructure.',
                'status' => 'inactive',
            ],
            [
                'name_en' => 'Bago',
                'name_my' => 'ပဲခူး',
                'description' => 'A city known for its ancient pagodas and historical significance.',
                'status' => 'active',
            ],
            [
                'name_en' => 'Taunggyi',
                'name_my' => 'တောင်ကြီး',
                'description' => 'The capital of Shan State, known for its scenic beauty and cultural diversity.',
                'status' => 'active',
            ],
            [
                'name_en' => 'Mawlamyine',
                'name_my' => 'မော်လမြိုင်',
                'description' => 'A coastal city known for its colonial history and beautiful beaches.',
                'status' => 'active',
            ],
            [
                'name_en' => 'Pathein',
                'name_my' => 'ပုသိမ်',
                'description' => 'A city famous for its traditional umbrellas and rich cultural heritage.',
                'status' => 'active',
            ],
            [
                'name_en' => 'Pyawbwe',
                'name_my' => 'ပျော်ဘွယ်',
                'description' => 'A city known for its agricultural products and local markets.',
                'status' => 'active',
            ],
            [
                'name_en' => 'Myitkyina',
                'name_my' => 'မြစ်ကြီးနား',
                'description' => 'The capital of Kachin State, known for its natural',
                'status' => 'active',
            ],
            [
                'name_en' => 'Shwe Nyaung',
                'name_my' => 'ရွှေညောင်',
                'description' => 'A town in Shan State, known for its proximity to Inle Lake and its scenic beauty.',
                'status' => 'active',
            ],
            [
                'name_en' => 'Sittwe',
                'name_my' => 'စစ်တွေ',
                'description' => 'A port city in Rakhine State, known for its rich maritime history.',
                'status' => 'active',
            ]
        ]);
    }
}
