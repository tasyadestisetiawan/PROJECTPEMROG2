<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaranTable extends Migration
{
    public function up()
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->decimal('jumlah_bayar', 10, 2);
            $table->decimal('kembalian', 10, 2)->nullable();
            $table->timestamps();
            $table->foreignId('transaksi_id')->constrained('transaksi')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('user')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pembayaran');
    }
}
