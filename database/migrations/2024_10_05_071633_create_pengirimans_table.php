<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengirimansTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pengirimans', function (Blueprint $table) {
            $table->increments('pengiriman_id'); // Primary Key
            $table->unsignedInteger('stokis_id'); // Foreign Key to Stokis
            $table->unsignedInteger('produk_id'); // Foreign Key to Produk
            $table->integer('quantitas_produk');
            $table->date('tanggal_pengiriman');
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('stokis_id')->references('stokis_id')->on('stokis')->onDelete('cascade');
            $table->foreign('produk_id')->references('produk_id')->on('produks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('pengirimans');
    }
}