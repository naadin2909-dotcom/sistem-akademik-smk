<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rapor extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'kelas_id',
        'semester',
        'tahun_ajaran',
        'rata_rata_nilai',
        'predikat_umum',
        'catatan_wali',
        'generated_by',
        'status',
    ];

    protected $casts = [
        'rata_rata_nilai' => 'decimal:2',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function generatedBy()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }

    public function detailNilai()
    {
        return $this->hasMany(Nilai::class, 'siswa_id', 'siswa_id')
            ->where('kelas_id', $this->kelas_id)
            ->where('semester', $this->semester)
            ->where('tahun_ajaran', $this->tahun_ajaran);
    }
}
