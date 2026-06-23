<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Jurusan;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\MataPelajaran;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        // ==================
        // JURUSAN
        // ==================
        $tkj = Jurusan::create(['kode_jurusan' => 'TKJ', 'nama_jurusan' => 'Teknik Komputer & Jaringan', 'deskripsi' => 'Jurusan yang mempelajari jaringan komputer dan administrasi sistem']);
        $rpl = Jurusan::create(['kode_jurusan' => 'RPL', 'nama_jurusan' => 'Rekayasa Perangkat Lunak', 'deskripsi' => 'Jurusan yang mempelajari pengembangan perangkat lunak']);
        $mm = Jurusan::create(['kode_jurusan' => 'MM', 'nama_jurusan' => 'Multimedia', 'deskripsi' => 'Jurusan yang mempelajari desain grafis, animasi, dan video']);

        // ==================
        // MATA PELAJARAN
        // ==================
        $mapels = [
            ['kode_mapel' => 'MTK', 'nama_mapel' => 'Matematika', 'kelompok' => 'Normatif', 'jurusan_id' => null],
            ['kode_mapel' => 'BIN', 'nama_mapel' => 'Bahasa Indonesia', 'kelompok' => 'Normatif', 'jurusan_id' => null],
            ['kode_mapel' => 'BIG', 'nama_mapel' => 'Bahasa Inggris', 'kelompok' => 'Normatif', 'jurusan_id' => null],
            ['kode_mapel' => 'PKK', 'nama_mapel' => 'Pendidikan Kewarganegaraan', 'kelompok' => 'Normatif', 'jurusan_id' => null],
            ['kode_mapel' => 'TIK', 'nama_mapel' => 'Teknologi Informasi & Komputer', 'kelompok' => 'Adaptif', 'jurusan_id' => null],
            ['kode_mapel' => 'TKJ1', 'nama_mapel' => 'Dasar Jaringan', 'kelompok' => 'Produktif', 'jurusan_id' => $tkj->id],
            ['kode_mapel' => 'TKJ2', 'nama_mapel' => 'Administrasi Server', 'kelompok' => 'Produktif', 'jurusan_id' => $tkj->id],
            ['kode_mapel' => 'RPL1', 'nama_mapel' => 'Dasar Pemrograman', 'kelompok' => 'Produktif', 'jurusan_id' => $rpl->id],
            ['kode_mapel' => 'RPL2', 'nama_mapel' => 'Pemrograman Web', 'kelompok' => 'Produktif', 'jurusan_id' => $rpl->id],
            ['kode_mapel' => 'MM1', 'nama_mapel' => 'Desain Grafis', 'kelompok' => 'Produktif', 'jurusan_id' => $mm->id],
            ['kode_mapel' => 'MM2', 'nama_mapel' => 'Animasi 2D & 3D', 'kelompok' => 'Produktif', 'jurusan_id' => $mm->id],
        ];
        foreach ($mapels as $m) {
            MataPelajaran::create($m);
        }

        // ==================
        // GURU + USER
        // ==================
        $guruData = [
            ['nip' => '198501012010011001', 'nama_lengkap' => 'Budi Santoso, S.Pd', 'jenis_kelamin' => 'Laki-laki', 'mata_pelajaran' => 'Matematika'],
            ['nip' => '198502022010012002', 'nama_lengkap' => 'Siti Aminah, S.Pd', 'jenis_kelamin' => 'Perempuan', 'mata_pelajaran' => 'Bahasa Indonesia'],
            ['nip' => '198603032011011003', 'nama_lengkap' => 'Ahmad Hidayat, S.Pd', 'jenis_kelamin' => 'Laki-laki', 'mata_pelajaran' => 'Bahasa Inggris'],
            ['nip' => '198704042012012004', 'nama_lengkap' => 'Dewi Lestari, S.Kom', 'jenis_kelamin' => 'Perempuan', 'mata_pelajaran' => 'TIK'],
            ['nip' => '198805052013011005', 'nama_lengkap' => 'Rudi Hermawan, S.Kom', 'jenis_kelamin' => 'Laki-laki', 'mata_pelajaran' => 'Jaringan Komputer'],
            ['nip' => '198906062014012006', 'nama_lengkap' => 'Rina Wati, S.Ds', 'jenis_kelamin' => 'Perempuan', 'mata_pelajaran' => 'Desain Grafis'],
        ];

        $gurus = [];
        foreach ($guruData as $i => $g) {
            $user = User::create([
                'name' => $g['nama_lengkap'],
                'email' => 'guru' . ($i + 1) . '@smk.sch.id',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => 'guru',
                'is_active' => true,
            ]);
            $user->assignRole('guru');

            $guru = Guru::create([
                'user_id' => $user->id,
                'nip' => $g['nip'],
                'nama_lengkap' => $g['nama_lengkap'],
                'jenis_kelamin' => $g['jenis_kelamin'],
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1985-01-01',
                'alamat' => 'Jl. Pendidikan No. 1',
                'no_telp' => '081234567890',
                'mata_pelajaran' => $g['mata_pelajaran'],
            ]);
            $gurus[] = $guru;
        }

        // ==================
        // KELAS
        // ==================
        $kelasData = [
            ['nama_kelas' => 'X-TKJ-1', 'tingkat' => 'X', 'jurusan_id' => $tkj->id, 'wali_kelas_id' => $gurus[0]->id],
            ['nama_kelas' => 'X-TKJ-2', 'tingkat' => 'X', 'jurusan_id' => $tkj->id, 'wali_kelas_id' => $gurus[1]->id],
            ['nama_kelas' => 'X-RPL-1', 'tingkat' => 'X', 'jurusan_id' => $rpl->id, 'wali_kelas_id' => $gurus[2]->id],
            ['nama_kelas' => 'XI-TKJ-1', 'tingkat' => 'XI', 'jurusan_id' => $tkj->id, 'wali_kelas_id' => $gurus[3]->id],
            ['nama_kelas' => 'XI-RPL-1', 'tingkat' => 'XI', 'jurusan_id' => $rpl->id, 'wali_kelas_id' => $gurus[4]->id],
            ['nama_kelas' => 'XI-MM-1', 'tingkat' => 'XI', 'jurusan_id' => $mm->id, 'wali_kelas_id' => $gurus[5]->id],
        ];

        $kelasList = [];
        foreach ($kelasData as $k) {
            $kelasList[] = Kelas::create(array_merge($k, ['tahun_ajaran' => '2025/2026']));
        }

        // ==================
        // SISWA + USER (Sample per kelas)
        // ==================
        $siswaData = [
            // X-TKJ-1
            ['nama' => 'Andi Pratama', 'nis' => '2025001', 'nisn' => '0012345001', 'jk' => 'Laki-laki', 'kelas_idx' => 0],
            ['nama' => 'Rina Marlina', 'nis' => '2025002', 'nisn' => '0012345002', 'jk' => 'Perempuan', 'kelas_idx' => 0],
            ['nama' => 'Dani Kurniawan', 'nis' => '2025003', 'nisn' => '0012345003', 'jk' => 'Laki-laki', 'kelas_idx' => 0],
            // X-TKJ-2
            ['nama' => 'Sari Dewi', 'nis' => '2025004', 'nisn' => '0012345004', 'jk' => 'Perempuan', 'kelas_idx' => 1],
            ['nama' => 'Fajar Nugroho', 'nis' => '2025005', 'nisn' => '0012345005', 'jk' => 'Laki-laki', 'kelas_idx' => 1],
            // X-RPL-1
            ['nama' => 'Bima Ardiansyah', 'nis' => '2025006', 'nisn' => '0012345006', 'jk' => 'Laki-laki', 'kelas_idx' => 2],
            ['nama' => 'Putri Ramadhani', 'nis' => '2025007', 'nisn' => '0012345007', 'jk' => 'Perempuan', 'kelas_idx' => 2],
            ['nama' => 'Rizky Aditya', 'nis' => '2025008', 'nisn' => '0012345008', 'jk' => 'Laki-laki', 'kelas_idx' => 2],
            // XI-TKJ-1
            ['nama' => 'Agus Setiawan', 'nis' => '2024001', 'nisn' => '0012345009', 'jk' => 'Laki-laki', 'kelas_idx' => 3],
            ['nama' => 'Maya Sari', 'nis' => '2024002', 'nisn' => '0012345010', 'jk' => 'Perempuan', 'kelas_idx' => 3],
            // XI-RPL-1
            ['nama' => 'Yoga Pratama', 'nis' => '2024003', 'nisn' => '0012345011', 'jk' => 'Laki-laki', 'kelas_idx' => 4],
            ['nama' => 'Lestari Putri', 'nis' => '2024004', 'nisn' => '0012345012', 'jk' => 'Perempuan', 'kelas_idx' => 4],
            // XI-MM-1
            ['nama' => 'Dian Permata', 'nis' => '2024005', 'nisn' => '0012345013', 'jk' => 'Perempuan', 'kelas_idx' => 5],
            ['nama' => 'Farhan Maulana', 'nis' => '2024006', 'nisn' => '0012345014', 'jk' => 'Laki-laki', 'kelas_idx' => 5],
        ];

        $angkatanMap = ['X' => '2025', 'XI' => '2024'];

        foreach ($siswaData as $s) {
            $kelas = $kelasList[$s['kelas_idx']];

            $user = User::create([
                'name' => $s['nama'],
                'email' => strtolower(str_replace(' ', '.', $s['nama'])) . '@siswa.smk.sch.id',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => 'siswa',
                'is_active' => true,
            ]);
            $user->assignRole('siswa');

            Siswa::create([
                'user_id' => $user->id,
                'nis' => $s['nis'],
                'nisn' => $s['nisn'],
                'nama_lengkap' => $s['nama'],
                'kelas_id' => $kelas->id,
                'jenis_kelamin' => $s['jk'],
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2008-01-01',
                'alamat' => 'Jl. Pelajar No. ' . $s['nis'],
                'nama_ortu' => 'Orang Tua ' . $s['nama'],
                'no_telp_ortu' => '081234567890',
                'angkatan' => $angkatanMap[$kelas->tingkat],
            ]);
        }

        $this->command->info('Sample data berhasil dibuat!');
        $this->command->info('Login Siswa: email @siswa.smk.sch.id / password');
    }
}
