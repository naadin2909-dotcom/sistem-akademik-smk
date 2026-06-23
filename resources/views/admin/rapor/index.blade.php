@extends('layouts.app', ['pageSlug' => 'rapor'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h4 class="card-title">Rapor Siswa</h4>
                    </div>
                    <div class="col-4 text-right">
                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#generateModal">+ Generate Rapor</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('admin.rapor.index') }}" method="GET" class="row mb-3">
                    <div class="col-md-3">
                        <select name="kelas_id" class="form-control form-control-sm">
                            <option value="">-- Semua Kelas --</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="semester" class="form-control form-control-sm">
                            <option value="">-- Semester --</option>
                            <option value="1" {{ request('semester') == '1' ? 'selected' : '' }}>1 (Ganjil)</option>
                            <option value="2" {{ request('semester') == '2' ? 'selected' : '' }}>2 (Genap)</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="tahun_ajaran" class="form-control form-control-sm" placeholder="Tahun Ajaran" value="{{ request('tahun_ajaran') }}">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-sm btn-info">Filter</button>
                        <a href="{{ route('admin.rapor.index') }}" class="btn btn-sm btn-secondary">Reset</a>
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
                                <td>{{ $rapor->siswa->nis ?? '-' }}</td>
                                <td>{{ $rapor->siswa->nama_lengkap ?? '-' }}</td>
                                <td>{{ $rapor->siswa->kelas->nama_kelas ?? '-' }}</td>
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
                                    @if($rapor->status == 'draft')
                                        <form action="{{ route('admin.rapor.update-status', $rapor) }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="status" value="final">
                                            <button type="submit" class="btn btn-sm btn-info">Final</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center">Belum ada data rapor.</td>
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

<!-- Generate Modal -->
<div class="modal fade" id="generateModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.rapor.generate') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Generate Rapor</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kelas</label>
                        <select name="kelas_id" class="form-control" required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Semester</label>
                        <select name="semester" class="form-control" required>
                            <option value="1">1 (Ganjil)</option>
                            <option value="2">2 (Genap)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tahun Ajaran</label>
                        <input type="text" name="tahun_ajaran" class="form-control" required placeholder="2025/2026">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Generate</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
