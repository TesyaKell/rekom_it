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

    <div class="container-header">
        <div class="row-header">
            <div class="col-header">
                <p class="pt-3 ms-5 ps-5">DAFTAR SIGNATURE</p>
            </div>
        </div>


        <form method="POST" action="/signature" enctype="multipart/form-data">
            <div class="container tight-rows table-grid mt-3 ms-3">
                <div class="row g-0 w-50">
                    <div class="col-4 d-flex align-items-center p-3 fw-bold">
                        Nomor signature
                    </div>
                    <div class="col-8 d-flex align-items-center p-2">
                        <span class="form-control-plaintext">{{ $lastId + 1 }}</span>
                    </div>
                </div>

                @csrf
                <div class="row g-0 w-50">
                    <div class="col-4 d-flex justify-content-start p-3 fw-bold">Nama Lengkap</div>
                    <div class="col-8 p-2"><input class="form-control" type="text"
                            placeholder="Masukkan nama signature" name="nama_approval">
                    </div>
                </div>
                <div class="row g-0 w-50">
                    <div class="col-4 d-flex justify-content-start p-3 fw-bold">Jabatan</div>
                    <div class="col-8 p-2">
                        <select class="form-control" name="jabatan" required>
                            <option value="">Pilih jabatan</option>
                            @foreach ($department as $jabatan)
                                <option value="{{ $jabatan }}">{{ $jabatan }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row g-0 w-50">
                    <div class="col-4 d-flex justify-content-start p-3 fw-bold">Tanda Tangan</div>
                    <div class="col-8 p-2">
                        <input class="form-control" type="file" name="sign" accept="image/*">
                    </div>
                </div>
                <div class="row g-0 w-50">
                    <div class="col">
                        <div class="d-flex gap-2 mt-2 justify-content-start">
                            <button type="submit" class="btn btn-success fw-bold fs-6">Tambah</button>
                            {{-- <button type="button" class="btn btn-danger fw-bold fs-6">Batal</button> --}}
                        </div>
                    </div>
                </div>
        </form>
    </div>

    <div class="container mt-4 tight-rows table-grid ms-3">
        <div class="row g-0 row-cols-4 w-50" style="margin:0;">
            <div class="col-2 fw-bold p-2 border" style="min-width:70px;">No. Sign</div>
            <div class="col-4 fw-bold p-2 border">Nama Lengkap</div>
            <div class="col-4 fw-bold p-2 border">Jabatan</div>
            <div class="col-2 fw-bold p-2 border" style="min-width:70px;">Action</div>
        </div>

        @if (isset($signatures) && count($signatures) > 0)
            @foreach ($signatures as $signature)
                <div class="row g-0 row-cols-3 w-50" style="margin:0;">
                    <div class="col-2 border d-flex justify-content-start ps-3" style="min-width:70px;">
                        {{ $signature->id_sign }}</div>

                    <div class="col-4 border d-flex justify-content-start ps-3">{{ $signature->nama_approval }}
                    </div>

                    <div class="col-4 border d-flex justify-content-start ps-3">{{ $signature->jabatan }}
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
            <div class="row g-0 w-75" style="margin:0;">
                <div class="col-12 text-center py-3 border">Tidak ada data signature</div>
            </div>
        @endif
    </div>
    </div>

    <!-- Modal Edit signature -->
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
                                <input type="text" class="form-control" name="jabatan"
                                    value="{{ $signature->jabatan }}" required>
                            </div>

                            <div class="row g-0 w-50">
                                <div class="col-4 d-flex justify-content-start p-3 fw-bold">Tanda Tangan</div>
                                <div class="col-8 p-2">
                                    <input class="form-control" type="file" name="sign" accept="image/*">
                                </div>
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
