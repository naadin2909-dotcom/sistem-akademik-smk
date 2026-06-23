<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ========================
        // PERMISSIONS
        // ========================

        // Permission Modul Data Master
        Permission::create(['name' => 'manage-jurusan', 'guard_name' => 'web']);
        Permission::create(['name' => 'manage-kelas', 'guard_name' => 'web']);
        Permission::create(['name' => 'manage-guru', 'guard_name' => 'web']);
        Permission::create(['name' => 'manage-siswa', 'guard_name' => 'web']);
        Permission::create(['name' => 'manage-mapel', 'guard_name' => 'web']);

        // Permission Modul Jadwal
        Permission::create(['name' => 'manage-jadwal', 'guard_name' => 'web']);
        Permission::create(['name' => 'view-jadwal', 'guard_name' => 'web']);

        // Permission Modul Absensi
        Permission::create(['name' => 'manage-absensi', 'guard_name' => 'web']);
        Permission::create(['name' => 'input-absensi', 'guard_name' => 'web']);
        Permission::create(['name' => 'view-absensi', 'guard_name' => 'web']);

        // Permission Modul Nilai
        Permission::create(['name' => 'manage-nilai', 'guard_name' => 'web']);
        Permission::create(['name' => 'input-nilai', 'guard_name' => 'web']);
        Permission::create(['name' => 'view-nilai', 'guard_name' => 'web']);

        // Permission Modul Rapor
        Permission::create(['name' => 'manage-rapor', 'guard_name' => 'web']);
        Permission::create(['name' => 'view-rapor', 'guard_name' => 'web']);
        Permission::create(['name' => 'cetak-rapor', 'guard_name' => 'web']);

        // Permission Modul PKL
        Permission::create(['name' => 'manage-pkl', 'guard_name' => 'web']);
        Permission::create(['name' => 'view-pkl', 'guard_name' => 'web']);
        Permission::create(['name' => 'input-nilai-pkl', 'guard_name' => 'web']);

        // Permission Modul Laporan
        Permission::create(['name' => 'manage-laporan', 'guard_name' => 'web']);
        Permission::create(['name' => 'view-laporan', 'guard_name' => 'web']);

        // ========================
        // ROLES
        // ========================

        // Role Admin
        $admin = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $admin->givePermissionTo([
            'manage-jurusan',
            'manage-kelas',
            'manage-guru',
            'manage-siswa',
            'manage-mapel',
            'manage-jadwal',
            'view-jadwal',
            'manage-absensi',
            'view-absensi',
            'manage-nilai',
            'view-nilai',
            'manage-rapor',
            'view-rapor',
            'cetak-rapor',
            'manage-pkl',
            'view-pkl',
            'manage-laporan',
            'view-laporan',
        ]);

        // Role Guru
        $guru = Role::create(['name' => 'guru', 'guard_name' => 'web']);
        $guru->givePermissionTo([
            'view-jadwal',
            'input-absensi',
            'view-absensi',
            'input-nilai',
            'view-nilai',
            'input-nilai-pkl',
            'view-pkl',
        ]);

        // Role Siswa
        $siswa = Role::create(['name' => 'siswa', 'guard_name' => 'web']);
        $siswa->givePermissionTo([
            'view-jadwal',
            'view-absensi',
            'view-nilai',
            'view-rapor',
            'view-pkl',
        ]);
    }
}
