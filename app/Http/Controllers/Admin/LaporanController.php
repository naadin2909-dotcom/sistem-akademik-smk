<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Absensi;
use App\Models\Nilai;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $stats = [
            'total_siswa' => Siswa::count(),
            'total_guru' => \App\Models\Guru::count(),
            'total_kelas' => Kelas::count(),
            'total_jurusan' => Jurusan::count(),
        ];

        return view('admin.laporan.index', compact('stats'));
    }

    public function siswaPerKelas(Request $request)
    {
        $query = Siswa::with(['kelas.jurusan']);

        if ($request->has('jurusan_id') && $request->jurusan_id) {
            $query->whereHas('kelas', function ($q) use ($request) {
                $q->where('jurusan_id', $request->jurusan_id);
            });
        }

        if ($request->has('kelas_id') && $request->kelas_id) {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->has('angkatan') && $request->angkatan) {
            $query->where('angkatan', $request->angkatan);
        }

        $siswas = $query->orderBy('nama_lengkap')->get();
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();
        $kelas = Kelas::orderBy('nama_kelas')->get();

        $rekapPerKelas = $siswas->groupBy('kelas_id')->map(function ($items, $kelasId) {
            $kelas = Kelas::find($kelasId);
            return [
                'nama_kelas' => $kelas ? $kelas->nama_kelas : 'N/A',
                'jurusan' => $kelas && $kelas->jurusan ? $kelas->jurusan->nama_jurusan : 'N/A',
                'jumlah' => $items->count(),
                'laki' => $items->where('jenis_kelamin', 'Laki-laki')->count(),
                'perempuan' => $items->where('jenis_kelamin', 'Perempuan')->count(),
            ];
        })->values();

        return view('admin.laporan.siswa-per-kelas', compact('siswas', 'jurusans', 'kelas', 'rekapPerKelas'));
    }

    public function absensiBulanan(Request $request)
    {
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));
        $kelasId = $request->get('kelas_id');

        $query = Absensi::with(['siswa.kelas', 'jadwal.mataPelajaran'])
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun);

        if ($kelasId) {
            $query->whereHas('siswa', function ($q) use ($kelasId) {
                $q->where('kelas_id', $kelasId);
            });
        }

        $absensis = $query->get();

        $rekapPerStatus = [
            'Hadir' => $absensis->where('status', 'Hadir')->count(),
            'Izin' => $absensis->where('status', 'Izin')->count(),
            'Sakit' => $absensis->where('status', 'Sakit')->count(),
            'Alpa' => $absensis->where('status', 'Alpa')->count(),
        ];

        $totalSemua = $absensis->count();
        $persentase = [
            'Hadir' => $totalSemua > 0 ? round(($rekapPerStatus['Hadir'] / $totalSemua) * 100, 1) : 0,
            'Izin' => $totalSemua > 0 ? round(($rekapPerStatus['Izin'] / $totalSemua) * 100, 1) : 0,
            'Sakit' => $totalSemua > 0 ? round(($rekapPerStatus['Sakit'] / $totalSemua) * 100, 1) : 0,
            'Alpa' => $totalSemua > 0 ? round(($rekapPerStatus['Alpa'] / $totalSemua) * 100, 1) : 0,
        ];

        $rekapPerKelas = $absensis->groupBy('siswa.kelas_id')->map(function ($items, $kelasId) {
            $kelas = Kelas::find($kelasId);
            return [
                'nama_kelas' => $kelas ? $kelas->nama_kelas : 'N/A',
                'total' => $items->count(),
                'hadir' => $items->where('status', 'Hadir')->count(),
                'izin' => $items->where('status', 'Izin')->count(),
                'sakit' => $items->where('status', 'Sakit')->count(),
                'alpa' => $items->where('status', 'Alpa')->count(),
            ];
        })->values();

        $kelasList = Kelas::orderBy('nama_kelas')->get();

        return view('admin.laporan.absensi-bulanan', compact(
            'absensis', 'rekapPerStatus', 'persentase', 'rekapPerKelas',
            'kelasList', 'bulan', 'tahun', 'totalSemua'
        ));
    }

    public function nilaiPerKelas(Request $request)
    {
        $semester = $request->get('semester', '1');
        $tahunAjaran = $request->get('tahun_ajaran', date('Y') . '/' . (date('Y') + 1));
        $kelasId = $request->get('kelas_id');

        $query = Nilai::with(['siswa.kelas', 'mataPelajaran', 'guru']);

        if ($kelasId) {
            $query->where('kelas_id', $kelasId);
        }

        $query->where('semester', $semester)
              ->where('tahun_ajaran', $tahunAjaran);

        $nilais = $query->get();

        $rekapPerKelas = $nilais->groupBy('kelas_id')->map(function ($items, $kelasId) {
            $kelas = Kelas::find($kelasId);
            return [
                'nama_kelas' => $kelas ? $kelas->nama_kelas : 'N/A',
                'jumlah_siswa' => $items->pluck('siswa_id')->unique()->count(),
                'rata_rata' => $items->avg('nilai_akhir'),
                'nilai_tertinggi' => $items->max('nilai_akhir'),
                'nilai_terendah' => $items->min('nilai_akhir'),
                'predikat_A' => $items->where('predikat', 'A')->count(),
                'predikat_B' => $items->where('predikat', 'B')->count(),
                'predikat_C' => $items->where('predikat', 'C')->count(),
                'predikat_D' => $items->where('predikat', 'D')->count(),
                'predikat_E' => $items->where('predikat', 'E')->count(),
            ];
        })->values();

        $distribusiPredikat = [
            'A' => $nilais->where('predikat', 'A')->count(),
            'B' => $nilais->where('predikat', 'B')->count(),
            'C' => $nilais->where('predikat', 'C')->count(),
            'D' => $nilais->where('predikat', 'D')->count(),
            'E' => $nilais->where('predikat', 'E')->count(),
        ];

        $rekapPerMapel = $nilais->groupBy('mata_pelajaran_id')->map(function ($items) {
            return [
                'nama_mapel' => $items->first()->mataPelajaran->nama_mapel ?? 'N/A',
                'kode_mapel' => $items->first()->mataPelajaran->kode_mapel ?? '-',
                'rata_rata' => $items->avg('nilai_akhir'),
                'nilai_tertinggi' => $items->max('nilai_akhir'),
                'nilai_terendah' => $items->min('nilai_akhir'),
                'jumlah' => $items->count(),
            ];
        })->values();

        $kelasList = Kelas::orderBy('nama_kelas')->get();

        return view('admin.laporan.nilai-per-kelas', compact(
            'nilais', 'rekapPerKelas', 'distribusiPredikat', 'rekapPerMapel',
            'kelasList', 'semester', 'tahunAjaran'
        ));
    }

    public function apiChartDashboard()
    {
        $siswaPerJurusan = Jurusan::withCount('siswa')
            ->get()
            ->pluck('siswa_count', 'nama_jurusan');

        $sixMonthsAgo = now()->subMonths(5)->startOfMonth();
        $absensiBulanan = Absensi::where('tanggal', '>=', $sixMonthsAgo)
            ->selectRaw("DATE_FORMAT(tanggal, '%Y-%m') as bulan, 
                         SUM(CASE WHEN status = 'Hadir' THEN 1 ELSE 0 END) as hadir,
                         SUM(CASE WHEN status = 'Izin' THEN 1 ELSE 0 END) as izin,
                         SUM(CASE WHEN status = 'Sakit' THEN 1 ELSE 0 END) as sakit,
                         SUM(CASE WHEN status = 'Alpa' THEN 1 ELSE 0 END) as alpa")
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $rataNilaiPerKelas = Nilai::join('kelas', 'nilais.kelas_id', '=', 'kelas.id')
            ->selectRaw('kelas.nama_kelas, AVG(nilais.nilai_akhir) as rata_rata')
            ->groupBy('kelas.nama_kelas')
            ->pluck('rata_rata', 'nama_kelas');

        $distribusiPredikat = Nilai::selectRaw('predikat, COUNT(*) as jumlah')
            ->groupBy('predikat')
            ->pluck('jumlah', 'predikat');

        return response()->json([
            'siswa_per_jurusan' => $siswaPerJurusan,
            'absensi_bulanan' => $absensiBulanan,
            'rata_nilai_per_kelas' => $rataNilaiPerKelas,
            'distribusi_predikat' => $distribusiPredikat,
        ]);
    }
}
