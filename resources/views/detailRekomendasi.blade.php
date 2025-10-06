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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(120deg, #fff 60%, #0d606e 100%);
        }



        p {
            text-align: left;
            font-size: 14px;
            font-weight: bold;
            color: #0d606e;
        }

        .container-header {
            margin-top: 0;
        }

        .row-header .col-header {
            border-bottom: 2px solid #d8d8d8;
            background-color: #ffffff;
            text-align: left;
        }

        .card-rekomendasi,
        .card-detail {
            margin-top: 10px;
            margin-bottom: 10px;
            box-shadow: #0d606e 2px 2px 8px;
            border-radius: 10px;
        }

        .card-rekomendasi .card-body-rekomendasi,
        .card-detail .card-body-detail {
            background-color: #fff;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.07);
            border-radius: 12px;
            padding: 24px;
            transition: box-shadow 0.2s;
        }

        .card-rekomendasi .card-body-rekomendasi:hover,
        .card-detail .card-body-detail:hover {
            box-shadow: 0 8px 24px rgba(232, 178, 0, 0.13);
        }

        h6 {
            color: #212121;
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 12px;
        }

        table {
            background-color: #f9f9f9;
            border-radius: 8px;
            overflow: hidden;
        }

        th {
            background-color: #fffbe6;
            color: #323232;
            font-size: 14px;
            font-weight: 600;
            border-bottom: 2px solid #e8b200;
        }

        tr {
            background-color: #ffffff;
            transition: background 0.2s;
        }

        tr:hover {
            background-color: #fffbe6;
        }

        td {
            font-size: 13px;
            vertical-align: middle;
        }

        .btn-primary {
            background-color: #e8b200;
            border: none;
            color: #fff;
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: #c49c00;
        }

        .masukan-input {
            border-radius: 6px;
            border: 1px solid #e8b200;
        }

        .text-success {
            color: #2e7d32 !important;
            font-weight: 500;
        }

        .table thead th {
            background: #0d606e;
            color: #fff;
            font-weight: bold;
        }

        .text-muted {
            color: #bdbdbd !important;
        }

        @media (max-width: 900px) {
            .card-detail .card-body-detail {
                width: 100%;
                padding: 10px;

            }

            .card-rekomendasi .card-body-rekomendasi {
                width: 100%;
                padding: 10px;
            }

            .container {
                padding: 0;
            }
        }
    </style>
</head>



