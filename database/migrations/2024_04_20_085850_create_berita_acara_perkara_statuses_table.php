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
        Schema::create('berita_acara_perkara_statuses', function (Blueprint $table) {
            $table->id();
            $table->enum('bap_status', ['Belum Diproses', 'Sedang Diproses', 'Selesai Diproses', 'not set'])->default('not set');
            $table->longText('bap_keterangan')->default('not set');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita_acara_perkara_statuses');
    }
};
