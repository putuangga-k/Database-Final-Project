<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventarisTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('inventaris', function (Blueprint $table) {
            $table->increments('inventaris_id'); // Primary Key
            $table->unsignedInteger('produk_id')->unique(); // Foreign Key to Produk
            $table->integer('kuantitas')->default(0);
            $table->timestamps();

            // Foreign Key Constraint
            $table->foreign('produk_id')->references('produk_id')->on('produks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('inventaris');
    }
}