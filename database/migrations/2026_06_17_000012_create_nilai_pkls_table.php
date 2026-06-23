<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilai_pkls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pkl_id')->constrained('pkls')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
            $table->decimal('nilai', 5, 2)->default(0);
            $table->string('predikat', 1)->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->unique(['pkl_id', 'siswa_id'], 'nilai_pkl_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilai_pkls');
    }
};
