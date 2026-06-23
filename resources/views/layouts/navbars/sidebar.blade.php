<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="#" class="simple-text logo-mini">{{ __('SMK') }}</a>
            <a href="#" class="simple-text logo-normal">{{ __('Sistem Akademik') }}</a>
        </div>
        <ul class="nav">
            @if(auth()->user()->hasRole('admin'))
                {{-- MENU ADMIN --}}
                <li @if(($pageSlug ?? '') == 'dashboard') class="active" @endif>
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="tim-icons icon-chart-pie-36"></i>
                        <p>{{ __('Dashboard') }}</p>
                    </a>
                </li>
                <li @if(($pageSlug ?? '') == 'jurusan') class="active" @endif>
                    <a href="{{ route('admin.jurusan.index') }}">
                        <i class="tim-icons icon-briefcase-24"></i>
                        <p>{{ __('Data Jurusan') }}</p>
                    </a>
                </li>
                <li @if(($pageSlug ?? '') == 'kelas') class="active" @endif>
                    <a href="{{ route('admin.kelas.index') }}">
                        <i class="tim-icons icon-bullet-list-67"></i>
                        <p>{{ __('Data Kelas') }}</p>
                    </a>
                </li>
                <li @if(($pageSlug ?? '') == 'guru') class="active" @endif>
                    <a href="{{ route('admin.guru.index') }}">
                        <i class="tim-icons icon-badge"></i>
                        <p>{{ __('Data Guru') }}</p>
                    </a>
                </li>
                <li @if(($pageSlug ?? '') == 'siswa') class="active" @endif>
                    <a href="{{ route('admin.siswa.index') }}">
                        <i class="tim-icons icon-single-02"></i>
                        <p>{{ __('Data Siswa') }}</p>
                    </a>
                </li>
                <li @if(($pageSlug ?? '') == 'mapel') class="active" @endif>
                    <a href="{{ route('admin.mapel.index') }}">
                        <i class="tim-icons icon-book-book-open"></i>
                        <p>{{ __('Mata Pelajaran') }}</p>
                    </a>
                </li>
                <li @if(($pageSlug ?? '') == 'jadwal') class="active" @endif>
                    <a href="{{ route('admin.jadwal.index') }}">
                        <i class="tim-icons icon-calendar-60"></i>
                        <p>{{ __('Jadwal Pelajaran') }}</p>
                    </a>
                </li>
                <li @if(($pageSlug ?? '') == 'absensi') class="active" @endif>
                    <a href="{{ route('admin.absensi.index') }}">
                        <i class="tim-icons icon-check-2"></i>
                        <p>{{ __('Absensi') }}</p>
                    </a>
                </li>
                <li @if(($pageSlug ?? '') == 'nilai') class="active" @endif>
                    <a href="{{ route('admin.rapor.index') }}">
                        <i class="tim-icons icon-paper"></i>
                        <p>{{ __('Rapor') }}</p>
                    </a>
                </li>
                <li @if(($pageSlug ?? '') == 'rapor') class="active" @endif>
                    <a href="{{ route('admin.rapor.index') }}">
                        <i class="tim-icons icon-book-book-open"></i>
                        <p>{{ __('Rapor Siswa') }}</p>
                    </a>
                </li>
                <li @if(($pageSlug ?? '') == 'pkl') class="active" @endif>
                    <a href="{{ route('admin.pkl.index') }}">
                        <i class="tim-icons icon-building"></i>
                        <p>{{ __('PKL / Prakerin') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a data-toggle="collapse" href="#submenu-laporan" aria-expanded="{{ ($pageSlug ?? '') == 'laporan' ? 'true' : 'false' }}">
                        <i class="tim-icons icon-notes"></i>
                        <span class="nav-link-text">{{ __('Laporan') }}</span>
                        <b class="caret mt-1"></b>
                    </a>
                    <div class="collapse {{ ($pageSlug ?? '') == 'laporan' ? 'show' : '' }}" id="submenu-laporan">
                        <ul class="nav pl-4">
                            <li>
                                <a href="{{ route('admin.laporan.index') }}">
                                    <i class="tim-icons icon-paper"></i>
                                    <p>{{ __('Dashboard Laporan') }}</p>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.laporan.siswa-per-kelas') }}">
                                    <i class="tim-icons icon-single-02"></i>
                                    <p>{{ __('Siswa per Kelas') }}</p>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.laporan.absensi-bulanan') }}">
                                    <i class="tim-icons icon-check-2"></i>
                                    <p>{{ __('Absensi Bulanan') }}</p>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.laporan.nilai-per-kelas') }}">
                                    <i class="tim-icons icon-book-book-open"></i>
                                    <p>{{ __('Nilai per Kelas') }}</p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-toggle="collapse" href="#submenu-admin" aria-expanded="true">
                        <i class="tim-icons icon-settings-gear-63"></i>
                        <span class="nav-link-text">{{ __('Pengaturan') }}</span>
                        <b class="caret mt-1"></b>
                    </a>
                    <div class="collapse show" id="submenu-admin">
                        <ul class="nav pl-4">
                            <li>
                                <a href="{{ route('admin.user.index') }}">
                                    <i class="tim-icons icon-single-02"></i>
                                    <p>{{ __('User Management') }}</p>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.profile.edit') }}">
                                    <i class="tim-icons icon-settings"></i>
                                    <p>{{ __('Profil') }}</p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

            @elseif(auth()->user()->hasRole('guru'))
                {{-- MENU GURU --}}
                <li @if(($pageSlug ?? '') == 'dashboard') class="active" @endif>
                    <a href="{{ route('guru.dashboard') }}">
                        <i class="tim-icons icon-chart-pie-36"></i>
                        <p>{{ __('Dashboard') }}</p>
                    </a>
                </li>
                <li @if(($pageSlug ?? '') == 'jadwal') class="active" @endif>
                    <a href="#">
                        <i class="tim-icons icon-calendar-60"></i>
                        <p>{{ __('Jadwal Mengajar') }}</p>
                    </a>
                </li>
                <li @if(($pageSlug ?? '') == 'absensi') class="active" @endif>
                    <a href="{{ route('guru.absensi.index') }}">
                        <i class="tim-icons icon-check-2"></i>
                        <p>{{ __('Input Absensi') }}</p>
                    </a>
                </li>
                <li @if(($pageSlug ?? '') == 'nilai') class="active" @endif>
                    <a href="{{ route('guru.nilai.index') }}">
                        <i class="tim-icons icon-paper"></i>
                        <p>{{ __('Input Nilai') }}</p>
                    </a>
                </li>
                <li @if(($pageSlug ?? '') == 'pkl') class="active" @endif>
                    <a href="{{ route('guru.pkl.index') }}">
                        <i class="tim-icons icon-building"></i>
                        <p>{{ __('PKL / Prakerin') }}</p>
                    </a>
                </li>
                <li>
                    <a href="{{ route('guru.profile.edit') }}">
                        <i class="tim-icons icon-settings"></i>
                        <p>{{ __('Profil') }}</p>
                    </a>
                </li>

            @elseif(auth()->user()->hasRole('siswa'))
                {{-- MENU SISWA --}}
                <li @if(($pageSlug ?? '') == 'dashboard') class="active" @endif>
                    <a href="{{ route('siswa.dashboard') }}">
                        <i class="tim-icons icon-chart-pie-36"></i>
                        <p>{{ __('Dashboard') }}</p>
                    </a>
                </li>
                <li @if(($pageSlug ?? '') == 'jadwal') class="active" @endif>
                    <a href="#">
                        <i class="tim-icons icon-calendar-60"></i>
                        <p>{{ __('Jadwal Pelajaran') }}</p>
                    </a>
                </li>
                <li @if(($pageSlug ?? '') == 'absensi') class="active" @endif>
                    <a href="{{ route('siswa.absensi.index') }}">
                        <i class="tim-icons icon-check-2"></i>
                        <p>{{ __('Rekap Absensi') }}</p>
                    </a>
                </li>
                <li @if(($pageSlug ?? '') == 'nilai') class="active" @endif>
                    <a href="{{ route('siswa.nilai.index') }}">
                        <i class="tim-icons icon-paper"></i>
                        <p>{{ __('Lihat Nilai') }}</p>
                    </a>
                </li>
                <li @if(($pageSlug ?? '') == 'rapor') class="active" @endif>
                    <a href="{{ route('siswa.rapor.index') }}">
                        <i class="tim-icons icon-book-book-open"></i>
                        <p>{{ __('Rapor') }}</p>
                    </a>
                </li>
                <li @if(($pageSlug ?? '') == 'pkl') class="active" @endif>
                    <a href="{{ route('siswa.pkl.index') }}">
                        <i class="tim-icons icon-building"></i>
                        <p>{{ __('PKL / Prakerin') }}</p>
                    </a>
                </li>
                <li>
                    <a href="{{ route('siswa.profile.edit') }}">
                        <i class="tim-icons icon-settings"></i>
                        <p>{{ __('Profil') }}</p>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</div>
