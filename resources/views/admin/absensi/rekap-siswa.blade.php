@extends('layouts.app', ['pageSlug' => 'absensi'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h4 class="card-title">Rekap Absensi - {{ $siswa->nama_lengkap }}</h4>
                    </div>
                    <div class="col-4 text-right">
                        <a href="{{ route('admin.absensi.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card card-stats">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="text-center">
                                            <i class="tim-icons icon-check-2 text-success"></i>
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <div class="numbers">
                                            <p class="card-category">Hadir</p>
                                            <h3 class="card-title">{{ $rekap['Hadir'] }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-stats">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="text-center">
                                            <i class="tim-icons icon-alert-circle-exc text-warning"></i>
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <div class="numbers">
                                            <p class="card-category">Izin</p>
                                            <h3 class="card-title">{{ $rekap['Izin'] }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-stats">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="text-center">
                                            <i class="tim-icons icon-single-02 text-info"></i>
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <div class="numbers">
                                            <p class="card-category">Sakit</p>
                                            <h3 class="card-title">{{ $rekap['Sakit'] }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-stats">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="text-center">
                                            <i class="tim-icons icon-simple-remove text-danger"></i>
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <div class="numbers">
                                            <p class="card-category">Alpa</p>
                                            <h3 class="card-title">{{ $rekap['Alpa'] }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table tablesorter">
                        <thead class="text-primary">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Mata Pelajaran</th>
                                <th>Guru</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($absensis as $absensi)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($absensi->tanggal)->format('d/m/Y') }}</td>
                                <td>{{ $absensi->jadwal->mataPelajaran->nama_mapel ?? '-' }}</td>
                                <td>{{ $absensi->jadwal->guru->nama_lengkap ?? '-' }}</td>
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
                                <td>{{ $absensi->keterangan ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada data absensi.</td>
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
