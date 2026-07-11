# UML Documentation - Sistem Akademik SMK

Dokumentasi UML lengkap untuk Sistem Akademik SMK.

---

## Table of Contents

1. [Use Case Diagram](#use-case-diagram)
2. [Class Diagram](#class-diagram)
3. [Sequence Diagram - Login](#sequence-diagram---login)
4. [Sequence Diagram - Input Absensi](#sequence-diagram---input-absensi)
5. [Sequence Diagram - Input Nilai](#sequence-diagram---input-nilai)
6. [Sequence Diagram - Generate Rapor](#sequence-diagram---generate-rapor)
7. [Activity Diagram - Login](#activity-diagram---login)
8. [Activity Diagram - Input Absensi](#activity-diagram---input-absensi)
9. [Entity Relationship Diagram (ERD)](#entity-relationship-diagram-erd)
10. [Component Diagram](#component-diagram)

---

## Use Case Diagram

```mermaid
graph LR
    subgraph Actors
        A((Admin))
        G((Guru))
        S((Siswa))
    end

    subgraph Authentication
        UC_LOGIN[Login]
        UC_LOGOUT[Logout]
        UC_PROFILE[Update Profile]
    end

    subgraph Admin Features
        UC_MANAGE_JURUSAN[Manage Jurusan]
        UC_MANAGE_KELAS[Manage Kelas]
        UC_MANAGE_GURU[Manage Guru]
        UC_MANAGE_SISWA[Manage Siswa]
        UC_MANAGE_MAPEL[Manage Mata Pelajaran]
        UC_MANAGE_JADWAL[Manage Jadwal]
        UC_MANAGE_ABSENSI[Manage Absensi]
        UC_EXPORT_ABSENSI[Export Absensi]
        UC_MANAGE_RAPOR[Manage Rapor]
        UC_MANAGE_PKL[Manage PKL]
        UC_MANAGE_LAPORAN[View Laporan]
        UC_MANAGE_USER[Manage User]
    end

    subgraph Guru Features
        UC_GURU_ABSENSI[Input Absensi]
        UC_GURU_NILAI[Input Nilai]
        UC_GURU_PKL[Input Nilai PKL]
        UC_GURU_JADWAL[Lihat Jadwal]
    end

    subgraph Siswa Features
        UC_SISWA_JADWAL[Lihat Jadwal]
        UC_SISWA_ABSENSI[Lihat Absensi]
        UC_SISWA_NILAI[Lihat Nilai]
        UC_SISWA_RAPOR[Lihat & Cetak Rapor]
        UC_SISWA_PKL[Lihat PKL]
    end

    A --> UC_LOGIN
    A --> UC_LOGOUT
    A --> UC_PROFILE
    A --> UC_MANAGE_JURUSAN
    A --> UC_MANAGE_KELAS
    A --> UC_MANAGE_GURU
    A --> UC_MANAGE_SISWA
    A --> UC_MANAGE_MAPEL
    A --> UC_MANAGE_JADWAL
    A --> UC_MANAGE_ABSENSI
    A --> UC_EXPORT_ABSENSI
    A --> UC_MANAGE_RAPOR
    A --> UC_MANAGE_PKL
    A --> UC_MANAGE_LAPORAN
    A --> UC_MANAGE_USER

    G --> UC_LOGIN
    G --> UC_LOGOUT
    G --> UC_PROFILE
    G --> UC_GURU_ABSENSI
    G --> UC_GURU_NILAI
    G --> UC_GURU_PKL
    G --> UC_GURU_JADWAL

    S --> UC_LOGIN
    S --> UC_LOGOUT
    S --> UC_PROFILE
    S --> UC_SISWA_JADWAL
    S --> UC_SISWA_ABSENSI
    S --> UC_SISWA_NILAI
    S --> UC_SISWA_RAPOR
    S --> UC_SISWA_PKL
```

---

## Class Diagram

```mermaid
classDiagram
    class User {
        +int id
        +string name
        +string email
        +string role
        +bool is_active
        +isAdmin() bool
        +isGuru() bool
        +isSiswa() bool
    }

    class Guru {
        +int id
        +int user_id
        +string nip
        +string nama_lengkap
        +string jenis_kelamin
        +string tempat_lahir
        +date tanggal_lahir
        +string alamat
        +string no_telp
        +string mata_pelajaran
        +string foto
    }

    class Siswa {
        +int id
        +int user_id
        +string nis
        +string nisn
        +string nama_lengkap
        +int kelas_id
        +string jenis_kelamin
        +string tempat_lahir
        +date tanggal_lahir
        +string alamat
        +string nama_ortu
        +string no_telp_ortu
        +string foto
        +string angkatan
    }

    class Kelas {
        +int id
        +string nama_kelas
        +int jurusan_id
        +int tingkat
        +string tahun_ajaran
        +int wali_kelas_id
    }

    class Jurusan {
        +int id
        +string kode_jurusan
        +string nama_jurusan
        +string deskripsi
    }

    class MataPelajaran {
        +int id
        +string kode_mapel
        +string nama_mapel
        +string kelompok
        +int jurusan_id
    }

    class Jadwal {
        +int id
        +int kelas_id
        +int mata_pelajaran_id
        +int guru_id
        +string hari
        +time jam_mulai
        +time jam_selesai
        +string ruangan
        +int semester
        +string tahun_ajaran
    }

    class Absensi {
        +int id
        +int siswa_id
        +int jadwal_id
        +date tanggal
        +string status
        +string keterangan
        +int input_by
    }

    class Nilai {
        +int id
        +int siswa_id
        +int mata_pelajaran_id
        +int kelas_id
        +int guru_id
        +int semester
        +string tahun_ajaran
        +decimal tugas
        +decimal uts
        +decimal uas
        +decimal nilai_akhir
        +string predikat
        +hitungNilaiAkhir() decimal
        +hitungPredikat() string
    }

    class Rapor {
        +int id
        +int siswa_id
        +int kelas_id
        +int semester
        +string tahun_ajaran
        +decimal rata_rata_nilai
        +string predikat_umum
        +string catatan_wali
        +int generated_by
        +string status
    }

    class Pkl {
        +int id
        +int siswa_id
        +int guru_id
        +string perusahaan
        +string alamat_perusahaan
        +string kontak_perusahaan
        +date tanggal_mulai
        +date tanggal_selesai
        +string status
        +string catatan
    }

    class NilaiPkl {
        +int id
        +int pkl_id
        +decimal pengetahuan
        +decimal keterampilan
        +decimal sikap
        +decimal nilai_akhir
        +string predikat
    }

    User "1" --> "1" Guru : has
    User "1" --> "1" Siswa : has
    Guru "1" --> "*" Jadwal : teaches
    Guru "1" --> "*" Kelas : wali_kelas
    Guru "1" --> "*" Pkl : pembimbing
    Siswa "*" --> "1" Kelas : belongs_to
    Siswa "1" --> "*" Absensi : has
    Siswa "1" --> "*" Nilai : has
    Siswa "1" --> "1" Rapor : has
    Siswa "1" --> "1" Pkl : has
    Kelas "*" --> "1" Jurusan : belongs_to
    Kelas "1" --> "*" Siswa : has
    Kelas "1" --> "*" Jadwal : has
    MataPelajaran "*" --> "1" Jurusan : belongs_to
    MataPelajaran "1" --> "*" Jadwal : has
    MataPelajaran "1" --> "*" Nilai : has
    Jadwal "*" --> "1" Kelas : belongs_to
    Jadwal "*" --> "1" MataPelajaran : belongs_to
    Jadwal "*" --> "1" Guru : belongs_to
    Absensi "*" --> "1" Siswa : belongs_to
    Absensi "*" --> "1" Jadwal : belongs_to
    Nilai "*" --> "1" Siswa : belongs_to
    Nilai "*" --> "1" MataPelajaran : belongs_to
    Nilai "*" --> "1" Kelas : belongs_to
    Nilai "*" --> "1" Guru : belongs_to
    Rapor "*" --> "1" Siswa : belongs_to
    Rapor "*" --> "1" Kelas : belongs_to
    Pkl "*" --> "1" Siswa : belongs_to
    Pkl "*" --> "1" Guru : belongs_to
    Pkl "1" --> "0..1" NilaiPkl : has
    NilaiPkl "*" --> "1" Pkl : belongs_to
```

---

## Sequence Diagram - Login

```mermaid
sequenceDiagram
    actor U as User
    participant W as Web Router
    participant LC as LoginController
    participant Auth as Auth System
    participant DB as Database

    U->>W: GET /login
    W->>LC: showLoginForm()
    LC-->>U: Tampilkan form login

    U->>W: POST /login (email, password)
    W->>LC: login(Request)
    LC->>Auth: attempt(email, password)
    Auth->>DB: Query users table
    DB-->>Auth: User data
    Auth-->>LC: true/false

    alt Login Berhasil
        LC->>DB: Update last_login
        LC-->>W: Redirect to dashboard
        W-->>U: Dashboard sesuai role
    else Login Gagal
        LC-->>W: Back with errors
        W-->>U: Tampilkan error message
    end
```

---

## Sequence Diagram - Input Absensi

```mermaid
sequenceDiagram
    actor G as Guru/Admin
    participant W as Web Router
    participant AC as AbsensiController
    participant DB as Database

    G->>W: GET /absensi/create
    W->>AC: create()
    AC->>DB: Query kelas, jadwal
    DB-->>AC: Data kelas & jadwal
    AC-->>W: Form input absensi
    W-->>G: Tampilkan form

    G->>W: POST /absensi (kelas_id, jadwal_id, tanggal, statuses[])
    W->>AC: store(StoreAbsensiRequest)
    AC->>AC: Validasi input

    loop Untuk setiap siswa
        AC->>DB: Absensi::updateOrCreate()
        DB-->>AC: Berhasil disimpan
    end

    AC-->>W: Redirect to index
    W-->>G: Tampilkan daftar absensi dengan success message
```

---

## Sequence Diagram - Input Nilai

```mermaid
sequenceDiagram
    actor G as Guru
    participant W as Web Router
    participant NC as NilaiController
    participant N as Nilai Model
    participant DB as Database

    G->>W: GET /nilai/create
    W->>NC: create()
    NC->>DB: Query kelas, jadwal milik guru
    DB-->>NC: Data kelas & jadwal
    NC-->>W: Form input nilai
    W-->>G: Tampilkan form

    G->>W: POST /nilai (siswa_id, mapel_id, tugas, uts, uas)
    W->>NC: store(Request)
    NC->>N: hitungNilaiAkhir(tugas, uts, uas)
    N-->>NC: nilai_akhir
    NC->>N: hitungPredikat(nilai_akhir)
    N-->>NC: predikat
    NC->>DB: Nilai::updateOrCreate()
    DB-->>NC: Berhasil disimpan
    NC-->>W: Redirect to index
    W-->>G: Tampilkan daftar nilai dengan success message
```

---

## Sequence Diagram - Generate Rapor

```mermaid
sequenceDiagram
    actor A as Admin
    participant W as Web Router
    participant RC as RaporController
    participant R as Rapor Model
    participant N as Nilai Model
    participant DB as Database

    A->>W: POST /rapor/generate (kelas_id, semester, tahun_ajaran)
    W->>RC: generate(Request)
    RC->>DB: Query siswa per kelas

    loop Untuk setiap siswa
        RC->>N: Query nilai per siswa
        N-->>RC: Daftar nilai
        RC->>RC: Hitung rata-rata nilai
        RC->>RC: Hitung predikat umum

        alt Belum ada rapor
            RC->>DB: Rapor::create()
        else Sudah ada rapor
            RC->>DB: Rapor::update()
        end
        DB-->>RC: Berhasil disimpan
    end

    RC-->>W: Redirect to index
    W-->>A: Tampilkan daftar rapor dengan success message
```

---

## Activity Diagram - Login

```mermaid
flowchart TD
    Start((Start))
    InputEmail[Input Email & Password]
    Validate{Validasi Input}
    CheckUser{User exists?}
    CheckPassword{Password valid?}
    CheckActive{Account active?}
    GetRole[Dapatkan Role User]
    AdminDashboard[Redirect Admin Dashboard]
    GuruDashboard[Redirect Guru Dashboard]
    SiswaDashboard[Redirect Siswa Dashboard]
    ShowError[Show Error Message]
    End((End))

    Start --> InputEmail
    InputEmail --> Validate
    Validate -->|Invalid| ShowError
    Validate -->|Valid| CheckUser
    CheckUser -->|Not Found| ShowError
    CheckUser -->|Found| CheckPassword
    CheckPassword -->|Wrong| ShowError
    CheckPassword -->|Correct| CheckActive
    CheckActive -->|Inactive| ShowError
    CheckActive -->|Active| GetRole
    GetRole --> AdminDashboard
    GetRole --> GuruDashboard
    GetRole --> SiswaDashboard
    AdminDashboard --> End
    GuruDashboard --> End
    SiswaDashboard --> End
    ShowError --> End
```

---

## Activity Diagram - Input Absensi

```mermaid
flowchart TD
    Start((Start))
    SelectKelas[Pilih Kelas]
    SelectJadwal[Pilih Jadwal Pelajaran]
    SelectTanggal[Pilih Tanggal]
    LoadSiswa[Load Daftar Siswa]
    InputStatus[Input Status per Siswa]
    Validate{Validasi Input}
    SaveData[Simpan Data Absensi]
    CheckDuplicate{Data sudah ada?}
    UpdateData[Update Data]
    CreateData[Buat Data Baru]
    Success[Redirect dengan Success Message]
    End((End))

    Start --> SelectKelas
    SelectKelas --> SelectJadwal
    SelectJadwal --> SelectTanggal
    SelectTanggal --> LoadSiswa
    LoadSiswa --> InputStatus
    InputStatus --> Validate
    Validate -->|Invalid| InputStatus
    Validate -->|Valid| SaveData
    SaveData --> CheckDuplicate
    CheckDuplicate -->|Ya| UpdateData
    CheckDuplicate -->|Tidak| CreateData
    UpdateData --> Success
    CreateData --> Success
    Success --> End
```

---

## Entity Relationship Diagram (ERD)

```mermaid
erDiagram
    users {
        int id PK
        string name
        string email UK
        string password
        string role
        boolean is_active
        timestamp created_at
        timestamp updated_at
    }

    gurus {
        int id PK
        int user_id FK
        string nip UK
        string nama_lengkap
        string jenis_kelamin
        string tempat_lahir
        date tanggal_lahir
        string alamat
        string no_telp
        string mata_pelajaran
        string foto
        timestamps created_at
        timestamps updated_at
    }

    siswas {
        int id PK
        int user_id FK
        string nis UK
        string nisn UK
        string nama_lengkap
        int kelas_id FK
        string jenis_kelamin
        string tempat_lahir
        date tanggal_lahir
        string alamat
        string nama_ortu
        string no_telp_ortu
        string foto
        string angkatan
        timestamps created_at
        timestamps updated_at
    }

    jurusans {
        int id PK
        string kode_jurusan UK
        string nama_jurusan
        string deskripsi
        timestamps created_at
        timestamps updated_at
    }

    kelas {
        int id PK
        string nama_kelas
        int jurusan_id FK
        int tingkat
        string tahun_ajaran
        int wali_kelas_id FK
        timestamps created_at
        timestamps updated_at
    }

    mata_pelajarans {
        int id PK
        string kode_mapel UK
        string nama_mapel
        string kelompok
        int jurusan_id FK
        timestamps created_at
        timestamps updated_at
    }

    jadwals {
        int id PK
        int kelas_id FK
        int mata_pelajaran_id FK
        int guru_id FK
        string hari
        time jam_mulai
        time jam_selesai
        string ruangan
        int semester
        string tahun_ajaran
        timestamps created_at
        timestamps updated_at
    }

    absensis {
        int id PK
        int siswa_id FK
        int jadwal_id FK
        date tanggal
        string status
        string keterangan
        int input_by FK
        timestamps created_at
        timestamps updated_at
    }

    nilais {
        int id PK
        int siswa_id FK
        int mata_pelajaran_id FK
        int kelas_id FK
        int guru_id FK
        int semester
        string tahun_ajaran
        decimal tugas
        decimal uts
        decimal uas
        decimal nilai_akhir
        string predikat
        timestamps created_at
        timestamps updated_at
    }

    rapors {
        int id PK
        int siswa_id FK
        int kelas_id FK
        int semester
        string tahun_ajaran
        decimal rata_rata_nilai
        string predikat_umum
        string catatan_wali
        int generated_by FK
        string status
        timestamps created_at
        timestamps updated_at
    }

    pkls {
        int id PK
        int siswa_id FK
        int guru_id FK
        string perusahaan
        string alamat_perusahaan
        string kontak_perusahaan
        date tanggal_mulai
        date tanggal_selesai
        string status
        string catatan
        timestamps created_at
        timestamps updated_at
    }

    nilai_pkls {
        int id PK
        int pkl_id FK
        decimal pengetahuan
        decimal keterampilan
        decimal sikap
        decimal nilai_akhir
        string predikat
        timestamps created_at
        timestamps updated_at
    }

    users ||--|| gurus : "has"
    users ||--|| siswas : "has"
    users ||--o{ absensis : "inputs"
    users ||--o{ rapors : "generates"
    jurusans ||--o{ kelas : "has"
    jurusans ||--o{ mata_pelajarans : "has"
    kelas ||--o{ siswas : "has"
    kelas ||--o{ jadwals : "has"
    kelas ||--o{ nilais : "has"
    kelas ||--o{ rapors : "has"
    gurus ||--o{ jadwals : "teaches"
    gurus ||--o{ pkls : "supervises"
    gurus ||--o{ nilais : "grades"
    siswas ||--o{ absensis : "has"
    siswas ||--o{ nilais : "has"
    siswas ||--|| rapors : "has"
    siswas ||--|| pkls : "has"
    mata_pelajarans ||--o{ jadwals : "scheduled"
    mata_pelajarans ||--o{ nilais : "graded"
    jadwals ||--o{ absensis : "tracked"
```

---

## Component Diagram

```mermaid
graph TD
    subgraph Presentation["Presentation Layer"]
        AdminViews["Admin Views (Blade)"]
        GuruViews["Guru Views (Blade)"]
        SiswaViews["Siswa Views (Blade)"]
        AuthViews["Auth Views (Blade)"]
    end

    subgraph Application["Application Layer"]
        AdminControllers["Admin Controllers"]
        GuruControllers["Guru Controllers"]
        SiswaControllers["Siswa Controllers"]
        AuthControllers["Auth Controllers"]
        FormRequests["Form Requests"]
        Middleware["Middleware (CheckRole)"]
    end

    subgraph Domain["Domain Layer"]
        Models["Eloquent Models"]
        Relationships["Model Relationships"]
        BusinessLogic["Business Logic (Nilai Calculation)"]
    end

    subgraph Infrastructure["Infrastructure Layer"]
        Database["Database (MySQL/SQLite)"]
        Exports["Export Classes (Excel)"]
        Permissions["Spatie Permission"]
    end

    AdminViews --> AdminControllers
    GuruViews --> GuruControllers
    SiswaViews --> SiswaControllers
    AuthViews --> AuthControllers

    AdminControllers --> FormRequests
    GuruControllers --> FormRequests
    SiswaControllers --> FormRequests

    AdminControllers --> Middleware
    GuruControllers --> Middleware
    SiswaControllers --> Middleware

    AdminControllers --> Models
    GuruControllers --> Models
    SiswaControllers --> Models
    AuthControllers --> Models

    Models --> Relationships
    Models --> BusinessLogic

    Models --> Database
    AdminControllers --> Exports
    Models --> Permissions

    style Presentation fill:#E3F2FD,stroke:#1565C0
    style Application fill:#E8F5E9,stroke:#2E7D32
    style Domain fill:#FFF3E0,stroke:#E65100
    style Infrastructure fill:#F3E5F5,stroke:#6A1B9A
```
