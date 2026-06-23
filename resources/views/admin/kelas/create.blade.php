@extends('layouts.app', ['pageSlug' => 'kelas'])

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Tambah Kelas</h4>
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
                <form action="{{ route('admin.kelas.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Nama Kelas</label>
                        <input type="text" name="nama_kelas" class="form-control" value="{{ old('nama_kelas') }}" required placeholder="Contoh: X TKJ 1">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jurusan</label>
                                <select name="jurusan_id" class="form-control" required>
                                    <option value="">-- Pilih Jurusan --</option>
                                    @foreach($jurusans as $j)
                                        <option value="{{ $j->id }}" {{ old('jurusan_id') == $j->id ? 'selected' : '' }}>{{ $j->nama_jurusan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tingkat</label>
                                <select name="tingkat" class="form-control" required>
                                    <option value="">-- Pilih Tingkat --</option>
                                    <option value="X" {{ old('tingkat') == 'X' ? 'selected' : '' }}>X</option>
                                    <option value="XI" {{ old('tingkat') == 'XI' ? 'selected' : '' }}>XI</option>
                                    <option value="XII" {{ old('tingkat') == 'XII' ? 'selected' : '' }}>XII</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tahun Ajaran</label>
                                <input type="text" name="tahun_ajaran" class="form-control" value="{{ old('tahun_ajaran') }}" required placeholder="Contoh: 2025/2026">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Wali Kelas</label>
                                <select name="wali_kelas_id" class="form-control">
                                    <option value="">-- Pilih Wali Kelas --</option>
                                    @foreach($gurus as $g)
                                        <option value="{{ $g->id }}" {{ old('wali_kelas_id') == $g->id ? 'selected' : '' }}>{{ $g->nama_lengkap }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('admin.kelas.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
