<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gurus', function (Blueprint $table) {
            $table->string('agama', 20)->nullable()->after('jenis_kelamin');
            $table->text('riwayat_pendidikan')->nullable()->after('mata_pelajaran');
        });
    }

    public function down(): void
    {
        Schema::table('gurus', function (Blueprint $table) {
            $table->dropColumn(['agama', 'riwayat_pendidikan']);
        });
    }
};
