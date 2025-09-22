@extends('layouts.app')

@section('title', 'Detail Rekomendasi')

@php
    $pageTitle = 'Detail Rekomendasi';
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Rekomendasi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


    <style>
        body {
            background-color: #efefef;
        }

        .row .col {
            border: 1px solid #000;
            background-color: #fff;
            padding: 20px;
            margin: 10px 0;
            text-align: center;
        }

        .container-1 {
            margin-top: -20px;
        }

        .row-2 .col-12 {
            border-bottom: 2px solid #d8d8d8;
            background-color: #ffffff;
            text-align: left;
        }

        p {
            text-align: left;
            font-size: 14px;
            font-weight: bold;
            color: #e8b200;
        }

        .container-2 {
            background-color: #ffffff;
            border-radius: 5px;
        }

        title {
            font-weight: bold;
        }

        tr {
            background-color: #ffffff;
        }

        th,
        td {
            font-size: 13px;
        }

        .modal-backdrop.show {
            opacity: 0.2 !important;
        }

        .form-label {
            font-weight: 600;
            color: #000000cb;
        }
    </style>
</head>

<div class= "container-1">
    <div class="row-2">
        <div class="col-12">

        </div>
        <div class="row-2">
            <div class="col-12">
                <p class="pt-3 mt-3 ms-5 ps-5">DETAIL REKOMENDASI</p>
            </div>
        </div>
    </div>


    <body>

        <div class="container mt-1 mb-5 me-5 ms-5 p-2">
            <h6 class="mt-3 mb-2 fw-bold">Rekomendasi</h6>
            <table class="table table-bordered table-sm align-middle me-5 mt-3 bg-light">
                <tbody class="table-light">
                    {{-- Tampilkan data rekomendasi utama --}}
                    @if ($data->count())
                        @php $header = $data->first(); @endphp
                        <tr>
                            <td class="ps-3" style="width: 170px;">No. Rek</td>
                            <td class="ps-3">{{ $header->id_rek }}</td>
                        </tr>
                        <tr>
                            <td class="ps-3" style="width: 170px;">No. PR</td>
                            <td class="ps-3">{{ $header->no_spb }}</td>
                        </tr>
                        <tr>
                            <td class="ps-3" style="width: 170px;">Nama Pengaju</td>
                            <td class="ps-3">{{ $header->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <td class="ps-3" style="width: 170px;">Department</td>
                            <td class="ps-3">{{ $header->nama_dep ?? $header->jabatan_receiver }}</td>
                        </tr>
                        <tr>
                            <td class="ps-3" style="width: 170px;">Tanggal Pengajuan</td>
                            <td class="ps-3">{{ $header->tgl_masuk }}</td>
                        </tr>
                        <tr>
                            <td class="ps-3" style="width: 170px;">Alasan</td>
                            <td class="ps-3">{{ $header->alasan_rek }}</td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="2" class="text-center">Data tidak ditemukan.</td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <h6 class="mt-4 mb-2 fw-bold">Detail Rekomendasi</h6>
            <table class="table table-bordered table-sm align-middle bg-light">
                <thead>
                    <tr>
                        <th class="ps-3">Jenis Unit</th>
                        <th class="ps-3">Keterangan</th>
                        <th class="ps-3">Estimasi Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($details) && count($details))
                        @foreach ($details as $detail)
                            <tr>
                                <td class="ps-3">{{ $detail->jenis_unit }}</td>
                                <td class="ps-3">{{ $detail->ket_unit }}</td>
                                <td class="ps-3">Rp. {{ number_format($detail->estimasi_harga, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3" class="text-center">Detail tidak ditemukan.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
        </script>
    </body>

</html>
