<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->string('nama_produk');
            $table->integer('berat')->nullable();
            $table->string('satuan');
            $table->string('harga');
            $table->integer('stok')->nullable();
            $table->unsignedBigInteger('kategori_id');
            // $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign('kategori_id')->references('id')->on('kategori');
            // $table->foreign('user_id')->references('id')->on('user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
