@extends('layouts.app', ['pageSlug' => 'dashboard'])

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
                                <h3 class="card-title">{{ $stats['siswa'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <hr>
                    <div class="stats">
                        <i class="tim-icons icon-single-02"></i> Data Siswa
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
                                <h3 class="card-title">{{ $stats['guru'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <hr>
                    <div class="stats">
                        <i class="tim-icons icon-badge"></i> Data Guru
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
                                <h3 class="card-title">{{ $stats['kelas'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <hr>
                    <div class="stats">
                        <i class="tim-icons icon-bullet-list-67"></i> Data Kelas
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
                                <h3 class="card-title">{{ $stats['jurusan'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <hr>
                    <div class="stats">
                        <i class="tim-icons icon-briefcase-24"></i> Data Jurusan
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Siswa per Jurusan</h5>
                </div>
                <div class="card-body">
                    <canvas id="chartSiswaJurusan" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Distribusi Predikat Nilai</h5>
                </div>
                <div class="card-body">
                    <canvas id="chartPredikat" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Rata-rata Nilai per Kelas</h5>
                </div>
                <div class="card-body">
                    <canvas id="chartNilaiKelas" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Absensi 6 Bulan Terakhir</h5>
                </div>
                <div class="card-body">
                    <canvas id="chartAbsensiBulanan" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    @push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('{{ route('admin.api.chart-dashboard') }}')
                .then(response => response.json())
                .then(data => {
                    // Chart 1: Siswa per Jurusan (Pie)
                    var ctx1 = document.getElementById('chartSiswaJurusan').getContext('2d');
                    new Chart(ctx1, {
                        type: 'pie',
                        data: {
                            labels: Object.keys(data.siswa_per_jurusan),
                            datasets: [{
                                data: Object.values(data.siswa_per_jurusan),
                                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796'],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: { legend: { position: 'bottom', labels: { color: '#fff' } } }
                        }
                    });

                    // Chart 2: Distribusi Predikat (Doughnut)
                    var ctx2 = document.getElementById('chartPredikat').getContext('2d');
                    new Chart(ctx2, {
                        type: 'doughnut',
                        data: {
                            labels: Object.keys(data.distribusi_predikat),
                            datasets: [{
                                data: Object.values(data.distribusi_predikat),
                                backgroundColor: ['#2ECC71', '#3498DB', '#F39C12', '#E74C3C', '#34495E'],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: { legend: { position: 'bottom', labels: { color: '#fff' } } }
                        }
                    });

                    // Chart 3: Rata-rata Nilai per Kelas (Bar)
                    var ctx3 = document.getElementById('chartNilaiKelas').getContext('2d');
                    new Chart(ctx3, {
                        type: 'bar',
                        data: {
                            labels: Object.keys(data.rata_nilai_per_kelas),
                            datasets: [{
                                label: 'Rata-rata Nilai',
                                data: Object.values(data.rata_nilai_per_kelas).map(v => parseFloat(v).toFixed(1)),
                                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: { beginAtZero: true, max: 100, ticks: { color: '#fff' } },
                                x: { ticks: { color: '#fff' } }
                            },
                            plugins: { legend: { labels: { color: '#fff' } } }
                        }
                    });

                    // Chart 4: Absensi Bulanan (Line)
                    var ctx4 = document.getElementById('chartAbsensiBulanan').getContext('2d');
                    var absensiData = data.absensi_bulanan;
                    var labels = absensiData.map(d => d.bulan);
                    new Chart(ctx4, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [
                                { label: 'Hadir', data: absensiData.map(d => d.hadir), borderColor: '#2ECC71', fill: false, tension: 0.1 },
                                { label: 'Izin', data: absensiData.map(d => d.izin), borderColor: '#F39C12', fill: false, tension: 0.1 },
                                { label: 'Sakit', data: absensiData.map(d => d.sakit), borderColor: '#3498DB', fill: false, tension: 0.1 },
                                { label: 'Alpa', data: absensiData.map(d => d.alpa), borderColor: '#E74C3C', fill: false, tension: 0.1 }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: { beginAtZero: true, ticks: { color: '#fff' } },
                                x: { ticks: { color: '#fff' } }
                            },
                            plugins: { legend: { position: 'bottom', labels: { color: '#fff' } } }
                        }
                    });
                });
        });
    </script>
    @endpush
@endsection
