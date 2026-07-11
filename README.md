# Sistem Akademik SMK

Aplikasi web untuk mengelola data akademik sekolah menengah kejuruan (SMK), dibangun dengan Laravel 11 dan Blade Template Engine.

## Fitur Utama

### 1. Tiga Role Pengguna

- **Admin** - Kelola seluruh data sekolah, master data, jadwal, absensi, nilai, rapor, dan laporan
- **Guru** - Input absensi siswa, input nilai, input nilai PKL/Prakerin
- **Siswa** - Melihat jadwal, absensi, nilai, rapor, dan data PKL

### 2. Modul Admin

- **Master Data**: Kelola Jurusan, Kelas, Guru, Siswa, Mata Pelajaran
- **Jadwal Pelajaran**: Kelola jadwal mengajar per kelas
- **Absensi**: Input, rekap, dan export absensi siswa (Excel)
- **Nilai**: Monitoring dan input nilai siswa
- **Rapor**: Generate, cetak, dan manage rapor siswa
- **PKL/Prakerin**: Kelola data praktik kerja lapangan
- **Laporan**: Dashboard statistik, laporan per kelas, absensi bulanan, nilai
- **User Management**: Kelola akun pengguna
- **Profile**: Update profil dan password

### 3. Modul Guru

- **Input Absensi**: Input kehadiran siswa per jadwal pelajaran
- **Input Nilai**: Input nilai tugas, UTS, UAS siswa
- **Input Nilai PKL**: Input penilaian praktik kerja lapangan
- **Lihat Jadwal**: Melihat jadwal mengajar sendiri
- **Profile**: Update profil dan password

### 4. Modul Siswa

- **Lihat Jadwal**: Melihat jadwal pelajaran kelas
- **Lihat Absensi**: Melihat riwayat kehadiran sendiri
- **Lihat Nilai**: Melihat nilai dari semua mata pelajaran
- **Lihat Rapor**: Melihat dan cetak rapor
- **Lihat PKL**: Melihat data praktik kerja lapangan
- **Profile**: Update profil dan password

### 5. Fitur Keamanan & Validasi

- Role-based access control dengan Spatie Permission (Admin, Guru, Siswa)
- Custom middleware CheckRole untuk validasi akses
- Form Request validation (StoreAbsensiRequest)
- Soft deletes untuk data penting
- Autentikasi dengan Laravel Auth
- Password validation dengan CurrentPasswordCheckRule

## Tech Stack

- **Framework**: Laravel 11.x
- **Template Engine**: Blade + Tailwind CSS (Black Dashboard Preset)
- **Database**: MySQL / SQLite
- **Autentikasi**: Laravel Auth
- **Role Management**: Spatie Laravel Permission
- **DataTables**: Yajra Laravel Datatables
- **Export Excel**: Maatwebsite Excel
- **PDF Export**: Laravel DomPDF
- **Frontend Assets**: Vite + Alpine.js

## Arsitektur

### Clean Architecture (Layered)

```
app/
├── Exports/                # Export classes (AbsensiExport)
├── Http/
│   ├── Controllers/
│   │   ├── Admin/          # Admin controllers
│   │   │   ├── AbsensiController.php
│   │   │   ├── GuruController.php
│   │   │   ├── JadwalController.php
│   │   │   ├── JurusanController.php
│   │   │   ├── KelasController.php
│   │   │   ├── LaporanController.php
│   │   │   ├── MataPelajaranController.php
│   │   │   ├── PklController.php
│   │   │   ├── RaporController.php
│   │   │   └── SiswaController.php
│   │   ├── Auth/           # Authentication controllers
│   │   ├── Guru/           # Guru controllers
│   │   │   ├── AbsensiController.php
│   │   │   ├── NilaiController.php
│   │   │   └── PklController.php
│   │   └── Siswa/          # Siswa controllers
│   │       ├── AbsensiController.php
│   │       ├── NilaiController.php
│   │       ├── PklController.php
│   │       └── RaporController.php
│   ├── Middleware/          # CheckRole middleware
│   └── Requests/           # Form Request validation
├── Models/                 # Eloquent Models
│   ├── Absensi.php
│   ├── Guru.php
│   ├── Jadwal.php
│   ├── Jurusan.php
│   ├── Kelas.php
│   ├── MataPelajaran.php
│   ├── Nilai.php
│   ├── NilaiPkl.php
│   ├── Pkl.php
│   ├── Rapor.php
│   ├── Siswa.php
│   └── User.php
├── Providers/              # Service Providers
└── Rules/                  # Custom validation rules
    └── CurrentPasswordCheckRule.php
```

