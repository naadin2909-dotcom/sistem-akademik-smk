@extends('layouts.app', ['pageSlug' => 'rapor'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Rapor Saya</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('siswa.rapor.index') }}" method="GET" class="row mb-3">
                    <div class="col-md-3">
                        <select name="semester" class="form-control form-control-sm">
                            <option value="">-- Semua Semester --</option>
                            <option value="1" {{ request('semester') == '1' ? 'selected' : '' }}>1 (Ganjil)</option>
                            <option value="2" {{ request('semester') == '2' ? 'selected' : '' }}>2 (Genap)</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="tahun_ajaran" class="form-control form-control-sm" placeholder="Tahun Ajaran" value="{{ request('tahun_ajaran') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-sm btn-info">Filter</button>
                        <a href="{{ route('siswa.rapor.index') }}" class="btn btn-sm btn-secondary">Reset</a>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table tablesorter">
                        <thead class="text-primary">
                            <tr>
                                <th>No</th>
                                <th>Kelas</th>
                                <th>Semester</th>
                                <th>Tahun Ajaran</th>
                                <th>Rata-rata</th>
                                <th>Predikat</th>
                                <th>Status</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rapors as $rapor)
                            <tr>
                                <td>{{ $rapors->firstItem() + $loop->index }}</td>
                                <td>{{ $rapor->kelas->nama_kelas ?? '-' }}</td>
                                <td>{{ $rapor->semester }}</td>
                                <td>{{ $rapor->tahun_ajaran }}</td>
                                <td><strong>{{ $rapor->rata_rata_nilai }}</strong></td>
                                <td>
                                    @if($rapor->predikat_umum == 'A')
                                        <span class="badge badge-success">{{ $rapor->predikat_umum }}</span>
                                    @elseif($rapor->predikat_umum == 'B')
                                        <span class="badge badge-info">{{ $rapor->predikat_umum }}</span>
                                    @elseif($rapor->predikat_umum == 'C')
                                        <span class="badge badge-warning">{{ $rapor->predikat_umum }}</span>
                                    @else
                                        <span class="badge badge-danger">{{ $rapor->predikat_umum }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($rapor->status == 'final')
                                        <span class="badge badge-success">Final</span>
                                    @else
                                        <span class="badge badge-warning">Draft</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    @if($rapor->status == 'final')
                                        <a href="{{ route('siswa.rapor.cetak', $rapor) }}" class="btn btn-sm btn-success" target="_blank">Cetak</a>
                                    @else
                                        <span class="text-muted">Belum final</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">Belum ada data rapor.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    {{ $rapors->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
