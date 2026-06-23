<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Pkl;
use App\Models\NilaiPkl;
use Illuminate\Http\Request;

class PklController extends Controller
{
    public function index(Request $request)
    {
        $guru = auth()->user()->guru;

        $query = Pkl::with(['siswa.kelas'])
            ->where('guru_id', $guru->id);

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $pkls = $query->latest()->paginate(15);

        return view('guru.pkl.index', compact('pkls'));
    }

    public function inputNilai(Pkl $pkl)
    {
        $guru = auth()->user()->guru;

        if ($pkl->guru_id !== $guru->id) {
            abort(403);
        }

        $pkl->load('siswa.kelas');
        $nilaiPkl = $pkl->nilaiPkl;

        return view('guru.pkl.input-nilai', compact('pkl', 'nilaiPkl'));
    }

    public function storeNilai(Request $request, Pkl $pkl)
    {
        $guru = auth()->user()->guru;

        if ($pkl->guru_id !== $guru->id) {
            abort(403);
        }

        $request->validate([
            'nilai' => 'required|numeric|min:0|max:100',
            'catatan' => 'nullable|string',
        ]);

        $predikat = \App\Models\NilaiPkl::hitungPredikat($request->nilai);

        \App\Models\NilaiPkl::updateOrCreate(
            [
                'pkl_id' => $pkl->id,
                'siswa_id' => $pkl->siswa_id,
            ],
            [
                'guru_id' => $guru->id,
                'nilai' => $request->nilai,
                'predikat' => $predikat,
                'catatan' => $request->catatan,
            ]
        );

        return redirect()->route('guru.pkl.index')
            ->with('success', 'Nilai PKL berhasil disimpan.');
    }
}