### Key Design Patterns

- **MVC Architecture**: Model-View-Controller pattern
- **Role-Based Access Control**: Spatie Permission untuk multi-role
- **Form Request Validation**: Validasi input terpisah di Request classes
- **Resource Controllers**: CRUD operations dengan resource routing
- **Middleware**: CheckRole untuk authorization
- **Eloquent Relationships**: Relasi antar model (belongsTo, hasMany, hasManyThrough)

## Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/username/sistem-akademik-smk.git
cd sistem-akademik-smk
```

### 2. Install Dependencies

```bash
composer install
npm install
npm run build
```

### 3. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Setup

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistem_akademik_smk
DB_USERNAME=root
DB_PASSWORD=your_password
```

Atau gunakan SQLite:

```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

### 5. Migration & Seeding

```bash
php artisan migrate:fresh --seed
```

### 6. Storage Link

```bash
php artisan storage:link
```

### 7. Jalankan Aplikasi

```bash
php artisan serve
```

Akses aplikasi di `http://localhost:8000`

## Akun Default

Setelah seeding, tersedia akun berikut:

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@smk.com | password |
| Guru | guru@smk.com | password |
| Siswa | siswa@smk.com | password |

## Struktur URL

### Admin Routes (`/admin`)

- `/admin/dashboard` - Dashboard admin dengan statistik
- `/admin/jurusan` - Kelola data jurusan
- `/admin/kelas` - Kelola data kelas
- `/admin/guru` - Kelola data guru
- `/admin/siswa` - Kelola data siswa
- `/admin/mapel` - Kelola mata pelajaran
- `/admin/jadwal` - Kelola jadwal pelajaran
- `/admin/absensi` - Kelola dan rekap absensi
- `/admin/absensi/export` - Export absensi ke Excel
- `/admin/rapor` - Kelola dan generate rapor
- `/admin/pkl` - Kelola data PKL/Prakerin
- `/admin/laporan` - Laporan dan statistik
- `/admin/user` - Manajemen user
- `/admin/profile` - Update profil

### Guru Routes (`/guru`)

- `/guru/dashboard` - Dashboard guru
- `/guru/absensi` - Input dan lihat absensi
- `/guru/nilai` - Input dan lihat nilai
- `/guru/pkl` - Input nilai PKL
- `/guru/profile` - Update profil

### Siswa Routes (`/siswa`)

- `/siswa/dashboard` - Dashboard siswa
- `/siswa/absensi` - Lihat riwayat absensi
- `/siswa/nilai` - Lihat nilai
- `/siswa/rapor` - Lihat dan cetak rapor
- `/siswa/pkl` - Lihat data PKL
- `/siswa/profile` - Update profil

## Command Penting

### Generate Rapor (Manual)

```bash
php artisan rapor:generate
```

### Reset Data Absensi

```bash
php artisan absensi:reset
```

### Cetak Rapor PDF

Rapor dapat dicetak langsung dari halaman admin/rapor atau dari dashboard siswa.

## Business Rules

1. **Role-Based Access**: Setiap user memiliki role (admin/guru/siswa) yang menentukan akses fitur

2. **Perhitungan Nilai Akhir**:
   - Tugas: 30%
   - UTS: 30%
   - UAS: 40%
   - Formula: ` nilai_akhir = (tugas × 0.3) + (uts × 0.3) + (uas × 0.4) `

3. **Predikat Nilai**:
   - A: ≥ 90
   - B: ≥ 80
   - C: ≥ 70
   - D: ≥ 60
   - E: < 60

4. **Absensi**:
   - Status: Hadir, Izin, Sakit, Alpa
   - Input per jadwal pelajaran per tanggal

5. **Rapor**:
   - Generated per semester per tahun ajaran
   - Berisi rata-rata nilai dan predikat umum
   - Catatan wali kelas

6. **PKL/Prakerin**:
   - Data perusahaan dan kontak
   - Tanggal mulai dan selesai
   - Status: Aktif, Selesai, Dibatalkan

## Testing

### Manual Testing Checklist

**Admin Flow:**

1. Login ke `/admin` dengan akun admin
2. Dashboard menampilkan statistik (jumlah siswa, guru, kelas, jurusan)
3. Kelola data Jurusan (CRUD)
4. Kelola data Kelas (CRUD)
5. Kelola data Guru (CRUD)
6. Kelola data Siswa (CRUD)
7. Kelola Mata Pelajaran (CRUD)
8. Kelola Jadwal Pelajaran (CRUD)
9. Input dan rekap Absensi
10. Export Absensi ke Excel
11. Generate dan cetak Rapor
12. Kelola data PKL/Prakerin
13. Lihat Laporan dan Statistik
14. Manajemen User

