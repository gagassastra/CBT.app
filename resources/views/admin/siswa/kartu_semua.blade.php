<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Semua Kartu Peserta Ujian</title>
    <style>
        @page { margin: 1cm; }
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            margin: 0; padding: 0;
            background-color: #ffffff;
        }
        
        table.grid-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 5px; /* Jarak antar kartu lebih rapat */
        }
        
        .grid-col {
            width: 50%;
            vertical-align: top;
            padding: 0;
        }

        .card {
            width: 198.42pt; 
            height: 141.73pt; 
            border: 2px solid #1e40af; /* Sama dengan cetak satu siswa */
            box-sizing: border-box;
            background-color: #ffffff;
            position: relative;
            margin: 0 auto;
        }
        
        .header {
            background-color: #1e40af;
            color: #ffffff;
            text-align: center;
            padding: 4px;
        }
        .header h1 {
            font-size: 10px;
            margin: 0;
            text-transform: uppercase;
        }
        .header p {
            font-size: 7px;
            margin: 2px 0 0 0;
        }
        .content {
            padding: 8px 10px; /* Sama dengan cetak satu siswa */
        }
        .title {
            text-align: center;
            font-size: 11px; /* Sama dengan cetak satu siswa */
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 8px; /* Sama dengan cetak satu siswa */
            border-bottom: 1px dashed #cbd5e1; /* Sama dengan cetak satu siswa */
            padding-bottom: 4px; /* Sama dengan cetak satu siswa */
        }
        .info-table {
            width: 100%;
            font-size: 8px;
            border-collapse: collapse;
        }
        .info-table td { 
            padding: 2px 0; /* Sama dengan cetak satu siswa */
            vertical-align: top;
            border: none;
        }
        .footer {
            margin-top: 8px; /* Sama dengan cetak satu siswa */
            text-align: right;
            font-size: 7px;
            padding-right: 10px;
        }
        .signature {
            margin-top: 15px; /* Sama dengan cetak satu siswa */
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    @php
        $chunks = $siswa->chunk(2);
    @endphp

    <table class="grid-table">
        @foreach($chunks as $row)
        <tr>
            @foreach($row as $s)
            <td class="grid-col">
                <div class="card">
                    <div class="header">
                        <h1>PKBM AL-QUDWAH</h1>
                        <p>KARTU PESERTA UJIAN SEKOLAH</p>
                    </div>
                    <div class="content">
                        <div class="title">TAHUN AJARAN {{ date('Y') }} / {{ date('Y') + 1 }}</div>
                        <table class="info-table">
                            <tr>
                                <td width="35"><strong>Nama</strong></td>
                                <td width="5">:</td>
                                <td style="font-weight: bold; font-size: 9px;">{{ strtoupper($s->name) }}</td>
                            </tr>
                            <tr>
                                <td><strong>TTL</strong></td>
                                <td>:</td>
                                <td>{{ $s->tempat_lahir ?? '-' }}, {{ $s->tanggal_lahir ? \Carbon\Carbon::parse($s->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Username</strong></td>
                                <td>:</td>
                                <td>{{ $s->nisn ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Password</strong></td>
                                <td>:</td>
                                <td style="font-family: monospace; font-weight: bold; color: #b91c1c;">{{ $s->password_plain }}</td>
                            </tr>
                        </table>
                        <div class="footer">
                            Kepala Sekolah<br>
                            <div class="signature">ELIS MASRIDAH, M.Pd</div>
                        </div>
                    </div>
                </div>
            </td>
            @endforeach
            
            @if($row->count() == 1)
            <td></td>
            @endif
        </tr>
        @endforeach
    </table>
</body>
</html>

