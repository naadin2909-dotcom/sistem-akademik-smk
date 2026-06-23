<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Jadwal;
use App\Models\Siswa;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    private function getGuruJadwalIds()
    {
        $guru = auth()->user()->guru;
        if (!$guru) {
            return collect();
        }
        return Jadwal::where('guru_id', $guru->id)->pluck('id');
    }

    public function index(Request $request)
    {
        $jadwalIds = $this->getGuruJadwalIds();

        $query = Absensi::with(['siswa.kelas', 'jadwal.mataPelajaran'])
            ->whereIn('jadwal_id', $jadwalIds);

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

        $kelasIds = Jadwal::whereIn('id', $jadwalIds)->pluck('kelas_id')->unique();
        $kelas = \App\Models\Kelas::whereIn('id', $kelasIds)->orderBy('nama_kelas')->get();

        return view('guru.absensi.index', compact('absensis', 'kelas'));
    }

    public function create(Request $request)
    {
        $guru = auth()->user()->guru;
        $jadwalIds = $this->getGuruJadwalIds();

        $kelasIds = Jadwal::whereIn('id', $jadwalIds)->pluck('kelas_id')->unique();
        $kelas = \App\Models\Kelas::whereIn('id', $kelasIds)->orderBy('nama_kelas')->get();

        $kelasId = $request->get('kelas_id');
        $jadwalId = $request->get('jadwal_id');
        $tanggal = $request->get('tanggal', date('Y-m-d'));

        $jadwals = collect();
        $siswas = collect();

        if ($kelasId) {
            $jadwals = Jadwal::with(['mataPelajaran', 'guru'])
                ->where('guru_id', $guru->id)
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

        return view('guru.absensi.create', compact('kelas', 'jadwals', 'siswas', 'kelasId', 'jadwalId', 'tanggal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'jadwal_id' => 'required|exists:jadwals,id',
            'tanggal' => 'required|date',
            'statuses' => 'required|array',
            'statuses.*' => 'required|in:Hadir,Izin,Sakit,Alpa',
        ]);

        $guru = auth()->user()->guru;
        $jadwal = Jadwal::where('id', $request->jadwal_id)
            ->where('guru_id', $guru->id)
            ->first();

        if (!$jadwal) {
            return back()->with('error', 'Anda tidak memiliki akses ke jadwal ini.');
        }

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

        return redirect()->route('guru.absensi.index')
            ->with('success', 'Absensi berhasil disimpan.');
    }
}
