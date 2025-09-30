<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Cetak Rekomendasi</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            background: #fff;
            margin: 0;
            padding: 0;
        }

        .card-3 {
            background-color: #fff;
            width: 90%;
            margin: 20px auto;
            padding: 10px 20px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .logo-img {
            max-width: 60px;
            height: auto;
            margin-top: 10px;
            margin-bottom: 20px;
            display: block;
        }

        .title {
            text-align: center;
            font-weight: bold;
            margin-top: -60px;
            margin-bottom: 40px;
            font-size: 18px;
        }

        table {
            margin-top: 40px;
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }

        th,
        td {
            border: 1px solid #000000;
            padding: 7px 10px;
            font-size: 14px;
            background-color: #ffffff;
        }

        th {
            background-color: #f3f3f3;
            font-weight: bold;
        }

        .no-border {
            border: none !important;
            background: none !important;
        }

        .ttd-table {
            width: 100%;
            text-align: center;
            margin-left: -38px;
            margin-top: -70px;
        }

        .ttd-table td {
            border: none;
            background: none;
            height: 80px;
            vertical-align: bottom;
        }

        .ttd-label {
            font-size: 14px;
        }

        .ttd-name {
            padding-top: 0px;
            font-size: 14px;
        }

        .ttd-role {
            font-size: 13px;
        }

        .date-table {
            width: 100%;
            margin-top: 50px;
            text-align: right;
            margin-left: -20px;
        }

        .date-table td {
            border: none;
            background: none;
            font-size: 14px;
            margin-bottom: -80px;
        }

        .text-center {
            text-align: center;
        }

        .text-end {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="card-3">
        <img src="{{ asset('images/logo-ggp.png') }}" class="logo-img" alt="Logo">
        <div class="title">
            LEMBAR REKOMENDASI & SERVIS UNIT KOMPUTER
        </div>

        <table style="width: 350px;">
            <tbody>
                @if ($data)
                    <tr>
                        <td>No. Rek</td>
                        <td>{{ $data->id_rek }}</td>
                    </tr>
                    <tr>
                        <td>No. PR</td>
                        <td>{{ $data->no_spb }}</td>
                    </tr>
                    <tr>
                        <td>Nama Pengaju</td>
                        <td>{{ $data->nama_lengkap }}</td>
                    </tr>
                    <tr>
                        <td>Department</td>
                        <td>{{ $data->nama_dep }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Pengajuan</td>
                        <td>{{ $data->tgl_masuk }}</td>
                    </tr>
                    <tr>
                        <td>Alasan</td>
                        <td>{{ $data->alasan_rek }}</td>
                    </tr>
                @else
                    <tr>
                        <td colspan="2" class="text-center">Data tidak ditemukan.</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Unit</th>
                    <th>Keterangan Unit</th>
                    <th>Estimasi Harga</th>
                    <th>Masukan Kabag</th>
                    <th>Masukan IT</th>
                </tr>
            </thead>
            <tbody>
                @if ($details && count($details))
                    @foreach ($details as $idx => $detail)
                        <tr>
                            <td>{{ $idx + 1 }}</td>
                            <td>{{ $detail->jenis_unit }}</td>
                            <td>{{ $detail->ket_unit }}</td>
                            <td>Rp. {{ number_format($detail->estimasi_harga, 0, ',', '.') }}</td>
                            <td>{{ $detail->masukan_kabag }}</td>
                            <td>{{ $detail->masukan_it }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="text-center">Detail rekomendasi tidak ditemukan.</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <table class="date-table">
            <tr>
                <td>
                    Labuhan Ratu, {{ \Carbon\Carbon::now()->format('d F Y') }}
                </td>
            </tr>
        </table>

        <table class="ttd-table">
            <tr>
                <td class="ttd-label">Disetujui,</td>
                <td class="ttd-label">Diketahui Oleh,</td>
                <td class="ttd-label">Diminta Oleh,</td>
            </tr>
            <tr>
                <td>
                    @if ($data && $data->status === 'Diterima' && !empty($sign_approval))
                        <img src="{{ asset($sign_approval) }}" style="height:60px;">
                    @endif
                </td>
                <td>
                    @if ($data && $data->status === 'Diterima' && !empty($sign_user))
                        <img src="{{ asset($sign_user) }}" style="height:60px;">
                    @endif
                </td>
                <td></td>
            </tr>
            <tr>
                <td class="ttd-name">
                    <u>{{ $data->nama_receiver ?? '' }}</u><br>
                    <span class="ttd-role">Kepala Bagian {{ $data->nama_dep ?? 'Accounting' }}</span>
                </td>
                <td class="ttd-name">
                    <u>{{ $data->nama_it ?? '' }}</u><br>
                    <span class="ttd-role">Departement IT</span>
                </td>
                <td class="ttd-name">
                    <u>{{ $data->nama_lengkap ?? '' }}</u><br>
                    <span class="ttd-role">Pemohon</span>
                </td>
            </tr>
        </table>
        @if (!$data)
            <div class="text-center mt-3">Data tidak ditemukan.</div>
        @endif
    </div>
</body>

</html>
