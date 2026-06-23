<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Pkl;

class PklController extends Controller
{
    public function index()
    {
        $siswa = auth()->user()->siswa;

        $pkls = Pkl::with(['guru', 'nilaiPkl'])
            ->where('siswa_id', $siswa->id)
            ->latest()
            ->paginate(10);

        return view('siswa.pkl.index', compact('pkls'));
    }
}
