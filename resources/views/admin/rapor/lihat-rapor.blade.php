@extends('layouts.app', ['pageSlug' => 'rapor'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h4 class="card-title">Rapor - {{ $siswa->nama_lengkap }}</h4>
                    </div>
                    <div class="col-4 text-right">
                        <a href="{{ route('admin.rapor.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table tablesorter">
                        <thead class="text-primary">
                            <tr>
                                <th>No</th>
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
                                    <a href="{{ route('admin.rapor.cetak', $rapor) }}" class="btn btn-sm btn-success" target="_blank">Cetak</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada data rapor.</td>
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
