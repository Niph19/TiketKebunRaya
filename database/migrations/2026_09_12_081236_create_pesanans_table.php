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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_invoice')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('tanggal_kunjungan');
            $table->unsignedInteger('jumlah_dewasa');
            $table->unsignedInteger('jumlah_anak');
            $table->unsignedBigInteger('total_harga');
            $table->enum('status', ['pending', 'menunggu_konfirmasi', 'lunas', 'ditolak'])->default('pending');
            $table->string('bukti_pembayaran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
