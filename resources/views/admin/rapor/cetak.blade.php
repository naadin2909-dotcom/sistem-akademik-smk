<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rapor Siswa</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 20px; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2 { margin: 5px 0; }
        .header p { margin: 2px 0; font-size: 11px; }
        .info-table { width: 100%; margin-bottom: 15px; }
        .info-table td { padding: 3px 0; vertical-align: top; }
        .info-table td:first-child { width: 150px; font-weight: bold; }
        table.data-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        table.data-table th, table.data-table td { border: 1px solid #333; padding: 6px 8px; text-align: left; font-size: 11px; }
        table.data-table th { background-color: #f0f0f0; font-weight: bold; }
        table.data-table td.center { text-align: center; }
        table.data-table td.right { text-align: right; }
        .section-title { font-weight: bold; font-size: 13px; margin: 15px 0 8px 0; border-bottom: 1px solid #999; padding-bottom: 3px; }
        .rekap-table { width: 50%; margin-bottom: 15px; }
        .rekap-table td { padding: 3px 8px; }
        .rekap-table td:first-child { width: 100px; }
        .footer { margin-top: 40px; }
        .signature { text-align: right; margin-top: 30px; }
        .signature .name { font-weight: bold; text-decoration: underline; }
    </style>
</head>
<body>
    <div class="header">
        <h2>SEKOLAH MENENGAH KEJURUAN (SMK)</h2>
        <h3 style="margin-top: 5px;">LAPORAN HASIL BELAJAR</h3>
        <p>Alamat: Jl. Pendidikan No. 1, Kota | Telp: (021) 123456</p>
    </div>

    <table class="info-table">
        <tr>
            <td>Nama Siswa</td>
            <td>: {{ $rapor->siswa->nama_lengkap ?? '-' }}</td>
        </tr>
        <tr>
            <td>NIS</td>
            <td>: {{ $rapor->siswa->nis ?? '-' }}</td>
        </tr>
        <tr>
            <td>NISN</td>
            <td>: {{ $rapor->siswa->nisn ?? '-' }}</td>
        </tr>
        <tr>
            <td>Kelas</td>
            <td>: {{ $rapor->siswa->kelas->nama_kelas ?? '-' }}</td>
        </tr>
        <tr>
            <td>Jurusan</td>
            <td>: {{ $rapor->siswa->kelas->jurusan->nama_jurusan ?? '-' }}</td>
        </tr>
        <tr>
            <td>Semester</td>
            <td>: {{ $rapor->semester }} ({{ $rapor->semester == '1' ? 'Ganjil' : 'Genap' }})</td>
        </tr>
        <tr>
            <td>Tahun Ajaran</td>
            <td>: {{ $rapor->tahun_ajaran }}</td>
        </tr>
    </table>

    <div class="section-title">Daftar Nilai Mata Pelajaran</div>
    <table class="data-table">
        <thead>
            <tr>
                <th width="30">No</th>
                <th>Mata Pelajaran</th>
                <th class="center" width="60">Tugas</th>
                <th class="center" width="60">UTS</th>
                <th class="center" width="60">UAS</th>
                <th class="center" width="60">Akhir</th>
                <th class="center" width="50">Predikat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($nilais as $i => $nilai)
            <tr>
                <td class="center">{{ $i + 1 }}</td>
                <td>{{ $nilai->mataPelajaran->nama_mapel ?? '-' }}</td>
                <td class="center">{{ $nilai->tugas }}</td>
                <td class="center">{{ $nilai->uts }}</td>
                <td class="center">{{ $nilai->uas }}</td>
                <td class="center"><strong>{{ $nilai->nilai_akhir }}</strong></td>
                <td class="center"><strong>{{ $nilai->predikat }}</strong></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Rekapitulasi Kehadiran</div>
    <table class="rekap-table">
        <tr>
            <td>Hadir</td>
            <td>: {{ $rekapAbsensi['Hadir'] }} hari</td>
        </tr>
        <tr>
            <td>Izin</td>
            <td>: {{ $rekapAbsensi['Izin'] }} hari</td>
        </tr>
        <tr>
            <td>Sakit</td>
            <td>: {{ $rekapAbsensi['Sakit'] }} hari</td>
        </tr>
        <tr>
            <td>Alpa</td>
            <td>: {{ $rekapAbsensi['Alpa'] }} hari</td>
        </tr>
    </table>

    <div class="section-title">Ringkasan</div>
    <table class="info-table">
        <tr>
            <td>Rata-rata Nilai</td>
            <td>: <strong>{{ $rapor->rata_rata_nilai }}</strong></td>
        </tr>
        <tr>
            <td>Predikat Umum</td>
            <td>: <strong>{{ $rapor->predikat_umum }}</strong></td>
        </tr>
        <tr>
            <td>Status</td>
            <td>: {{ ucfirst($rapor->status) }}</td>
        </tr>
    </table>

    @if($rapor->catatan_wali)
    <div class="section-title">Catatan Wali Kelas</div>
    <p>{{ $rapor->catatan_wali }}</p>
    @endif

    <div class="signature">
        <p>Kota, {{ now()->format('d F Y') }}</p>
        <p>Wali Kelas,</p>
        <br><br><br>
        <p class="name">{{ $rapor->kelas->waliKelas->nama_lengkap ?? '_______________' }}</p>
        <p>NIP. {{ $rapor->kelas->waliKelas->nip ?? '_______________' }}</p>
    </div>
</body>
</html>
