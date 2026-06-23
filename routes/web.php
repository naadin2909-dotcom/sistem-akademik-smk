<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\JurusanController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\MataPelajaranController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\AbsensiController as AdminAbsensiController;
use App\Http\Controllers\Guru\AbsensiController as GuruAbsensiController;
use App\Http\Controllers\Siswa\AbsensiController as SiswaAbsensiController;
use App\Http\Controllers\Guru\NilaiController as GuruNilaiController;
use App\Http\Controllers\Admin\RaporController;
use App\Http\Controllers\Siswa\NilaiController as SiswaNilaiController;
use App\Http\Controllers\Siswa\RaporController as SiswaRaporController;
use App\Http\Controllers\Guru\PklController as GuruPklController;
use App\Http\Controllers\Admin\PklController;
use App\Http\Controllers\Siswa\PklController as SiswaPklController;
use App\Http\Controllers\Admin\LaporanController;

// Home
Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->hasRole('admin')) return redirect('/admin/dashboard');
        if ($user->hasRole('guru')) return redirect('/guru/dashboard');
        if ($user->hasRole('siswa')) return redirect('/siswa/dashboard');
    }
    return redirect('/login');
});

// Login Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Forgot Password Routes
Route::get('/forgot-password', function () {
    return view('auth.passwords.email');
})->name('password.request')->middleware('guest');

Route::post('/forgot-password', function (Illuminate\Http\Request $request) {
    $request->validate([
        'email' => 'required|email',
    ]);

    $status = \Illuminate\Support\Facades\Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? back()->with('status', __($status))
        : back()->withErrors(['email' => __($status)]);
})->name('password.email')->middleware('guest');

// ========================
// ADMIN ROUTES
// ========================
Route::group([
    'middleware' => ['auth', 'role:admin'],
    'prefix' => 'admin',
    'as' => 'admin.',
], function () {
    // Dashboard
    Route::get('/dashboard', function () {
        $stats = [
            'siswa' => \App\Models\Siswa::count(),
            'guru' => \App\Models\Guru::count(),
            'kelas' => \App\Models\Kelas::count(),
            'jurusan' => \App\Models\Jurusan::count(),
        ];
        return view('admin.dashboard', compact('stats'));
    })->name('dashboard');

    // Master Data
    Route::resource('jurusan', JurusanController::class)->except(['show']);
    Route::resource('kelas', KelasController::class)->except(['show']);
    Route::resource('guru', GuruController::class)->except(['show']);
    Route::resource('siswa', SiswaController::class)->except(['show']);

    // Mata Pelajaran & Jadwal
    Route::resource('mapel', MataPelajaranController::class)->except(['show']);
    Route::resource('jadwal', JadwalController::class)->except(['show']);

    // Absensi
    Route::get('absensi/rekap-siswa/{siswa}', [AdminAbsensiController::class, 'rekapSiswa'])->name('absensi.rekap-siswa');
    Route::get('absensi/export', [AdminAbsensiController::class, 'exportExcel'])->name('absensi.export');
    Route::get('absensi/create', [AdminAbsensiController::class, 'create'])->name('absensi.create');
    Route::post('absensi', [AdminAbsensiController::class, 'store'])->name('absensi.store');
    Route::get('absensi', [AdminAbsensiController::class, 'index'])->name('absensi.index');

    // Rapor
    Route::post('rapor/generate', [RaporController::class, 'generate'])->name('rapor.generate');
    Route::get('rapor/{rapor}/cetak', [RaporController::class, 'cetak'])->name('rapor.cetak');
    Route::post('rapor/{rapor}/status', [RaporController::class, 'updateStatus'])->name('rapor.update-status');
    Route::get('rapor/siswa/{siswa}', [RaporController::class, 'lihatRapor'])->name('rapor.lihat-rapor');
    Route::get('rapor', [RaporController::class, 'index'])->name('rapor.index');

    // PKL / Prakerin
    Route::get('pkl/{pkl}/cetak-surat', [PklController::class, 'cetakSurat'])->name('pkl.cetak-surat');
    Route::resource('pkl', PklController::class)->except(['show']);

    // Laporan
    Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('laporan/siswa', [LaporanController::class, 'siswaPerKelas'])->name('laporan.siswa-per-kelas');
    Route::get('laporan/absensi', [LaporanController::class, 'absensiBulanan'])->name('laporan.absensi-bulanan');
    Route::get('laporan/nilai', [LaporanController::class, 'nilaiPerKelas'])->name('laporan.nilai-per-kelas');
    Route::get('api/chart-dashboard', [LaporanController::class, 'apiChartDashboard'])->name('api.chart-dashboard');

    // User Management
    Route::resource('user', UserController::class, ['except' => ['show']]);

    // Profile
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [ProfileController::class, 'password'])->name('profile.password');
});

// ========================
// GURU ROUTES
// ========================
Route::group([
    'middleware' => ['auth', 'role:guru'],
    'prefix' => 'guru',
    'as' => 'guru.',
], function () {
    Route::get('/dashboard', function () {
        return view('guru.dashboard');
    })->name('dashboard');

    // Absensi
    Route::get('absensi/create', [GuruAbsensiController::class, 'create'])->name('absensi.create');
    Route::post('absensi', [GuruAbsensiController::class, 'store'])->name('absensi.store');
    Route::get('absensi', [GuruAbsensiController::class, 'index'])->name('absensi.index');

    // Nilai
    Route::get('nilai/create', [GuruNilaiController::class, 'create'])->name('nilai.create');
    Route::post('nilai', [GuruNilaiController::class, 'store'])->name('nilai.store');
    Route::get('nilai', [GuruNilaiController::class, 'index'])->name('nilai.index');

    // PKL / Prakerin
    Route::post('pkl/{pkl}/nilai', [GuruPklController::class, 'storeNilai'])->name('pkl.store-nilai');
    Route::get('pkl/{pkl}/nilai', [GuruPklController::class, 'inputNilai'])->name('pkl.input-nilai');
    Route::get('pkl', [GuruPklController::class, 'index'])->name('pkl.index');

    // Profile
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [ProfileController::class, 'password'])->name('profile.password');
});

// ========================
// SISWA ROUTES
// ========================
Route::group([
    'middleware' => ['auth', 'role:siswa'],
    'prefix' => 'siswa',
    'as' => 'siswa.',
], function () {
    Route::get('/dashboard', function () {
        return view('siswa.dashboard');
    })->name('dashboard');

    // Absensi
    Route::get('absensi', [SiswaAbsensiController::class, 'index'])->name('absensi.index');

    // Nilai
    Route::get('nilai', [SiswaNilaiController::class, 'index'])->name('nilai.index');

    // Rapor
    Route::get('rapor/{rapor}/cetak', [SiswaRaporController::class, 'cetak'])->name('rapor.cetak');
    Route::get('rapor', [SiswaRaporController::class, 'index'])->name('rapor.index');

    // PKL / Prakerin
    Route::get('pkl', [SiswaPklController::class, 'index'])->name('pkl.index');

    // Profile
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [ProfileController::class, 'password'])->name('profile.password');
});
