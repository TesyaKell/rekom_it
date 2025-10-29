<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

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

        .form-control {
            border-radius: 8px;
            border: 1px solid #0d606e;
            background: #fff;
            font-size: 15px;
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

        .page-item.active .page-link {
            background-color: #0d606e !important;
            color: #fff !important;
        }

        .pagination .page-link {
            color: #0d606e;
        }
    </style>
</head>

<body>
    <div class="container-header">
        <div class="row-header">
            <div class="col-header">
                <p class="pt-3 ms-5 ps-5">DAFTAR USER</p>
            </div>
        </div>

        <form method="POST" action="{{ route('user.create') }}" enctype="multipart/form-data">
            @csrf
            <div class="container-post tight-rows table-grid mt-3 ms-3">
                <div class="row g-0 w-100 mb-3">
                    <div class="col-4 d-flex align-items-center fw-bold">Nama Lengkap</div>
                    <div class="col-8">
                        <input class="form-control" type="text" placeholder="Masukkan nama user" name="nama_leng"
                            required>
                    </div>
                </div>

                <div class="row g-0 w-100 mb-3 mb-3">
                    <div class="col-4 d-flex align-items-center fw-bold">Jabatan</div>
                    <div class="col-8">
                        <select class="form-select" name="id_jab" required>
                            <option value="">Pilih jabatan</option>
                            @foreach ($positions as $jabatan)
                                <option value="{{ $jabatan->id_jab }}">{{ $jabatan->nama_jab }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row g-0 w-100 mb-3">
                    <div class="col-4 d-flex align-items-center fw-bold">Department</div>
                    <div class="col-8">
                        <select id="departmentSelect" class="form-select" name="kode_dep" required>
                            <option value="">Pilih department</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->kode_dep }}" data-name="{{ $department->nama_dep }}"
                                    @if (old('kode_dep') == $department->kode_dep) selected @endif>
                                    {{ $department->nama_dep }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row g-0 w-100 mb-3">
                    <div class="col-4 d-flex align-items-center fw-bold">Username</div>
                    <div class="col-8">
                        <input class="form-control" type="text" placeholder="Masukkan username" name="username"
                            value="{{ old('username') }}" required>
                    </div>
                </div>

                <div class="row g-0 w-100 mb-3">
                    <div class="col-4 d-flex align-items-center fw-bold">Password</div>
                    <div class="col-8">
                        <input class="form-control" type="password" placeholder="Masukkan password" name="password"
                            required>
                    </div>
                </div>

                <div id="alamatRow" class="row g-0 w-100" style="display:none;">
                    <div class="col-4 d-flex align-items-center fw-bold">Alamat</div>
                    <div class="col-8">
                        <input class="form-control" type="text" placeholder="Masukkan alamat" name="alamat"
                            value="{{ old('alamat') }}">
                    </div>
                </div>

                <script>
                    (function() {
                        const sel = document.getElementById('departmentSelect');
                        const alamatRow = document.getElementById('alamatRow');

                        function toggleAlamat() {
                            const opt = sel.options[sel.selectedIndex];
                            const name = opt ? (opt.dataset.name || '').trim().toUpperCase() : '';
                            alamatRow.style.display = (name === 'IT') ? '' : 'none';
                        }

                        if (sel) {
                            sel.addEventListener('change', toggleAlamat);
                            document.addEventListener('DOMContentLoaded', toggleAlamat);
                            toggleAlamat();
                        }
                    })();
                </script>

                <div class="row g-0 w-100">
                    <div class="col">
                        <div class="d-flex gap-2 mt-3 justify-content-end">
                            <button type="submit" class="btn btn-success fw-bold fs-6"
                                style="color:white">Tambah</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>


        {{-- DATA USER --}}
        <div class="container-data mt-4 tight-rows table-grid ms-3">
            <div class="row g-0 mb-4 d-flex justify-content-end" style="width: 195px; margin-left: -20px;">
                <div class="col text-end" style="border: none; background: none;">
                    <label for="showCount" class="me-2 fw-bold" style="color:#ffa800;">Tampilkan</label>
                    <select id="showCount" class="form-select d-inline-block w-auto" style="width:80px;">
                        <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                        <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15</option>
                        <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </div>
            </div>
            <div class="row w-100 table-header signature-row" style="margin:0;">
                <div class="col-3 fw-bold p-2 text-start mb-1">Nama Lengkap</div>
                <div class="col-2 fw-bold p-2 text-start mb-1">Username</div>
                <div class="col-3 fw-bold p-2 text-start mb-1">Jabatan</div>
                <div class="col-2 fw-bold p-2 text-start mb-1">Department</div>
                <div class="col-2 fw-bold p-2 text-center mb-1">Action</div>
            </div>

            @if (isset($users) && count($users) > 0)
                @foreach ($users as $user)
                    <div class="row g-0 row-cols-4 w-100 signature-row" style="margin:0;">
                        <div class="col-3 ps-2 mb-1 mt-1">{{ $user->nama_leng }}</div>
                        <div class="col-2 ps-2 mb-1 mt-1">{{ $user->username }}</div>
                        <div class="col-3 ps-2 mb-1 mt-1">{{ $user->jabatan->nama_jab ?? '' }}</div>
                        <div class="col-2 ps-2 mb-1 mt-1">{{ $user->department->nama_dep ?? '' }}</div>
                        <div class="col-2 d-flex justify-content-center mb-1 mt-1">
                            <div class="dropdown m-0">
                                <button class="btn btn-light border p-0" type="button" data-bs-toggle="dropdown">
                                    <span class="fw-bold fs-4" style="color:#0d606e">⋮</span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <button class="dropdown-item" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $user->id_user }}">Edit</button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item text-danger fw-bold" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $user->id_user }}">Hapus</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- Modal Edit --}}
                    <div class="modal fade" id="editModal{{ $user->id_user }}" tabindex="-1">
                        <div class="modal-dialog">
                            <form method="POST" action="{{ route('user.update', $user->id_user) }}">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit User</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Username</label>
                                            <input type="text" class="form-control" name="username"
                                                value="{{ $user->username }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <input type="password" class="form-control" name="password"
                                                value="{{ $user->password }}" required>
                                        </div>


                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-success">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Modal Hapus --}}
                    <div class="modal fade" id="deleteModal{{ $user->id_user }}" tabindex="-1">
                        <div class="modal-dialog">
                            <form method="POST" action="{{ route('user.destroy', $user->id_user) }}">
                                @csrf
                                @method('DELETE')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Hapus users</h5>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda yakin ingin menghapus data ini?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
                <div class="mt-3">
                    {{ $users->links() }}
                </div>
            @else
                <div class="row g-0 w-100 text-center py-3">
                    <div class="col-12">Tidak ada data users</div>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const showCount = document.getElementById('showCount');

            showCount.addEventListener('change', function() {
                const perPage = parseInt(this.value);
                const url = new URL(window.location.href);
                const currentPage = parseInt(url.searchParams.get('page')) || 1;
                const currentPerPage = parseInt('{{ $perPage }}');

                // ngitung item pertama di halaman sekarang
                const firstItemOnCurrentPage = (currentPage - 1) * currentPerPage + 1;

                // ini untuk ngitung page baru nya apa abis di ubah banyak datanya
                const newPage = Math.ceil(firstItemOnCurrentPage / perPage);

                url.searchParams.set('per_page', perPage);
                url.searchParams.set('page', newPage);

                window.location.href = url.toString();
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
@extends('layouts.app')

@section('title', 'Daftar User')

@php
    $pageTitle = 'Daftar User';
@endphp
