@extends('layouts.app', ['pageSlug' => 'pkl'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Data PKL Siswa</h4>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table tablesorter">
                        <thead class="text-primary">
                            <tr>
                                <th>No</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Perusahaan</th>
                                <th>Periode</th>
                                <th>Status</th>
                                <th>Nilai</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pkls as $pkl)
                            <tr>
                                <td>{{ $pkls->firstItem() + $loop->index }}</td>
                                <td>{{ $pkl->siswa->nis ?? '-' }}</td>
                                <td>{{ $pkl->siswa->nama_lengkap ?? '-' }}</td>
                                <td>{{ $pkl->siswa->kelas->nama_kelas ?? '-' }}</td>
                                <td>{{ $pkl->perusahaan }}</td>
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
                                <td class="text-right">
                                    @if(!$pkl->nilaiPkl)
                                        <a href="{{ route('guru.pkl.input-nilai', $pkl) }}" class="btn btn-sm btn-primary">Input Nilai</a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center">Belum ada data PKL.</td>
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
