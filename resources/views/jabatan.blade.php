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
            background-color: #efefef;
        }

        .row .col,
        .col-4,
        .col-7,
        .col-2,
        .col-3,
        .col-8 {
            border: 1px solid #000;
            background-color: #fff;
            text-align: center;
            padding: 10px;
        }

        .container-header {
            margin-top: -20px;
        }

        .row-header .col-header {
            border-bottom: 2px solid #d8d8d8;
            background-color: #ffffff;
            text-align: left;
            margin-top: 15px;
        }

        p {
            text-align: left;
            font-size: 14px;
            font-weight: bold;
            color: #e8b200;
        }

        .row {
            margin-bottom: 0;
            margin-top: 0;
        }

        .tight-rows .row+.row {
            margin-top: -1px;
        }

        .table-grid .col {
            margin-bottom: 0;
            border-bottom: none;
        }

        .table-grid .row:last-child .col {
            border-bottom: 1px solid #000;
        }

        .form-control {
            border-radius: 0;
            border: #fff;
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
            <div class="container tight-rows table-grid mt-3 ms-3">
                <div class="row g-0 w-50">
                    <div class="col-4 d-flex align-items-center p-3 fw-bold">
                        Nomor Jabatan
                    </div>
                    <div class="col-8 d-flex align-items-center p-2">
                        <span class="form-control-plaintext">{{ $lastId + 1 }}</span>
                    </div>
                </div>

                @csrf
                <div class="row g-0 w-50">
                    <div class="col-4 d-flex justify-content-start p-3 fw-bold">Nama Jabatan</div>
                    <div class="col-8 p-2">
                        <input class="form-control" type="text" placeholder="Masukkan nama jabatan" name="nama_jab">
                    </div>
                </div>
                <div class="row g-0 w-50">
                    <div class="col">
                        <div class="d-flex gap-2 mt-2 justify-content-start">
                            <button type="submit" class="btn btn-success fw-bold fs-6">Tambah</button>
                        </div>
                    </div>
                </div>
        </form>
    </div>

    <div class="container mt-4 tight-rows table-grid ms-3">
        <div class="row g-0 row-cols-3 w-50" style="margin:0;">
            <div class="col-2 fw-bold p-2 border" style="min-width:70px;">No. Jab</div>
            <div class="col-7 fw-bold p-2 border">Nama Jabatan</div>
            <div class="col-2 fw-bold p-2 border" style="min-width:70px;">Action</div>
        </div>

        @if (isset($jabatans) && count($jabatans) > 0)
            @foreach ($jabatans as $jabatan)
                <div class="row g-0 row-cols-3 w-50" style="margin:0;">
                    <div class="col-2 border d-flex justify-content-start ps-3" style="min-width:70px;">
                        {{ $jabatan->id_jab }}
                    </div>

                    <div class="col-7 border d-flex justify-content-start ps-3">
                        {{ $jabatan->nama_jab }}
                    </div>

                    <div class="col-2 fw-bold p-2 border" style="min-width:70px;">
                        <div class="dropdown m-0">
                            <button class="btn btn-light border p-0" type="button"
                                id="dropdownMenuButton{{ $jabatan->id_jab }}" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <span class="fw-bold fs-4">⋮</span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $jabatan->id_jab }}">
                                <li>
                                    <button class="dropdown-item" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $jabatan->id_jab }}">
                                        Edit
                                    </button>
                                </li>

                                <li>
                                    <form action="{{ url("jabatan/{$jabatan->id_jab}") }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus jabatan ini?')"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger">Hapus</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="row g-0 w-75" style="margin:0;">
                <div class="col-12 text-center py-3 border">Tidak ada data jabatan</div>
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
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>

@extends('layouts.app')

@section('title', 'Jabatan')

@php
    $pageTitle = 'Jabatan';
@endphp
