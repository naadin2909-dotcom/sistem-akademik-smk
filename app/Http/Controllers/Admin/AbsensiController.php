<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\Jadwal;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AbsensiExport;
use App\Http\Requests\Admin\StoreAbsensiRequest;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $query = Absensi::with(['siswa.kelas', 'jadwal.mataPelajaran', 'jadwal.guru']);

        if ($request->has('kelas_id') && $request->kelas_id) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }

        if ($request->has('bulan') && $request->bulan) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        if ($request->has('tahun') && $request->tahun) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $absensis = $query->latest('tanggal')->paginate(20);
        $kelas = Kelas::orderBy('nama_kelas')->get();

        return view('admin.absensi.index', compact('absensis', 'kelas'));
    }

    public function create(Request $request)
    {
        $kelasId = $request->get('kelas_id');
        $jadwalId = $request->get('jadwal_id');
        $tanggal = $request->get('tanggal', date('Y-m-d'));

        $kelas = Kelas::orderBy('nama_kelas')->get();
        $jadwals = [];
        $siswas = collect();

        if ($kelasId) {
            $jadwals = Jadwal::with(['mataPelajaran', 'guru'])
                ->where('kelas_id', $kelasId)
                ->orderBy('hari')
                ->get();
        }

        if ($kelasId && $jadwalId && $tanggal) {
            $siswas = Siswa::where('kelas_id', $kelasId)->orderBy('nama_lengkap')->get();

            foreach ($siswas as $siswa) {
                $existing = Absensi::where('siswa_id', $siswa->id)
                    ->where('jadwal_id', $jadwalId)
                    ->where('tanggal', $tanggal)
                    ->first();
                $siswa->absensi_status = $existing ? $existing->status : 'Hadir';
                $siswa->absensi_keterangan = $existing ? $existing->keterangan : '';
            }
        }

        return view('admin.absensi.create', compact('kelas', 'jadwals', 'siswas', 'kelasId', 'jadwalId', 'tanggal'));
    }

    public function store(StoreAbsensiRequest $request)
    {
        $kelasId = $request->kelas_id;
        $jadwalId = $request->jadwal_id;
        $tanggal = $request->tanggal;
        $statuses = $request->statuses;
        $keterangan = $request->keterangan ?? [];
        $inputBy = auth()->id();

        $siswas = Siswa::where('kelas_id', $kelasId)->get();

        foreach ($siswas as $siswa) {
            if (isset($statuses[$siswa->id])) {
                Absensi::updateOrCreate(
                    [
                        'siswa_id' => $siswa->id,
                        'jadwal_id' => $jadwalId,
                        'tanggal' => $tanggal,
                    ],
                    [
                        'status' => $statuses[$siswa->id],
                        'keterangan' => $keterangan[$siswa->id] ?? null,
                        'input_by' => $inputBy,
                    ]
                );
            }
        }

        return redirect()->route('admin.absensi.index')
            ->with('success', 'Absensi berhasil disimpan.');
    }

    public function rekapSiswa(Siswa $siswa)
    {
        $absensis = Absensi::with(['jadwal.mataPelajaran', 'jadwal.guru'])
            ->where('siswa_id', $siswa->id)
            ->latest('tanggal')
            ->get();

        $rekap = [
            'Hadir' => $absensis->where('status', 'Hadir')->count(),
            'Izin' => $absensis->where('status', 'Izin')->count(),
            'Sakit' => $absensis->where('status', 'Sakit')->count(),
            'Alpa' => $absensis->where('status', 'Alpa')->count(),
        ];

        return view('admin.absensi.rekap-siswa', compact('siswa', 'absensis', 'rekap'));
    }

    public function exportExcel(Request $request)
    {
        $kelasId = $request->get('kelas_id');
        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun');

        return Excel::download(new AbsensiExport($kelasId, $bulan, $tahun), 'rekap-absensi.xlsx');
    }
}
