@extends('layouts.app', ['pageSlug' => 'mapel'])

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit Mata Pelajaran</h4>
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
                <form action="{{ route('admin.mapel.update', $mapel) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kode Mapel</label>
                                <input type="text" name="kode_mapel" class="form-control" value="{{ old('kode_mapel', $mapel->kode_mapel) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kelompok</label>
                                <select name="kelompok" class="form-control" required>
                                    <option value="Normatif" {{ old('kelompok', $mapel->kelompok) == 'Normatif' ? 'selected' : '' }}>Normatif</option>
                                    <option value="Adaptif" {{ old('kelompok', $mapel->kelompok) == 'Adaptif' ? 'selected' : '' }}>Adaptif</option>
                                    <option value="Produktif" {{ old('kelompok', $mapel->kelompok) == 'Produktif' ? 'selected' : '' }}>Produktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Nama Mata Pelajaran</label>
                        <input type="text" name="nama_mapel" class="form-control" value="{{ old('nama_mapel', $mapel->nama_mapel) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Jurusan (Kosongkan untuk Umum)</label>
                        <select name="jurusan_id" class="form-control">
                            <option value="">-- Umum / Semua Jurusan --</option>
                            @foreach($jurusans as $j)
                                <option value="{{ $j->id }}" {{ old('jurusan_id', $mapel->jurusan_id) == $j->id ? 'selected' : '' }}>{{ $j->nama_jurusan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <a href="{{ route('admin.mapel.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Perbarui</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
