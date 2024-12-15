<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PembelianSeeder extends Seeder
{
    public function run()
    {
        DB::table('pembelians')->insert([
            ['id' => 6, 'produk_id' => 1, 'vendor_id' => 2, 'tanggal_pembelian' => '2024-10-05', 'harga_produk' => 40000.00, 'quantitas_produk' => 15, 'total_harga' => 600000.00, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'produk_id' => 1, 'vendor_id' => 1, 'tanggal_pembelian' => '2024-10-05', 'harga_produk' => 35000.00, 'quantitas_produk' => 25, 'total_harga' => 875000.00, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
