@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="mt-4">
        <h1>Selamat Datang, {{ Auth::user()->name }}!</h1>
        <p class="lead">Ini adalah dashboard Anda. Silakan pilih menu di sidebar untuk mengelola data.</p>
    </div>

    <div class="row mt-4">
        <!-- Produk, Vendor, Stokis, Mitra Count -->
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Total Produk</div>
                <div class="card-body">
                    <h5 class="card-title text-center">{{ $produkCount }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Total Vendor</div>
                <div class="card-body">
                    <h5 class="card-title text-center">{{ $vendorCount }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Total Stokis</div>
                <div class="card-body">
                    <h5 class="card-title text-center">{{ $stokisCount }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger mb-3">
                <div class="card-header">Total Mitra</div>
                <div class="card-body">
                    <h5 class="card-title text-center">{{ $mitraCount }}</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Chart Pembelian -->
        <div class="col-md-6">
            <!-- Mengatur tinggi chart menjadi 2 kali lipat -->
            <canvas id="pembelianChart" style="height: 400px;"></canvas>
        </div>
        <!-- Chart Pengiriman -->
        <div class="col-md-6">
            <!-- Mengatur tinggi chart menjadi 2 kali lipat -->
            <canvas id="pengirimanChart" style="height: 400px;"></canvas>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Chart Inventaris -->
        <div class="col-md-12">
            <!-- Mengatur tinggi chart menjadi 2 kali lipat -->
            <canvas id="inventarisChart" style="height: 600px;"></canvas>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Tambahkan Chart.js dari CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Plugin untuk mengatur background chart
        const backgroundColorPlugin = {
            id: 'custom_background_color',
            beforeDraw: (chart) => {
                const ctx = chart.ctx;
                ctx.save();
                ctx.fillStyle = 'rgba(0, 0, 0, 0.5)'; // Warna hitam transparan
                ctx.fillRect(0, 0, chart.width, chart.height);
                ctx.restore();
            }
        };

        // Mendaftarkan plugin
        Chart.register(backgroundColorPlugin);

        // Data untuk Chart Pembelian
        var pembelianLabels = {!! json_encode($pembelianLabels) !!};
        var pembelianData = {!! json_encode($pembelianData) !!};

        // Data untuk Chart Pengiriman
        var pengirimanLabels = {!! json_encode($pengirimanLabels) !!};
        var pengirimanData = {!! json_encode($pengirimanData) !!};

        // Data untuk Chart Inventaris
        var inventarisLabels = {!! json_encode($inventarisLabels) !!};
        var inventarisValues = {!! json_encode($inventarisValues) !!};

        // Chart Pembelian
        var pembelianCtx = document.getElementById('pembelianChart').getContext('2d');
        var pembelianChart = new Chart(pembelianCtx, {
            type: 'line',
            data: {
                labels: pembelianLabels,
                datasets: [{
                    label: 'Pembelian per Bulan',
                    data: pembelianData,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    fill: true,
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Menonaktifkan rasio aspek default
                scales: {
                    x: {
                        ticks: {
                            color: 'white' // Warna label sumbu x
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.2)' // Warna grid sumbu x
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: 'white', // Warna label sumbu y
                            precision: 0
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.2)' // Warna grid sumbu y
                        }
                    }
                },
                plugins: {
                    custom_background_color: true, // Mengaktifkan plugin background
                    title: {
                        display: true,
                        text: 'Grafik Pembelian per Bulan',
                        color: 'white', // Warna judul
                        font: {
                            size: 18
                        }
                    },
                    legend: {
                        labels: {
                            color: 'white' // Warna label legenda
                        }
                    }
                }
            }
        });

        // Chart Pengiriman
        var pengirimanCtx = document.getElementById('pengirimanChart').getContext('2d');
        var pengirimanChart = new Chart(pengirimanCtx, {
            type: 'line',
            data: {
                labels: pengirimanLabels,
                datasets: [{
                    label: 'Pengiriman per Bulan',
                    data: pengirimanData,
                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                    borderColor: 'rgba(255, 159, 64, 1)',
                    fill: true,
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        ticks: {
                            color: 'white'
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.2)'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: 'white',
                            precision: 0
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.2)'
                        }
                    }
                },
                plugins: {
                    custom_background_color: true,
                    title: {
                        display: true,
                        text: 'Grafik Pengiriman per Bulan',
                        color: 'white',
                        font: {
                            size: 18
                        }
                    },
                    legend: {
                        labels: {
                            color: 'white'
                        }
                    }
                }
            }
        });

        // Chart Inventaris
        var inventarisCtx = document.getElementById('inventarisChart').getContext('2d');
        var inventarisChart = new Chart(inventarisCtx, {
            type: 'bar',
            data: {
                labels: inventarisLabels,
                datasets: [{
                    label: 'Kuantitas Produk di Inventaris',
                    data: inventarisValues,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'x',
                scales: {
                    x: {
                        ticks: {
                            color: 'white',
                            autoSkip: false,
                            maxRotation: 90,
                            minRotation: 45
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.2)'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: 'white',
                            precision: 0
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.2)'
                        }
                    }
                },
                plugins: {
                    custom_background_color: true,
                    title: {
                        display: true,
                        text: 'Grafik Kuantitas Inventaris per Produk',
                        color: 'white',
                        font: {
                            size: 18
                        }
                    },
                    legend: {
                        labels: {
                            color: 'white'
                        }
                    }
                }
            }
        });
    </script>
@endsection