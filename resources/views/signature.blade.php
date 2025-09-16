<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Signature</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


    <style>
        body {
            background-color: #efefef;
        }

        .row .col {
            border: 1px solid #000;
            background-color: #fff;
            text-align: center;
            padding: 10px;
        }

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

        .container-1 {
            margin-top: -20px;
        }

        .row-2 .col-12 {
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

        .container-2 {
            background-color: #ffffff;
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
    </style>
</head>

<body>

    <div class="container-1">
        <div class="row-2">
            <div class="row-2">
                <div class="col-12">
                    <p class="pt-3 ms-5 ps-5">Daftar signature</p>
                </div>
            </div>
        </div>

        <div class="container tight-rows table-grid mt-3 ms-3">
            <div class="row g-0 w-50">
                <div class="col-4 d-flex justify-content-start p-3 fw-bold">
                    Nomor signature
                </div>
                <div class="col-8"></div>
            </div>
            <div class="row g-0 w-50">
                <div class="col-4 d-flex justify-content-start p-3 fw-bold">Nama Lengkap</div>
                <div class="col-8 p-2"><input class="form-control" type="text" placeholder="Masukkan nama signature">
                </div>
            </div>
            <div class="row g-0 w-50">
                <div class="col-4 d-flex justify-content-start p-3 fw-bold">Jabatan</div>
                <div class="col-8 p-2"><input class="form-control" type="text" placeholder="Masukkan nama signature">
                </div>
            </div>
            <div class="row g-0 w-50">
                <div class="col">
                    <div class="d-flex gap-2 mt-2 justify-content-start">
                        <a href="{{ route('signature.create') }}" class="btn btn-success fw-bold fs-6">Tambah</a>
                        <button type="button" class="btn btn-danger fw-bold fs-6">Batal</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mt-4 tight-rows table-grid ms-3">
            <div class="row g-0 row-cols-3 w-50" style="margin:0;">
                <div class="col-3 fw-bold p-2 border" style="min-width:70px;">No. Signature</div>
                <div class="col-7 fw-bold p-2 border">Nama Lengkap</div>
                <div class="col-7 fw-bold p-2 border">Jabatan</div>
                <div class="col-2 fw-bold p-2 border" style="min-width:70px;">Action</div>
            </div>

            @if (isset($signatures) && count($signatures) > 0)
                @foreach ($signatures as $signature)
                    <div class="row g-0 row-cols-3 w-50" style="margin:0;">
                        <div class="col-3 border d-flex justify-content-start ps-3" style="min-width:70px;">
                            {{ $signature->id_sign }}</div>
                        <div class="col-7 border d-flex justify-content-start ps-3">{{ $signature->nama_approval }}
                        </div>
                        <div class="col-2 fw-bold p-2 border" style="min-width:70px;">
                            <div class="dropdown m-0">
                                <button class="btn btn-light border p-0" type="button"
                                    id="dropdownMenuButton{{ $signature->id_sign }}" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <span class="fw-bold fs-4">⋮</span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $signature->id_sign }}">
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ url("signature/{$signature->id_sign}/edit") }}">Edit</a>
                                    </li>
                                    <li>
                                        <form action="{{ url("signature/{$signature->id_sign}") }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this signature?')"
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
                    <div class="col-12 text-center py-3 border">Tidak ada data signature</div>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Edit signature -->
    <div class="modal fade" id="editsignatureModal" tabindex="-1" aria-labelledby="editsignatureModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form id="editsignatureForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editsignatureModalLabel">Edit Nama signature</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="editsignatureId" name="id">

                        <div class="mb-3">
                            <label for="editKodeDep" class="form-label">No. signature</label>
                            <div class="col-3 border d-flex justify-content-start ps-3" style="min-width:70px;"
                                name="id_sign">
                                {{ $signature->id_sign }}</div>
                        </div>

                        <div class="mb-3">
                            <label for="editNamaDep" class="form-label">Nama signature</label>
                            <input type="text" class="form-control" id="editNamaDep" name="nama_approval"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Tangkap klik tombol Edit
        document.querySelectorAll('.dropdown-item[href*="edit"]').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                // Ambil data dari baris yang diklik
                var row = btn.closest('.row');
                var id_sign = row.querySelector('.col-3').textContent.trim();
                var nama_approval = row.querySelector('.col-7').textContent.trim();

                // Isi modal dengan data
                document.getElementById('editNamaDep').value = nama_approval;
                document.getElementById('editsignatureForm').action = '/signature/' + id_sign;
                document.getElementById('editsignatureId').value = id_sign;

                // Tampilkan modal
                var modal = new bootstrap.Modal(document.getElementById('editsignatureModal'));
                modal.show();
            });
        });
    </script>
    <!-- Bootstrap JS for dropdown functionality -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>

@extends('layouts.app')

@section('title', 'Signature')

@php
    $pageTitle = 'Signature';
@endphp
