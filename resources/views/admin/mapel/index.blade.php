@extends('layouts.app', ['pageSlug' => 'mapel'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h4 class="card-title">Data Mata Pelajaran</h4>
                    </div>
                    <div class="col-4 text-right">
                        <a href="{{ route('admin.mapel.create') }}" class="btn btn-sm btn-primary">+ Tambah Mapel</a>
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
                                <th>Nama Mapel</th>
                                <th>Kelompok</th>
                                <th>Jurusan</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mapels as $mapel)
                            <tr>
                                <td>{{ $mapels->firstItem() + $loop->index }}</td>
                                <td>{{ $mapel->kode_mapel }}</td>
                                <td>{{ $mapel->nama_mapel }}</td>
                                <td>
                                    @if($mapel->kelompok == 'Normatif')
                                        <span class="badge badge-primary">{{ $mapel->kelompok }}</span>
                                    @elseif($mapel->kelompok == 'Adaptif')
                                        <span class="badge badge-info">{{ $mapel->kelompok }}</span>
                                    @else
                                        <span class="badge badge-warning">{{ $mapel->kelompok }}</span>
                                    @endif
                                </td>
                                <td>{{ $mapel->jurusan->nama_jurusan ?? 'Umum' }}</td>
                                <td class="text-right">
                                    <a href="{{ route('admin.mapel.edit', $mapel) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.mapel.destroy', $mapel) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-name="{{ $mapel->nama_mapel }}">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada data mata pelajaran.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    {{ $mapels->links() }}
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
                text: "Data mata pelajaran '" + name + "' akan dihapus permanen!",
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
