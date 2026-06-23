@extends('layouts.app', ['pageSlug' => 'nilai'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Nilai Saya</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('siswa.nilai.index') }}" method="GET" class="row mb-3">
                    <div class="col-md-3">
                        <select name="semester" class="form-control form-control-sm">
                            <option value="">-- Semua Semester --</option>
                            <option value="1" {{ request('semester') == '1' ? 'selected' : '' }}>1 (Ganjil)</option>
                            <option value="2" {{ request('semester') == '2' ? 'selected' : '' }}>2 (Genap)</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="tahun_ajaran" class="form-control form-control-sm" placeholder="Tahun Ajaran" value="{{ request('tahun_ajaran') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-sm btn-info">Filter</button>
                        <a href="{{ route('siswa.nilai.index') }}" class="btn btn-sm btn-secondary">Reset</a>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table tablesorter">
                        <thead class="text-primary">
                            <tr>
                                <th>No</th>
                                <th>Semester</th>
                                <th>Tahun Ajaran</th>
                                <th>Mata Pelajaran</th>
                                <th>Guru</th>
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
                                <td>{{ $nilai->semester }}</td>
                                <td>{{ $nilai->tahun_ajaran }}</td>
                                <td>{{ $nilai->mataPelajaran->nama_mapel ?? '-' }}</td>
                                <td>{{ $nilai->guru->nama_lengkap ?? '-' }}</td>
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
                                <td colspan="10" class="text-center">Belum ada data nilai.</td>
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
