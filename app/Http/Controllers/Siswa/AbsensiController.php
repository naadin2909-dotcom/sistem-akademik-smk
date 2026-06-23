<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $siswa = auth()->user()->siswa;

        $query = Absensi::with(['jadwal.mataPelajaran', 'jadwal.guru'])
            ->where('siswa_id', $siswa->id);

        if ($request->has('bulan') && $request->bulan) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        if ($request->has('tahun') && $request->tahun) {
            $query->whereYear('tanggal', $request->tahun);
        }

        if ($request->has('mapel') && $request->mapel) {
            $query->whereHas('jadwal', function ($q) use ($request) {
                $q->where('mata_pelajaran_id', $request->mapel);
            });
        }

        $absensis = $query->latest('tanggal')->paginate(20);

        $rekap = [
            'Hadir' => Absensi::where('siswa_id', $siswa->id)->where('status', 'Hadir')->count(),
            'Izin' => Absensi::where('siswa_id', $siswa->id)->where('status', 'Izin')->count(),
            'Sakit' => Absensi::where('siswa_id', $siswa->id)->where('status', 'Sakit')->count(),
            'Alpa' => Absensi::where('siswa_id', $siswa->id)->where('status', 'Alpa')->count(),
        ];

        $mapels = \App\Models\MataPelajaran::orderBy('nama_mapel')->get();

        return view('siswa.absensi.index', compact('absensis', 'rekap', 'mapels'));
    }
}
