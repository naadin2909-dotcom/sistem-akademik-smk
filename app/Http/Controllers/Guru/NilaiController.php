<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Nilai;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Siswa;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    private function getGuruJadwalIds()
    {
        $guru = auth()->user()->guru;
        if (!$guru) {
            return collect();
        }
        return \App\Models\Jadwal::where('guru_id', $guru->id)->pluck('id');
    }

    public function index(Request $request)
    {
        $guru = auth()->user()->guru;
        $jadwalIds = $this->getGuruJadwalIds();

        $query = Nilai::with(['siswa.kelas', 'mataPelajaran'])
            ->where('guru_id', $guru->id);

        if ($request->has('kelas_id') && $request->kelas_id) {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->has('semester') && $request->semester) {
            $query->where('semester', $request->semester);
        }

        if ($request->has('tahun_ajaran') && $request->tahun_ajaran) {
            $query->where('tahun_ajaran', $request->tahun_ajaran);
        }

        $nilais = $query->latest()->paginate(20);

        $kelasIds = \App\Models\Jadwal::whereIn('id', $jadwalIds)->pluck('kelas_id')->unique();
        $kelas = Kelas::whereIn('id', $kelasIds)->orderBy('nama_kelas')->get();

        return view('guru.nilai.index', compact('nilais', 'kelas'));
    }

    public function create(Request $request)
    {
        $guru = auth()->user()->guru;
        $jadwalIds = $this->getGuruJadwalIds();

        $kelasIds = \App\Models\Jadwal::whereIn('id', $jadwalIds)->pluck('kelas_id')->unique();
        $kelas = Kelas::whereIn('id', $kelasIds)->orderBy('nama_kelas')->get();

        $kelasId = $request->get('kelas_id');
        $mapelId = $request->get('mata_pelajaran_id');
        $semester = $request->get('semester', date('m') <= 6 ? '2' : '1');
        $tahunAjaran = $request->get('tahun_ajaran', date('Y') . '/' . (date('Y') + 1));

        $mapels = collect();
        $siswas = collect();

        if ($kelasId) {
            $jadwalMapelIds = \App\Models\Jadwal::where('guru_id', $guru->id)
                ->where('kelas_id', $kelasId)
                ->pluck('mata_pelajaran_id')
                ->unique();
            $mapels = MataPelajaran::whereIn('id', $jadwalMapelIds)->orderBy('nama_mapel')->get();
        }

        if ($kelasId && $mapelId && $semester && $tahunAjaran) {
            $siswas = Siswa::where('kelas_id', $kelasId)->orderBy('nama_lengkap')->get();

            foreach ($siswas as $siswa) {
                $existing = Nilai::where('siswa_id', $siswa->id)
                    ->where('mata_pelajaran_id', $mapelId)
                    ->where('kelas_id', $kelasId)
                    ->where('semester', $semester)
                    ->where('tahun_ajaran', $tahunAjaran)
                    ->first();

                $siswa->nilai_tugas = $existing ? $existing->tugas : 0;
                $siswa->nilai_uts = $existing ? $existing->uts : 0;
                $siswa->nilai_uas = $existing ? $existing->uas : 0;
            }
        }

        return view('guru.nilai.create', compact('kelas', 'mapels', 'siswas', 'kelasId', 'mapelId', 'semester', 'tahunAjaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'semester' => 'required|in:1,2',
            'tahun_ajaran' => 'required|string|max:9',
            'tugas' => 'required|array',
            'tugas.*' => 'required|numeric|min:0|max:100',
            'uts' => 'required|array',
            'uts.*' => 'required|numeric|min:0|max:100',
            'uas' => 'required|array',
            'uas.*' => 'required|numeric|min:0|max:100',
        ]);

        $guru = auth()->user()->guru;
        $kelasId = $request->kelas_id;
        $mapelId = $request->mata_pelajaran_id;
        $semester = $request->semester;
        $tahunAjaran = $request->tahun_ajaran;

        $siswas = Siswa::where('kelas_id', $kelasId)->get();

        foreach ($siswas as $siswa) {
            $tugas = $request->tugas[$siswa->id] ?? 0;
            $uts = $request->uts[$siswa->id] ?? 0;
            $uas = $request->uas[$siswa->id] ?? 0;
            $nilaiAkhir = Nilai::hitungNilaiAkhir($tugas, $uts, $uas);
            $predikat = Nilai::hitungPredikat($nilaiAkhir);

            Nilai::updateOrCreate(
                [
                    'siswa_id' => $siswa->id,
                    'mata_pelajaran_id' => $mapelId,
                    'kelas_id' => $kelasId,
                    'semester' => $semester,
                    'tahun_ajaran' => $tahunAjaran,
                ],
                [
                    'guru_id' => $guru->id,
                    'tugas' => $tugas,
                    'uts' => $uts,
                    'uas' => $uas,
                    'nilai_akhir' => $nilaiAkhir,
                    'predikat' => $predikat,
                ]
            );
        }

        return redirect()->route('guru.nilai.index')
            ->with('success', 'Nilai berhasil disimpan.');
    }
}
