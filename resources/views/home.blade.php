<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


    <style>
        body {
            background-color: #ebefe6;
        }

        .card {
            background-color: rgb(70, 140, 9);
        }

        .card-body {
            padding: 5px;
            padding-top: 3px;
            padding-bottom: 0px;
        }

        .hamburger-icon {
            display: inline-block;
            cursor: pointer;
            margin: 0px;
        }

        .hamburger-line {
            width: 25px;
            height: 3px;
            background-color: #ffffff;
            margin: 4px 0;
            transition: 0.4s;
        }

        .position-fixed {
            background-color: rgb(70, 140, 9);
        }

        .nav {
            width: 100%;
            padding: 0;
        }

        .y-sidebarItem {
            width: 115%;
            margin-left: -15px;
        }

        .nav-link {
            display: block;
            width: 100%;
            color: white;
            padding: 10px 15px;
            margin: 0;
            text-align: left;
        }

        .nav-link:hover {
            background-color: rgb(54, 109, 6);
            color: white;
            transform: scale(1.02);
        }

        h3 {
            color: white;
            margin-top: 7px;
        }

        /* .btn {
            display: block;
            width: 109%;
            color: white;
            padding: 10px 15px;
            margin: 0;
            text-align: left;
            margin-left: -15px;
        } */
    </style>

</head>

<img src="{{ asset('images/header.png') }}" class="h-20 object-contain rounded-t-xl" alt="No image">


<body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
</body>

</html>

@extends('layouts.app')

@section('title', 'Home')

@php
    $pageTitle = 'Home';
@endphp
