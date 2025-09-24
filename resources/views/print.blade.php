@extends('layouts.app')

@section('title', 'Cetak Rekomendasi')

@php
    $pageTitle = 'Cetak Rekomendasi';
@endphp


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Rekomendasi</title>

    <style>
        td,
        tr {
            background-color: #ffffff;
            padding-left: 8px;
            font-size: 14px;
            font-family: 'Times New Roman', Times, serif;
            font-style: normal;
        }


        .ps-3 {
            background-color: #ffffff;
        }


        img {
            max-width: 60px;
            height: auto;
            display: left;
            margin-left: auto;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .card-3,
        .card-body-3 {
            background-color: #fff;
            width: 90%;
            margin-left: auto;
            margin-right: auto;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        span {
            font-family: 'Times New Roman', Times, serif;
        }
    </style>
</head>

<body>
    <div class="card-3">
        <img src="{{ asset('images/logo-ggp.png') }}" class="object-contain rounded-t-xl ms-3" alt="No image">
        <span class="d-flex justify-content-center mt-3 mb-2 fw-bold"
            style="position: absolute; top: 40px; left: 0; right: 0;">
            LEMBAR REKOMENDASI & SERVIS UNIT KOMPUTER
        </span>


        <div class="container mt-3 mb-5 me-5 ms-5 p-2">

            {{-- Tabel Data Rekomendasi --}}
            <table class="table table-bordered table-sm align-middle me-5 mt-3 bg-light">
                <tbody class="table-light">
                    @if ($data)
                        <tr>
                            <td class="ps-3" style="width: 170px;">No. Rek</td>
                            <td class="ps-3">{{ $data->id_rek }}</td>
                        </tr>
                        <tr>
                            <td class="ps-3" style="width: 170px;">No. PR</td>
                            <td class="ps-3">{{ $data->no_spb }}</td>
                        </tr>
                        <tr>
                            <td class="ps-3" style="width: 170px;">Nama Pengaju</td>
                            <td class="ps-3">{{ $data->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <td class="ps-3" style="width: 170px;">Department</td>
                            <td class="ps-3">{{ $data->nama_dep }}</td>
                        </tr>
                        <tr>
                            <td class="ps-3" style="width: 170px;">Tanggal Pengajuan</td>
                            <td class="ps-3">{{ $data->tgl_masuk }}</td>
                        </tr>
                        <tr>
                            <td class="ps-3" style="width: 170px;">Alasan</td>
                            <td class="ps-3">{{ $data->alasan_rek }}</td>
                        </tr>
                        <tr>
                            <td class="ps-3" style="width: 170px;">Harga Estimasi</td>
                            <td class="ps-3">Rp. {{ $data->estimasi_harga }}</td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="8" class="text-center">Data tidak ditemukan.</td>
                        </tr>
                    @endif
                </tbody>
            </table>

            {{-- Tabel Data Detail Rekomendasi --}}
            <table class="table table-bordered table-sm align-middle me-5 mt-3 bg-light">
                <thead>
                    <tr>
                        <th class="ps-3">No</th>
                        <th class="ps-3">Jenis Unit</th>
                        <th class="ps-3">Keterangan Unit</th>
                        <th class="ps-3">Estimasi Harga</th>
                        <th class="ps-3">Masukan</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($details && count($details))
                        @foreach ($details as $idx => $detail)
                            <tr>
                                <td class="ps-3">{{ $idx + 1 }}</td>
                                <td class="ps-3">{{ $detail->jenis_unit }}</td>
                                <td class="ps-3">{{ $detail->ket_unit }}</td>
                                <td class="ps-3">Rp. {{ $detail->estimasi_harga }}</td>
                                <td class="ps-3">{{ $detail->masukan }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center">Detail rekomendasi tidak ditemukan.</td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <table style="width:100%; text-align:end; margin-top: 50px;">
                @if ($data)
                    <tr class="mt-5">
                        <td class="ps-3 d-flex justify-content-end me-4">Labuhan Ratu,
                            {{ \Carbon\Carbon::now()->format('d F Y') }}</td>
                    </tr>
                @else
                    <tr>
                        <td colspan="8" class="text-center">Data tidak ditemukan.</td>
                    </tr>
                @endif

            </table>

            <div style="margin-top:10px; margin-bottom:20px;">
                <table style="width:100%; text-align:center;">
                    <tr>
                        <td style="width:33%;">Disetujui,</td>
                        <td style="width:33%;">Diketahui Oleh,</td>
                        <td style="width:33%;">Diminta Oleh,</td>
                    </tr>
                    <tr>
                        <td style="height:80px;">
                            @if ($data && $data->status === 'Diterima' && !empty($sign_approval))
                                <img src="{{ asset($sign_approval) }}" alt="Tanda Tangan" style="height:60px;">
                            @endif
                        </td>
                        <td style="height:80px;">
                            @if ($data && $data->status === 'Diterima' && !empty($sign_user))
                                <img src="{{ asset($sign_user) }}" alt="Tanda Tangan" style="height:60px;">
                            @endif
                        </td>
                        <td style="height:80px;"></td>
                    </tr>
                    <tr>
                        <td style="padding-top:10px;">
                            <u>{{ $nama_approval ?? 'Ella' }}</u><br>
                            <span style="font-size:13px;">Kabag {{ $data->nama_dep ?? 'Accounting' }}</span>
                        </td>
                        <td style="padding-top:10px;">
                            <u>{{ $nama_leng ?? 'Andi Prasetyo' }}</u><br>
                            <span style="font-size:13px;">Dept IT</span>
                        </td>
                        <td style="padding-top:10px;">
                            <u>{{ $data->nama_rek ?? 'Dani' }}</u><br>
                            <span style="font-size:13px;">Pemohon</span>
                        </td>
                    </tr>
                </table>
                @if (!$data)
                    <div class="text-center mt-3">Data tidak ditemukan.</div>
                @endif
            </div>



        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>

</body>

</html>
