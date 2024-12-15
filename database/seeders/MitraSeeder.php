<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MitraSeeder extends Seeder
{
    public function run()
    {
        DB::table('mitras')->insert([
            ['mitra_id' => 2, 'nama_mitra' => 'Zandi', 'no_hp' => '567890', 'lokasi' => 'Sby', 'created_at' => now(), 'updated_at' => now()],
            ['mitra_id' => 3, 'nama_mitra' => 'Angga', 'no_hp' => '0812345678', 'lokasi' => 'mulyosari', 'created_at' => now(), 'updated_at' => now()],
            ['mitra_id' => 4, 'nama_mitra' => 'Romero', 'no_hp' => '0833256724', 'lokasi' => 'gubeng', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}