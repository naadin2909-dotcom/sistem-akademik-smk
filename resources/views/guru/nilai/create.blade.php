@extends('layouts.app', ['pageSlug' => 'nilai'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Input Nilai</h4>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('guru.nilai.create') }}" method="GET" class="row mb-4">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Kelas</label>
                            <select name="kelas_id" class="form-control" required>
                                <option value="">-- Pilih --</option>
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id }}" {{ $kelasId == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Mata Pelajaran</label>
                            <select name="mata_pelajaran_id" class="form-control" required>
                                <option value="">-- Pilih --</option>
                                @foreach($mapels as $m)
                                    <option value="{{ $m->id }}" {{ $mapelId == $m->id ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Semester</label>
                            <select name="semester" class="form-control" required>
                                <option value="1" {{ $semester == '1' ? 'selected' : '' }}>1 (Ganjil)</option>
                                <option value="2" {{ $semester == '2' ? 'selected' : '' }}>2 (Genap)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tahun Ajaran</label>
                            <input type="text" name="tahun_ajaran" class="form-control" value="{{ $tahunAjaran }}" required placeholder="2025/2026">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-info btn-block">Tampilkan</button>
                        </div>
                    </div>
                </form>

                @if($siswas->count() > 0)
                    <form action="{{ route('guru.nilai.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="kelas_id" value="{{ $kelasId }}">
                        <input type="hidden" name="mata_pelajaran_id" value="{{ $mapelId }}">
                        <input type="hidden" name="semester" value="{{ $semester }}">
                        <input type="hidden" name="tahun_ajaran" value="{{ $tahunAjaran }}">

                        <div class="table-responsive">
                            <table class="table tablesorter">
                                <thead class="text-primary">
                                    <tr>
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama Siswa</th>
                                        <th>Tugas (30%)</th>
                                        <th>UTS (30%)</th>
                                        <th>UAS (40%)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($siswas as $siswa)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $siswa->nis }}</td>
                                        <td>{{ $siswa->nama_lengkap }}</td>
                                        <td>
                                            <input type="number" name="tugas[{{ $siswa->id }}]" class="form-control form-control-sm"
                                                   value="{{ $siswa->nilai_tugas }}" min="0" max="100" required>
                                        </td>
                                        <td>
                                            <input type="number" name="uts[{{ $siswa->id }}]" class="form-control form-control-sm"
                                                   value="{{ $siswa->nilai_uts }}" min="0" max="100" required>
                                        </td>
                                        <td>
                                            <input type="number" name="uas[{{ $siswa->id }}]" class="form-control form-control-sm"
                                                   value="{{ $siswa->nilai_uas }}" min="0" max="100" required>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <a href="{{ route('guru.nilai.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Nilai</button>
                    </form>
                @elseif($kelasId && $mapelId)
                    <div class="alert alert-info">Tidak ada siswa di kelas ini.</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
