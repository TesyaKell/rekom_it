<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>No. Rek</th>
                <th>No. PR</th>
                <th>Nama Unit</th>
                <th>Keterangan</th>
                <th>Alasan</th>
                <th>Estimasi Harga</th>
                <th>Dibuat Oleh</th>
                <th>Department</th>
                <th>Tanggal Pengajuan</th>
                <th>Status</th>
                <th>Tanggal Realisasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($results as $item)
                <tr>
                    <td>{{ $item->id_rek }}</td>
                    <td>{{ $item->no_spb }}</td>
                    <td>{{ $item->jenis_unit }}</td>
                    <td>{{ $item->ket_unit }}</td>
                    <td>{{ $item->alasan_rek }}</td>
                    <td>{{ $item->estimasi_harga }}</td>
                    <td>{{ $item->nama_lengkap }}</td>
                    <td>{{ $item->nama_dep }}</td>
                    <td>{{ $item->tgl_masuk }}</td>
                    <td>{{ $item->status }}</td>
                    <td>{{ $item->tanggal_realisasi }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
