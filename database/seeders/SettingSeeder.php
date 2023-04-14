<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $key = [
            'config-quote',
            'config-aboutus',
            'config-facebook',
            'config-twitter',
            'config-line',
            'config-youtube',
        ];
        foreach ($key as $value) {
            $data = new Setting();
            $data->key = $value;
            $data->save();
        }
    }
}
// namespace Database\Seeders;

// use App\Models\Setting;
// use Illuminate\Database\Seeder;

// class SettingSeeder extends Seeder
// {
//     /**
//      * Run the database seeds.
//      */
//     public function run(): void
//     {
//         $key = [
//             'config-quote',
//             'config-aboutus',
//             'config-facebook',
//             'config-twitter',
//             'config-line',
//             'config-youtube',
//         ];
//         foreach ($key as $value) {
//             Setting::factory()->create([
//                 'key' => $value,
//             ]);
//         }
//     }
// }
