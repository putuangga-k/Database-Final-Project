<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventarisSeeder extends Seeder
{
    public function run()
    {
        DB::table('inventaris')->insert([
            ['inventaris_id' => 3, 'produk_id' => 1, 'kuantitas' => 80, 'created_at' => now(), 'updated_at' => now()],
            ['inventaris_id' => 4, 'produk_id' => 2, 'kuantitas' => 5, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}