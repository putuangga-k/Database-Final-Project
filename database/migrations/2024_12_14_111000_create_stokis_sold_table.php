<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stokis_sold', function (Blueprint $table) {
            $table->increments('id'); // Primary Key Auto Increment
            
            // Kolom foreign key
            // Pastikan di tabel 'produks', kolom 'produk_id' didefinisikan dengan increments (INT UNSIGNED)
            $table->unsignedInteger('product_id');

            // Pastikan di tabel 'stokis', kolom 'stokis_id' didefinisikan dengan increments (INT UNSIGNED)
            $table->unsignedInteger('stokis_id');
            
            // Kolom tanggal_sold (format YYYY-MM-DD), gunakan tipe date
            $table->date('tanggal_sold');
            
            // Kolom harga, bisa berupa integer atau decimal. 
            // Jika harga dalam integer tanpa desimal, gunakan integer. 
            // Jika harga butuh desimal, gunakan decimal. 
            // Contoh: harga dalam integer (misalnya satuan rupiah)
            $table->integer('harga');

            $table->timestamps();

            // Definisi Foreign Key Constraints
            $table->foreign('product_id')
                  ->references('produk_id')->on('produks')
                  ->onDelete('cascade');

            $table->foreign('stokis_id')
                  ->references('stokis_id')->on('stokis')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stokis_sold');
    }
};