<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StokisSeeder extends Seeder
{
    public function run()
    {
        DB::table('stokis')->insert([
            ['stokis_id' => 1, 'nama_stokis' => 'stokis_sby', 'no_hp' => '567890', 'lokasi' => 'Sby', 'created_at' => now(), 'updated_at' => now()],
            ['stokis_id' => 2, 'nama_stokis' => 'stokis_ploso', 'no_hp' => '12345678', 'lokasi' => 'ploso', 'created_at' => now(), 'updated_at' => now()],
            ['stokis_id' => 3, 'nama_stokis' => 'stokis_solo', 'no_hp' => '391309044910', 'lokasi' => 'solo', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}