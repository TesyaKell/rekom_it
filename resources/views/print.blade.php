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

            <table class="table table-bordered table-sm align-middle me-5 mt-3 bg-light">
                <tbody class="table-light">
                    @if ($data)
                        <tr>
                            <td class="ps-3" style="width: 170px;">No. Rek</td>
                            <td class="ps-3">{{ $data->id_rek }}</td>
                        </tr>
                        <tr>
                            <td class="ps-3" style="width: 170px;">No. PR</th>
                            <td class="ps-3">{{ $data->no_spb }}</td>
                        </tr>
                        <tr>
                            <td class="ps-3" style="width: 170px;">Jenis Unit</td>
                            <td class="ps-3">{{ $data->jenis_unit }}</td>
                        </tr>
                        <tr>
                            <td class="ps-3" style="width: 170px;">Nama Pengaju</td>
                            <td class="ps-3">{{ $data->nama_rek }}</td>
                        </tr>
                        <tr>
                            <td class="ps-3" style="width: 170px;">Department</td>
                            <td class="ps-3">{{ $data->jabatan_receiver }}</td>
                        </tr>
                        <tr>
                            <td class="ps-3" style="width: 170px;">Tanggal Pengajuan</td>
                            <td class="ps-3">{{ $data->tgl_masuk }}</td>
                        </tr>
                        {{-- <tr>
                            <th class="ps-3">Status</th>
                            <td class="ps-3">
                                @if ($data->status == 'menunggu verifikasi Kabag')
                                    <span class="badge text-light p-1"
                                        style="background-color: rgb(249, 137, 0);">Menunggu
                                        Kabag</span>
                                @elseif($data->status == 'menunggu verifikasi Tim IT')
                                    <span class="badge bg-orange text-light p-1"
                                        style="background-color: rgb(41, 63, 230);">Menunggu Tim IT</span>
                                @elseif($data->status == 'Ditolak')
                                    <span class="badge bg-danger p-1">Ditolak</span>
                                @elseif($data->status == 'Diterima')
                                    <span class="badge bg-success p-1">Diterima</span>
                                @else
                                    <span class="badge bg-secondary">{{ $data->status }}</span>
                                @endif
                            </td>
                        </tr> --}}
                    @else
                        <tr>
                            <td colspan="8" class="text-center">Data tidak ditemukan.</td>
                        </tr>
                    @endif
                </tbody>

            </table>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>

</body>

</html>
