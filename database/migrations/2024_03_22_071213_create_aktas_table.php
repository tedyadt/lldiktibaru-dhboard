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
        Schema::create('aktas', function (Blueprint $table) {
            $table->id();
            $table->string('akta_nomor',45)->default('not set');
            $table->char("akta_defined_id", 16)->unique();
            $table->date('akta_tgl_dibuat')->default('1000-01-01');
            $table->string('akta_nama_atau_pengesah',150)->default('not set')->comment('berisi nama notaris(untuk bp) dan pengesah(untuk pt)');
            $table->string('akta_kota_notaris',150)->default('not set');
            $table->string('akta_perihal', 200)->default('not set');
            $table->enum('akta_jenis', ['Pendirian','Pembaruan','not set'])->default('not set');
            $table->string('akta_dokumen', 100)->nullable()->default('not_set.png');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aktas');
    }
};
