<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Data Santri</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
            margin: 0;
            padding: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        @media print {
            body { padding: 0; }
            @page { margin: 1cm; size: landscape; }
        }
    </style>
</head>
<body>
    <h2>DATA SANTRI TPQ</h2>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama Lengkap</th>
                <th>Panggilan</th>
                <th>Kelas</th>
                <th>L/P</th>
                <th>Tgl. Lahir</th>
                <th>Nama Ayah</th>
                <th>Nama Ibu</th>
                <th>No HP</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($santris as $s)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $s->nis }}</td>
                <td>{{ $s->nama_santri }}</td>
                <td>{{ $s->nama_panggilan }}</td>
                <td>{{ $s->kelas ? $s->kelas->nama_kelas : 'Tanpa Kelas' }}</td>
                <td>{{ $s->jenis_kelamin }}</td>
                <td>{{ $s->tanggal_lahir ? date('d-m-Y', strtotime($s->tanggal_lahir)) : '' }}</td>
                <td>{{ $s->nama_ayah }}</td>
                <td>{{ $s->nama_ibu }}</td>
                <td>{{ $s->no_hp_orang_tua }}</td>
                <td>{{ $s->alamat_rumah }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        // Otomatis trigger print saat halaman dimuat
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
