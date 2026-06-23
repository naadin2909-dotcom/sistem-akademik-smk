<?php

namespace App\Exports;

use App\Models\Absensi;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AbsensiExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    protected $kelasId;
    protected $bulan;
    protected $tahun;

    public function __construct($kelasId = null, $bulan = null, $tahun = null)
    {
        $this->kelasId = $kelasId;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function query()
    {
        $query = Absensi::with(['siswa.kelas', 'jadwal.mataPelajaran', 'jadwal.guru']);

        if ($this->kelasId) {
            $query->whereHas('siswa', function ($q) {
                $q->where('kelas_id', $this->kelasId);
            });
        }

        if ($this->bulan) {
            $query->whereMonth('tanggal', $this->bulan);
        }

        if ($this->tahun) {
            $query->whereYear('tanggal', $this->tahun);
        }

        return $query->orderBy('tanggal')->orderBy('siswa_id');
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'NIS',
            'Nama Siswa',
            'Kelas',
            'Mata Pelajaran',
            'Guru',
            'Status',
            'Keterangan',
        ];
    }

    public function map($absensi): array
    {
        return [
            $absensi->tanggal->format('d/m/Y'),
            $absensi->siswa->nis ?? '-',
            $absensi->siswa->nama_lengkap ?? '-',
            $absensi->siswa->kelas->nama_kelas ?? '-',
            $absensi->jadwal->mataPelajaran->nama_mapel ?? '-',
            $absensi->jadwal->guru->nama_lengkap ?? '-',
            $absensi->status,
            $absensi->keterangan ?? '-',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
