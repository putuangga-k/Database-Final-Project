<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('vendor_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('produk_id'); 
            $table->unsignedInteger('vendor_id'); 
    
            $table->date('tanggal_berlaku');
            $table->decimal('harga_laku', 10, 2);
            $table->timestamps();
    
            $table->foreign('produk_id')
                  ->references('produk_id')
                  ->on('produks')
                  ->onDelete('cascade');
    
            $table->foreign('vendor_id')
                  ->references('vendor_id')
                  ->on('vendors')
                  ->onDelete('cascade');
        });
    }    

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('vendor_prices');
    }
};
