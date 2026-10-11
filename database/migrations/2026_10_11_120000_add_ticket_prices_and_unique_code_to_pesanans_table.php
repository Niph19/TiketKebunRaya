<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->uuid('kode_tiket')->nullable()->unique();
            $table->unsignedBigInteger('harga_dewasa')->default(0);
            $table->unsignedBigInteger('harga_anak')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropUnique(['kode_tiket']);
            $table->dropColumn(['kode_tiket', 'harga_dewasa', 'harga_anak']);
        });
    }
};
