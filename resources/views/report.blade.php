<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report</title>

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

        .container-form {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 16px #0d606e22;
            width: 440px;
            min-height: 350px;
            padding: 24px 28px;
            margin-bottom: 24px;
            border: 1.5px solid #0d606e;
        }

        .container-notes {
            background-color: #ffde093b;
            border-radius: 5px;
        }

        .container-table {
            background: #fff;
            width: 1150px;
            box-shadow: 0 4px 16px #0d606e22;
            border-radius: 15px;
        }

        .table thead th {
            background: #0d606e;
            color: #fff;
            font-weight: bold;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1.5px solid #0d606e !important;
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

        .btn-warning {
            background-color: #ffa800;
            border: none;
            color: #fff !important;
        }

        .btn-warning:hover {
            background-color: #0d606e;
            color: #fff !important;
        }

        .form-label {
            font-weight: 600;
            color: #0d606e;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            border: 1px solid #0d606e;
            background: #fff;
            font-size: 15px;
        }

        .input-group-text {
            background: #ffa80022;
            color: #0d606e;
            font-weight: bold;
        }

        .badge {
            font-size: 13px;
            border-radius: 6px;
        }

        .select2-container--default .select2-selection--multiple {
            border-radius: 8px;
            border: 1px solid #0d606e;
            min-height: 38px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #ffa800;
            color: #fff;
            border: none;
            border-radius: 6px;
            margin-top: 4px;
        }
    </style>
</head>

<div class="container-header">
    <div class="row-header">
        <div class="col-header">
            <p class="pt-3 mt-3 ms-5 ps-5 fw-bold">LAPORAN REKOMENDASI & SERVIS UNIT KOMPUTER</p>
        </div>
    </div>



    <body>
        <div class="container-form mt-4 mb-5 me-5 ms-5">
            <form method="GET" action="{{ route('report') }}" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="noRek" class="form-label">No. Rekomendasi</label>
                        <div class="input-group">
                            <input class="form-check-input me-3" type="checkbox" id="chkNoRek">
                            <input type="text" class="form-control" name="noRek" id="noRek"
                                value="{{ request('noRek') }}" placeholder="Dari" disabled>
                            <span class="input-group-text">s/d</span>
                            <input type="text" class="form-control" name="noRek2" id="noRek2"
                                value="{{ request('noRek2') }}" placeholder="Sampai" disabled>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="tgl_awal" class="form-label ms-2">Periode Tanggal Masuk</label>
                        <div class="input-group">
                            <input class="form-check-input me-3" type="checkbox" id="chkTanggal">
                            <input type="date" class="form-control" name="tgl_awal" id="tgl_awal"
                                value="{{ request('tgl_awal') }}" disabled>
                            <span class="input-group-text">s/d</span>
                            <input type="date" class="form-control" name="tgl_akhir" id="tgl_akhir"
                                value="{{ request('tgl_akhir') }}" disabled>
                        </div>
                    </div>
                    @if (session('loginRole') === 'IT')
                        <div class="col-md-12">
                            <label for="department" class="form-label">Department</label>
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <input class="form-check-input" type="checkbox" id="chkDepartment"
                                        style="margin-top:8px;">
                                </div>
                                <div class="col">
                                    <select class="form-select" name="department[]" id="department" multiple disabled
                                        style="min-width: 180px;">
                                        @foreach ($departmentList ?? [] as $department)
                                            <option value="{{ $department }}"
                                                {{ in_array($department, (array) request('department')) ? 'selected' : '' }}>
                                                {{ $department }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="col-md-12 d-flex align-items-end">
                        <button type="submit" class="btn btn-success w-50 fw-bold">Tampilkan</button>
                        <a href="{{ route('report.export', request()->query()) }}"
                            class="btn btn-warning ms-2 w-50 fw-bold">Export Excel</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="container-notes me-5 ms-5">
            <p class="p-3 mt-4" style="color: #b85600; font-weight: 100px;">
                * Hasil Pencarian :
                {{ $results->sum(fn($item) => $item->detail_rekomendasi->count()) }} data
            </p>
        </div>
        <div class="container-table mb-5 me-5 ms-5 p-2">
            <table class="table table-bordered table-sm align-middle me-5 mt-3">
                <thead>
                    <tr>
                        <th class="ps-2">No. Rek</th>
                        <th class="ps-2">No. PR</th>
                        <th class="ps-2">Nama Unit</th>
                        <th class="ps-2">Keterangan</th>
                        <th class="ps-2">Alasan</th>
                        <th class="ps-2">Estimasi Harga</th>
                        <th class="ps-2">Dibuat Oleh</th>
                        <th class="ps-2">Department</th>
                        <th class="ps-2">Tanggal Pengajuan</th>
                        <th class="ps-2">Status</th>
                        <th class="ps-2">Tangal Realisasi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($results as $item)
                        @foreach ($item->detail_rekomendasi as $detail)
                            <tr>
                                <td class="ps-2">{{ $item->id_rek }}</td>
                                <td class="ps-2">{{ $item->no_spb }}</td>
                                <td class="ps-2">{{ $detail->jenis_unit }}</td>
                                <td class="ps-2">{{ $detail->ket_unit }} </td>
                                <td class="ps-2">{{ $item->alasan_rek }}</td>
                                <td class="ps-2">Rp. {{ number_format($detail->estimasi_harga, 0, ',', '.') }}</td>
                                <td class="ps-2">{{ $item->nama_lengkap }}</td>
                                <td class="ps-2">{{ $item->nama_dep }}</td>
                                <td class="ps-2">{{ $item->tgl_masuk }}</td>
                                <td class="ps-2">
                                    @if ($item->status == 'menunggu verifikasi Kabag')
                                        <span class="badge text-light p-1" style="background-color: #ffa800;">Menunggu
                                            Kabag</span>
                                    @elseif($item->status == 'menunggu verifikasi Tim IT')
                                        <span class="badge text-light p-1" style="background-color: #0d606e;">Menunggu
                                            Tim IT</span>
                                    @elseif($item->status == 'Ditolak')
                                        <span class="badge bg-danger p-1">Ditolak</span>
                                    @elseif($item->status == 'Diterima')
                                        <span class="badge bg-success p-1">Diterima</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $item->status }}</span>
                                    @endif
                                </td>
                                <td class="ps-3">
                                    @if ($detail->tanggal_realisasi)
                                        {{ $detail->tanggal_realisasi }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
        </script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    </body>

</html>

@extends('layouts.app')

@section('title', 'Laporan Rekomendasi')

@php
    $pageTitle = 'Laporan Rekomendasi';
@endphp

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const chkNoRek = document.getElementById("chkNoRek");
        const noRek = document.getElementById("noRek");
        const noRek2 = document.getElementById("noRek2");

        chkNoRek.addEventListener("change", function() {
            noRek.disabled = !this.checked;
            noRek2.disabled = !this.checked;
        });

        const chkTanggal = document.getElementById("chkTanggal");
        const tglAwal = document.getElementById("tgl_awal");
        const tglAkhir = document.getElementById("tgl_akhir");

        chkTanggal.addEventListener("change", function() {
            tglAwal.disabled = !this.checked;
            tglAkhir.disabled = !this.checked;
        });

        $(document).ready(function() {
            const department = $("#department");

            department.select2({
                placeholder: "Pilih Department",
                allowClear: true,
                width: '100%',
                dropdownParent: $('.container-form')
            });

            department.prop("disabled", true);

            $("#chkDepartment").on("change", function() {
                if (this.checked) {
                    department.prop("disabled", false);
                } else {
                    department.prop("disabled", true).val(null).trigger("change");
                }
            });
        });
    });
</script>
