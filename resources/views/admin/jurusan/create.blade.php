@extends('layouts.app', ['pageSlug' => 'jurusan'])

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Tambah Jurusan</h4>
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
                <form action="{{ route('admin.jurusan.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Kode Jurusan</label>
                        <input type="text" name="kode_jurusan" class="form-control" value="{{ old('kode_jurusan') }}" required placeholder="Contoh: TKJ, RPL, AKL">
                    </div>
                    <div class="form-group">
                        <label>Nama Jurusan</label>
                        <input type="text" name="nama_jurusan" class="form-control" value="{{ old('nama_jurusan') }}" required placeholder="Contoh: Teknik Komputer dan Jaringan">
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3" placeholder="Deskripsi jurusan...">{{ old('deskripsi') }}</textarea>
                    </div>
                    <a href="{{ route('admin.jurusan.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
