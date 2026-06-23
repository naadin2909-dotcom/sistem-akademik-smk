@extends('layouts.app', ['pageSlug' => 'laporan'])

@section('content')
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col-5">
                        <div class="icon-big text-center icon-warning">
                            <i class="tim-icons icon-single-02 text-primary"></i>
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="numbers">
                            <p class="card-category">Total Siswa</p>
                            <h3 class="card-title">{{ $stats['total_siswa'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col-5">
                        <div class="icon-big text-center icon-warning">
                            <i class="tim-icons icon-badge text-warning"></i>
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="numbers">
                            <p class="card-category">Total Guru</p>
                            <h3 class="card-title">{{ $stats['total_guru'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col-5">
                        <div class="icon-big text-center icon-warning">
                            <i class="tim-icons icon-bullet-list-67 text-success"></i>
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="numbers">
                            <p class="card-category">Total Kelas</p>
                            <h3 class="card-title">{{ $stats['total_kelas'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col-5">
                        <div class="icon-big text-center icon-warning">
                            <i class="tim-icons icon-briefcase-24 text-danger"></i>
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="numbers">
                            <p class="card-category">Total Jurusan</p>
                            <h3 class="card-title">{{ $stats['total_jurusan'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <a href="{{ route('admin.laporan.siswa-per-kelas') }}">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Laporan Siswa</h4>
                </div>
                <div class="card-body">
                    <p class="card-description">Data siswa per kelas dan jurusan dengan filter lengkap.</p>
                    <div class="text-center">
                        <i class="tim-icons icon-single-02 text-primary" style="font-size: 3rem;"></i>
                        <p class="mt-3"><strong>Lihat Laporan</strong></p>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('admin.laporan.absensi-bulanan') }}">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Laporan Absensi</h4>
                </div>
                <div class="card-body">
                    <p class="card-description">Rekap absensi bulanan dengan chart dan statistik per kelas.</p>
                    <div class="text-center">
                        <i class="tim-icons icon-check-2 text-success" style="font-size: 3rem;"></i>
                        <p class="mt-3"><strong>Lihat Laporan</strong></p>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('admin.laporan.nilai-per-kelas') }}">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Laporan Nilai</h4>
                </div>
                <div class="card-body">
                    <p class="card-description">Rekap nilai per kelas dengan distribusi predikat dan grafik.</p>
                    <div class="text-center">
                        <i class="tim-icons icon-paper text-warning" style="font-size: 3rem;"></i>
                        <p class="mt-3"><strong>Lihat Laporan</strong></p>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection
