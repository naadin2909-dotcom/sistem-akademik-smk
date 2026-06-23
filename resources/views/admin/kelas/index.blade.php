@extends('layouts.app', ['pageSlug' => 'kelas'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h4 class="card-title">Data Kelas</h4>
                    </div>
                    <div class="col-4 text-right">
                        <a href="{{ route('admin.kelas.create') }}" class="btn btn-sm btn-primary">+ Tambah Kelas</a>
                    </div>
                </div>
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
                                <th>Nama Kelas</th>
                                <th>Tingkat</th>
                                <th>Jurusan</th>
                                <th>Tahun Ajaran</th>
                                <th>Wali Kelas</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kelas as $k)
                            <tr>
                                <td>{{ $kelas->firstItem() + $loop->index }}</td>
                                <td>{{ $k->nama_kelas }}</td>
                                <td>{{ $k->tingkat }}</td>
                                <td>{{ $k->jurusan->nama_jurusan ?? '-' }}</td>
                                <td>{{ $k->tahun_ajaran }}</td>
                                <td>{{ $k->waliKelas->nama_lengkap ?? '-' }}</td>
                                <td class="text-right">
                                    <a href="{{ route('admin.kelas.edit', $k) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.kelas.destroy', $k) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-name="{{ $k->nama_kelas }}">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada data kelas.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    {{ $kelas->links() }}
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
                text: "Data kelas '" + name + "' akan dihapus permanen!",
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
