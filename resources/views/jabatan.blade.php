<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Jabatan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        body {
            background: linear-gradient(120deg, #fff 60%, #0d606e 100%);
            min-height: 100vh;
        }

        .container-header {
            margin-top: -20px;
        }

        .row-header .col-header {
            background: white;
            text-align: left;
            margin-top: 16px;
            border-radius: 12px 12px 0 0;
            box-shadow: 0 2px 8px #0d606e22;
            border-bottom: 2px solid #d8d8d8;
        }

        p {
            text-align: left;
            font-size: 14px;
            font-weight: bold;
            color: #0d606e;
            letter-spacing: 1px;
        }

        .container-post,
        .container-data {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 16px #0d606e22;
            padding: 18px 24px;
            margin-bottom: 24px;
            border: 1.5px solid #0d606e;
        }

        .container-post {
            width: 45%;
        }

        .container-data {
            width: 65%;
        }

        .row .col,
        .col-4,
        .col-7,
        .col-2,
        .col-3,
        .col-8,
        .col-5 {
            border: none;
            background: none;
            text-align: left;
            padding: 10px 12px;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #0d606e;
            background: #fff;
            font-size: 15px;
        }

        .form-label {
            font-weight: 600;
            color: #0d606e;
        }

        .btn-success {
            background-color: #0d606e;
            border: none;
            color: #fff;
        }

        .btn-success:hover {
            background-color: #ffa800;
            color: #fff;
        }

        .btn-danger {
            background-color: #ffa800;
            border: none;
            color: #fff;
        }

        .btn-danger:hover {
            background-color: #0d606e;
            color: #fff;
        }

        .btn-primary {
            background-color: #ffa800;
            border: none;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #0d606e;
            color: #fff;
        }

        .dropdown-menu {
            border-radius: 8px;
            border: 1px solid #ffa800;
        }

        .fw-bold {
            color: #0d606e;
        }


        .jabatan-row {
            background: #fff;
            border-bottom: 1px solid #0d606e22;
            transition: box-shadow 0.2s;
        }

        .jabatan-row:hover {
            box-shadow: 0 2px 12px #ffa80033;
            background: #f8fafc;
        }

        .modal-header {
            background: linear-gradient(90deg, #0d606e 70%, #ffa800 100%);
            color: #fff;
            border-radius: 12px 12px 0 0;
        }

        .modal-title {
            color: #ffffff !important;
        }

        .form-select {
            border-radius: 8px;
            border: 1px solid #0d606e;
        }

        .modal-backdrop.show {
            opacity: 0.2 !important;
        }
    </style>
</head>

<body>

    <div class="container-header">
        <div class="row-header">
            <div class="col-header">
                <p class="pt-3 ms-5 ps-5">DAFTAR JABATAN</p>
            </div>
        </div>
        <form method="POST" action="/jabatan">
            <div class="container-post tight-rows table-grid mt-3 ms-3">
                <div class="row g-0 w-100">
                    <div class="col-4 d-flex align-items-center fw-bold">
                        Nomor Jabatan
                    </div>
                    <div class="col-8 d-flex align-items-center">
                        <span class="fw-bold" style="color:#ffa800">{{ $lastId + 1 }}</span>
                    </div>
                </div>
                @csrf
                <div class="row g-0 w-100">
                    <div class="col-4 d-flex align-items-center fw-bold">Nama Jabatan</div>
                    <div class="col-8">
                        <input class="form-control" type="text" placeholder="Masukkan nama jabatan" name="nama_jab">
                    </div>
                </div>
                <div class="row g-0 w-100">
                    <div class="col">
                        <div class="d-flex gap-2 mt-2 justify-content-end" style="margin-right: -12px">
                            <button type="submit" class="btn btn-success fw-bold fs-6">Tambah</button>
                        </div>
                    </div>
                </div>
        </form>
    </div>
    <div class="container-data mt-4 tight-rows table-grid ms-3">
        <div class="row g-0 mb-2 d-flex justify-content-end" style="width: 195px;">
            <div class="col text-end" style="border: none; background: none;">
                <label for="showCount" class="me-2 fw-bold" style="color:#ffa800;">Tampilkan</label>
                <select id="showCount" class="form-select d-inline-block w-auto" style="width:80px;">
                    <option value="6">5</option>
                    <option value="11">10</option>
                    <option value="16">15</option>
                    <option value="21">20</option>
                    <option value="51">50</option>
                    <option value="101">100</option>
                </select>
            </div>
        </div>
        <div class="row g-0 row-cols-3 w-100 table-header jabatan-row" style="margin:0;">
            <div class="col-2 fw-bold p-2 text-start" style="min-width:70px;">No. Jab</div>
            <div class="col-7 fw-bold p-2 text-start">Nama Jabatan</div>
            <div class="col-2 fw-bold p-2" style="min-width:70px;">Action</div>
        </div>
        @if (isset($jabatans) && count($jabatans) > 0)
            @foreach ($jabatans as $jabatan)
                <div class="row g-0 row-cols-3 w-100 jabatan-row" style="margin:0;">
                    <div class="col-2 d-flex justify-content-start ps-3" style="min-width:70px;">
                        <span style="color:#000000">{{ $jabatan->id_jab }}</span>
                    </div>
                    <div class="col-7 d-flex justify-content-start ps-3">{{ $jabatan->nama_jab }}</div>
                    <div class="col-2 fw-bold p-2">
                        <div class="dropdown m-0">
                            <button class="btn btn-light border p-0" type="button"
                                id="dropdownMenuButton{{ $jabatan->id_jab }}" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <span class="fw-bold fs-4" style="color:#0d606e">⋮</span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $jabatan->id_jab }}">
                                <li>
                                    <button class="dropdown-item" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $jabatan->id_jab }}">
                                        Edit
                                    </button>
                                </li>

                                <li>
                                    <button type="button" class="dropdown-item text-danger fw-bold"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteJabatanModal{{ $jabatan->id_jab }}">
                                        Hapus
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="row g-0 w-75" style="margin:0;">
                <div class="col-12 text-center py-3">Tidak ada data jabatan</div>
            </div>
        @endif
    </div>
    </div>

    <!-- Modal Edit Jabatan -->
    @foreach ($jabatans as $jabatan)
        <div class="modal fade" id="editModal{{ $jabatan->id_jab }}" tabindex="-1"
            aria-labelledby="editModalLabel{{ $jabatan->id_jab }}" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('jabatan.update', $jabatan->id_jab) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel{{ $jabatan->id_jab }}">Edit Jabatan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">No. Jabatan</label>
                                <input type="text" class="form-control" value="{{ $jabatan->id_jab }}" disabled>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Jabatan</label>
                                <input type="text" class="form-control" name="nama_jab"
                                    value="{{ $jabatan->nama_jab }}" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach

    <!-- Modal Hapus Jabatan -->
    @foreach ($jabatans as $item)
        <div class="modal fade" id="deleteJabatanModal{{ $item->id_jab }}" tabindex="-1"
            aria-labelledby="deleteJabatanModalLabel{{ $item->id_jab }}" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ url("jabatan/{$item->id_jab}") }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteJabatanModalLabel{{ $item->id_jab }}">
                                Konfirmasi Hapus Jabatan
                            </h5>
                        </div>
                        <div class="modal-body">
                            Apakah anda yakin ingin menghapus jabatan ini?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const showCount = document.getElementById('showCount');
            const rows = document.querySelectorAll('.jabatan-row');

            function updateRows() {
                const count = parseInt(showCount.value);
                rows.forEach((row, idx) => {
                    row.style.display = idx < count ? '' : 'none';
                });
            }
            showCount.addEventListener('change', updateRows);
            updateRows();
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>

@extends('layouts.app')

@section('title', 'Jabatan')

@php
    $pageTitle = 'Jabatan';
@endphp