<body>
    <div class= "container-header">
        <div class="row-header">
            <div class="col-header">
                <p class="pt-3 ms-5 ps-5">DETAIL REKOMENDASI</p>
            </div>
        </div>



        <div class="container mt-1 mb-5 me-5 ms-5 p-2">
            <h6 class="mt-3 mb-2 fw-bold" style="color:#ffa800;"></i>Rekomendasi</h6>
            <div class="card-rekomendasi">
                <div class="card-body-rekomendasi">
                    <table class="table table-bordered table-sm align-middle bg-light" style="width: 100%;">
                        <tbody class="table-light">
                            @if ($data->count())
                                @php $header = $data->first(); @endphp
                                <tr>
                                    <td class="ps-3 p-2" style="width: 170px;">No. Rek</td>
                                    <td class="ps-3">{{ $header->id_rek }}</td>
                                </tr>
                                <tr>
                                    <td class="ps-3 p-2" style="width: 170px;">No. PR</td>
                                    <td class="ps-3">{{ $header->no_spb }}</td>
                                </tr>
                                <tr>
                                    <td class="ps-3 p-2" style="width: 170px;">Dibuat Oleh</td>
                                    <td class="ps-3">{{ $header->nama_lengkap }}</td>
                                </tr>
                                <tr>
                                    <td class="ps-3 p-2" style="width: 170px;">Department</td>
                                    <td class="ps-3">{{ $header->nama_dep ?? $header->jabatan_receiver }}</td>
                                </tr>
                                <tr>
                                    <td class="ps-3 p-2" style="width: 170px;">Tanggal Pengajuan</td>
                                    <td class="ps-3">{{ $header->tgl_masuk }}</td>
                                </tr>
                                <tr>
                                    <td class="ps-3 p-2" style="width: 170px;">Alasan</td>
                                    <td class="ps-3">{{ $header->alasan_rek }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="2" class="text-center">Data tidak ditemukan.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <h6 class="mt-4 mb-2 fw-bold" style="color:#ffa800;"></i>Detail Rekomendasi</h6>
            <div class="card-detail">
                <div class="card-body-detail">
                    <table class="table table-bordered table-sm align-middle bg-light">
                        <thead>
                            <tr>
                                <th class="ps-3">Nama Unit</th>
                                <th class="ps-3">Keterangan</th>
                                <th class="ps-3">Estimasi Harga</th>
                                @if (session('loginRole') === 'IT')
                                    <th class="ps-3">Berikan Masukan</th>
                                @elseif (session('loginRole') === 'Kabag')
                                    <th class="ps-3">Berikan Masukan Kabag</th>
                                @else
                                    <th class="ps-3">Masukan dari Tim IT</th>
                                @endif
                                <th class="ps-3">Tanggal Realisasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($details) && count($details))
                                @foreach ($details as $detail)
                                    <tr>
                                        <td class="ps-3">{{ $detail->jenis_unit }}</td>
                                        <td class="ps-3">{{ $detail->ket_unit }}</td>
                                        <td class="ps-3">Rp. {{ number_format($detail->estimasi_harga, 0, ',', '.') }}
                                        </td>
                                        @if (session('loginRole') === 'IT')
                                            <td class="ps-3">
                                                @if ($detail->masukan_it)
                                                    <span class="text-success">{{ $detail->masukan_it }}</span>
                                                @else
                                                    @if ($status == 'menunggu verifikasi Tim IT')
                                                        <form method="POST"
                                                            action="{{ route('detailRekomendasi.masukan', $detail->id_detail_rekomendasi) }}"
                                                            class="d-flex align-items-center masukan-form">
                                                            @csrf
                                                            <input class="form-control me-2 masukan-input"
                                                                type="text" name="masukan_it"
                                                                placeholder="Berikan masukan IT">
                                                            <button type="submit"
                                                                class="btn btn-sm btn-primary">Simpan</button>
                                                        </form>
                                                    @else
                                                        <span class="text-muted">Belum bisa beri masukan karena belum di
                                                            ACC Kabag</span>
                                                    @endif
                                                @endif
                                            </td>
                                        @elseif (session('loginRole') === 'Kabag')
                                            <td class="ps-3">
                                                @if ($detail->masukan_kabag)
                                                    <span class="text-success">{{ $detail->masukan_kabag }}</span>
                                                @else
                                                    @if ($status == 'menunggu verifikasi Kabag')
                                                        <form method="POST"
                                                            action="{{ route('detailRekomendasi.masukan', $detail->id_detail_rekomendasi) }}"
                                                            class="d-flex align-items-center masukan-form">
                                                            @csrf
                                                            <input class="form-control me-2 masukan-input"
                                                                type="text" name="masukan_kabag"
                                                                placeholder="Berikan masukan Kabag">
                                                            <button type="submit"
                                                                class="btn btn-sm btn-primary">Simpan</button>
                                                        </form>
                                                    @else
                                                        <span class="text-muted">sudah di acc</span>
                                                    @endif
                                                @endif
                                            </td>
                                        @else
                                            <td class="ps-3">
                                                @if ($detail->masukan_it)
                                                    <span class="text-success">{{ $detail->masukan_it }}</span>
                                                @else
                                                    <span class="text-muted">Belum ada masukan</span>
                                                @endif
                                            </td>
                                        @endif
                                        <td class="ps-3">
                                            @if ($detail->tanggal_realisasi)
                                                {{ $detail->tanggal_realisasi }}
                                            @else
                                                <span class="text-muted">Belum Terealisasi</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">Detail tidak ditemukan.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
        </script>
</body>

</html>
