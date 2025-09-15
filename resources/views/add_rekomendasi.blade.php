<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Rekomendasi</title>

    <link rel="stylesheet" href="./assets/css/bootstrap.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        body {
            background-color: #efefef;
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

        <div class="card-3 mt-2 ms-4 me-4">
            <div class="card-body-3">
                <div class="row">
                    <div class="col">
                        <form class="ms-2">
                            <div class="form-group">
                                <label for="exampleFormControlInput1" class="mb-1">No. Rekomendasi</label>
                                <input type="email" class="form-control" id="exampleFormControlInput1">
                            </div>
                            <div class="form-group mt-2">
                                <label for="exampleFormControlInput1" class="mb-1">No. PR</label>
                                <input class="form-control" id="pr">
                            </div>
                            <div class="form-group mt-2">
                                <label for="exampleFormControlInput1" class="mb-1">Nama Pengaju</label>
                                <input class="form-control" id="namapengaju" placeholder="Masukan Nama Anda">
                            </div>
                            <div class="form-group mt-2">
                                <label for="exampleFormControlSelect1" class="mb-1">Department</label>
                                <select class="form-control" id="department">
                                    <option>Accounting</option>
                                    <option>Human Resources</option>
                                    <option>IT</option>
                                    <option>Marketing</option>
                                    <option>Sales</option>
                                </select>
                            </div>

                        </form>

                    </div>
                    <div class="col">
                        <form>
                            <div class="form-group">
                                <label for="exampleFormControlInput1" class="mb-1">Jenis Unit</label>
                                <input class="form-control" id="jenisunit" placeholder="Masukkan Jenis Unit">
                            </div>
                            <div class="form-group mt-2">
                                <label for="exampleFormControlTextarea1">Keterangan</label>
                                <textarea class="form-control" id="keterangan" rows="3"></textarea>
                            </div>
                            <div class="form-group mt-2">
                                <label for="exampleFormControlInput1">Estimasi Harga (Rp)</label>
                                <input class="form-control" id="estimasiharga" placeholder="Rp.">
                            </div>

                            <div class="form-group mt-2">
                                <label for="tanggal_pengajuan">Tanggal Pengajuan</label>
                                <input type="date" class="form-control" id="tanggal_pengajuan" name="tanggal_pengajuan">
                            </div>


                            <div class="d-flex gap-2 mt-3 justify-content-end">
                                <button type="button" class="btn btn-success fw-bold fs-6">Simpan</button>
                                <button type="button" class="btn btn-success fw-bold fs-6">Simpan & Lanjut</button>
                                <button type="button" class="btn btn-danger fw-bold fs-6">Batal</button>
                            </div>


                        </form>
                    </div>
                </div>



            </div>
        </div>
    @endsection

    @php
        $pageTitle = 'Add Rekomendasi';
    @endphp

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
</body>

</html>
