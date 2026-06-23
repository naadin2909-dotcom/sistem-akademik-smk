@extends('layouts.app', ['pageSlug' => 'nilai'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h4 class="card-title">Data Nilai</h4>
                    </div>
                    <div class="col-4 text-right">
                        <a href="{{ route('guru.nilai.create') }}" class="btn btn-sm btn-primary">+ Input Nilai</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('guru.nilai.index') }}" method="GET" class="row mb-3">
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
                        <a href="{{ route('guru.nilai.index') }}" class="btn btn-sm btn-secondary">Reset</a>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table tablesorter">
                        <thead class="text-primary">
                            <tr>
                                <th>No</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Mata Pelajaran</th>
                                <th>Tugas</th>
                                <th>UTS</th>
                                <th>UAS</th>
                                <th>Akhir</th>
                                <th>Predikat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($nilais as $nilai)
                            <tr>
                                <td>{{ $nilais->firstItem() + $loop->index }}</td>
                                <td>{{ $nilai->siswa->nis ?? '-' }}</td>
                                <td>{{ $nilai->siswa->nama_lengkap ?? '-' }}</td>
                                <td>{{ $nilai->mataPelajaran->nama_mapel ?? '-' }}</td>
                                <td>{{ $nilai->tugas }}</td>
                                <td>{{ $nilai->uts }}</td>
                                <td>{{ $nilai->uas }}</td>
                                <td><strong>{{ $nilai->nilai_akhir }}</strong></td>
                                <td>
                                    @if($nilai->predikat == 'A')
                                        <span class="badge badge-success">{{ $nilai->predikat }}</span>
                                    @elseif($nilai->predikat == 'B')
                                        <span class="badge badge-info">{{ $nilai->predikat }}</span>
                                    @elseif($nilai->predikat == 'C')
                                        <span class="badge badge-warning">{{ $nilai->predikat }}</span>
                                    @else
                                        <span class="badge badge-danger">{{ $nilai->predikat }}</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center">Belum ada data nilai.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    {{ $nilais->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
