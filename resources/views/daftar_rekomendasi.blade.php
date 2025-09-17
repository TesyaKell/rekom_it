@extends('layouts.app')

@section('title', 'Daftar Rekomendasi')

@php
    $pageTitle = 'Daftar Rekomendasi';
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar Rekomendasi</title>

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
    </style>
</head>

<div class= "container-1">
    <div class="row-2">
        <div class="col-12">

        </div>
        <div class="row-2">
            <div class="col-12">
                <p class="pt-3 mt-3 ms-5 ps-5">Daftar Rekomendasi & Servis Komputer</p>
            </div>
        </div>
    </div>


    <body>

        <div class="container-2 w-auto h-100 ms-3 me-3 mt-3 pt-2 pb-2">
            <div class="row">
                <div class="col-4">
                    <form class="d-flex justify-content-start">
                        <input class="form-control w-50 me-2 ms-2 mt-2 mb-2" type="search" placeholder="Search"
                            aria-label="Search">
                        <button class="btn btn-outline-success w-15 h-25 mt-2" type="submit">Search</button>
                    </form>
                </div>

                <div class="col-4 d-flex justify-content-start">
                    <div class="dropdown mt-2">
                        <button type="button" class="btn dropdown-toggle fw-bold" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Semua Rekomendasi
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Semua Rekomendasi</a></li>
                            <li><a class="dropdown-item" href="#">Belum Realisasi</a></li>
                            <li><a class="dropdown-item" href="#">Sudah Realisasi</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-4 d-flex justify-content-end">
                    <a href="{{ url('add_rekomendasi') }}">
                        <button type="button" class="btn btn-success mt-2 mb-2 me-2 fw-bold fs-6">
                            Tambah Data Rekomendasi
                        </button>
                    </a>
                </div>
            </div>
        </div>



        <div class="container mt-4">
            <table class="table table-sm align-middle m-3">
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
                            <td class="ps-2">{{ $item->jabatan_receiver }}</td>
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
                                        id="dropdownMenuButton{{ $item->id_rek }}" data-bs-toggle="dropdown"
                                        id="dropdownMenuButton{{ $item->id_rek }}" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <span class="fw-bold fs-4 d-flex justify-content-center align-items-center"
                                            style="height: 100%;">⋮</span>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $item->id_rek }}">
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ url('/print/' . $item->id_rek) }}">Print</a>
                                        </li>
                                        <li>
                                            <button class="dropdown-item" data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $item->id_rek }}">
                                                Edit
                                            </button>
                                        </li>
                                        <li>
                                            <form action="{{ url("rekomendasi/{$item->id_rek}") }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this item?')"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">Hapus</button>
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

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
        </script>
    </body>

</html>
@endphp
