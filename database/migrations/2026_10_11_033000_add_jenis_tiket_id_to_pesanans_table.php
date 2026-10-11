<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->foreignId('jenis_tiket_id')
                ->nullable()
                ->after('kode_invoice')
                ->constrained('jenis_tikets');
        });
    }

    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropForeign(['jenis_tiket_id']);
            $table->dropColumn('jenis_tiket_id');
        });
    }
};
