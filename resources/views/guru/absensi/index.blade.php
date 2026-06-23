@extends('layouts.app', ['pageSlug' => 'absensi'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h4 class="card-title">Rekap Absensi</h4>
                    </div>
                    <div class="col-4 text-right">
                        <a href="{{ route('guru.absensi.create') }}" class="btn btn-sm btn-primary">+ Input Absensi</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ route('guru.absensi.index') }}" method="GET" class="row mb-3">
                    <div class="col-md-3">
                        <select name="kelas_id" class="form-control form-control-sm">
                            <option value="">-- Semua Kelas --</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="bulan" class="form-control form-control-sm">
                            <option value="">-- Semua Bulan --</option>
                            @for($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>{{ Carbon\Carbon::create()->month($m)->format('F') }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="tahun" class="form-control form-control-sm">
                            <option value="">-- Semua Tahun --</option>
                            @for($y = date('Y'); $y >= date('Y') - 2; $y--)
                                <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-sm btn-info">Filter</button>
                        <a href="{{ route('guru.absensi.index') }}" class="btn btn-sm btn-secondary">Reset</a>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table tablesorter">
                        <thead class="text-primary">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Mata Pelajaran</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($absensis as $absensi)
                            <tr>
                                <td>{{ $absensis->firstItem() + $loop->index }}</td>
                                <td>{{ \Carbon\Carbon::parse($absensi->tanggal)->format('d/m/Y') }}</td>
                                <td>{{ $absensi->siswa->nis ?? '-' }}</td>
                                <td>{{ $absensi->siswa->nama_lengkap ?? '-' }}</td>
                                <td>{{ $absensi->siswa->kelas->nama_kelas ?? '-' }}</td>
                                <td>{{ $absensi->jadwal->mataPelajaran->nama_mapel ?? '-' }}</td>
                                <td>
                                    @if($absensi->status == 'Hadir')
                                        <span class="badge badge-success">{{ $absensi->status }}</span>
                                    @elseif($absensi->status == 'Izin')
                                        <span class="badge badge-warning">{{ $absensi->status }}</span>
                                    @elseif($absensi->status == 'Sakit')
                                        <span class="badge badge-info">{{ $absensi->status }}</span>
                                    @else
                                        <span class="badge badge-danger">{{ $absensi->status }}</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada data absensi.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    {{ $absensis->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
