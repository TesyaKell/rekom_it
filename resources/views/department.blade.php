<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar Department</title>

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

        .container-header {
            margin-top: -20px;
        }

        p {
            text-align: left;
            font-size: 14px;
            font-weight: bold;
            color: #e8b200;
        }

        .row-header .col-header {
            border-bottom: 2px solid #d8d8d8;
            background-color: #ffffff;
            text-align: left;
            margin-top: 15px;
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

        .form-label {
            font-weight: 600;
            color: #000000cb;
        }

        .container-post {
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: #0d606e 2px 2px 8px;
            padding: 15px;
            width: 50%;
        }

        .container-data {
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: #0d606e 2px 2px 8px;
            padding: 15px;
            width: 75%;
        }
    </style>
</head>

<body>

    <div class="container-header">
        <div class="row-header">
            <div class="col-header">
                <p class="pt-3 ms-5 ps-5">DAFTAR DEPARTMENT</p>
            </div>
        </div>


        <form method="POST" action="/department">
            @csrf
            <div class="container-post tight-rows table-grid mt-3 ms-3">
                <div class="row g-0 w-100">
                    <div class="col-4 d-flex justify-content-start p-3 fw-bold">
                        Nomor Department
                    </div>
                    <div class="col-8">
                        @php
                            $lastDep = $departments->last();
                            if ($lastDep) {
                                $lastNum = (int) substr($lastDep->kode_dep, 3);
                                $newId = 'DEP' . str_pad($lastNum + 1, 3, '0', STR_PAD_LEFT);
                            }
                        @endphp
                        {{ $newId }}
                    </div>
                </div>

                <div class="row g-0 w-100">
                    <div class="col-4 d-flex justify-content-start p-3 fw-bold">Nama Department</div>

                    <div class="col-8 p-2"><input class="form-control" type="text"
                            placeholder="Masukkan nama Department" name="nama_dep">

                    </div>
                </div>
                <div class="row g-0 w-100">
                    <div class="col" style="border-bottom: none; border-left: none; border-right: none;">
                        <div class="d-flex gap-2 mt-2 justify-content-start">
                            <button type="submit" class="btn btn-success fw-bold fs-6">Tambah</button>
                            <button type="button" class="btn btn-danger fw-bold fs-6">Batal</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>


        <div class="container-data mt-4 tight-rows table-grid ms-3">
            <!-- Dropdown untuk memilih jumlah data yang ditampilkan -->
            <div class="row g-0 mb-2 d-flex justify-content-end" style="width: 195px;">
                <div class="col text-end" style="border: 1px solid #000; background-color: #fff;">
                    <label for="showCount" class="me-2 fw-bold">Tampilkan</label>
                    <select id="showCount" class="form-select d-inline-block w-auto" style="width:80px;">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>
            <div class="row g-0 row-cols-4 w-100 department-row" style="margin:0;">
                <div class="col-2 border d-flex justify-content-start ps-3 fw-bold" style="min-width:70px;">
                    No.
                </div>
                <div class="col-3 border d-flex justify-content-start ps-3 fw-bold" style="min-width:70px;">
                    No. Department
                </div>
                <div class="col-5 border d-flex justify-content-start ps-3 pt-2 fw-bold" style="min-width:70px;">
                    Nama Department
                </div>
                <div class="col-2 fw-bold p-2 border fw-bold" style="min-width:70px;">
                    Aksi
                </div>
            </div>
            <div id="departmentRows">
                @if (isset($departments) && count($departments) > 0)
                    @foreach ($departments as $department)
                        <div class="row g-0 row-cols-4 w-100 department-row" style="margin:0;">
                            <div class="col-2 border d-flex justify-content-start ps-3" style="min-width:70px;">
                                {{ $loop->iteration }}
                            </div>
                            <div class="col-3 border d-flex justify-content-start ps-3" style="min-width:70px;">
                                {{ $department->kode_dep }}</div>
                            <div class="col-5 border d-flex justify-content-start ps-3 pt-2">{{ $department->nama_dep }}
                            </div>
                            <div class="col-2 fw-bold p-2 border" style="min-width:70px;">
                                <div class="dropdown m-0">
                                    <button class="btn btn-light border p-0" type="button"
                                        id="dropdownMenuButton{{ $department->kode_dep }}" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <span class="fw-bold fs-4">⋮</span>
                                    </button>
                                    <ul class="dropdown-menu"
                                        aria-labelledby="dropdownMenuButton{{ $department->kode_dep }}">
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ url("department/{$department->kode_dep}/edit") }}">Edit</a>
                                        </li>
                                        <li>
                                            <form action="{{ url("department/{$department->kode_dep}") }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this department?')"
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
                        <div class="col-12 text-center py-3 border">Tidak ada data department</div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Edit Department -->
    <div class="modal fade" id="editDepartmentModal" tabindex="-1" aria-labelledby="editDepartmentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form id="editDepartmentForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="editDepartmentModalLabel"
                            style="color: rgb(249, 137, 0);">
                            Edit Nama
                            Department</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="editDepartmentId" name="id">

                        <div class="mb-3">
                            <label for="editKodeDep" class="form-label">No. Department</label>
                            <div class="col-3 border d-flex justify-content-start ps-3" style="min-width:70px;"
                                id="editKodeDep">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="editNamaDep" class="form-label">Nama Department</label>
                            <input type="text" class="form-control" id="editNamaDep" name="nama_dep" required>
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
                var kode_dep = row.querySelector('.col-3').textContent.trim();
                var nama_dep = row.querySelector('.col-7').textContent.trim();

                // Isi modal dengan data
                document.getElementById('editKodeDep').textContent = kode_dep;
                document.getElementById('editNamaDep').value = nama_dep;
                document.getElementById('editDepartmentForm').action = '/department/' + kode_dep;
                document.getElementById('editDepartmentId').value = kode_dep;

                // Tampilkan modal
                var modal = new bootstrap.Modal(document.getElementById('editDepartmentModal'));
                modal.show();
            });
        });

        // Filter jumlah data yang ditampilkan
        document.addEventListener('DOMContentLoaded', function() {
            const showCount = document.getElementById('showCount');
            const rows = document.querySelectorAll('.department-row');

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
    <!-- Bootstrap JS for dropdown functionality -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>

@extends('layouts.app')

@section('title', 'Daftar Department')

@php
    $pageTitle = 'Daftar Department';
@endphp
