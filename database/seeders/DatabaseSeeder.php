<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeder default untuk User
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Memanggil semua seeder lainnya
        $this->call([
            ProdukSeeder::class,
            VendorSeeder::class,
            MitraSeeder::class,
            StokisSeeder::class,
            InventarisSeeder::class,
            PengirimanSeeder::class,
            PembelianSeeder::class,
        ]);
    }
}