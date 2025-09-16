<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar Department</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


    <style>
        body {
            background-color: #efefef;
        }

        .row .col {
            border: 1px solid #000;
            background-color: #fff;
            text-align: center;
            padding: 10px;
        }

        .col-5,
        .col-7 {
            border: 1px solid #000;
            background-color: #fff;
            text-align: center;
            padding: 10px;
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

        .row {
            margin-bottom: 0;
            margin-top: 0;
        }

        .tight-rows .row+.row {
            margin-top: -1px;
        }

        .table-grid .col {
            margin-bottom: 0;
            border-bottom: none;
        }

        .table-grid .row:last-child .col {
            border-bottom: 1px solid #000;
        }
    </style>
</head>

<div class="container-1">
    <div class="row-2">
        <div class="col-12">

        </div>
        <div class="row-2">
            <div class="col-12">
                <p class="pt-3 ms-5 ps-5">Daftar Department</p>
            </div>
        </div>
    </div>

    <body>

        <div class="container tight-rows table-grid m-3 w-50">
            <div class="row g-0">
                <div class="col-5">Nomor Rekomendasi</div>
                <div class="col-7">Nomor PR</div>
            </div>
            <div class="row g-0">
                <div class="col-5">Jenis Unit</div>
                <div class="col-7">Nama Pengaju</div>
            </div>
            <div class="row g-0">
                <div class="col">Department</div>
            </div>
        </div>

        <div class="container mt-4 m-3 tight-rows table-grid">
            <div class="row g-0 row-cols-8">
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
    </body>

</html>

@extends('layouts.app')

@section('title', 'Daftar Department')

@php
    $pageTitle = 'Daftar Department';
@endphp
