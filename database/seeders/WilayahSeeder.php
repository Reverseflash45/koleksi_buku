<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WilayahSeeder extends Seeder
{
    public function run()
    {
        // Bersihkan data lama
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('villages')->truncate();
        DB::table('districts')->truncate();
        DB::table('regencies')->truncate();
        DB::table('reg_provinces')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Ambil dan Masukkan Provinsi
        $provUrl = 'https://raw.githubusercontent.com/lokalan-indonesia/lokalan-indonesia/master/data/provinces.json';
        $provData = json_decode(file_get_contents($provUrl), true);
        DB::table('reg_provinces')->insert($provData);

        // Ambil dan Masukkan Kota/Kabupaten
        $regUrl = 'https://raw.githubusercontent.com/lokalan-indonesia/lokalan-indonesia/master/data/regencies.json';
        $regData = json_decode(file_get_contents($regUrl), true);
        DB::table('regencies')->insert($regData);

        // Kecamatan (Opsional)
        echo "Mengunduh dan memasukkan data kecamatan...\n";
        $distUrl = 'https://raw.githubusercontent.com/lokalan-indonesia/lokalan-indonesia/master/data/districts.json';
        $distData = json_decode(file_get_contents($distUrl), true);
        
        // Memecah insert karena data kecamatan cukup besar
        $distChunks = array_chunk($distData, 500);
        foreach ($distChunks as $chunk) {
            DB::table('districts')->insert($chunk);
        }

        echo "Selesai! Berhasil memasukkan " . count($provData) . " Provinsi dan " . count($regData) . " Kota.\n";
    }
}