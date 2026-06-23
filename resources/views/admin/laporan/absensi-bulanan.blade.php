@extends('layouts.app', ['pageSlug' => 'laporan'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h4 class="card-title">Laporan Absensi Bulanan</h4>
                    </div>
                    <div class="col-4 text-right">
                        <a href="{{ route('admin.laporan.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.laporan.absensi-bulanan') }}" method="GET" class="row mb-3">
                    <div class="col-md-2">
                        <select name="bulan" class="form-control form-control-sm">
                            @for($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>{{ Carbon\Carbon::create()->month($m)->format('F') }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="tahun" class="form-control form-control-sm">
                            @for($y = date('Y'); $y >= date('Y') - 2; $y--)
                                <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
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
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-sm btn-info">Filter</button>
                        <a href="{{ route('admin.laporan.absensi-bulanan') }}" class="btn btn-sm btn-secondary">Reset</a>
                    </div>
                </form>

                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="card card-stats">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="icon-big text-center icon-warning">
                                            <i class="tim-icons icon-check-2 text-success"></i>
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <div class="numbers">
                                            <p class="card-category">Hadir</p>
                                            <h3 class="card-title">{{ $rekapPerStatus['Hadir'] }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <hr>
                                <div class="stats">
                                    <i class="tim-icons icon-check-2"></i> {{ $persentase['Hadir'] }}%
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
                                            <i class="tim-icons icon-alert-circle-exc text-warning"></i>
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <div class="numbers">
                                            <p class="card-category">Izin</p>
                                            <h3 class="card-title">{{ $rekapPerStatus['Izin'] }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <hr>
                                <div class="stats">
                                    <i class="tim-icons icon-alert-circle-exc"></i> {{ $persentase['Izin'] }}%
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
                                            <i class="tim-icons icon-single-02 text-info"></i>
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <div class="numbers">
                                            <p class="card-category">Sakit</p>
                                            <h3 class="card-title">{{ $rekapPerStatus['Sakit'] }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <hr>
                                <div class="stats">
                                    <i class="tim-icons icon-single-02"></i> {{ $persentase['Sakit'] }}%
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
                                            <i class="tim-icons icon-simple-remove text-danger"></i>
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <div class="numbers">
                                            <p class="card-category">Alpa</p>
                                            <h3 class="card-title">{{ $rekapPerStatus['Alpa'] }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <hr>
                                <div class="stats">
                                    <i class="tim-icons icon-simple-remove"></i> {{ $persentase['Alpa'] }}%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Distribusi Status Kehadiran</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="chartAbsensi" height="250"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Rekap per Kelas</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead class="text-primary">
                                            <tr>
                                                <th>Kelas</th>
                                                <th>Hadir</th>
                                                <th>Izin</th>
                                                <th>Sakit</th>
                                                <th>Alpa</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($rekapPerKelas as $rk)
                                            <tr>
                                                <td>{{ $rk['nama_kelas'] }}</td>
                                                <td><span class="text-success">{{ $rk['hadir'] }}</span></td>
                                                <td><span class="text-warning">{{ $rk['izin'] }}</span></td>
                                                <td><span class="text-info">{{ $rk['sakit'] }}</span></td>
                                                <td><span class="text-danger">{{ $rk['alpa'] }}</span></td>
                                                <td><strong>{{ $rk['total'] }}</strong></td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6" class="text-center">Tidak ada data.</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('chartAbsensi').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Hadir', 'Izin', 'Sakit', 'Alpa'],
                datasets: [{
                    data: [
                        {{ $rekapPerStatus['Hadir'] }},
                        {{ $rekapPerStatus['Izin'] }},
                        {{ $rekapPerStatus['Sakit'] }},
                        {{ $rekapPerStatus['Alpa'] }}
                    ],
                    backgroundColor: [
                        '#2ECC71',
                        '#F39C12',
                        '#3498DB',
                        '#E74C3C'
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
