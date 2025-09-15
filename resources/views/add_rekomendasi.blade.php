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
        }
    </style>

</head>

<body>
    <div class="card">
        <div class="card-body">
            <p>Buat Rekomendasi</p>
        </div>
    </div>
    <div class="card mt-2 ms-4 me-4">
        <div class="card-body">
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
                            <label for="exampleFormControlInput1" class="mb-1">Jenis Unit</label>
                            <input class="form-control" id="jenisunit" placeholder="Masukkan Jenis Unit">
                        </div>
                    </form>

                </div>
                <div class="col">
                    <form>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Department</label>
                            <select class="form-control" id="department">
                                <option>Accounting</option>
                                <option>Human Resources</option>
                                <option>IT</option>
                                <option>Marketing</option>
                                <option>Sales</option>
                            </select>
                        </div>
                        <div class="form-group mt-2">
                            <label for="exampleFormControlTextarea1">Keterangan</label>
                            <textarea class="form-control" id="keterangan" rows="3"></textarea>
                        </div>
                        <div class="form-group mt-2">
                            <label for="exampleFormControlInput1">Estimasi Harga (Rp)</label>
                            <input class="form-control" id="estimasiharga" placeholder="Rp.">
                        </div>


                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <button type="button" class="btn btn-success mt-2 mb-2 me-2 fw-bold fs-6">Tambah
                                        Simpan</button>
                                </div>
                                <div class="col">
                                    <button type="button" class="btn btn-success mt-2 mb-2 me-2 fw-bold fs-6">Tambah
                                        Simpan & Lanjut</button>
                                </div>
                                <div class="col d-flex justify-content-end">
                                    <button type="button" class="btn btn-success mt-2 mb-2 me-2 fw-bold fs-6">Tambah
                                        Batal</button>
                                </div>
                            </div>
                        </div>


                    </form>
                </div>
            </div>



        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
</body>

</html>
