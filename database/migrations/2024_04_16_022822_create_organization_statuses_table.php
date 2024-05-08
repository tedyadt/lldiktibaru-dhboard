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
        Schema::create('organization_statuses', function (Blueprint $table) {
            $table->id();
            $table->enum('org_status', ['Aktif','Tidak Aktif', 'Pembinaan','Alih Bentuk','Alih Kelola','Tutup', 'not set'])->default('not set');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_statuses');
    }
};
