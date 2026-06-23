@extends('layouts.app', ['pageSlug' => 'pkl'])

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Input Nilai PKL - {{ $pkl->siswa->nama_lengkap }}</h4>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-4">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Siswa:</strong> {{ $pkl->siswa->nama_lengkap }}</p>
                            <p><strong>NIS:</strong> {{ $pkl->siswa->nis }}</p>
                            <p><strong>Kelas:</strong> {{ $pkl->siswa->kelas->nama_kelas ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Perusahaan:</strong> {{ $pkl->perusahaan }}</p>
                            <p><strong>Periode:</strong> {{ $pkl->tanggal_mulai->format('d/m/Y') }} - {{ $pkl->tanggal_selesai->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('guru.pkl.store-nilai', $pkl) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Nilai (0-100)</label>
                        <input type="number" name="nilai" class="form-control" value="{{ old('nilai', $nilaiPkl->nilai ?? '') }}" min="0" max="100" required>
                        <small class="text-muted">Predikat: A (90-100), B (80-89), C (70-79), D (60-69), E (&lt;60)</small>
                    </div>
                    <div class="form-group">
                        <label>Catatan</label>
                        <textarea name="catatan" class="form-control" rows="3">{{ old('catatan', $nilaiPkl->catatan ?? '') }}</textarea>
                    </div>
                    <a href="{{ route('guru.pkl.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Nilai</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
