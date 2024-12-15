<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->increments('vendor_id'); // Vendor_id sebagai Primary Key
            $table->string('vendor_nama', 255);
            $table->string('contact_info', 255);
            $table->string('lokasi', 255);
            $table->unsignedInteger('produk_id'); // Produk_id sebagai Foreign Key
            $table->timestamps(); // created_at dan updated_at

            // Menambahkan Foreign Key Constraint
            $table->foreign('produk_id')
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
        Schema::dropIfExists('vendors');
    }
}