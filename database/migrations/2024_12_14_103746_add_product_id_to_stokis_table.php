<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stokis', function (Blueprint $table) {
            // Menambahkan kolom product_id bertipe int unsigned
            $table->unsignedInteger('product_id')->nullable()->after('lokasi');

            // Menambahkan foreign key constraint ke tabel produks
            // Pastikan di tabel produks kolom produk_id didefinisikan dengan increments() atau unsignedInteger()
            $table->foreign('product_id')
                  ->references('produk_id')
                  ->on('produks')
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
        Schema::table('stokis', function (Blueprint $table) {
            // Hapus foreign key dahulu
            $table->dropForeign(['product_id']);
            // Hapus kolom product_id
            $table->dropColumn('product_id');
        });
    }
};