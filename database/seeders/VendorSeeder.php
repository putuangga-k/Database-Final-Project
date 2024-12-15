<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VendorSeeder extends Seeder
{
    public function run()
    {
        DB::table('vendors')->insert([
            ['vendor_id' => 1, 'vendor_nama' => 'Fiesta', 'contact_info' => '12345678', 'lokasi' => 'Sby', 'produk_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['vendor_id' => 2, 'vendor_nama' => 'chickenfresh', 'contact_info' => '12312321', 'lokasi' => 'Sby', 'produk_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['vendor_id' => 3, 'vendor_nama' => 'BOGASARI', 'contact_info' => '12312321', 'lokasi' => 'jkt', 'produk_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['vendor_id' => 4, 'vendor_nama' => 'KUNCI BIRU', 'contact_info' => '12312321', 'lokasi' => 'Bekasi', 'produk_id' => 2, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}