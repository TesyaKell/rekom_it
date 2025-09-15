<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar Rekomendasi</title>

    <link rel="stylesheet" href="./assets/css/bootstrap.min.css" />
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

        .container-1 {
            margin-top: -20px;
        }

        .row-2 .col-12 {
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

        .container-2 {
            background-color: #ffffff;
        }
    </style>
</head>



{{-- <img src="{{ asset('images/header.png') }}" class="h-20 object-contain rounded-t-xl" alt="No image"> --}}

<div class= "container-1">
    <div class="row-2">
        <div class="col-12">

        </div>
        <div class="row-2">
            <div class="col-12">
                <p class="pt-3 mt-3 ms-3">Daftar Rekomendasi & Servis Komputer</p>
            </div>
        </div>
    </div>


    <body>

        <div class="container-2 w-auto h-100 ms-3 me-3 mt-3 pt-2 pb-2">
            <div class="row">
                <div class="col-4">
                    <form class="d-flex justify-content-start">
                        <input class="form-control w-50 me-2 ms-2 mt-2 mb-2" type="search" placeholder="Search"
                            aria-label="Search">
                        <button class="btn btn-outline-success w-15 h-25 mt-2" type="submit">Search</button>
                    </form>
                </div>

                <div class="col-4 d-flex justify-content-start">
                    <div class="dropdown mt-2">
                        <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Semua Rekomendasi
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Semua Rekomendasi</a></li>
                            <li><a class="dropdown-item" href="#">Belum Realisasi</a></li>
                            <li><a class="dropdown-item" href="#">Sudah Realisasi</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-4 d-flex justify-content-end">
                    <button type="button" class="btn btn-success mt-2 mb-2 me-2 fw-bold fs-6">Tambah Data
                        Rekomendasi</button>
                </div>
            </div>
        </div>



        <div class="container">
            <div class="row row-cols-8">
                <div class="col">Nomor Rekomendasi</div>
                <div class="col">Nomor PR</div>
                <div class="col">Jenis Unit</div>
                <div class="col">Nama Pengaju</div>
                <div class="col">Department</div>
                <div class="col">Tanggal Pengajuan</div>
                <div class="col">Status</div>
                <div class="col">Action</div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
        </script>
    </body>

</html>
