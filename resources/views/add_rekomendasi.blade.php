<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Rekomendasi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        title {
            font-weight: bold;
        }

        p {
            color: #e8b200;
            margin-bottom: 5px;
            font-weight: bold;
            margin-left: 70px;
            font-size: 14px;
        }

        .container-header {
            margin-top: -20px;
        }

        .row-header .col-header {
            border-bottom: 2px solid #d8d8d8;
            background-color: #ffffff;
            text-align: left;
        }

        /* Card utama form rekomendasi */
        .card-4 .card-body-4 {
            background: white;
            box-shadow: 0 4px 16px rgba(232, 178, 0, 0.08);
            padding: 24px;
            width: 100%;
            max-width: 480px;
            margin-left: 30px;
            border-radius: 16px;
            transition: box-shadow 0.2s;
        }

        .card-4 .card-body-4:hover {
            box-shadow: 0 8px 24px rgba(78, 78, 78, 0.13);
        }

        /* Card detail rekomendasi */
        .card-3 .card-body-3 {
            background: #ffffff;
            box-shadow: 0 2px 8px rgba(232, 178, 0, 0.10);
            padding: 18px;
            width: 100%;
            max-width: 500px;
            margin-left: 25px;
            border-radius: 14px;
            transition: box-shadow 0.2s;
        }

        .card-3 .card-body-3:hover {
            box-shadow: 0 8px 24px rgba(232, 178, 0, 0.13);
        }

        .btn-success,
        .btn-primary,
        .btn-danger {
            font-weight: 500;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(232, 178, 0, 0.08);
            transition: background 0.2s, box-shadow 0.2s;
        }

        .btn-success {
            background-color: #2e7d32;
            border: none;
        }

        .btn-success:hover {
            background-color: #388e3c;
        }

        .btn-primary {
            background-color: #e8b200;
            border: none;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #c49c00;
        }

        .btn-danger {
            background-color: #e53935;
            border: none;
        }

        .btn-danger:hover {
            background-color: #b71c1c;
        }

        .form-control,
        .form-control-plaintext {
            border-radius: 8px;
            border: 1px solid #000000;
            font-size: 15px;
            padding: 8px 12px;
            background-color: #fff;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            border-color: #ffffff;
            box-shadow: 0 0 0 2px #fffbe6;
        }

        label {
            font-weight: 500;
            color: #000000;
            font-size: 14px;
        }

        .card-6 .card-body-6 {
            background: #ffffff;
            border-radius: 10px;
            padding: 10px 0 10px 10px;
            box-shadow: 0 2px 8px rgba(232, 178, 0, 0.07);
        }

        @media (max-width: 900px) {

            .card-detail .card-body-detail,
            .card-rekomendasi .card-body-rekomendasi,
            .card-4 .card-body-4,
            .card-3 .card-body-3 {
                width: 100%;
                padding: 10px;
                margin-left: 0;
            }

            .container {
                padding: 0;
            }
        }
    </style>

</head>

