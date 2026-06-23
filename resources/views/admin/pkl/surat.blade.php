<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Pengantar PKL</title>
    <style>
        body { font-family: 'Times New Roman', serif; font-size: 12pt; margin: 40px; line-height: 1.6; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 3px double #000; padding-bottom: 15px; }
        .header h2 { margin: 0; font-size: 14pt; }
        .header h3 { margin: 5px 0 0 0; font-size: 13pt; text-transform: uppercase; }
        .header p { margin: 2px 0; font-size: 10pt; }
        .surat-number { margin: 15px 0; }
        .content { margin-top: 15px; text-align: justify; }
        .content p { margin: 8px 0; }
        .info-table { width: 100%; margin: 15px 0; }
        .info-table td { padding: 4px 0; vertical-align: top; }
        .info-table td:first-child { width: 180px; }
        .signature { margin-top: 40px; display: flex; justify-content: space-between; }
        .signature-left { width: 50%; }
        .signature-right { width: 50%; text-align: right; }
        .signature .name { font-weight: bold; text-decoration: underline; margin-top: 40px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>SEKOLAH MENENGAH KEJURUAN (SMK)</h2>
        <h3>Surat Pengantar Praktik Kerja Lapangan</h3>
        <p>Jl. Pendidikan No. 1, Kota | Telp: (021) 123456</p>
    </div>

    <div class="surat-number">
        <p>Nomor: {{ '001/PKL/' . date('m') . '/' . date('Y') }}</p>
    </div>

    <div class="content">
        <p>Yth. pimpinan</p>
        <p><strong>{{ $pkl->perusahaan }}</strong></p>
        <p>di Tempat</p>

        <p>Dengan hormat,</p>

        <p>Yang bertanda tangan di bawah ini, Kepala Sekolah Menengah Kejuruan (SMK) dengan ini menerangkan bahwa:</p>

        <table class="info-table">
            <tr>
                <td>Nama Siswa</td>
                <td>: {{ $pkl->siswa->nama_lengkap }}</td>
            </tr>
            <tr>
                <td>NIS</td>
                <td>: {{ $pkl->siswa->nis }}</td>
            </tr>
            <tr>
                <td>NISN</td>
                <td>: {{ $pkl->siswa->nisn }}</td>
            </tr>
            <tr>
                <td>Kelas</td>
                <td>: {{ $pkl->siswa->kelas->nama_kelas ?? '-' }}</td>
            </tr>
            <tr>
                <td>Jurusan</td>
                <td>: {{ $pkl->siswa->kelas->jurusan->nama_jurusan ?? '-' }}</td>
            </tr>
        </table>

        <p>Adalah benar siswa kami yang tersebut di atas, dan siswa tersebut akan melaksanakan Praktik Kerja Lapangan (PKL) di perusahaan/instansi Bapak/Ibu dengan ketentuan sebagai berikut:</p>

        <table class="info-table">
            <tr>
                <td>Perusahaan</td>
                <td>: {{ $pkl->perusahaan }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>: {{ $pkl->alamat_perusahaan }}</td>
            </tr>
            <tr>
                <td>Guru Pembimbing</td>
                <td>: {{ $pkl->guru->nama_lengkap }} (NIP. {{ $pkl->guru->nip }})</td>
            </tr>
            <tr>
                <td>Periode PKL</td>
                <td>: {{ $pkl->tanggal_mulai->format('d F Y') }} s/d {{ $pkl->tanggal_selesai->format('d F Y') }}</td>
            </tr>
        </table>

        <p>Demikian surat pengantar ini kami buat dengan sebenar-benarnya. Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.</p>
    </div>

    <div class="signature">
        <div class="signature-left">
            <p>Guru Pembimbing,</p>
            <div class="name">{{ $pkl->guru->nama_lengkap }}</div>
            <p>NIP. {{ $pkl->guru->nip }}</p>
        </div>
        <div class="signature-right">
            <p>Kota, {{ now()->format('d F Y') }}</p>
            <p>Kepala Sekolah,</p>
            <div class="name">_______________________</div>
            <p>NIP. _________________</p>
        </div>
    </div>
</body>
</html>
