@extends('layouts.app')

@section('title', 'Daftar Rekomendasi')

@php
    $pageTitle = 'Daftar Rekomendasi';
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar Rekomendasi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #efefef;
        }

        .row .col {
            border: 1px solid #000;
            background-color: #fff;
            padding: 20px;
            margin: 10px 0;
            text-align: center;
        }

        .container-header {
            margin-top: -20px;
        }

        .row-header .col-header {
            border-bottom: 2px solid #d8d8d8;
            background: white;
            text-align: left;
        }

        p {
            text-align: left;
            font-size: 14px;
            font-weight: bold;
            color: #0d606e;
        }

        .p-3 {
            text-align: left;
            font-size: 14px;
            color: #e8b200;
            font-weight: 600;
        }

        .container-navigasi {
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

        .container-notes {
            background-color: #ffde093b;
            border-radius: 5px;
        }
    </style>
</head>

<div class= "container-header">
    <div class="row-header">
        <div class="col-header">
            <p class="pt-3 mt-3 ms-5 ps-5">DAFTAR REKOMENDASI & SERVIS KOMPUTER</p>
        </div>
    </div>


    <div style="position: relative; width: 100%; max-width: 1285px; margin: 0 auto;">
        <img src="{{ asset('images/rekom_home.png') }}" style="width:100%; height:auto;" alt="No image">
        <div
            style="position: absolute; bottom: -35px; left: 50%; transform: translateX(-50%); width: 100%; height: auto; z-index: 2; display: flex; justify-content: center;">
            <div class="container-navigasi h-20 mt-3 pt-2 pb-2"
                style="background: #ffffff; width: 1190px; border: 1px solid #878787; box-shadow:#0d606e 2px 2px 8px;">
                <div class="row">
                    <div class="col-4">
                        <form class="d-flex justify-content-start" action="{{ route('searchRekomendasi') }}"
                            method="GET">
                            <input class="form-control me-2 ms-2 mt-2 mb-2" type="search" placeholder="Search"
                                name="query" aria-label="Search" style="width: 250px; border: 1px solid #0d606e;">
                            <button class="btn bi bi-search w-15 h-25 mt-2" style="background:#0d606e; color: #fff;"
                                type="submit"></button>
                        </form>
                    </div>
                    <div class="col-4 d-flex justify-content-start">
                        <form action="{{ route('rekomendasi.filter') }}" method="GET">
                            <div class="dropdown mt-2">
                                @php
                                    $selected = request('status');
                                    $label = match ($selected) {
                                        'Belum Realisasi' => 'Belum Realisasi',
                                        'Diterima' => 'Sudah Realisasi',
                                        default => 'Semua Rekomendasi',
                                    };
                                @endphp
                                <button class="btn dropdown-toggle fw-bold" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    {{ $label }}
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <button class="dropdown-item" type="submit" name="status" value="">Semua
                                            Rekomendasi</button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item" type="submit" name="status"
                                            value="Belum Realisasi">Belum Realisasi</button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item" type="submit" name="status"
                                            value="Diterima">Sudah
                                            Realisasi</button>
                                    </li>
                                </ul>
                            </div>
                        </form>
                    </div>
                    <div class="col-4 d-flex justify-content-end">
                        @if (session('loginRole') === 'IT')
                            <a href="{{ url('add_rekomendasi') }}">
                                <button type="button" class="btn mt-2 mb-2 me-2 fw-bold fs-6"
                                    style="background: #0d606e; color: white;">
                                    Tambah Data Rekomendasi
                                </button>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('loginRole') === 'IT')
        <div class="container-notes w-90 h-50 ms-3 me-3" style="max-width: 100%; margin-top: 70px;">
            <p class="p-3 mt-4" style="color: #b85600">* Tim IT hanya dapat melakukan approval jika Kepala Bagian
                telah memberikan persetujuan</p>
        </div>
    @endif
    <div class="container-navigasi w-90 h-100 ms-3 me-3 mt-3 pb-2 overflow-auto" style="max-width: 100%;">
        <div class="table-responsive ms-3 me-3 mt-2 mb-2">
            <div class="row g-0 mb-2 d-flex justify-content-start" style="width: 220px;">
                <div class="col text-start" style="border: none; background: none;">
                    <label for="showCount" class="me-2 fw-bold"
                        style="color:#ffa800; margin-left: -12px;">Tampilkan</label>
                    <select id="showCount" class="form-select d-inline-block w-auto"
                        style="width:100px; font-size: 14px; padding: 6px 24px;">
                        <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                        <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15</option>
                        <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </div>
            </div>
            <table class="table table-sm align-middle m-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-2">No. Rek</th>
                        <th class="ps-2">No. PR</th>
                        <th class="ps-2">Dibuat Oleh</th>
                        <th class="ps-2">Department</th>
                        <th class="ps-2">Tanggal Pengajuan</th>
                        <th class="ps-2">Status</th>
                        <th class="ps-2 text-center">Action</th>
                        @if (session('loginRole') === 'IT' || session('loginRole') === 'Kabag')
                            <th class="ps-2 text-center">Approval</th>
                        @endif

                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $item)
                        <tr>
                            <td class="ps-2">
                                <a href="{{ route('rekomendasi.detail', $item->id_rek) }}"
                                    class="badge text-white text-decoration-none" style="background-color: #0d606e;">
                                    {{ $item->id_rek }}
                                </a>
                            </td>
                            <td class="ps-2">{{ $item->no_spb }}</td>
                            <td class="ps-2">{{ $item->nama_lengkap }}</td>
                            <td class="ps-2">{{ $item->nama_dep }}</td>
                            <td class="ps-2">{{ $item->tgl_masuk }}</td>
                            <td class="ps-2">
                                @if ($item->status == 'menunggu verifikasi Kabag')
                                    <span class="badge text-light p-1"
                                        style="background-color: rgba(245, 139, 9, 0.767);">Menunggu
                                        Kabag</span>
                                @elseif($item->status == 'menunggu verifikasi Tim IT')
                                    <span
                                        class="badge
                                            bg-orange text-light p-1"
                                        style="background-color: rgba(32, 55, 230, 0.79);">Menunggu
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
                                <div class="dropdown d-flex justify-content-center align-items-center dropstart">
                                    <button class="btn btn-light border p-0" type="button"
                                        id="dropdownMenuButton{{ $item->id_rek }}" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <span class="fw-bold fs-4 d-flex justify-content-center align-items-center"
                                            style="height: 100%;">⋮</span>
                                    </button>
                                    <ul class="dropdown-menu shadow-lg rounded-3"
                                        aria-labelledby="dropdownMenuButton{{ $item->id_rek }}">
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('rekomendasi.print', $item->id_rek) }}">
                                                Print PDF
                                            </a>
                                        </li>
                                        <li>
                                            @if ($item->status == 'menunggu verifikasi Kabag' || session('loginRole') === 'IT' || session('loginRole') === 'Kabag')
                                                <a class="dropdown-item"
                                                    href="{{ route('rekomendasi.edit', $item->id_rek) }}">
                                                    Edit </a>
                                            @endif
                                        </li>
                                        <li>
                                            <form action="{{ url("rekomendasi/{$item->id_rek}") }}" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus item ini?')"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger fw-bold">
                                                    Hapus
                                                </button>
                                            </form>
                                        </li>
                                    </ul>

                                </div>
                            </td>
                            @if (session('loginRole') === 'Kabag')

                                @if ($item->status === 'menunggu verifikasi Kabag')
                                    <td class="ps-2">
                                        <div class="d-flex gap-2 mt-2 mb-2 justify-content-center">
                                            @php
                                                // Cek apakah semua detail sudah ada masukan
                                                $allMasukanFilled =
                                                    \DB::table('detail_rekomendasi')
                                                        ->where('id_rek', $item->id_rek)
                                                        ->whereNull('masukan_kabag')
                                                        ->count() === 0;
                                            @endphp
                                            @if ($allMasukanFilled)
                                                <form action="{{ route('rekomendasi.approve', $item->id_rek) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    <input type="hidden" name="action" value="acc">
                                                    <input type="hidden" name="masukan_kabag"
                                                        value="Sudah ada masukan">
                                                    <button type="submit"
                                                        class="btn btn-primary btn-lg active btn-sm fw-bold">
                                                        Approve
                                                    </button>
                                                </form>
                                            @else
                                                <button type="button"
                                                    class="btn btn-primary btn-lg active btn-sm fw-bold"
                                                    id="approveBtnKabag{{ $item->id_rek }}">
                                                    Approve
                                                </button>
                                            @endif
                                            <form action="{{ route('rekomendasi.approve', $item->id_rek) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                <input type="hidden" name="action" value="tolak">
                                                <button type="submit"
                                                    class="btn btn-danger btn-sm fw-bold">Tolak</button>
                                            </form>
                                            @if ($item->status === 'acc')
                                                <span class="badge bg-success">Menunggu verifikasi Tim IT</span>
                                            @elseif ($item->status === 'tolak')
                                                <span class="badge bg-danger">Ditolak</span>
                                            @endif
                                        </div>
                                    </td>
                                @else
                                    <td class="ps-2 text-center">
                                        <span class="badge p-2"
                                            style="font-size: small; background-color: rgba(0, 128, 0, 0.463); width: 130px;">Selesai</span>
                                    </td>
                                @endif
                            @else
                                @if (session('loginRole') === 'IT')
                                    @if ($item->status === 'Diterima' || $item->status === 'acc_it' || $item->status === 'Ditolak')
                                        <td class="ps-2 text-center">
                                            <span class="badge p-2"
                                                style="font-size: small; background-color: rgba(0, 128, 0, 0.463); width: 130px;">Selesai</span>
                                        </td>
                                    @elseif ($item->status === 'menunggu verifikasi Tim IT')
                                        <td class="ps-2">
                                            <div class="d-flex gap-2 mt-3 justify-content-center">
                                                @php
                                                    $allMasukanFilledIT =
                                                        \DB::table('detail_rekomendasi')
                                                            ->where('id_rek', $item->id_rek)
                                                            ->whereNull('masukan_it')
                                                            ->count() === 0;
                                                @endphp
                                                @if ($allMasukanFilledIT)
                                                    <form action="{{ route('rekomendasi.approve', $item->id_rek) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        <input type="hidden" name="action" value="acc_it">
                                                        <input type="hidden" name="masukan_it"
                                                            value="Sudah ada masukan">
                                                        <button type="submit"
                                                            class="btn btn-primary btn-lg active btn-sm fw-bold">
                                                            Approve
                                                        </button>
                                                    </form>
                                                @else
                                                    <button type="button"
                                                        class="btn btn-primary btn-lg active btn-sm fw-bold"
                                                        id="approveBtnIT{{ $item->id_rek }}">
                                                        Approve
                                                    </button>
                                                @endif
                                                <form action="{{ route('rekomendasi.approve', $item->id_rek) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    <input type="hidden" name="action" value="tolak">
                                                    <button type="submit" class="btn btn-danger btn-sm fw-bold">
                                                        Tolak
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    @else
                                        <td class="ps-2">
                                            <div class="d-flex gap-2 mt-3 justify-content-center">
                                                <button type="button"
                                                    class="btn btn-primary btn-lg active btn-sm fw-bold" disabled>
                                                    Approve
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm fw-bold" disabled>
                                                    Tolak
                                                </button>
                                            </div>
                                        </td>
                                    @endif
                                @endif
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Data tidak ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-3">
                {{ $data->links() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="approveMasukanModal" tabindex="-1" aria-labelledby="approveMasukanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form id="approveMasukanForm" method="POST">
                @csrf
                <input type="hidden" name="action" id="approveMasukanAction" value="acc">
                <input type="hidden" name="id_rek" id="approveMasukanIdRek">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="approveMasukanModalLabel">Berikan Masukan pada Rekomendasi
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if (session('loginRole') === 'IT')
                            <input class="form-check-input" type="checkbox" value="Tidak ada masukan"
                                id="tidakAdaMasukanCheckbox" name="masukan_it">
                            <label class="form-check-label" for="tidakAdaMasukanCheckbox">
                                Tidak ada masukan
                            </label>
                        @else
                            <input class="form-check-input" type="checkbox" value="Tidak ada masukan"
                                id="tidakAdaMasukanCheckbox" name="masukan_kabag">
                            <label class="form-check-label" for="tidakAdaMasukanCheckbox">
                                Tidak ada masukan
                            </label>
                        @endif
                        <div id="masukanError" class="text-danger mt-2" style="display:none;">
                            Silakan centang jika tidak ada masukan.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
    <script>
        // Handle per page selection change
        document.addEventListener('DOMContentLoaded', function() {
            const showCount = document.getElementById('showCount');
            showCount.addEventListener('change', function() {
                const perPage = parseInt(this.value);
                const url = new URL(window.location.href);
                const currentPage = parseInt(url.searchParams.get('page')) || 1;
                const currentPerPage = parseInt('{{ $perPage }}');
                const firstItemOnCurrentPage = (currentPage - 1) * currentPerPage + 1;
                const newPage = Math.ceil(firstItemOnCurrentPage / perPage);
                url.searchParams.set('per_page', perPage);
                url.searchParams.set('page', newPage);
                window.location.href = url.toString();
            });
        });


        document.addEventListener('DOMContentLoaded', function() {
            @foreach ($data as $item)
                @php
                    $allMasukanFilled = \DB::table('detail_rekomendasi')->where('id_rek', $item->id_rek)->whereNull('masukan_kabag')->count() === 0;
                @endphp
                @if (session('loginRole') === 'Kabag' && $item->status === 'menunggu verifikasi Kabag' && !$allMasukanFilled)
                    var btnKabag = document.getElementById('approveBtnKabag{{ $item->id_rek }}');
                    if (btnKabag) {
                        btnKabag.addEventListener('click', function(e) {
                            document.getElementById('approveMasukanIdRek').value = '{{ $item->id_rek }}';
                            document.getElementById('approveMasukanForm').action =
                                "{{ route('rekomendasi.approve', $item->id_rek) }}";
                            document.getElementById('approveMasukanAction').value = 'acc'; // Kabag
                            document.getElementById('tidakAdaMasukanCheckbox').checked = false;
                            document.getElementById('masukanError').style.display = 'none';
                            var modal = new bootstrap.Modal(document.getElementById('approveMasukanModal'));
                            modal.show();
                        });
                    }
                @endif
                @php
                    $allMasukanFilledIT = \DB::table('detail_rekomendasi')->where('id_rek', $item->id_rek)->whereNull('masukan_it')->count() === 0;
                @endphp
                @if (session('loginRole') === 'IT' && $item->status === 'menunggu verifikasi Tim IT' && !$allMasukanFilledIT)
                    var btnIT = document.getElementById('approveBtnIT{{ $item->id_rek }}');
                    if (btnIT) {
                        btnIT.addEventListener('click', function(e) {
                            document.getElementById('approveMasukanIdRek').value = '{{ $item->id_rek }}';
                            document.getElementById('approveMasukanForm').action =
                                "{{ route('rekomendasi.approve', $item->id_rek) }}";
                            document.getElementById('approveMasukanAction').value = 'acc_it'; // IT
                            document.getElementById('tidakAdaMasukanCheckbox').checked = false;
                            document.getElementById('masukanError').style.display = 'none';
                            var modal = new bootstrap.Modal(document.getElementById('approveMasukanModal'));
                            modal.show();
                        });
                    }
                @endif
            @endforeach

            document.getElementById('approveMasukanForm').addEventListener('submit', function(e) {
                if (!document.getElementById('tidakAdaMasukanCheckbox').checked) {
                    e.preventDefault();
                    document.getElementById('masukanError').style.display = 'block';
                }
            });
        });
    </script>

    </body>

</html>
