<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pkl;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Requests\Admin\StorePklRequest;
use App\Http\Requests\Admin\UpdatePklRequest;

class PklController extends Controller
{
    public function index(Request $request)
    {
        $query = Pkl::with(['siswa.kelas', 'guru']);

        if ($request->has('kelas_id') && $request->kelas_id) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $pkls = $query->latest()->paginate(15);
        $kelas = Kelas::orderBy('nama_kelas')->get();

        return view('admin.pkl.index', compact('pkls', 'kelas'));
    }

    public function create()
    {
        $siswas = Siswa::with('kelas')->orderBy('nama_lengkap')->get();
        $gurus = Guru::orderBy('nama_lengkap')->get();

        return view('admin.pkl.create', compact('siswas', 'gurus'));
    }

    public function store(StorePklRequest $request)
    {
        Pkl::create($request->validated());

        return redirect()->route('admin.pkl.index')
            ->with('success', 'Data PKL berhasil ditambahkan.');
    }

    public function edit(Pkl $pkl)
    {
        $siswas = Siswa::with('kelas')->orderBy('nama_lengkap')->get();
        $gurus = Guru::orderBy('nama_lengkap')->get();

        return view('admin.pkl.edit', compact('pkl', 'siswas', 'gurus'));
    }

    public function update(UpdatePklRequest $request, Pkl $pkl)
    {
        $pkl->update($request->validated());

        return redirect()->route('admin.pkl.index')
            ->with('success', 'Data PKL berhasil diperbarui.');
    }

    public function destroy(Pkl $pkl)
    {
        $pkl->delete();

        return redirect()->route('admin.pkl.index')
            ->with('success', 'Data PKL berhasil dihapus.');
    }

    public function cetakSurat(Pkl $pkl)
    {
        $pkl->load(['siswa.kelas.jurusan', 'guru']);

        $pdf = Pdf::loadView('admin.pkl.surat', compact('pkl'));

        return $pdf->stream("surat-pkl-{$pkl->siswa->nis}.pdf");
    }
}
