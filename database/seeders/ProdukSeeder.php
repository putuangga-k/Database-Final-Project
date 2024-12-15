<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdukSeeder extends Seeder
{
    public function run()
    {
        DB::table('produks')->insert([
            ['produk_id' => 1, 'nama_produk' => 'AYAM', 'deskripsi' => 'AYAM', 'created_at' => now(), 'updated_at' => now()],
            ['produk_id' => 2, 'nama_produk' => 'TEPUNG', 'deskripsi' => 'TEPUNG', 'created_at' => now(), 'updated_at' => now()],
            ['produk_id' => 3, 'nama_produk' => 'SAUS', 'deskripsi' => 'SAUS', 'created_at' => now(), 'updated_at' => now()],
            ['produk_id' => 4, 'nama_produk' => 'PACKAGING', 'deskripsi' => 'PACKAGING', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}