<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (
            DB::table('detail_pesanans')->exists()
            || DB::table('tiket_kategoris')->exists()
        ) {
            throw new RuntimeException(
                'Cannot remove ticket category tables because they contain data. Archive or migrate that data first.'
            );
        }

        Schema::drop('detail_pesanans');
        Schema::drop('tiket_kategoris');
    }

    public function down(): void
    {
        Schema::create('tiket_kategoris', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->unsignedBigInteger('harga');
            $table->text('deskripsi')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('detail_pesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_id')->constrained('pesanans')->onDelete('cascade');
            $table->foreignId('kategori_id')->constrained('tiket_kategoris')->onDelete('cascade');
            $table->unsignedInteger('jumlah');
            $table->unsignedBigInteger('harga_satuan');
            $table->unsignedBigInteger('total_harga');
            $table->timestamps();
        });
    }
};
