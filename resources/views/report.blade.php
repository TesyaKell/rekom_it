<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report</title>

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
            color: #e8b200;
            font-weight: 600;
        }

        .container-2 {
            background-color: #ffffff;
            border-radius: 5px;
            width: 440px;
            height: 350px;
        }

        .container-5 {
            background-color: #ffa74844;
            border-radius: 5px;
            width: 1150px;
            height: 50px;
        }

        .container-3 {
            background-color: #ffffff;
            border-radius: 5px;
            width: 1150px;
            height: auto;
        }

        title {
            font-weight: bold;
        }

        tr {
            background-color: #ffffff;
        }

        th,
        td {
            font-size: 14px;
        }

        .col-md-4 {
            background: #ffffff;
        }

        label {
            font-size: 15px;
            font-weight: bold;
        }
    </style>
</head>

<div class= "container-1">
    <div class="row-2">
        <div class="col-12">

        </div>
        <div class="row-2">
            <div class="col-12">
                <p class="pt-3 mt-3 ms-5 ps-5 fw-bold">LAPORAN REKOMENDASI & SERVIS UNIT KOMPUTER</p>
            </div>
        </div>
    </div>


    <body>
        <div class="container-2 mt-4 mb-5 me-5 ms-5 p-4">
            <form method="GET" action="{{ route('report') }}" class="mb-4">
                <div class="row g-3">

                    <div class="col-md-12">
                        <label for="noRek" class="form-label">No. Rekomendasi</label>
                        <div class="input-group">
                            <input class="form-check-input me-3" type="checkbox" value="" id="flexCheckDefault">
                            <input type="text" class="form-control" name="noRek" id="noRek"
                                value="{{ request('noRek') }}" placeholder="Dari">
                            <span class="input-group-text">s/d</span>
                            <input type="text" class="form-control" name="noRek2" id="noRek2"
                                value="{{ request('noRek2') }}" placeholder="Sampai">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label for="tgl_awal" class="form-label">Periode Tanggal Masuk</label>
                        <div class="input-group">
                            <input class="form-check-input me-3" type="checkbox" value="" id="flexCheckDefault">
                            <input type="date" class="form-control" name="tgl_awal" id="tgl_awal"
                                value="{{ request('tgl_awal') }}">
                            <span class="input-group-text">s/d</span>
                            <input type="date" class="form-control" name="tgl_akhir" id="tgl_akhir"
                                value="{{ request('tgl_akhir') }}">
                        </div>
                    </div>

                    <div class="col-md-12 mb-2">
                        <label for="department" class="form-label">Department</label>
                        <div class="input-group">
                            <input class="form-check-input me-3" type="checkbox" value="" id="flexCheckDefault">
                            <select class="form-select" name="department" id="department">
                                <option value="">Semua Department</option>
                                @foreach ($departmentList ?? [] as $department)
                                    <option value="{{ $department }}"
                                        {{ request('department') == $department ? 'selected' : '' }}>
                                        {{ $department }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12 d-flex align-items-end">
                        <button type="submit" class="btn btn-success w-50">Tampilkan</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="container-5 me-5 ms-5">
            <p class="p-3 mt-4" style="color: #e68e00">* Hasil Pencarian : {{ $results->count() }} data</p>
        </div>

        <div class="container-3 mt-3 mb-5 me-5 ms-5 p-2">

            <table class="table table-bordered table-sm align-middle me-5 mt-3">
                <thead class="table-light">
                    <tr>
                        <th class="ps-2">No. Rek</th>
                        <th class="ps-2">No. PR</th>
                        <th class="ps-2">Jenis Unit</th>
                        <th class="ps-2">Keterangan</th>
                        <th class="ps-2">Alasan</th>
                        <th class="ps-2">Estimasi Harga</th>
                        <th class="ps-2">Nama Pengaju</th>
                        <th class="ps-2">Jabatan</th>
                        <th class="ps-2">Tanggal Pengajuan</th>
                        <th class="ps-2">Status</th>
                        <th class="ps-2">Tangal Realisasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($results as $item)
                        <tr>
                            <td class="ps-2">{{ $item->id_rek }}</td>
                            <td class="ps-2">{{ $item->no_spb }}</td>
                            <td class="ps-2">{{ $item->jenis_unit }}</td>
                            <td class="ps-2">{{ $item->ket_unit }}</td>
                            <td class="ps-2">{{ $item->alasan_rek }}</td>
                            <td class="ps-2">{{ $item->estimasi_harga }}</td>
                            <td class="ps-2">{{ $item->nama_rek }}</td>
                            <td class="ps-2">{{ $item->jabatan_receiver }}</td>

                            <td class="ps-2">{{ $item->tgl_masuk }}</td>
                            <td class="ps-2">
                                @if ($item->status == 'menunggu verifikasi Kabag')
                                    <span class="badge text-light p-1"
                                        style="background-color: rgb(249, 137, 0);">Menunggu
                                        Kabag</span>
                                @elseif($item->status == 'menunggu verifikasi Tim IT')
                                    <span
                                        class="badge
                                        bg-orange text-light p-1"
                                        style="background-color: rgb(41, 63, 230);">Menunggu
                                        Tim IT</span>
                                @elseif($item->status == 'Ditolak')
                                    <span class="badge bg-danger p-1">Ditolak</span>
                                @elseif($item->status == 'Diterima')
                                    <span class="badge bg-success p-1">Diterima</span>
                                @else
                                    <span class="badge bg-secondary">{{ $item->status }}</span>
                                @endif
                            </td>

                            <td class="ps-2">{{ $item->tgl_verif }}</td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Data tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
        </script>
    </body>

</html>

@extends('layouts.app')

@section('title', 'Laporan Rekomendasi')

@php
    $pageTitle = 'Laporan Rekomendasi';
@endphp
