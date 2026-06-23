@extends('layouts.app', ['pageSlug' => 'pkl'])

@section('content')
<div class="row">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit Data PKL</h4>
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
                <form action="{{ route('admin.pkl.update', $pkl) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Siswa</label>
                                <select name="siswa_id" class="form-control" required>
                                    <option value="">-- Pilih Siswa --</option>
                                    @foreach($siswas as $s)
                                        <option value="{{ $s->id }}" {{ old('siswa_id', $pkl->siswa_id) == $s->id ? 'selected' : '' }}>
                                            {{ $s->nama_lengkap }} ({{ $s->kelas->nama_kelas ?? '-' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Guru Pembimbing</label>
                                <select name="guru_id" class="form-control" required>
                                    <option value="">-- Pilih Guru --</option>
                                    @foreach($gurus as $g)
                                        <option value="{{ $g->id }}" {{ old('guru_id', $pkl->guru_id) == $g->id ? 'selected' : '' }}>{{ $g->nama_lengkap }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Nama Perusahaan</label>
                        <input type="text" name="perusahaan" class="form-control" value="{{ old('perusahaan', $pkl->perusahaan) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Alamat Perusahaan</label>
                        <textarea name="alamat_perusahaan" class="form-control" rows="2" required>{{ old('alamat_perusahaan', $pkl->alamat_perusahaan) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Kontak Perusahaan</label>
                        <input type="text" name="kontak_perusahaan" class="form-control" value="{{ old('kontak_perusahaan', $pkl->kontak_perusahaan) }}">
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" class="form-control" value="{{ old('tanggal_mulai', $pkl->tanggal_mulai->format('Y-m-d')) }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" class="form-control" value="{{ old('tanggal_selesai', $pkl->tanggal_selesai->format('Y-m-d')) }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control" required>
                                    <option value="draft" {{ old('status', $pkl->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="active" {{ old('status', $pkl->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="completed" {{ old('status', $pkl->status) == 'completed' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Catatan</label>
                        <textarea name="catatan" class="form-control" rows="2">{{ old('catatan', $pkl->catatan) }}</textarea>
                    </div>
                    <a href="{{ route('admin.pkl.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
