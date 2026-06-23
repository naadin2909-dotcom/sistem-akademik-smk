@extends('layouts.app', ['pageSlug' => 'laporan'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h4 class="card-title">Laporan Siswa per Kelas & Jurusan</h4>
                    </div>
                    <div class="col-4 text-right">
                        <a href="{{ route('admin.laporan.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.laporan.siswa-per-kelas') }}" method="GET" class="row mb-3">
                    <div class="col-md-3">
                        <select name="jurusan_id" class="form-control form-control-sm">
                            <option value="">-- Semua Jurusan --</option>
                            @foreach($jurusans as $j)
                                <option value="{{ $j->id }}" {{ request('jurusan_id') == $j->id ? 'selected' : '' }}>{{ $j->nama_jurusan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="kelas_id" class="form-control form-control-sm">
                            <option value="">-- Semua Kelas --</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="angkatan" class="form-control form-control-sm">
                            <option value="">-- Semua Angkatan --</option>
                            @for($a = date('Y'); $a >= date('Y') - 3; $a--)
                                <option value="{{ $a }}" {{ request('angkatan') == $a ? 'selected' : '' }}>{{ $a }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-sm btn-info">Filter</button>
                        <a href="{{ route('admin.laporan.siswa-per-kelas') }}" class="btn btn-sm btn-secondary">Reset</a>
                    </div>
                </form>

                <div class="row mb-4">
                    @foreach($rekapPerKelas as $rk)
                    <div class="col-lg-3 col-md-6">
                        <div class="card card-stats">
                            <div class="card-body">
                                <h5 class="card-category">{{ $rk['nama_kelas'] }}</h5>
                                <h3 class="card-title">{{ $rk['jumlah'] }} Siswa</h3>
                                <p class="text-muted" style="font-size: 0.8rem;">
                                    L: {{ $rk['laki'] }} | P: {{ $rk['perempuan'] }}
                                </p>
                            </div>
                            <div class="card-footer">
                                <hr>
                                <div class="stats">
                                    <i class="tim-icons icon-briefcase-24"></i> {{ $rk['jurusan'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="table-responsive">
                    <table class="table tablesorter">
                        <thead class="text-primary">
                            <tr>
                                <th>No</th>
                                <th>NIS</th>
                                <th>NISN</th>
                                <th>Nama Lengkap</th>
                                <th>Kelas</th>
                                <th>Jurusan</th>
                                <th>Jenis Kelamin</th>
                                <th>Angkatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($siswas as $siswa)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $siswa->nis }}</td>
                                <td>{{ $siswa->nisn }}</td>
                                <td>{{ $siswa->nama_lengkap }}</td>
                                <td>{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                                <td>{{ $siswa->kelas->jurusan->nama_jurusan ?? '-' }}</td>
                                <td>
                                    @if($siswa->jenis_kelamin == 'Laki-laki')
                                        <span class="badge badge-info">Laki-laki</span>
                                    @else
                                        <span class="badge badge-warning">Perempuan</span>
                                    @endif
                                </td>
                                <td>{{ $siswa->angkatan }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data siswa.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
