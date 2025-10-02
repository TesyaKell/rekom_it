@extends('layouts.app')

@section('title', 'Edit Rekomendasi')

@php
    $pageTitle = 'Edit Rekomendasi';
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Rekomendasi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


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
            background-color: #ffffff;
            text-align: left;
        }

        p {
            text-align: left;
            font-size: 14px;
            font-weight: bold;
            color: #e8b200;
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

        .form-label {
            font-weight: 600;
            color: #000000cb;
        }

        .card-edit-rekomendasi .card-body-edit-rekomendasi {
            background-color: #ffffff;
            height: auto;
            width: 880px;
            padding: 15px;
            border-radius: 5px;
        }

        .card-edit-detail .card-body-edit-detail {
            background-color: #ffffff;
            height: auto;
            width: 1150px;
            padding: 15px;
            border-radius: 5px;
        }
    </style>
</head>

<div class="container-header">
    <div class="row-header">
        <div class="col-header">
            <p class="pt-3 mt-3 ms-5 ps-5">EDIT REKOMENDASI</p>
        </div>
    </div>



    <body>
        <div class="container mt-1 mb-5 me-5 ms-5 p-2">
            <h6 class="mt-3 mb-2 fw-bold">Edit Data Rekomendasi</h6>
            <div class="card-edit-rekomendasi">
                <div class="card-body-edit-rekomendasi">
                    @if ($data->count())
                        @php $header = $data->first(); @endphp
                        <form method="POST" action="{{ route('rekomendasi.update', $header->id_rek) }}" class="mb-4">
                            @csrf
                            @method('PUT')

                            <div class="row mb-2">
                                @php
                                    $disabled = !in_array(session('loginRole'), ['IT', 'USER']) ? 'disabled' : '';
                                @endphp

                                <div class="col-md-4">
                                    <label class="form-label">No. PR</label>
                                    <input type="text" name="no_spb" class="form-control"
                                        value="{{ $header->no_spb }}" {{ $disabled }}>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Dibuat Oleh</label>
                                    <input type="text" name="nama_lengkap" class="form-control"
                                        value="{{ $header->nama_lengkap }}" {{ $disabled }}>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Department</label>
                                    <select name="nama_dep" class="form-control" {{ $disabled }}>
                                        @foreach ($departments as $dep)
                                            <option value="{{ $dep->nama_dep }}"
                                                {{ $header->nama_dep == $dep->nama_dep ? 'selected' : '' }}>
                                                {{ $dep->nama_dep }}
                                                {{ $disabled }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-2 mt-3">
                                <div class="col-md-4">
                                    <label class="form-label">Tanggal Pengajuan</label>
                                    <input type="date" name="tgl_masuk" class="form-control"
                                        value="{{ $header->tgl_masuk }}" {{ $disabled }}>
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label">Alasan</label>
                                    <input type="text" name="alasan_rek" class="form-control"
                                        value="{{ $header->alasan_rek }}" {{ $disabled }}>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan Rekomendasi</button>
                        </form>
                    @endif
                </div>
            </div>

            <h6 class="mt-4 mb-2 fw-bold">Edit Detail Rekomendasi</h6>
            <div class="card-edit-detail">
                <div class="card-body-edit-detail">
                    <table class="table table-bordered table-sm align-middle bg-light">
                        <thead>
                            <tr>
                                <th class="ps-3">Nama Unit</th>
                                <th class="ps-3">Keterangan</th>
                                <th class="ps-3">Estimasi Harga</th>
                                <th class="ps-3">Masukan</th>
                                @if (session('loginRole') === 'IT')
                                    <th class="ps-3">Tanggal Realisasi</th>
                                @endif
                                <th class="ps-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($details) && count($details))
                                @foreach ($details as $detail)
                                    <tr>
                                        <form method="POST"
                                            action="{{ route('detailRekomendasi.update', $detail->id_detail_rekomendasi) }}">
                                            @csrf
                                            @method('PUT')
                                            <td class="ps-3">
                                                <input type="text" name="jenis_unit"
                                                    class="form-control form-control-sm"
                                                    value="{{ $detail->jenis_unit }}" {{ $disabled }}>
                                            </td>
                                            <td class="ps-3">
                                                <input type="text" name="ket_unit"
                                                    class="form-control form-control-sm"
                                                    value="{{ $detail->ket_unit }}" {{ $disabled }}>
                                            </td>
                                            <td class="ps-3">
                                                <input type="number" name="estimasi_harga"
                                                    class="form-control form-control-sm"
                                                    value="{{ $detail->estimasi_harga }}" {{ $disabled }}>
                                            </td>
                                            @if (session('loginRole') === 'IT')
                                                <td class="ps-3">
                                                    <input type="text" name="masukan_it"
                                                        class="form-control form-control-sm"
                                                        value="{{ $detail->masukan_it }}">
                                                </td>
                                                <td class="ps-3">
                                                    <input type="date" name="tanggal_realisasi"
                                                        class="form-control form-control-sm"
                                                        value="{{ $detail->tanggal_realisasi }}">
                                                </td>
                                                <td class="ps-3">
                                                    <button type="submit"
                                                        class="btn btn-sm btn-success me-2">Simpan</button>
                                                </td>
                                            @elseif (session('loginRole') === 'Kabag')
                                                <td class="ps-3">
                                                    <input type="text" name="masukan_kabag"
                                                        class="form-control form-control-sm"
                                                        value="{{ $detail->masukan_kabag }}">
                                                </td>
                                                <td class="ps-3">
                                                    <button type="submit"
                                                        class="btn btn-sm btn-success me-2">Simpan</button>
                                                </td>
                                            @endif
                                        </form>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">Detail tidak ditemukan.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
        </script>
    </body>

</html>
