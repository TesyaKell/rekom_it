<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Grafik Rekomendasi</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(120deg, #fff 60%, #0d606e 100%);
        }

        canvas {
            max-height: 400px;
        }

        .card-custom {
            background: #fff;
            border-radius: 1.5rem;
            box-shadow: 0 4px 24px rgba(13, 96, 110, 0.12);
            border: 1px solid #0d606e;
            transition: box-shadow 0.2s, border 0.2s;
        }

        .card-custom:hover {
            box-shadow: 0 8px 32px rgba(13, 96, 110, 0.18);
            border: 1.5px solid #ffa800;
        }

        .card-header-custom {
            background: linear-gradient(90deg, #0d606e 70%, #ffa800 100%);
            border-bottom: none;
            border-radius: 1.5rem 1.5rem 0 0;
            padding: 1rem 1.5rem;
        }

        .divider {
            height: 4px;
            width: 120px;
            margin: 0 auto;
            background: linear-gradient(to right, #fff, #ffa800, #0d606e, #fff);
            border-radius: 2px;
        }

        .display-5 {
            color: #0d606e;
            text-shadow: 0 2px 8px #ffa80033;
        }

        .subtitle-custom {
            color: #ffa800;
            font-size: 1.25rem;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        .bg-body {
            background: linear-gradient(120deg, #fff 60%, #0d606e 100%);
        }

        .chart-bg {
            background-color: #f8fafc;
            border-radius: 1rem;
            padding: 1rem;
            border: 1px solid #0d606e22;
        }
    </style>
</head>
<div class= "container-header">

    <body class="bg-body p-4">
        <div class="container my-4">
            <!-- Header -->
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold mb-2 text-shadow">
                    Grafik Rekomendasi
                </h1>
                <p class="subtitle-custom mb-1">Dashboard Analisis per Bulan dan Departemen</p>
                <div class="divider mb-3"></div>
            </div>

            <!-- Charts Grid -->
            <div class="row g-4">
                <!-- Monthly Chart -->
                <div class="col-12 col-lg-6">
                    <div class="card card-custom h-100">
                        <div class="card-header card-header-custom d-flex align-items-center mb-2">
                            <div
                                style="width:8px; height:40px; background:linear-gradient(to bottom,#ffa800,#0d606e); border-radius:8px; margin-right:16px;">
                            </div>
                            <h2 class="h5 fw-semibold text-light mb-0" style="letter-spacing:1px;">Rekomendasi per Bulan
                            </h2>
                        </div>
                        <div class="card-body chart-bg">
                            <canvas id="monthlyChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Department Chart -->
                <div class="col-12 col-lg-6">
                    <div class="card card-custom h-100">
                        <div class="card-header card-header-custom d-flex align-items-center mb-2">
                            <div
                                style="width:8px; height:40px; background:linear-gradient(to bottom,#ffa800,#0d606e); border-radius:8px; margin-right:16px;">
                            </div>
                            <h2 class="h5 fw-semibold text-light mb-0" style="letter-spacing:1px;">Rekomendasi per
                                Departemen</h2>
                        </div>
                        <div class="card-body chart-bg">
                            <canvas id="departmentChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            const monthlyData = @json($monthlyData);
            const departmentData = @json($departmentData);
            const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
            new Chart(monthlyCtx, {
                type: 'line',
                data: {
                    labels: monthlyData.map(d => d.bulan),
                    datasets: [{
                        label: 'Jumlah Rekomendasi',
                        data: monthlyData.map(d => d.total),
                        borderColor: '#0d606e',
                        backgroundColor: 'rgba(13, 96, 110, 0.12)',
                        tension: 0.4,
                        fill: true,
                        borderWidth: 4,
                        pointBackgroundColor: '#ffa800',
                        pointBorderColor: '#0d606e',
                        pointBorderWidth: 2,
                        pointRadius: 7,
                        pointHoverRadius: 10,
                        pointHoverBackgroundColor: '#0d606e',
                        pointHoverBorderColor: '#ffa800',
                        pointHoverBorderWidth: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                color: '#0d606e',
                                font: {
                                    size: 15,
                                    weight: '600'
                                },
                                padding: 20
                            }
                        },
                        tooltip: {
                            backgroundColor: '#0d606e',
                            titleColor: '#ffa800',
                            bodyColor: '#fff',
                            borderColor: '#ffa800',
                            borderWidth: 2
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 5,
                                color: '#0d606e',
                                font: {
                                    size: 13
                                }
                            },
                            grid: {
                                color: '#ffa80022',
                                drawBorder: false
                            }
                        },
                        x: {
                            ticks: {
                                color: '#0d606e',
                                font: {
                                    size: 13
                                }
                            },
                            grid: {
                                color: '#ffa80011',
                                drawBorder: false
                            }
                        }
                    }
                }
            });

            // Department Chart (Bar)
            const deptCtx = document.getElementById('departmentChart').getContext('2d');
            new Chart(deptCtx, {
                type: 'bar',
                data: {
                    labels: departmentData.map(d => d.nama_dep),
                    datasets: [{
                        label: 'Jumlah Rekomendasi',
                        data: departmentData.map(d => d.total),
                        backgroundColor: [
                            '#ffa800cc',
                            '#0d606ecc',
                            '#ffa80099',
                            '#0d606e99'
                        ],
                        borderColor: [
                            '#0d606e',
                            '#ffa800',
                            '#0d606e',
                            '#ffa800'
                        ],
                        borderWidth: 2,
                        borderRadius: 12,
                        hoverBackgroundColor: [
                            '#ffa800',
                            '#0d606e',
                            '#ffa800',
                            '#0d606e'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#0d606e',
                            titleColor: '#ffa800',
                            bodyColor: '#fff',
                            borderColor: '#ffa800',
                            borderWidth: 2
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 10,
                                color: '#0d606e',
                                font: {
                                    size: 13
                                }
                            },
                            grid: {
                                color: '#ffa80022',
                                drawBorder: false
                            }
                        },
                        x: {
                            ticks: {
                                color: '#0d606e',
                                font: {
                                    size: 13
                                }
                            },
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>

</html>


@extends('layouts.app')

@section('title', 'Home')

@php
    $pageTitle = 'Home';
@endphp
