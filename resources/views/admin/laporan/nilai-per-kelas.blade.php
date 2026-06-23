@extends('layouts.app', ['pageSlug' => 'laporan'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h4 class="card-title">Laporan Nilai per Kelas</h4>
                    </div>
                    <div class="col-4 text-right">
                        <a href="{{ route('admin.laporan.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.laporan.nilai-per-kelas') }}" method="GET" class="row mb-3">
                    <div class="col-md-2">
                        <select name="semester" class="form-control form-control-sm">
                            <option value="1" {{ $semester == '1' ? 'selected' : '' }}>Semester 1</option>
                            <option value="2" {{ $semester == '2' ? 'selected' : '' }}>Semester 2</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="tahun_ajaran" class="form-control form-control-sm">
                            @for($y = date('Y'); $y >= date('Y') - 2; $y--)
                                <option value="{{ $y }}/{{ $y+1 }}" {{ $tahunAjaran == "$y/".($y+1) ? 'selected' : '' }}>{{ $y }}/{{ $y+1 }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="kelas_id" class="form-control form-control-sm">
                            <option value="">-- Semua Kelas --</option>
                            @foreach($kelasList as $k)
                                <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-sm btn-info">Filter</button>
                        <a href="{{ route('admin.laporan.nilai-per-kelas') }}" class="btn btn-sm btn-secondary">Reset</a>
                    </div>
                </form>

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
                                <h5 class="card-title">Distribusi Predikat</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="chartPredikat" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Rekap Nilai per Kelas</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table tablesorter">
                                        <thead class="text-primary">
                                            <tr>
                                                <th>No</th>
                                                <th>Kelas</th>
                                                <th>Jumlah Siswa</th>
                                                <th>Rata-rata</th>
                                                <th>Tertinggi</th>
                                                <th>Terendah</th>
                                                <th>A</th>
                                                <th>B</th>
                                                <th>C</th>
                                                <th>D</th>
                                                <th>E</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($rekapPerKelas as $rk)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td><strong>{{ $rk['nama_kelas'] }}</strong></td>
                                                <td>{{ $rk['jumlah_siswa'] }}</td>
                                                <td>
                                                    <span class="badge badge-{{ $rk['rata_rata'] >= 80 ? 'success' : ($rk['rata_rata'] >= 60 ? 'warning' : 'danger') }}">
                                                        {{ number_format($rk['rata_rata'], 1) }}
                                                    </span>
                                                </td>
                                                <td><span class="text-success">{{ number_format($rk['nilai_tertinggi'], 1) }}</span></td>
                                                <td><span class="text-danger">{{ number_format($rk['nilai_terendah'], 1) }}</span></td>
                                                <td><span class="badge badge-success">{{ $rk['predikat_A'] }}</span></td>
                                                <td><span class="badge badge-info">{{ $rk['predikat_B'] }}</span></td>
                                                <td><span class="badge badge-warning">{{ $rk['predikat_C'] }}</span></td>
                                                <td><span class="badge badge-danger">{{ $rk['predikat_D'] }}</span></td>
                                                <td><span class="badge badge-dark">{{ $rk['predikat_E'] }}</span></td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="11" class="text-center">Tidak ada data nilai.</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($rekapPerMapel->count() > 0)
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Rekap Nilai per Mata Pelajaran</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table tablesorter">
                                        <thead class="text-primary">
                                            <tr>
                                                <th>No</th>
                                                <th>Kode Mapel</th>
                                                <th>Mata Pelajaran</th>
                                                <th>Jumlah Data</th>
                                                <th>Rata-rata</th>
                                                <th>Tertinggi</th>
                                                <th>Terendah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($rekapPerMapel as $rk)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $rk['kode_mapel'] }}</td>
                                                <td>{{ $rk['nama_mapel'] }}</td>
                                                <td>{{ $rk['jumlah'] }}</td>
                                                <td>
                                                    <span class="badge badge-{{ $rk['rata_rata'] >= 80 ? 'success' : ($rk['rata_rata'] >= 60 ? 'warning' : 'danger') }}">
                                                        {{ number_format($rk['rata_rata'], 1) }}
                                                    </span>
                                                </td>
                                                <td><span class="text-success">{{ number_format($rk['nilai_tertinggi'], 1) }}</span></td>
                                                <td><span class="text-danger">{{ number_format($rk['nilai_terendah'], 1) }}</span></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctxKelas = document.getElementById('chartNilaiKelas').getContext('2d');
        new Chart(ctxKelas, {
            type: 'bar',
            data: {
                labels: {!! json_encode($rekapPerKelas->pluck('nama_kelas')) !!},
                datasets: [{
                    label: 'Rata-rata Nilai',
                    data: {!! json_encode($rekapPerKelas->pluck('rata_rata')->map(fn($v) => round($v, 1))) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }, {
                    label: 'Tertinggi',
                    data: {!! json_encode($rekapPerKelas->pluck('nilai_tertinggi')) !!},
                    backgroundColor: 'rgba(46, 204, 113, 0.6)',
                    borderColor: 'rgba(46, 204, 113, 1)',
                    borderWidth: 1
                }, {
                    label: 'Terendah',
                    data: {!! json_encode($rekapPerKelas->pluck('nilai_terendah')) !!},
                    backgroundColor: 'rgba(231, 76, 60, 0.6)',
                    borderColor: 'rgba(231, 76, 60, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            color: '#fff'
                        }
                    },
                    x: {
                        ticks: {
                            color: '#fff'
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: '#fff'
                        }
                    }
                }
            }
        });

        var ctxPredikat = document.getElementById('chartPredikat').getContext('2d');
        new Chart(ctxPredikat, {
            type: 'doughnut',
            data: {
                labels: ['A', 'B', 'C', 'D', 'E'],
                datasets: [{
                    data: [
                        {{ $distribusiPredikat['A'] ?? 0 }},
                        {{ $distribusiPredikat['B'] ?? 0 }},
                        {{ $distribusiPredikat['C'] ?? 0 }},
                        {{ $distribusiPredikat['D'] ?? 0 }},
                        {{ $distribusiPredikat['E'] ?? 0 }}
                    ],
                    backgroundColor: [
                        '#2ECC71',
                        '#3498DB',
                        '#F39C12',
                        '#E74C3C',
                        '#34495E'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#fff'
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection
