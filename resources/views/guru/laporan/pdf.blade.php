<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Nilai - {{ $ujian->nama_ujian }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 12px; color: #333; }
        .header-table { width: 100%; border-bottom: 3px solid #000; padding-bottom: 15px; margin-bottom: 20px; }
        .info { margin-bottom: 20px; width: 100%; font-size: 13px; }
        .info td { padding: 4px 0; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 30px; font-size: 13px; }
        .table th, .table td { border: 1px solid #000; padding: 10px; text-align: left; }
        .table th { background-color: #f2f2f2; font-weight: bold; text-align: center; }
        .text-center { text-align: center !important; }
        .ttd-box { width: 100%; margin-top: 50px; font-size: 13px; }
        .ttd-box table { width: 100%; }
        .ttd-box td { width: 50%; text-align: center; padding-top: 20px; }
        .ttd-name { font-weight: bold; text-decoration: underline; margin-top: 80px; }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td width="15%" style="text-align: center; vertical-align: middle;">
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('image/logo.jpg'))) }}" width="100">
            </td>
            <td width="85%" style="text-align: center; padding-right: 15%;">
                <h1 style="font-size: 26px; margin: 0; text-transform: uppercase;">PKBM AL-QUDWAH</h1>
                <p style="margin: 8px 0 0 0; font-size: 16px; font-weight: bold;">Laporan Hasil Ujian Sekolah Berbasis Web</p>
                <p style="margin: 5px 0 0 0; font-size: 13px; font-style: italic;">Sistem Evaluasi Digital Berstandar Nasional</p>
            </td>
        </tr>
    </table>

    <table class="info">
        <tr>
            <td width="130"><strong>Nama Ujian</strong></td>
            <td width="10">:</td>
            <td>{{ $ujian->nama_ujian }}</td>
            <td width="130"><strong>Mata Pelajaran</strong></td>
            <td width="10">:</td>
            <td>{{ $ujian->mataPelajaran->nama_pelajaran ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Kelas</strong></td>
            <td>:</td>
            <td>{{ $ujian->kelas->nama_kelas ?? '-' }}</td>
            <td><strong>Tanggal Ujian</strong></td>
            <td>:</td>
            <td>{{ \Carbon\Carbon::parse($ujian->created_at)->format('d F Y') }}</td>
        </tr>
    </table>

    <table class="table">
        <thead>
            <tr>
                <th width="40">No</th>
                <th>Nama Siswa</th>
                <th width="90">Benar</th>
                <th width="90">Salah</th>
                <th width="90">Kosong</th>
                <th width="120">Nilai Akhir</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($ujian->pesertaUjians as $peserta)
                @if($peserta->status == 'selesai' && $peserta->hasilUjian)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td>{{ $peserta->siswa->name ?? '-' }}</td>
                    <td class="text-center">{{ $peserta->hasilUjian->jumlah_benar }}</td>
                    <td class="text-center">{{ $peserta->hasilUjian->jumlah_salah }}</td>
                    <td class="text-center">{{ $peserta->hasilUjian->tidak_dijawab }}</td>
                    <td class="text-center" style="font-weight:bold; font-size:16px;">{{ number_format($peserta->hasilUjian->nilai_akhir, 0) }}</td>
                </tr>
                @endif
            @endforeach
            @if($no == 1)
                <tr>
                    <td colspan="6" class="text-center" style="padding: 20px;">Belum ada siswa yang menyelesaikan ujian ini.</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="ttd-box">
        <table>
            <tr>
                <td>
                    Mengetahui,<br>
                    Kepala Sekolah PKBM AL-QUDWAH
                    <div class="ttd-name">ELIS MASRIDAH, M.Pd</div>
                    NIP. -
                </td>
                <td>
                    Jakarta, {{ date('d F Y') }}<br>
                    Guru Mata Pelajaran
                    <div class="ttd-name">{{ $ujian->guru->name ?? '_______________________' }}</div>
                    NIP. -
                </td>
            </tr>
        </table>
    </div>

</body>
</html>