<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = DB::table('cities')->pluck('id', 'name_en')->toArray();
        $gates = [
            ['name_en' => 'Aungmingalar Gate', 'name_my' => 'အောင်မင်္ဂလာဂိတ်', 'city' => 'Yangon'],
            ['name_en' => 'Taungpaw Gate', 'name_my' => 'တောင်ပေါ်ဂိတ်', 'city' => 'Taunggyi'],
            ['name_en' => 'Aye Tharyar Bus Station', 'name_my' => 'အေးသာယာဘတ်စ်ကားဂိတ်', 'city' => 'Taunggyi'],
            ['name_en' => '146', 'name_my' => '146 ဌာန (လမ်းမ)', 'city' => 'Yangon'],
            ['name_en' => '39', 'name_my' => '39 ဌာန (လမ်းမ)', 'city' => 'Yangon'],
            ['name_en' => '115', 'name_my' => '115 ဌာန (လမ်းမ)', 'city' => 'Yangon'],
            ['name_en' => 'Yinmarpin DagonThitsarMoon Gate', 'name_my' => 'ယင်းမာပင် ဒဂုံသစ္စာမွန်ဂိတ်', 'city' => 'Pyawbwe'],
            ['name_en' => 'Min Lay', 'name_my' => 'မင်းလေး မော်တော်', 'city' => 'Pyawbwe'],
            ['name_en' => 'Sit Man Hein', 'name_my' => 'စစ်မန်း ဟိန်းမော်တော်ဂိတ်', 'city' => 'Pyawbwe'],
            ['name_en' => 'Shwe Nan San', 'name_my' => 'ရွှေနံစံဂိတ်', 'city' => 'Kalaw'],
            ['name_en' => 'HappyWay', 'name_my' => 'HappyWayဂိတ်', 'city' => 'Aungpan'],
            ['name_en' => 'YanNaung Ma Thida Win Gate', 'name_my' => 'ရန်နောင် မသီတာဝင်းဂိတ်', 'city' => 'Pyawbwe'],
            ['name_en' => 'ShweAungThu', 'name_my' => 'ရွှေအောင်သု', 'city' => 'Pyawbwe'],
            ['name_en' => 'Salin', 'name_my' => 'စလင်း', 'city' => 'Pyawbwe'],
            ['name_en' => 'ShweNyaung UK Gate', 'name_my' => 'UK ဂိတ်', 'city' => 'Shwe Nyaung'],
            ['name_en' => 'MyaMarLar', 'name_my' => 'မြမလား', 'city' => 'Shwe Nyaung'],
            ['name_en' => 'MaungPay', 'name_my' => 'မောင်ပေး', 'city' => 'Shwe Nyaung'],
            ['name_en' => 'AuntyCho', 'name_my' => 'အောင်တီချိုဂိတ်', 'city' => 'Shwe Nyaung'],
        ];

        foreach ($gates as $gate) {
            $cityId = $cities[$gate['city']] ?? null;
            if (!$cityId) {
                continue;
            }
            DB::table('gates')->insert([
                'name_en' => $gate['name_en'],
                'name_my' => $gate['name_my'],
                'city_id' => $cityId,
                'description' => '',
                'is_main' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
