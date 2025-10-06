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
            width: 50%;
        }

        .container-data {
            width: 75%;
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

        .table-header {
            background: linear-gradient(90deg, #0d606e 70%, #ffa800 100%);
            color: #fff;
            font-weight: bold;
            border-radius: 8px 8px 0 0;
        }

        .signature-row {
            background: #fff;
            border-bottom: 1px solid #0d606e22;
            border-radius: 0 0 8px 8px;
            transition: box-shadow 0.2s;
        }

        .signature-row:hover {
            box-shadow: 0 2px 12px #ffa80033;
            background: #f8fafc;
        }

        .modal-header {
            background: linear-gradient(90deg, #0d606e 70%, #ffa800 100%);
            color: #fff;
            border-radius: 12px 12px 0 0;
        }

        .modal-title {
            color: #ffa800 !important;
        }

        .form-select {
            border-radius: 8px;
            border: 1px solid #0d606e;
        }
    </style>
</head>

<body>

    <div class="container-header">
        <div class="row-header">
            <div class="col-header">
                <p class="pt-3 ms-5 ps-5">DAFTAR SIGNATURE</p>
            </div>
        </div>
        <form method="POST" action="/signature" enctype="multipart/form-data">
            <div class="container-post tight-rows table-grid mt-3 ms-3">
                <div class="row g-0 w-100">
                    <div class="col-4 d-flex align-items-center fw-bold">
                        Nomor signature
                    </div>
                    <div class="col-8 d-flex align-items-center">
                        <span class="fw-bold" style="color:#ffa800">{{ $lastId + 1 }}</span>
                    </div>
                </div>
                @csrf
                <div class="row g-0 w-100">
                    <div class="col-4 d-flex align-items-center fw-bold">Nama Lengkap</div>
                    <div class="col-8">
                        <input class="form-control" type="text" placeholder="Masukkan nama signature"
                            name="nama_approval">
                    </div>
                </div>
                <div class="row g-0 w-100">
                    <div class="col-4 d-flex align-items-center fw-bold">Jabatan</div>
                    <div class="col-8">
                        <select class="form-select" name="jabatan" required>
                            <option value="">Pilih jabatan</option>
                            @foreach ($department as $jabatan)
                                <option value="{{ $jabatan }}">{{ $jabatan }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row g-0 w-100">
                    <div class="col-4 d-flex align-items-center fw-bold">Tanda Tangan</div>
                    <div class="col-8">
                        <input class="form-control" type="file" name="sign" accept="image/*">
                    </div>
                </div>
                <div class="row g-0 w-100">
                    <div class="col">
                        <div class="d-flex gap-2 mt-2 justify-content-end">
                            <button type="submit" class="btn btn-success fw-bold fs-6">Tambah</button>
                        </div>
                    </div>
                </div>
        </form>
    </div>

    <div class="container-data mt-4 tight-rows table-grid ms-3">
        <div class="row g-0 row-cols-4 w-100 table-header signature-row" style="margin:0;">
            <div class="col-2 fw-bold p-2 text-start" style="min-width:70px;">No. Sign</div>
            <div class="col-4 fw-bold p-2 text-start">Nama Lengkap</div>
            <div class="col-4 fw-bold p-2 text-start">Jabatan</div>
            <div class="col-2 fw-bold p-2" style="min-width:70px;">Action</div>
        </div>
        @if (isset($signatures) && count($signatures) > 0)
            @foreach ($signatures as $signature)
                <div class="row g-0 row-cols-4 w-100 signature-row" style="margin:0;">
                    <div class="col-2 d-flex justify-content-start ps-3" style="min-width:70px;">
                        {{ $signature->id_sign }}
                    </div>
                    <div class="col-4 d-flex justify-content-start ps-3">{{ $signature->nama_approval }}</div>
                    <div class="col-4 d-flex justify-content-start ps-3">{{ $signature->jabatan }}</div>
                    <div class="col-2 fw-bold p-2">
                        <div class="dropdown m-0">
                            <button class="btn btn-light border p-0" type="button"
                                id="dropdownMenuButton{{ $signature->id_sign }}" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <span class="fw-bold fs-4" style="color:#0d606e">⋮</span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $signature->id_sign }}">
                                <li>
                                    <button class="dropdown-item" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $signature->id_sign }}">
                                        Edit
                                    </button>
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
            <div class="row g-0 w-100" style="margin:0;">
                <div class="col-12 text-center py-3">Tidak ada data signature</div>
            </div>
        @endif
    </div>
    </div>


    @foreach ($signatures as $signature)
        <div class="modal fade" id="editModal{{ $signature->id_sign }}" tabindex="-1"
            aria-labelledby="editModalLabel{{ $signature->id_sign }}" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('signature.update', $signature->id_sign) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel{{ $signature->id_sign }}">Edit Signature</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">No. signature</label>
                                <input type="text" class="form-control" value="{{ $signature->id_sign }}"
                                    disabled>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama signature</label>
                                <input type="text" class="form-control" name="nama_approval"
                                    value="{{ $signature->nama_approval }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jabatan</label>
                                <select class="form-control" name="jabatan" required>
                                    <option value="">Pilih jabatan</option>
                                    @foreach ($department as $jabatan)
                                        <option value="{{ $jabatan }}">{{ $jabatan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row g-0 w-100">
                                <div class="col-4 d-flex align-items-center fw-bold">Tanda Tangan</div>
                                <div class="col-8">
                                    <input class="form-control" type="file" name="sign" accept="image/*">
                                </div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>

@extends('layouts.app')

@section('title', 'Signature')

@php
    $pageTitle = 'Signature';
@endphp
