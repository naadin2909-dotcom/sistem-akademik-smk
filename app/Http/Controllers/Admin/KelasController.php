<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\Guru;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\StoreKelasRequest;
use App\Http\Requests\Admin\UpdateKelasRequest;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with(['jurusan', 'waliKelas'])->latest()->paginate(10);
        return view('admin.kelas.index', compact('kelas'));
    }

    public function create()
    {
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();
        $gurus = Guru::orderBy('nama_lengkap')->get();
        return view('admin.kelas.create', compact('jurusans', 'gurus'));
    }

    public function store(StoreKelasRequest $request)
    {
        Kelas::create($request->validated());

        return redirect()->route('admin.kelas.index')
            ->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function edit(Kelas $kelas)
    {
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();
        $gurus = Guru::orderBy('nama_lengkap')->get();
        return view('admin.kelas.edit', compact('kelas', 'jurusans', 'gurus'));
    }

    public function update(UpdateKelasRequest $request, Kelas $kelas)
    {
        $kelas->update($request->validated());

        return redirect()->route('admin.kelas.index')
            ->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy(Kelas $kelas)
    {
        if ($kelas->siswa()->count() > 0) {
            return redirect()->route('admin.kelas.index')
                ->with('error', 'Tidak dapat menghapus kelas yang masih memiliki siswa.');
        }

        if ($kelas->jadwal()->count() > 0) {
            return redirect()->route('admin.kelas.index')
                ->with('error', 'Tidak dapat menghapus kelas yang masih memiliki jadwal.');
        }

        $kelas->delete();

        return redirect()->route('admin.kelas.index')
            ->with('success', 'Kelas berhasil dihapus.');
    }
}
