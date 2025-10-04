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
            background: linear-gradient(120deg, #fff 60%, #0d606e 100%);
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
            color: #e8b200;
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

        .tight-rows .row+.row {
            margin-top: -1px;
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

        .department-row {
            background: #fff;
            border-bottom: 1px solid #0d606e22;
            border-radius: 0 0 8px 8px;
            transition: box-shadow 0.2s;
        }

        .department-row:hover {
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
                <p class="pt-3 ms-5 ps-5">DAFTAR DEPARTMENT</p>
            </div>
        </div>

        <form method="POST" action="/department">
            @csrf
            <div class="container-post tight-rows table-grid mt-3 ms-3">
                <div class="row g-0 w-100">
                    <div class="col-4 d-flex align-items-center fw-bold">
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
                        <span class="fw-bold" style="color:#ffa800">{{ $newId }}</span>
                    </div>
                </div>
                <div class="row g-0 w-100">
                    <div class="col-4 d-flex align-items-center fw-bold">Nama Department</div>
                    <div class="col-8 p-2">
                        <input class="form-control" type="text" placeholder="Masukkan nama Department"
                            name="nama_dep">
                    </div>
                </div>
                <div class="row g-0 w-100">
                    <div class="col" style="border-bottom: none; border-left: none; border-right: none;">
                        <div class="d-flex gap-2 mt-2 justify-content-end" style="margin-right: -4px;">
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
            <div class="row g-0 row-cols-4 w-100 table-header department-row" style="margin:0;">
                <div class="col-2 d-flex justify-content-start ps-3 fw-bold" style="min-width:70px;">
                    No.
                </div>
                <div class="col-3 d-flex justify-content-start ps-3 fw-bold" style="min-width:70px;">
                    No. Department
                </div>
                <div class="col-5 d-flex justify-content-start ps-3 pt-2 fw-bold" style="min-width:70px;">
                    Nama Department
                </div>
                <div class="col-2 fw-bold p-2" style="min-width:70px;">
                    Aksi
                </div>
            </div>
            <div id="departmentRows">
                @if (isset($departments) && count($departments) > 0)
                    @foreach ($departments as $department)
                        <div class="row g-0 row-cols-4 w-100 department-row" style="margin:0;">
                            <div class="col-2 d-flex justify-content-start ps-3" style="min-width:70px;">
                                {{ $loop->iteration }}
                            </div>
                            <div class="col-3 d-flex justify-content-start ps-3" style="min-width:70px;">
                                <span style="color:#ffa800">{{ $department->kode_dep }}</span>
                            </div>
                            <div class="col-5 d-flex justify-content-start ps-3 pt-2">{{ $department->nama_dep }}</div>
                            <div class="col-2 fw-bold p-2">
                                <div class="dropdown m-0">
                                    <button class="btn btn-light border p-0" type="button"
                                        id="dropdownMenuButton{{ $department->kode_dep }}" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <span class="fw-bold fs-4" style="color:#0d606e">⋮</span>
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
                        <div class="col-12 text-center py-3">Tidak ada data department</div>
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
                        <h5 class="modal-title fw-bold" id="editDepartmentModalLabel">
                            Edit Nama Department
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="editDepartmentId" name="id">
                        <div class="mb-3">
                            <label for="editKodeDep" class="form-label">No. Department</label>
                            <div class="col-3 d-flex justify-content-start ps-3"
                                style="min-width:70px; color:#ffa800;" id="editKodeDep">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editNamaDep" class="form-label">Nama Department</label>
                            <input type="text" class="form-control" id="editNamaDep" name="nama_dep" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
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
                var nama_dep = row.querySelector('.col-5').textContent.trim();

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

        // Pengfilter jumlah data yang ditampilkan
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

@extends('layouts.app')

@section('title', 'Daftar Department')

@php
    $pageTitle = 'Daftar Department';
@endphp
