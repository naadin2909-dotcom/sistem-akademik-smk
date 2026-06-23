@extends('layouts.app', ['pageSlug' => 'guru'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h4 class="card-title">Data Guru</h4>
                    </div>
                    <div class="col-4 text-right">
                        <a href="{{ route('admin.guru.create') }}" class="btn btn-sm btn-primary">+ Tambah Guru</a>
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
                                <th>Foto</th>
                                <th>NIP</th>
                                <th>Nama Lengkap</th>
                                <th>Jenis Kelamin</th>
                                <th>Mata Pelajaran</th>
                                <th>No. Telp</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($gurus as $guru)
                            <tr>
                                <td>{{ $gurus->firstItem() + $loop->index }}</td>
                                <td>
                                    @if($guru->foto)
                                        <img src="{{ asset('storage/' . $guru->foto) }}" alt="Foto" class="rounded-circle" width="40" height="40">
                                    @else
                                        <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center" style="width:40px;height:40px;color:#fff;">
                                            {{ strtoupper(substr($guru->nama_lengkap, 0, 1)) }}
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $guru->nip }}</td>
                                <td>{{ $guru->nama_lengkap }}</td>
                                <td>{{ $guru->jenis_kelamin }}</td>
                                <td>{{ $guru->mata_pelajaran ?? '-' }}</td>
                                <td>{{ $guru->no_telp ?? '-' }}</td>
                                <td class="text-right">
                                    <a href="{{ route('admin.guru.edit', $guru) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.guru.destroy', $guru) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-name="{{ $guru->nama_lengkap }}">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">Belum ada data guru.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    {{ $gurus->links() }}
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
                text: "Data guru '" + name + "' akan dihapus permanen!",
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
