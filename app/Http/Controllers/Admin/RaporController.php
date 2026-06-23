<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rapor;
use App\Models\Nilai;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class RaporController extends Controller
{
    public function index(Request $request)
    {
        $query = Rapor::with(['siswa.kelas', 'generatedBy']);

        if ($request->has('kelas_id') && $request->kelas_id) {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->has('semester') && $request->semester) {
            $query->where('semester', $request->semester);
        }

        if ($request->has('tahun_ajaran') && $request->tahun_ajaran) {
            $query->where('tahun_ajaran', $request->tahun_ajaran);
        }

        $rapors = $query->latest()->paginate(20);
        $kelas = Kelas::orderBy('nama_kelas')->get();

        return view('admin.rapor.index', compact('rapors', 'kelas'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'semester' => 'required|in:1,2',
            'tahun_ajaran' => 'required|string|max:9',
        ]);

        $kelasId = $request->kelas_id;
        $semester = $request->semester;
        $tahunAjaran = $request->tahun_ajaran;
        $generatedBy = auth()->id();

        $siswas = Siswa::where('kelas_id', $kelasId)->get();
        $count = 0;

        foreach ($siswas as $siswa) {
            $nilais = Nilai::where('siswa_id', $siswa->id)
                ->where('kelas_id', $kelasId)
                ->where('semester', $semester)
                ->where('tahun_ajaran', $tahunAjaran)
                ->get();

            if ($nilais->isEmpty()) {
                continue;
            }

            $rataRata = $nilais->avg('nilai_akhir');
            $predikatUmum = \App\Models\Nilai::hitungPredikat($rataRata);

            Rapor::updateOrCreate(
                [
                    'siswa_id' => $siswa->id,
                    'kelas_id' => $kelasId,
                    'semester' => $semester,
                    'tahun_ajaran' => $tahunAjaran,
                ],
                [
                    'rata_rata_nilai' => round($rataRata, 2),
                    'predikat_umum' => $predikatUmum,
                    'generated_by' => $generatedBy,
                    'status' => 'draft',
                ]
            );
            $count++;
        }

        return redirect()->route('admin.rapor.index')
            ->with('success', "Berhasil generate rapor untuk {$count} siswa.");
    }

    public function cetak(Rapor $rapor)
    {
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
            ->where('tanggal', '>=', $rapor->semester == '1' ? $rapor->tahun_ajaran . '-07-01' : substr($rapor->tahun_ajaran, 0, 4) . '-01-01')
            ->where('tanggal', '<=', $rapor->semester == '1' ? substr($rapor->tahun_ajaran, 0, 4) . '-12-31' : substr($rapor->tahun_ajaran, 5) . '-06-30')
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

    public function updateStatus(Rapor $rapor, Request $request)
    {
        $rapor->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status rapor berhasil diperbarui.');
    }

    public function lihatRapor(Siswa $siswa, Request $request)
    {
        $query = Rapor::with(['kelas', 'generatedBy'])
            ->where('siswa_id', $siswa->id);

        if ($request->has('semester') && $request->semester) {
            $query->where('semester', $request->semester);
        }

        if ($request->has('tahun_ajaran') && $request->tahun_ajaran) {
            $query->where('tahun_ajaran', $request->tahun_ajaran);
        }

        $rapors = $query->latest()->paginate(10);

        return view('admin.rapor.lihat-rapor', compact('siswa', 'rapors'));
    }
}
