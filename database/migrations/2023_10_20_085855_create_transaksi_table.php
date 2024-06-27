<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('produk_id');
            $table->integer('quantity');
            $table->decimal('berat', 8, 2); // Kolom berat
            $table->decimal('harga_satuan', 15, 2);
            $table->decimal('subtotal_harga', 15, 2)->default(0);
            $table->decimal('total_harga', 15, 2)->default(0);
            $table->date('tanggal')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customer')->onDelete('cascade');
            $table->foreign('produk_id')->references('id')->on('produk')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
