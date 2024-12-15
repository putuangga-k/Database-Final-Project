<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembeliansTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pembelians', function (Blueprint $table) {
            $table->increments('id'); // Primary Key
            $table->unsignedInteger('produk_id'); // Foreign Key to Produk
            $table->unsignedInteger('vendor_id'); // Foreign Key to Vendor
            $table->date('tanggal_pembelian');
            $table->decimal('harga_produk', 15, 2);
            $table->integer('quantitas_produk');
            $table->decimal('total_harga', 15, 2);
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('produk_id')->references('produk_id')->on('produks')->onDelete('cascade');
            $table->foreign('vendor_id')->references('vendor_id')->on('vendors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('pembelians');
    }
}