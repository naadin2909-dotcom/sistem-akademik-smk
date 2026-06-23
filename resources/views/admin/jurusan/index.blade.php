@extends('layouts.app', ['pageSlug' => 'jurusan'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h4 class="card-title">Data Jurusan</h4>
                    </div>
                    <div class="col-4 text-right">
                        <a href="{{ route('admin.jurusan.create') }}" class="btn btn-sm btn-primary">+ Tambah Jurusan</a>
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
                                <th>Kode</th>
                                <th>Nama Jurusan</th>
                                <th>Deskripsi</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jurusans as $jurusan)
                            <tr>
                                <td>{{ $jurusans->firstItem() + $loop->index }}</td>
                                <td>{{ $jurusan->kode_jurusan }}</td>
                                <td>{{ $jurusan->nama_jurusan }}</td>
                                <td>{{ Str::limit($jurusan->deskripsi, 50) }}</td>
                                <td class="text-right">
                                    <a href="{{ route('admin.jurusan.edit', $jurusan) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.jurusan.destroy', $jurusan) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-name="{{ $jurusan->nama_jurusan }}">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada data jurusan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    {{ $jurusans->links() }}
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
                text: "Data jurusan '" + name + "' akan dihapus permanen!",
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