<div class= "container-header">
    <div class="row-header">
        <div class="col-header">
            <p class="pt-3 mt-3 ms-5 ps-5">TAMBAH REKOMENDASI</p>
        </div>
    </div>

    <body>

        @extends('layouts.app')

        @section('title', 'Add Rekomendasi')

        @section('content')
            <div id="mainContent">
                <div class="row mt-2 ms-4 me-4">
                    <div class="col-md-5">
                        <div class="card-4 mb-5">
                            <div class="card-body-4">
                                <form id="mainForm" class="ms-2" method="POST" action="/add_rekomendasi">
                                    @csrf
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1" class="mb-1">No. Rekomendasi</label>
                                        <input type="text" readonly
                                            class="form-control-plaintext border px-2 text-center" id="norekom"
                                            name="norekom" value="{{ $lastId + 1 }}" style="font-weight: bold;">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="exampleFormControlInput1" class="mb-1 mt-2">No. PR</label>
                                        <input class="form-control" id="no_spb" name="no_spb">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="tanggal_pengajuan" class="mb-1 mt-2">Tanggal Pengajuan</label>
                                        <input type="date" class="form-control" id="tanggal_pengajuan" name="tgl_masuk">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="exampleFormControlInput1" class="mb-1 mt-2">Nama Pengaju</label>
                                        <input class="form-control" id="namapengaju" name="nama_lengkap"
                                            placeholder="Masukan Nama Anda">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="department" class="mb-1 mt-2">Department</label>
                                        <select class="form-control" id="kode_dep" name="kode_dep">
                                            @foreach ($departments as $dep)
                                                <option value="{{ $dep->kode_dep }}">{{ $dep->nama_dep }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="alasan" class="mb-1 mt-2">Alasan</label>
                                        <textarea class="form-control" id="alasan" name="alasan_rek" rows="3" placeholder="Masukkan Alasan"></textarea>
                                    </div>

                                    <!-- Tempatkan input detail rekomendasi di sini -->
                                    <div id="detailInputs"></div>

                                    <div class="card-6 mt-1 mb-5 d-flex justify-content-end">
                                        <div class="card-body-6">
                                            <div class="d-flex gap-2 mt-3 justify-content-end"
                                                style="margin-bottom: -30px;">
                                                <button type="submit" class="btn btn-success fw-bold fs-6">Simpan</button>
                                                <button type="button" class="btn btn-danger fw-bold fs-6">Batal</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <button id="addRekomendasiBtn" type="button" class="btn btn-primary mb-3 ms-4 shadow-sm">
                            <i class="bi bi-plus-circle me-1"></i>Tambah Rekomendasi
                        </button>
                        <div id="rekomendasiCards"></div>
                    </div>
                </div>
            </div>
        @endsection

        @php
            $pageTitle = 'Add Rekomendasi';
        @endphp

        <script>
            let detailList = [];
            document.addEventListener('DOMContentLoaded', function() {
                const btn = document.getElementById('addRekomendasiBtn');
                const container = document.getElementById('rekomendasiCards');
                const detailInputs = document.getElementById('detailInputs');
                const mainForm = document.getElementById('mainForm');
                const batalBtn = mainForm.querySelector('.btn-danger');

                btn.addEventListener('click', function() {
                    const idx = detailList.length;
                    const card = document.createElement('div');
                    card.className = 'card-3 mb-3';
                    card.innerHTML = `
                    <div class="card-body-3">
                        <div class="form-group">
                            <label for="jenisunit_${idx}" class="mb-1">Jenis Unit</label>
                            <input class="form-control" id="jenisunit_${idx}" placeholder="Masukkan Jenis Unit">
                        </div>
                        <div class="form-group">
                            <label for="keterangan_${idx}" class="mb-1 mt-2">Keterangan</label>
                            <input class="form-control" id="keterangan_${idx}" placeholder="Masukkan Keterangan">
                        </div>
                        <div class="form-group mt-2">
                            <label for="estimasiharga_${idx}" class="mb-1 mt-1">Estimasi Harga (Rp)</label>
                            <input class="form-control" id="estimasiharga_${idx}" placeholder="Rp.">
                        </div>
                        <button type="button" class="btn btn-success mt-3 shadow-sm" onclick="addDetail(${idx})">
                            <i class="bi bi-check2-circle me-1"></i>Simpan Detail
                        </button>
                    </div>
                `;
                    container.appendChild(card);
                });

                window.addDetail = function(idx) {
                    const jenis = document.getElementById(`jenisunit_${idx}`).value;
                    const ket = document.getElementById(`keterangan_${idx}`).value;
                    const harga = document.getElementById(`estimasiharga_${idx}`).value;
                    if (jenis && ket && harga) {
                        detailList.push({
                            jenis_unit: jenis,
                            ket_unit: ket,
                            estimasi_harga: harga
                        });
                        // Tambahkan input hidden ke form utama
                        const inputDiv = document.createElement('div');
                        inputDiv.innerHTML = `
                        <input type="hidden" name="detail_rekomendasi[${detailList.length-1}][jenis_unit]" value="${jenis}">
                        <input type="hidden" name="detail_rekomendasi[${detailList.length-1}][ket_unit]" value="${ket}">
                        <input type="hidden" name="detail_rekomendasi[${detailList.length-1}][estimasi_harga]" value="${harga}">
                        `;
                        detailInputs.appendChild(inputDiv);

                        // Card kalau sudah tersimpan datanya
                        const savedCard = document.createElement('div');
                        savedCard.className = 'card-3 mb-2';
                        savedCard.innerHTML = `
                        <div class="card-body-3">
                            <table class="table table-bordered mb-0">
                                <tr>
                                    <th style="width: 30%; font-weight: normal;">Jenis Unit</th>
                                    <td style="width: 70%;">${jenis}</td>
                                </tr>
                                <tr>
                                    <th style="width: 30%; font-weight: normal;">Keterangan</th>
                                    <td style="width: 70%;">${ket}</td>
                                </tr>
                                <tr>
                                    <th style="width: 30%; font-weight: normal;">Estimasi Harga</th>
                                    <td style="width: 70%;">Rp. ${harga}</td>
                                </tr>
                            </table>
                        </div>
                        `;
                        // Tampilkan di bawah semua card
                        container.appendChild(savedCard);

                        // Hapus card input yang baru saja diisi
                        const inputCard = document.getElementById(`jenisunit_${idx}`).closest('.card-3');
                        inputCard.remove();

                        alert('Detail berhasil ditambahkan!');
                    } else {
                        alert('Semua field detail harus diisi!');
                    }
                }

                batalBtn.addEventListener('click', function() {
                    // Kosongkan semua input di form utama
                    mainForm.reset();
                    // Kosongkan semua card input detail yang belum disimpan
                    Array.from(container.querySelectorAll('.card-3')).forEach(function(card) {
                        // Hanya hapus card yang masih ada input (editable)
                        if (card.querySelector('input[id^="jenisunit_"]')) {
                            card.remove();
                        }
                    });
                    // Kosongkan input hidden detail
                    detailInputs.innerHTML = '';
                });
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
        </script>
    </body>

</html>
