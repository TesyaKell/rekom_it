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
            max-width: 85px;
            height: auto;
            margin-top: 10px;
            margin-bottom: 20px;
            display: block;
        }

        .title {
            text-align: center;
            font-weight: bold;
            margin-top: -75px;
            margin-bottom: 80px;
            font-size: 20px;
        }

        table {
            margin-top: 40px;
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }

        th,
        td {
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
            margin-top: -40px;
        }

        .ttd-table td {
            border: none;
            background: none;
            height: 40px;
            vertical-align: bottom;
            padding-bottom: 10px;
        }

        .ttd-label {
            font-size: 14px;
        }

        .ttd-name {
            font-size: 14px;
            padding-top: 5px;
            margin-top: 0;
        }

        .ttd-role {
            font-size: 13px;
        }

        .date-table {
            width: 100%;
            margin-top: 50px;
            text-align: right;
            margin-left: -60px;
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
                        <td>No. Rekomendasi</td>
                        <td> : </td>
                        <td>{{ $data->id_rek }}</td>
                    </tr>
                    <tr>
                        <td>No. PR</td>
                        <td> : </td>
                        <td>{{ $data->no_spb }}</td>
                    </tr>
                    <tr>
                        <td>Dibuat Oleh</td>
                        <td> : </td>
                        <td>{{ $data->nama_lengkap }}</td>
                    </tr>
                    <tr>
                        <td>Department</td>
                        <td> : </td>
                        <td>{{ $data->nama_dep }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Pengajuan</td>
                        <td> : </td>
                        <td>{{ $data->tgl_masuk }}</td>
                    </tr>
                    <tr>
                        <td>Alasan</td>
                        <td> : </td>
                        <td>{{ $data->alasan_rek }}</td>
                    </tr>
                @else
                    <tr>
                        <td colspan="2" class="text-center">Data tidak ditemukan.</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <table border="1" style="border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="text-align:left;">No</th>
                    <th style="text-align:left;">Nama Unit</th>
                    <th style="text-align:left;">Keterangan Unit</th>
                    <th style="text-align:left;">Estimasi Harga</th>
                    <th style="text-align:left;">Masukan Kabag</th>
                    <th style="text-align:left;">Rekomendasi IT</th>
                </tr>
            </thead>
            <tbody>
                @if ($details && count($details))
                    @foreach ($details as $idx => $detail)
                        <tr>
                            <td style="border: 1px solid #747474;">{{ $idx + 1 }}</td>
                            <td style="border: 1px solid #747474;">{{ $detail->jenis_unit }}</td>
                            <td style="border: 1px solid #747474;">{{ $detail->ket_unit }}</td>
                            <td style="border: 1px solid #747474;">Rp.
                                {{ number_format($detail->estimasi_harga, 0, ',', '.') }}</td>
                            <td style="border: 1px solid #747474;">{{ $detail->masukan_kabag }}</td>
                            <td style="border: 1px solid #747474;">{{ $detail->masukan_it }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="text-center" style="border: 1px solid #ddd;">Detail rekomendasi tidak
                            ditemukan.</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <table class="date-table">
            <tr>
                <td>
                    {{ $alamat ? $alamat : 'Lampung' }}, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
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
                        <img src="{{ asset($sign_approval) }}" style="height:60px; margin-bottom:0;">
                    @endif
                </td>
                <td>
                    @if ($data && $data->status === 'Diterima' && !empty($sign_user))
                        <img src="{{ asset($sign_user) }}" style="height:60px; margin-bottom:0;">
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
