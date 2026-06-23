<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pkls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
            $table->string('perusahaan');
            $table->text('alamat_perusahaan');
            $table->string('kontak_perusahaan')->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('status', ['draft', 'active', 'completed'])->default('draft');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->unique(['siswa_id', 'tanggal_mulai'], 'pkl_siswa_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pkls');
    }
};
