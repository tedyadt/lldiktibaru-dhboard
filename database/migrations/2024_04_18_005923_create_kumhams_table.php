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
        Schema::create('kumhams', function (Blueprint $table) {
            $table->id();
            $table->string('kumham_nomor_sk',30)->nullable(false)->default('not set');
            $table->date('kumham_tgl_sk')->nullable(false)->default('1000-01-01');
            $table->string('kumham_dokumen', 100)->nullable(false)->default('not set');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kumhams');
    }
};
