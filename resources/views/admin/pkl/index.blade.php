@extends('layouts.app', ['pageSlug' => 'pkl'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h4 class="card-title">Data PKL / Prakerin</h4>
                    </div>
                    <div class="col-4 text-right">
                        <a href="{{ route('admin.pkl.create') }}" class="btn btn-sm btn-primary">+ Tambah PKL</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('admin.pkl.index') }}" method="GET" class="row mb-3">
                    <div class="col-md-3">
                        <select name="kelas_id" class="form-control form-control-sm">
                            <option value="">-- Semua Kelas --</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-control form-control-sm">
                            <option value="">-- Semua Status --</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-sm btn-info">Filter</button>
                        <a href="{{ route('admin.pkl.index') }}" class="btn btn-sm btn-secondary">Reset</a>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table tablesorter">
                        <thead class="text-primary">
                            <tr>
                                <th>No</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Perusahaan</th>
                                <th>Pembimbing</th>
                                <th>Periode</th>
                                <th>Status</th>
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
                                <td class="text-right">
                                    <a href="{{ route('admin.pkl.cetak-surat', $pkl) }}" class="btn btn-sm btn-success" target="_blank">Surat</a>
                                    <a href="{{ route('admin.pkl.edit', $pkl) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.pkl.destroy', $pkl) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-name="{{ $pkl->siswa->nama_lengkap ?? 'PKL' }}">Hapus</button>
                                    </form>
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

@push('js')
<script>
    document.querySelectorAll('.btn-delete').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var name = this.getAttribute('data-name');
            var form = this.closest('form');
            Swal.fire({
                title: 'Yakin hapus?',
                text: "Data PKL '" + name + "' akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74a3b',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
