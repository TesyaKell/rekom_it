<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Grafik Rekomendasi</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        canvas {
            max-height: 400px;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-gray-900 via-blue-950 to-black min-h-screen p-4 md:p-8">
    <div class="container mx-auto max-w-7xl">
        <!-- Header -->
        <div class="text-center mb-8 md:mb-12">
            <h1
                class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-blue-400 via-cyan-300 to-blue-600 bg-clip-text text-transparent mb-3 drop-shadow-lg">
                Grafik Rekomendasi
            </h1>
            <p class="text-blue-200/80 text-base md:text-lg font-light">Dashboard Analisis per Bulan dan Departemen</p>
            <div
                class="mt-4 h-1 w-32 mx-auto bg-gradient-to-r from-transparent via-blue-400 to-transparent rounded-full">
            </div>
        </div>

        <!-- Charts Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">
            <!-- Monthly Chart -->
            <div
                class="group bg-gradient-to-br from-gray-800/80 to-blue-950/80 backdrop-blur-xl border border-blue-500/30 rounded-3xl p-6 md:p-8 shadow-xl hover:shadow-blue-600/40 hover:border-blue-400/60 transition-all duration-300 hover:scale-[1.01]">
                <div class="flex items-center gap-3 mb-6">
                    <div
                        class="w-1.5 h-10 bg-gradient-to-b from-blue-400 to-blue-600 rounded-full shadow-lg shadow-blue-500/50">
                    </div>
                    <h2 class="text-xl md:text-2xl font-semibold text-blue-100">Rekomendasi per Bulan</h2>
                </div>
                <div class="bg-gray-900/50 backdrop-blur-sm rounded-2xl p-4 md:p-6 border border-blue-600/20">
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>

            <!-- Department Chart -->
            <div
                class="group bg-gradient-to-br from-gray-800/80 to-blue-950/80 backdrop-blur-xl border border-blue-500/30 rounded-3xl p-6 md:p-8 shadow-xl hover:shadow-blue-600/40 hover:border-blue-400/60 transition-all duration-300 hover:scale-[1.01]">
                <div class="flex items-center gap-3 mb-6">
                    <div
                        class="w-1.5 h-10 bg-gradient-to-b from-blue-400 to-blue-600 rounded-full shadow-lg shadow-blue-500/50">
                    </div>
                    <h2 class="text-xl md:text-2xl font-semibold text-blue-100">Rekomendasi per Departemen</h2>
                </div>
                <div class="bg-gray-900/50 backdrop-blur-sm rounded-2xl p-4 md:p-6 border border-blue-600/20">
                    <canvas id="departmentChart"></canvas>
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
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 4,
                    pointBackgroundColor: '#1e40af',
                    pointBorderColor: '#93c5fd',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    pointHoverBackgroundColor: '#2563eb',
                    pointHoverBorderColor: '#bfdbfe',
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
                            color: '#bfdbfe',
                            font: {
                                size: 14,
                                weight: '500'
                            },
                            padding: 20
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(30, 64, 175, 0.9)',
                        titleColor: '#e0f2fe',
                        bodyColor: '#e0f2fe',
                        borderColor: '#3b82f6',
                        borderWidth: 1
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 5,
                            color: '#93c5fd',
                            font: {
                                size: 12
                            }
                        },
                        grid: {
                            color: 'rgba(147, 197, 253, 0.1)',
                            drawBorder: false
                        }
                    },
                    x: {
                        ticks: {
                            color: '#93c5fd',
                            font: {
                                size: 12
                            }
                        },
                        grid: {
                            color: 'rgba(147, 197, 253, 0.05)',
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
                        'rgba(59, 130, 246, 0.7)',
                        'rgba(96, 165, 250, 0.7)',
                        'rgba(37, 99, 235, 0.7)',
                        'rgba(29, 78, 216, 0.7)'
                    ],
                    borderColor: [
                        '#3b82f6',
                        '#60a5fa',
                        '#2563eb',
                        '#1d4ed8'
                    ],
                    borderWidth: 2,
                    borderRadius: 12,
                    hoverBackgroundColor: [
                        'rgba(59, 130, 246, 0.9)',
                        'rgba(96, 165, 250, 0.9)',
                        'rgba(37, 99, 235, 0.9)',
                        'rgba(29, 78, 216, 0.9)'
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
                        backgroundColor: 'rgba(30, 64, 175, 0.9)',
                        titleColor: '#e0f2fe',
                        bodyColor: '#e0f2fe',
                        borderColor: '#3b82f6',
                        borderWidth: 1
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 10,
                            color: '#93c5fd',
                            font: {
                                size: 12
                            }
                        },
                        grid: {
                            color: 'rgba(147, 197, 253, 0.1)',
                            drawBorder: false
                        }
                    },
                    x: {
                        ticks: {
                            color: '#93c5fd',
                            font: {
                                size: 12
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
</body>

</html>


@extends('layouts.app')

@section('title', 'Home')

@php
    $pageTitle = 'Home';
@endphp
