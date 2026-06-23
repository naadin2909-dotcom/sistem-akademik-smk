<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\StoreMataPelajaranRequest;
use App\Http\Requests\Admin\UpdateMataPelajaranRequest;

class MataPelajaranController extends Controller
{
    public function index()
    {
        $mapels = MataPelajaran::with('jurusan')->latest()->paginate(10);
        return view('admin.mapel.index', compact('mapels'));
    }

    public function create()
    {
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();
        return view('admin.mapel.create', compact('jurusans'));
    }

    public function store(StoreMataPelajaranRequest $request)
    {
        MataPelajaran::create($request->validated());

        return redirect()->route('admin.mapel.index')
            ->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function edit(MataPelajaran $mapel)
    {
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();
        return view('admin.mapel.edit', compact('mapel', 'jurusans'));
    }

    public function update(UpdateMataPelajaranRequest $request, MataPelajaran $mapel)
    {
        $mapel->update($request->validated());

        return redirect()->route('admin.mapel.index')
            ->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    public function destroy(MataPelajaran $mapel)
    {
        if ($mapel->jadwal()->count() > 0) {
            return redirect()->route('admin.mapel.index')
                ->with('error', 'Tidak dapat menghapus mata pelajaran yang masih memiliki jadwal.');
        }

        $mapel->delete();

        return redirect()->route('admin.mapel.index')
            ->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}
