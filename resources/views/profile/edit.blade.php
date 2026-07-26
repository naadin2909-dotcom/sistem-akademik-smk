@extends('layouts.app', ['page' => __('Profile'), 'pageSlug' => 'profile'])

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ __('Identitas') }}</h5>
                </div>
                <div class="card-body">
                    @include('alerts.success')

                    @if(auth()->user()->hasRole('siswa') && $siswa)
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td style="width: 200px; background-color: #f8f9fa;">{{ __('NIS') }}</td>
                                    <td><strong>{{ $siswa->nis ?? '-' }}</strong></td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f8f9fa;">{{ __('NISN') }}</td>
                                    <td><strong>{{ $siswa->nisn ?? '-' }}</strong></td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f8f9fa;">{{ __('Nama Lengkap') }}</td>
                                    <td><strong>{{ $siswa->nama_lengkap ?? '-' }}</strong></td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f8f9fa;">{{ __('Tempat, Tanggal Lahir') }}</td>
                                    <td>
                                        <strong>
                                            {{ $siswa->tempat_lahir ?? '-' }},
                                            {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d M Y') : '-' }}
                                        </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f8f9fa;">{{ __('Jenis Kelamin') }}</td>
                                    <td><strong>{{ $siswa->jenis_kelamin ?? '-' }}</strong></td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f8f9fa;">{{ __('Agama') }}</td>
                                    <td><strong>{{ $siswa->agama ?? '-' }}</strong></td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f8f9fa;">{{ __('Kelas') }}</td>
                                    <td>
                                        <strong>
                                            {{ $siswa->kelas->nama_kelas ?? '-' }}
                                            @if($siswa->kelas && $siswa->kelas->jurusan)
                                                - {{ $siswa->kelas->jurusan->nama_jurusan }}
                                            @endif
                                        </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f8f9fa;">{{ __('Angkatan') }}</td>
                                    <td><strong>{{ $siswa->angkatan ?? '-' }}</strong></td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f8f9fa;">{{ __('Alamat') }}</td>
                                    <td><strong>{{ $siswa->alamat ?? '-' }}</strong></td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f8f9fa;">{{ __('No. Telepon') }}</td>
                                    <td><strong>{{ $siswa->no_telp ?? '-' }}</strong></td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f8f9fa;">{{ __('Email') }}</td>
                                    <td><strong>{{ $user->email ?? '-' }}</strong></td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f8f9fa;">{{ __('Nama Wali') }}</td>
                                    <td><strong>{{ $siswa->nama_ortu ?? '-' }}</strong></td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f8f9fa;">{{ __('No. Telp Wali') }}</td>
                                    <td><strong>{{ $siswa->no_telp_ortu ?? '-' }}</strong></td>
                                </tr>
                            </tbody>
                        </table>

                    @elseif(auth()->user()->hasRole('guru') && $guru)
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td style="width: 200px; background-color: #f8f9fa;">{{ __('NIP') }}</td>
                                    <td><strong>{{ $guru->nip ?? '-' }}</strong></td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f8f9fa;">{{ __('Nama Lengkap') }}</td>
                                    <td><strong>{{ $guru->nama_lengkap ?? '-' }}</strong></td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f8f9fa;">{{ __('Tempat, Tanggal Lahir') }}</td>
                                    <td>
                                        <strong>
                                            {{ $guru->tempat_lahir ?? '-' }},
                                            {{ $guru->tanggal_lahir ? \Carbon\Carbon::parse($guru->tanggal_lahir)->translatedFormat('d M Y') : '-' }}
                                        </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f8f9fa;">{{ __('Jenis Kelamin') }}</td>
                                    <td><strong>{{ $guru->jenis_kelamin ?? '-' }}</strong></td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f8f9fa;">{{ __('Agama') }}</td>
                                    <td><strong>{{ $guru->agama ?? '-' }}</strong></td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f8f9fa;">{{ __('Mata Pelajaran') }}</td>
                                    <td><strong>{{ $guru->mata_pelajaran ?? '-' }}</strong></td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f8f9fa;">{{ __('Riwayat Pendidikan') }}</td>
                                    <td><strong>{!! nl2br(e($guru->riwayat_pendidikan ?? '-')) !!}</strong></td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f8f9fa;">{{ __('Alamat') }}</td>
                                    <td><strong>{{ $guru->alamat ?? '-' }}</strong></td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f8f9fa;">{{ __('No. Telepon') }}</td>
                                    <td><strong>{{ $guru->no_telp ?? '-' }}</strong></td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f8f9fa;">{{ __('Email') }}</td>
                                    <td><strong>{{ $user->email ?? '-' }}</strong></td>
                                </tr>
                            </tbody>
                        </table>

                    @else
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td style="width: 200px; background-color: #f8f9fa;">{{ __('Nama') }}</td>
                                    <td><strong>{{ $user->name ?? '-' }}</strong></td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f8f9fa;">{{ __('Email') }}</td>
                                    <td><strong>{{ $user->email ?? '-' }}</strong></td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f8f9fa;">{{ __('Role') }}</td>
                                    <td><strong>{{ ucfirst($user->role) ?? '-' }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ __('Ubah Password') }}</h5>
                </div>
                <form method="post" action="{{ route('profile.password') }}" autocomplete="off">
                    <div class="card-body">
                        @csrf
                        @method('put')

                        @include('alerts.success', ['key' => 'password_status'])

                        <div class="form-group{{ $errors->has('old_password') ? ' has-danger' : '' }}">
                            <label>{{ __('Password Saat Ini') }}</label>
                            <input type="password" name="old_password" class="form-control{{ $errors->has('old_password') ? ' is-invalid' : '' }}" placeholder="{{ __('Password Saat Ini') }}" value="" required>
                            @include('alerts.feedback', ['field' => 'old_password'])
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                            <label>{{ __('Password Baru') }}</label>
                            <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Password Baru') }}" value="" required>
                            @include('alerts.feedback', ['field' => 'password'])
                        </div>

                        <div class="form-group">
                            <label>{{ __('Konfirmasi Password Baru') }}</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="{{ __('Konfirmasi Password Baru') }}" value="" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-fill btn-primary">{{ __('Ubah Password') }}</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-user">
                <div class="card-body">
                    <p class="card-text">
                        <div class="author">
                            <div class="block block-one"></div>
                            <div class="block block-two"></div>
                            <div class="block block-three"></div>
                            <div class="block block-four"></div>
                            <a href="#">
                                @if(auth()->user()->hasRole('siswa') && $siswa && $siswa->foto)
                                    <img class="avatar" src="{{ asset('storage/' . $siswa->foto) }}" alt="{{ $siswa->nama_lengkap }}">
                                @elseif(auth()->user()->hasRole('guru') && $guru && $guru->foto)
                                    <img class="avatar" src="{{ asset('storage/' . $guru->foto) }}" alt="{{ $guru->nama_lengkap }}">
                                @else
                                    <img class="avatar" src="{{ asset('black') }}/img/anime3.png" alt="{{ $user->name }}">
                                @endif
                                <h5 class="title">{{ $user->name }}</h5>
                            </a>
                            <p class="description">
                                @if(auth()->user()->hasRole('siswa') && $siswa)
                                    {{ $siswa->nis ?? 'Siswa' }}
                                    @if($siswa->kelas)
                                        - {{ $siswa->kelas->nama_kelas }}
                                    @endif
                                @elseif(auth()->user()->hasRole('guru') && $guru)
                                    {{ $guru->nip ?? 'Guru' }}
                                    @if($guru->mata_pelajaran)
                                        <br>{{ $guru->mata_pelajaran }}
                                    @endif
                                @else
                                    {{ __('Administrator') }}
                                @endif
                            </p>
                        </div>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
