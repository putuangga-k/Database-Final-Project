<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMitrasTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('mitras', function (Blueprint $table) {
            $table->increments('mitra_id'); // Primary Key
            $table->string('nama_mitra', 255);
            $table->string('no_hp', 20);
            $table->string('lokasi', 255);
            $table->timestamps(); // created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('mitras');
    }
}