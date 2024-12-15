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
        Schema::table('produks', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable()->after('produk_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
        });
    }    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            //
        });
    }
};
