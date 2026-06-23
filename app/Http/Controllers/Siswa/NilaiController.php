<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Nilai;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        $siswa = auth()->user()->siswa;

        $query = Nilai::with(['mataPelajaran', 'guru'])
            ->where('siswa_id', $siswa->id);

        if ($request->has('semester') && $request->semester) {
            $query->where('semester', $request->semester);
        }

        if ($request->has('tahun_ajaran') && $request->tahun_ajaran) {
            $query->where('tahun_ajaran', $request->tahun_ajaran);
        }

        $nilais = $query->orderBy('tahun_ajaran', 'desc')
            ->orderBy('semester', 'desc')
            ->paginate(20);

        return view('siswa.nilai.index', compact('nilais'));
    }
}
