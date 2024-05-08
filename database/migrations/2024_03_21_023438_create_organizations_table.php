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
        Schema::create('organizations', function (Blueprint $table) {

            $table->id();
            $table->string('org_nama',100)->default('not set');
            $table->string("org_nama_singkat", 50)->default('not set');
            $table->char("org_kode", 6)->unique();
            $table->char("org_defined_id", 16)->unique();
            $table->string('org_email', 100)->default('not set');
            $table->string('org_telp', 20)->default('not set');
            $table->string('org_website', 100)->default('not set');
            $table->string('org_kota',45)->default('not set');
            $table->string('org_alamat', 200)->default('not set');
            $table->string('org_logo', 200)->default('not_set.png');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