**Guru Flow:**

1. Login ke `/guru` dengan akun guru
2. Dashboard guru ditampilkan
3. Input absensi siswa per jadwal
4. Input nilai siswa (Tugas, UTS, UAS)
5. Input nilai PKL siswa
6. Lihat jadwal mengajar

**Siswa Flow:**

1. Login ke `/siswa` dengan akun siswa
2. Dashboard siswa ditampilkan
3. Lihat jadwal pelajaran
4. Lihat riwayat absensi
5. Lihat nilai semua mata pelajaran
6. Lihat dan cetak rapor
7. Lihat data PKL

## UML Documentation

Dokumentasi UML dapat dibuat menggunakan tools seperti:
- **Draw.io** (https://app.diagrams.net)
- **Lucidchart** (https://www.lucidchart.com)
- **PlantUML** (https://www.plantuml.com)

### Diagram yang Direkomendasikan

1. **Use Case Diagram**
   - Aktor: Admin, Guru, Siswa
   - Sistem: Autentikasi, Manajemen Data, Akademik, Laporan

2. **Class Diagram**
   - Models: User, Guru, Siswa, Kelas, Jurusan, MataPelajaran, Jadwal, Absensi, Nilai, Rapor, Pkl, NilaiPkl
   - Relasi: belongsTo, hasMany, hasManyThrough

3. **Sequence Diagram**
   - Login Flow
   - Input Absensi Flow
   - Input Nilai Flow
   - Generate Rapor Flow

4. **Activity Diagram**
   - Login Activity
   - Input Absensi Activity
   - Input Nilai Activity

5. **ERD (Entity Relationship Diagram)**
   - Tabel: users, gurus, siswas, kelas, jurusans, mata_pelajarans, jadwals, absensis, nilais, rapors, pkls, nilai_pkls

## Development

### Code Quality Standards

- Type hints pada semua parameter
- Return types pada semua method
- Form Request validation untuk input
- Eloquent relationships untuk relasi data
- Resource controllers untuk CRUD
- Middleware untuk authorization

### Menambahkan Fitur Baru

1. **Model**: Tambahkan di `app/Models/`
2. **Migration**: Buat di `database/migrations/`
3. **Controller**: Buat di `app/Http/Controllers/Admin/`
4. **Form Request**: Buat di `app/Http/Requests/`
5. **Views**: Buat di `resources/views/admin/`
6. **Routes**: Tambahkan di `routes/web.php`
7. **Permissions**: Tambahkan di `RolePermissionSeeder.php`

## Deployment

### Production Checklist

- Ganti `APP_ENV=production`
- Ganti `APP_DEBUG=false`
- Setup database production
- Jalankan `php artisan migrate --force`
- Jalankan `php artisan db:seed --force`
- Optimasi: `php artisan optimize`
- Konfigurasi SSL/HTTPS
- Setup queue worker (supervisor)
- Setup cron job untuk scheduler

### Server Requirements

- PHP >= 8.2
- Extensions: BCMath, Ctype, cURL, DOM, Fileinfo, JSON, Mbstring, OpenSSL, PCRE, PDO, Tokenizer, XML
- MySQL >= 5.7 / SQLite
- Composer
- Node.js & NPM (untuk build assets)

## Troubleshooting

### Error: "no such table: roles"

```bash
php artisan vendor:publish --provider="Spatie\\Permission\\PermissionServiceProvider"
php artisan migrate
```

### Error: "Class not found"

```bash
composer dump-autoload
```

### Permission Denied pada Storage

```bash
chmod -R 775 storage bootstrap/cache
```

### Error: "Route not found"

```bash
php artisan route:clear
php artisan route:cache
```

### Error: "View not found"

```bash
php artisan view:clear
php artisan view:cache
```

## License

MIT License

## Kontribusi

Silakan buat Pull Request untuk kontribusi. Pastikan untuk:

1. Fork repository
2. Buat branch fitur (`git checkout -b feature/fitur-baru`)
3. Commit perubahan (`git commit -am 'Add fitur baru'`)
4. Push ke branch (`git push origin feature/fitur-baru`)
5. Buat Pull Request

## Support

Untuk pertanyaan atau issue, silakan buat GitHub Issue.

---

**Dibuat dengan Laravel 11 & Blade Template Engine**
