<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Rapor;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class RaporController extends Controller
{
    public function index(Request $request)
    {
        $siswa = auth()->user()->siswa;

        $query = Rapor::with(['kelas'])
            ->where('siswa_id', $siswa->id);

        if ($request->has('semester') && $request->semester) {
            $query->where('semester', $request->semester);
        }

        if ($request->has('tahun_ajaran') && $request->tahun_ajaran) {
            $query->where('tahun_ajaran', $request->tahun_ajaran);
        }

        $rapors = $query->latest()->paginate(10);

        return view('siswa.rapor.index', compact('rapors'));
    }

    public function cetak(Rapor $rapor)
    {
        $siswa = auth()->user()->siswa;

        if ($rapor->siswa_id !== $siswa->id) {
            abort(403);
        }

        $rapor->load(['siswa.user', 'siswa.kelas.jurusan', 'kelas.waliKelas']);

        $nilais = Nilai::with(['mataPelajaran'])
            ->where('siswa_id', $rapor->siswa_id)
            ->where('kelas_id', $rapor->kelas_id)
            ->where('semester', $rapor->semester)
            ->where('tahun_ajaran', $rapor->tahun_ajaran)
            ->get();

        $absensi = \App\Models\Absensi::where('siswa_id', $rapor->siswa_id)
            ->whereHas('jadwal', function ($q) use ($rapor) {
                $q->where('kelas_id', $rapor->kelas_id);
            })
            ->get();

        $rekapAbsensi = [
            'Hadir' => $absensi->where('status', 'Hadir')->count(),
            'Izin' => $absensi->where('status', 'Izin')->count(),
            'Sakit' => $absensi->where('status', 'Sakit')->count(),
            'Alpa' => $absensi->where('status', 'Alpa')->count(),
        ];

        $pdf = Pdf::loadView('admin.rapor.cetak', compact('rapor', 'nilais', 'rekapAbsensi'));

        return $pdf->stream("rapor-{$rapor->siswa->nis}-{$rapor->semester}-{$rapor->tahun_ajaran}.pdf");
    }
}
