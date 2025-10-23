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
        Schema::create('sertifikat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_daftar_hadir')->constrained('daftar_hadir')->onDelete('cascade');
            $table->string('code_unik')->unique();
            $table->string('nama_kegiatan')->default('SEMNAS');
            $table->string('status')->default('PESERTA');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_sertifikat');
    }
};
