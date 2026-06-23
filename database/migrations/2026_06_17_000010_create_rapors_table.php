<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rapors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->enum('semester', ['1', '2']);
            $table->string('tahun_ajaran', 9);
            $table->decimal('rata_rata_nilai', 5, 2)->default(0);
            $table->string('predikat_umum', 1)->nullable();
            $table->text('catatan_wali')->nullable();
            $table->foreignId('generated_by')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['draft', 'final'])->default('draft');
            $table->timestamps();

            $table->unique(['siswa_id', 'kelas_id', 'semester', 'tahun_ajaran'], 'rapor_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rapors');
    }
};
