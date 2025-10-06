@extends('layouts.app')

@section('title', 'Deleted Rekomendasi')

@php
    $pageTitle = 'Deleted Rekomendasi';
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Deleted Rekomendasi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


    <style>
        .container-header {
            margin-top: -20px;
        }

        .row-header .col-header {
            border-bottom: 2px solid #d8d8d8;
            background-color: #ffffff;
            text-align: left;
        }

        p {
            text-align: left;
            font-size: 14px;
            font-weight: bold;
            color: #0d606e;
        }

        .container-deleted {
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: #0d606e 2px 2px 8px;
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

<div class= "container-header">
    <div class="row-header">
        <div class="col-header">
            <p class="pt-3 mt-3 ms-5 ps-5">DAFTAR DELETED REKOMENDASI</p>
        </div>
    </div>


    <body>
        <div class="container-deleted w-90 h-100 ms-3 me-3 mt-3 pt-2 pb-2 overflow-auto" style="max-width: 100%;">
            <div class="table-responsive ms-3 me-3 mt-2 mb-2">
                <table class="table table-sm align-middle m-3">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-2">No. Rek</th>
                            <th class="ps-2">No. PR</th>
                            <th class="ps-2">Nama Unit</th>
                            <th class="ps-2">Dibuat Oleh</th>
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
                                <td class="ps-2">{{ $item->nama_lengkap }}</td>
                                <td class="ps-2">{{ $item->nama_dep }}</td>
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
                                            style="background-color: rgb(249, 137, 0);">Menunggu
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
                                            aria-expanded="false">
                                            <span class="fw-bold fs-4 d-flex justify-content-center align-items-center"
                                                style="height: 100%;">⋮</span>
                                        </button>
                                        <ul class="dropdown-menu"
                                            aria-labelledby="dropdownMenuButton{{ $item->id_rek }}">
                                            <li>
                                                <form action="{{ route('rekomendasi.restore', $item->id_rek) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin mengembalikan data ini?')"
                                                    style="display:inline;">
                                                    @csrf
                                                    <button type="submit"
                                                        class="dropdown-item text-success">Restore</button>
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
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
        </script>
    </body>

</html>
