<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Rekomendasi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        body {
            background-color: #efefef;
        }

        title {
            font-weight: bold;
        }

        p {
            color: #e8b200;
            margin-bottom: 5px;
            font-weight: bold;
            margin-left: 70px;
        }

        .card-2 .card-body-2 {
            background-color: #ffffff;
            height: 50px;
            padding-top: 10px;
        }

        .card-3 .card-body-3 {
            background-color: #ffffff;
            padding: 15px;
            width: 650px;
            margin-left: 30px;
            border-radius: 15px;
        }

        .card-4 .card-body-4 {
            background-color: #ffffff;
            padding: 15px;
            width: 450px;
            border-radius: 15px;
        }
    </style>

</head>

<body>
    <div class="card-2">
        <div class="card-body-2 ps-3">
            <p>Buat Rekomendasi</p>
        </div>
    </div>

    @extends('layouts.app')

    @section('title', 'Add Rekomendasi')

    @section('content')
        {{-- 🔑 Tambahkan wrapper untuk konten utama --}}
        <div id="mainContent">
            <div class="row mt-2 ms-4 me-4">
                <div class="col-md-5">
                    <div class="card-4">
                        <div class="card-body-4">
                            <form id="mainForm" class="ms-2" method="POST" action="/add_rekomendasi">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleFormControlInput1" class="mb-1">No. Rekomendasi</label>
                                    <input type="text" readonly class="form-control-plaintext border px-2 text-center"
                                        id="norekom" name="norekom" value="{{ $lastId + 1 }}">
                                </div>
                                <div class="form-group mt-2">
                                    <label for="exampleFormControlInput1" class="mb-1 mt-1">No. PR</label>
                                    <input class="form-control" id="no_spb" name="no_spb">
                                </div>
                                <div class="form-group mt-2">
                                    <label for="tanggal_pengajuan" class="mb-1 mt-1">Tanggal Pengajuan</label>
                                    <input type="date" class="form-control" id="tanggal_pengajuan" name="tgl_masuk">
                                </div>
                                <div class="form-group mt-2">
                                    <label for="exampleFormControlInput1" class="mb-1 mt-1">Nama Pengaju</label>
                                    <input class="form-control" id="namapengaju" name="nama_lengkap"
                                        placeholder="Masukan Nama Anda">
                                </div>
                                <div class="form-group mt-2">
                                    <label for="department" class="mb-1 mt-1">Department</label>
                                    <select class="form-control" id="kode_dep" name="kode_dep">
                                        @foreach ($departments as $dep)
                                            <option value="{{ $dep->kode_dep }}">{{ $dep->nama_dep }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mt-2">
                                    <label for="alasan" class="mb-1 mt-1">Alasan</label>
                                    <textarea class="form-control" id="alasan" name="alasan_rek" rows="3" placeholder="Masukkan Alasan"></textarea>
                                </div>

                                <!-- Tempatkan input detail rekomendasi di sini -->
                                <div id="detailInputs"></div>

                                <div class="card-6 mt-1 mb-5 d-flex justify-content-start">
                                    <div class="card-body-6">
                                        <div class="d-flex gap-2 mt-3 justify-content-start">
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
                    <button id="addRekomendasiBtn" type="button" class="btn btn-primary mb-3 ms-4">
                        Tambah Rekomendasi [+]
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
                        <button type="button" class="btn btn-success mt-2" onclick="addDetail(${idx})">Simpan Detail</button>
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
                    alert('Detail berhasil ditambahkan!');
                } else {
                    alert('Semua field detail harus diisi!');
                }
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
</body>

</html>
