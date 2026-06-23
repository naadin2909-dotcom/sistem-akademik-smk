@extends('layouts.app', ['pageSlug' => 'mapel'])

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Tambah Mata Pelajaran</h4>
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
                <form action="{{ route('admin.mapel.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kode Mapel</label>
                                <input type="text" name="kode_mapel" class="form-control" value="{{ old('kode_mapel') }}" required placeholder="Contoh: PW, PJOK">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kelompok</label>
                                <select name="kelompok" class="form-control" required>
                                    <option value="">-- Pilih Kelompok --</option>
                                    <option value="Normatif" {{ old('kelompok') == 'Normatif' ? 'selected' : '' }}>Normatif</option>
                                    <option value="Adaptif" {{ old('kelompok') == 'Adaptif' ? 'selected' : '' }}>Adaptif</option>
                                    <option value="Produktif" {{ old('kelompok') == 'Produktif' ? 'selected' : '' }}>Produktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Nama Mata Pelajaran</label>
                        <input type="text" name="nama_mapel" class="form-control" value="{{ old('nama_mapel') }}" required placeholder="Contoh: Pemrograman Web">
                    </div>
                    <div class="form-group">
                        <label>Jurusan (Kosongkan untuk Umum)</label>
                        <select name="jurusan_id" class="form-control">
                            <option value="">-- Umum / Semua Jurusan --</option>
                            @foreach($jurusans as $j)
                                <option value="{{ $j->id }}" {{ old('jurusan_id') == $j->id ? 'selected' : '' }}>{{ $j->nama_jurusan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <a href="{{ route('admin.mapel.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
