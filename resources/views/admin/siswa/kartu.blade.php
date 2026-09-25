<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kartu Ujian - {{ $siswa->name }}</title>
    <style>
        @page { margin: 0px; }
        body { 
            margin: 0px; 
            padding: 0px; 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            width: 198.42pt; 
            height: 141.73pt; 
            background-color: #ffffff;
            box-sizing: border-box;
            border: 2px solid #1e40af;
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
            padding: 8px 10px;
        }
        .title {
            text-align: center;
            font-size: 11px;
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 8px;
            border-bottom: 1px dashed #cbd5e1;
            padding-bottom: 4px;
        }
        .info-table {
            width: 100%;
            font-size: 8px;
        }
        .info-table td {
            padding: 2px 0;
            vertical-align: top;
        }
        .footer {
            margin-top: 8px;
            text-align: right;
            font-size: 7px;
            padding-right: 10px;
        }
        .signature {
            margin-top: 15px;
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>
<body>
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
                <td style="font-weight: bold; font-size: 9px;">{{ strtoupper($siswa->name) }}</td>
            </tr>
            <tr>
                <td><strong>TTL</strong></td>
                <td>:</td>
                <td>{{ $siswa->tempat_lahir ?? '-' }}, {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</td>
            </tr>
            <tr>
                <td><strong>Username</strong></td>
                <td>:</td>
                <td>{{ $siswa->nisn ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Password</strong></td>
                <td>:</td>
                <td style="font-family: monospace; font-weight: bold; color: #b91c1c;">{{ $siswa->password_plain }}</td>
            </tr>
        </table>
        
        <div class="footer">
            Kepala Sekolah<br>
            <div class="signature">ELIS MASRIDAH, M.Pd</div>
        </div>
    </div>
</body>
</html>

