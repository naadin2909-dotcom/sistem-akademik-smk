@extends('layouts.app', ['pageSlug' => 'absensi'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Input Absensi</h4>
            </div>
            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.absensi.create') }}" method="GET" class="row mb-4">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Kelas</label>
                            <select name="kelas_id" class="form-control" required>
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id }}" {{ $kelasId == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Jadwal</label>
                            <select name="jadwal_id" class="form-control" required>
                                <option value="">-- Pilih Jadwal --</option>
                                @foreach($jadwals as $j)
                                    <option value="{{ $j->id }}" {{ $jadwalId == $j->id ? 'selected' : '' }}>
                                        {{ $j->mataPelajaran->nama_mapel }} ({{ $j->hari }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" value="{{ $tanggal }}" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-info btn-block">Tampilkan Siswa</button>
                        </div>
                    </div>
                </form>

                @if($siswas->count() > 0)
                    <form action="{{ route('admin.absensi.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="kelas_id" value="{{ $kelasId }}">
                        <input type="hidden" name="jadwal_id" value="{{ $jadwalId }}">
                        <input type="hidden" name="tanggal" value="{{ $tanggal }}">

                        <div class="table-responsive">
                            <table class="table tablesorter">
                                <thead class="text-primary">
                                    <tr>
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama Siswa</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($siswas as $siswa)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $siswa->nis }}</td>
                                        <td>{{ $siswa->nama_lengkap }}</td>
                                        <td>
                                            <select name="statuses[{{ $siswa->id }}]" class="form-control form-control-sm" required>
                                                @foreach(['Hadir', 'Izin', 'Sakit', 'Alpa'] as $status)
                                                    <option value="{{ $status }}" {{ ($siswa->absensi_status ?? 'Hadir') == $status ? 'selected' : '' }}>
                                                        {{ $status }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="keterangan[{{ $siswa->id }}]" class="form-control form-control-sm"
                                                   value="{{ $siswa->absensi_keterangan ?? '' }}" placeholder="Opsional">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <a href="{{ route('admin.absensi.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Absensi</button>
                    </form>
                @elseif($kelasId && $jadwalId)
                    <div class="alert alert-info">Tidak ada siswa di kelas ini.</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
