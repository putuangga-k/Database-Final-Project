<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengirimanSeeder extends Seeder
{
    public function run()
    {
        DB::table('pengirimans')->insert([
            ['pengiriman_id' => 5, 'stokis_id' => 1, 'produk_id' => 1, 'quantitas_produk' => 10, 'tanggal_pengiriman' => '2024-10-05', 'created_at' => now(), 'updated_at' => now()],
            ['pengiriman_id' => 6, 'stokis_id' => 2, 'produk_id' => 1, 'quantitas_produk' => 15, 'tanggal_pengiriman' => '2024-10-05', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}