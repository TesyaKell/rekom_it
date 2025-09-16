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
            font-weight: bold;
            color: #e8b200;
        }

        .container-2 {
            background-color: #ffffff;
            border-radius: 5px;
            width: 400px;
            height: 350px;
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
                <p class="pt-3 mt-3 ms-5 ps-5">LAPORAN REKOMENDASI & SERVIS UNIT KOMPUTER</p>
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
                            <input type="text" class="form-control" name="noRek" id="noRek"
                                value="{{ request('id_rek') }}" placeholder="Dari">
                            <span class="input-group-text">s/d</span>
                            <input type="text" class="form-control" name="noRek2" id="noRek2"
                                value="{{ request('id_rek') }}" placeholder="Sampai">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="tgl_awal" class="form-label">Periode Tanggal Masuk</label>
                        <div class="input-group">
                            <input type="date" class="form-control" name="tgl_awal" id="tgl_awal"
                                value="{{ request('tgl_awal') }}">
                            <span class="input-group-text">s/d</span>
                            <input type="date" class="form-control" name="tgl_akhir" id="tgl_akhir"
                                value="{{ request('tgl_akhir') }}">
                        </div>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <select class="form-select" name="jabatan" id="jabatan">
                            <option value="">Semua Jabatan</option>
                            @foreach ($jabatanList as $jabatan)
                                <option value="{{ $jabatan }}"
                                    {{ request('jabatan_receiver') == $jabatan ? 'selected' : '' }}>
                                    {{ $jabatan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12 d-flex align-items-end">
                        <button type="submit" class="btn btn-success w-50">Tampilkan</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="container-3 mt-3 mb-5 me-5 ms-5 p-2">
            <p class="ps-2 pt-2">* Hasil Pencarian : {{ $data->count() }} data</p>
            <table class="table table-bordered table-sm align-middle me-5 mt-3">
                <thead class="table-light">
                    <tr>
                        <th class="ps-2">No. Rek</th>
                        <th class="ps-2">No. PR</th>
                        <th class="ps-2">Jenis Unit</th>
                        <th class="ps-2">Nama Pengaju</th>
                        <th class="ps-2">Department</th>
                        <th class="ps-2">Tanggal Pengajuan</th>
                        <th class="ps-2">Status</th>
                        <th class="ps-2 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $item)
                        <tr>
                            <td class="ps-2">{{ $item->id_rek }}</td>
                            <td class="ps-2">{{ $item->no_spb }}</td>
                            <td class="ps-2">{{ $item->jenis_unit }}</td>
                            <td class="ps-2">{{ $item->nama_rek }}</td>
                            <td class="ps-2">{{ $item->jabatan }}</td>
                            <td class="ps-2">{{ $item->tgl_masuk }}</td>
                            <td class="ps-2">
                                @if ($item->status == 'menunggu verifikasi Kabag')
                                    <span class="badge text-light p-1"
                                        style="background-color: rgb(249, 137, 0);">Menunggu
                                        Kabag</span>
                                @elseif($item->status == 'menunggu verifikasi Tim IT')
                                    <span class="badge
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
                            <td>
                                <div class="dropdown d-flex justify-content-center align-items-center">
                                    <button class="btn btn-light border p-0" type="button"
                                        id="dropdownMenuButton{{ $item->id_sign }}" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <span class="fw-bold fs-4 d-flex justify-content-center align-items-center"
                                            style="height: 100%;">⋮</span>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $item->id_sign }}">
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ url("item/{$item->id_sign}/edit") }}">Edit</a>
                                        </li>
                                        <li>
                                            <form action="{{ url("item/{$item->id_sign}") }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this item?')"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="dropdown-item text-danger">Hapus</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
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

@section('title', 'Laporan Rekomendasi & Servis Unit Komputer')

@php
    $pageTitle = 'Laporan Rekomendasi & Servis Unit Komputer';
@endphp
