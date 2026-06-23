@extends('layouts.app', ['pageSlug' => 'pkl'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Data PKL Saya</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table tablesorter">
                        <thead class="text-primary">
                            <tr>
                                <th>No</th>
                                <th>Perusahaan</th>
                                <th>Alamat</th>
                                <th>Pembimbing</th>
                                <th>Periode</th>
                                <th>Status</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pkls as $pkl)
                            <tr>
                                <td>{{ $pkls->firstItem() + $loop->index }}</td>
                                <td>{{ $pkl->perusahaan }}</td>
                                <td>{{ Str::limit($pkl->alamat_perusahaan, 30) }}</td>
                                <td>{{ $pkl->guru->nama_lengkap ?? '-' }}</td>
                                <td>{{ $pkl->tanggal_mulai->format('d/m/Y') }} - {{ $pkl->tanggal_selesai->format('d/m/Y') }}</td>
                                <td>
                                    @if($pkl->status == 'active')
                                        <span class="badge badge-success">Aktif</span>
                                    @elseif($pkl->status == 'completed')
                                        <span class="badge badge-info">Selesai</span>
                                    @else
                                        <span class="badge badge-warning">Draft</span>
                                    @endif
                                </td>
                                <td>
                                    @if($pkl->nilaiPkl)
                                        <strong>{{ $pkl->nilaiPkl->nilai }}</strong>
                                        <span class="badge badge-info">{{ $pkl->nilaiPkl->predikat }}</span>
                                    @else
                                        <span class="text-muted">Belum dinilai</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada data PKL.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    {{ $pkls->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
