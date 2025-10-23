@extends('layouts.app')

@section('title', 'Add User')

@section('content')
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

    <div class="container-header">
        <div class="row-header">
            <div class="col-header">
                <p class="pt-3 ms-5 ps-5">DAFTAR USER</p>
            </div>
        </div>

        <form method="POST" action="{{ route('user.create') }}" enctype="multipart/form-data">
            @csrf
            <div class="container-post tight-rows table-grid mt-3 ms-3">
                <div class="row g-0 w-100">
                    <div class="col-4 d-flex align-items-center fw-bold">Nama Lengkap</div>
                    <div class="col-8">
                        <input class="form-control" type="text" placeholder="Masukkan nama user" name="nama_leng"
                            required>
                    </div>
                </div>

                <div class="row g-0 w-100">
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

                <div class="row g-0 w-100">
                    <div class="col-4 d-flex align-items-center fw-bold">Department</div>
                    <div class="col-8">
                        <select class="form-select" name="kode_dep" required>
                            <option value="">Pilih department</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->kode_dep }}">{{ $department->nama_dep }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row g-0 w-100">
                    <div class="col-4 d-flex align-items-center fw-bold">Username</div>
                    <div class="col-8">
                        <input class="form-control" type="text" placeholder="Masukkan username" name="username" required>
                    </div>
                </div>

                <div class="row g-0 w-100">
                    <div class="col-4 d-flex align-items-center fw-bold">Password</div>
                    <div class="col-8">
                        <input class="form-control" type="password" placeholder="Masukkan password" name="password"
                            required>
                    </div>
                </div>
                kalau dia darii dept IT tampilkan kolom ini
                @if (stripos($departments, 'IT') !== false)
                    {
                    <div class="container-post tight-rows table-grid mt-3 ms-3">
                        <div class="row g-0 w-100">
                            <div class="col-4 d-flex align-items-center fw-bold">Alamat</div>
                            <div class="col-8">
                                <input class="form-control" type="text" placeholder="Masukkan alamat" name="alamat"
                                    required>
                            </div>
                        </div>
                        }
                @endif

                <div class="row g-0 w-100">
                    <div class="col">
                        <div class="d-flex gap-2 mt-2 justify-content-end">
                            <button type="submit" class="btn btn-success fw-bold fs-6">Tambah</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- DATA USER --}}
    <div class="container-data mt-4 tight-rows table-grid ms-3">
        <div class="row g-0 row-cols-4 w-100 table-header signature-row" style="margin:0;">
            <div class="col-4 fw-bold p-2 text-start">Nama Lengkap</div>
            <div class="col-4 fw-bold p-2 text-start">Username</div>
            <div class="col-4 fw-bold p-2 text-start">Jabatan</div>
            <div class="col-4 fw-bold p-2 text-start">Department</div>
            <div class="col-2 fw-bold p-2 text-start">Action</div>
        </div>

        @if (isset($users) && count($users) > 0)
            @foreach ($users as $user)
                <div class="row g-0 row-cols-4 w-100 signature-row" style="margin:0;">
                    <div class="col-2 ps-3">{{ $user->id_user }}</div>
                    <div class="col-4 ps-3">{{ $user->nama_leng }}</div>
                    <div class="col-4 ps-3">{{ $user->username }}</div>
                    <div class="col-4 ps-3">{{ $user->jabatan->nama_jab ?? '' }}</div>
                    <div class="col-4 ps-3">{{ $user->department->nama_dep ?? '' }}</div>
                    <div class="col-2 p-2">
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
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
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
        @else
            <div class="row g-0 w-100 text-center py-3">
                <div class="col-12">Tidak ada data users</div>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
