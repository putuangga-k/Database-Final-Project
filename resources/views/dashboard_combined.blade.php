<!-- resources/views/dashboard_combined.blade.php -->
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Definisikan Nama Kategori di PHP -->
    @php
        $categoryNames = [
            1 => 'Ayam',
            2 => 'Tepung',
            3 => 'Saus',
            4 => 'Packaging'
        ];
    @endphp

    <!-- Sambutan -->
    <div class="mt-4">
        <h1>Selamat Datang, {{ Auth::user()->name }}!</h1>
        <p class="lead">Silakan Pilih dari Dropdown Menu untuk Informasi Lebih Lanjut!</p>
    </div>

    <!-- Statistik Utama -->
    <div class="row mt-4">
        <!-- Total Produk -->
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Total Produk</div>
                <div class="card-body">
                    <h5 class="card-title text-center">{{ $produkCount }}</h5>
                </div>
            </div>
        </div>
        <!-- Total Vendor -->
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Total Vendor</div>
                <div class="card-body">
                    <h5 class="card-title text-center">{{ $vendorCount }}</h5>
                </div>
            </div>
        </div>
        <!-- Total Stokis -->
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Total Stokis</div>
                <div class="card-body">
                    <h5 class="card-title text-center">{{ $stokisCount }}</h5>
                </div>
            </div>
        </div>
        <!-- Total Mitra -->
        <div class="col-md-3">
            <div class="card text-white bg-danger mb-3">
                <div class="card-header">Total Mitra</div>
                <div class="card-body">
                    <h5 class="card-title text-center">{{ $mitraCount }}</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Kuantitas Inventaris Produk - Diletakkan di Tengah -->
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card bg-dark text-white mb-4">
                <div class="card-header bg-warning text-white">
                    <h4>Grafik Kuantitas Inventaris Produk</h4>
                </div>
                <div class="card-body">
                    <canvas id="inventarisChart" style="height: 400px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Fakta Penjualan dan Fakta Pengiriman -->
    <div class="mt-5" style="text-align: justify;">
        <h2 class="mb-4">Fakta Pembelian</h2>

        <!-- Formulir Filter -->
        <form action="{{ route('dashboard.combined') }}" method="GET" id="filterForm">
            <!-- Filter Kuartal di bawah Fakta Pembelian -->
            <div class="mb-4">
                <label for="quartile">Pilih Kuartal:</label>
                <select name="quartile" id="quartile" class="form-control w-25 d-inline-block">
                    <option value="all" {{ $kuartal == 'all' ? 'selected' : '' }}>Semua Kuartal</option>
                    @foreach($quartiles as $q)
                        <option value="{{ $q }}" {{ $kuartal == $q ? 'selected' : '' }}>{{ $q }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Statistik Fakta Penjualan -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <!-- Total Gain -->
                    <div class="card text-white bg-danger mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total Gain</h5>
                            <p class="card-text display-3">Rp {{ number_format($totalGain, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <!-- Total Vendor -->
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <h5 class="card-title">Total Vendor</h5>
                            <p class="card-text display-4">{{ $totalVendor }}</p>
                        </div>
                    </div>
                </div>

                <!-- Grafik Distribusi Total Gain per Vendor -->
                <div class="col-md-6">
                    <div class="card bg-dark text-white">
                        <div class="card-header bg-info text-white">
                            <h4>Distribusi Total Gain Berdasarkan Vendor</h4>
                        </div>
                        <div class="card-body">
                            <div style="height: 400px;">
                                <canvas id="chartVendor"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grafik Total Gain per Vendor -->
            <div class="card bg-dark text-white mb-4">
                <div class="card-header bg-primary text-white">
                    <h4>Total Gain per Vendor</h4>
                </div>
                <div class="card-body">
                    <canvas id="chartVendorGain" style="height: 400px;"></canvas>
                </div>
            </div>

            <!-- Grafik Total Gain per Bulan -->
            <div class="card bg-dark text-white mb-5">
                <div class="card-header bg-warning text-white">
                    <h4>Total Gain per Bulan</h4>
                </div>
                <div class="card-body">
                    <canvas id="chartGainPerMonth" style="height: 400px;"></canvas> 
                </div>
            </div>

            <!-- Fakta Pengiriman -->
            <div class="mt-5" style="text-align: justify;">
                <h2 class="mb-4">Fakta Pengiriman</h2>
            </div>

            <!-- Grafik Harga Total per Stokis dan Kuantitas Pengiriman per Bulan -->
            <div class="row mb-4">
                <!-- Grafik Harga Total per Stokis dengan Dropdown Kategori -->
                <div class="col-md-6">
                    <div class="card bg-dark text-white">
                        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                            <h4>Harga Total per Stokis (Kategori {{ $categoryNames[$selectedCategory] }})</h4>
                            <!-- Dropdown Pilih Kategori ditempatkan di sebelah judul -->
                            <div>
                                <label for="cat" class="mr-2">Pilih Kategori:</label>
                                <select name="cat" id="cat" class="form-control d-inline-block" style="width: auto;">
                                    @foreach($categoryNames as $c => $name)
                                        <option value="{{ $c }}" {{ $selectedCategory == $c ? 'selected' : '' }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="chartHargaPerStokis" style="height: 400px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Grafik Kuantitas Pengiriman per Bulan -->
                <div class="col-md-6">
                    <div class="card bg-dark text-white">
                        <div class="card-header bg-info text-white">
                            <h4>Kuantitas Pengiriman per Bulan</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="chartKuantitasPengirimanPerMonth" style="height: 400px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grafik Jumlah Produk Terkirim per Stokis -->
            <div class="card bg-dark text-white mb-4" style="text-align: justify;">
                <div class="card-header bg-secondary text-white">
                    <h4>Jumlah Produk Terkirim per Stokis (by Category)</h4>
                </div>
                <div class="card-body">
                    <canvas id="chartJumlahProdukTerkirim" style="height: 400px;"></canvas>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('styles')
    <style>
        .bg-purple {
            background-color: #6f42c1; 
        }
    </style>
@endsection

@section('scripts')
    <!-- Tambahkan Chart.js dari CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Definisikan Nama Kategori di JavaScript
        const categoryNames = @json($categoryNames);

        // Definisikan Warna untuk Setiap Kategori
        const categoryColors = {
            1: { // Ayam
                backgroundColor: 'rgba(255, 99, 132, 0.8)', // Merah
                borderColor: 'rgba(255, 99, 132, 1)'
            },
            2: { // Tepung
                backgroundColor: 'rgba(54, 162, 235, 0.8)', // Biru
                borderColor: 'rgba(54, 162, 235, 1)'
            },
            3: { // Saus
                backgroundColor: 'rgba(75, 192, 192, 0.8)', // Hijau
                borderColor: 'rgba(75, 192, 192, 1)'
            },
            4: { // Packaging
                backgroundColor: 'rgba(255, 206, 86, 0.8)', // Kuning
                borderColor: 'rgba(255, 206, 86, 1)'
            }
        };

        // Definisi Warna untuk Chart Lain
        const chartColors = {
            primary: 'rgba(54, 162, 235, 0.8)',
            primaryBorder: 'rgba(54, 162, 235, 1)',
            success: 'rgba(75, 192, 192, 0.8)',
            successBorder: 'rgba(75, 192, 192, 1)',
            danger: 'rgba(255, 99, 132, 0.8)',
            dangerBorder: 'rgba(255, 99, 132, 1)',
            warning: 'rgba(255, 206, 86, 0.8)',
            warningBorder: 'rgba(255, 206, 86, 1)',
            info: 'rgba(153, 102, 255, 0.8)',
            infoBorder: 'rgba(153, 102, 255, 1)'
        };

        // Fungsi untuk Mengatur Opsi Dasar Chart
        function getChartOptions(xTitle, yTitle) {
            return {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        top: 20,
                        bottom: 20,
                        left: 20,
                        right: 20
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: 'white',
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.3)',
                            borderDash: [5, 5],
                            lineWidth: 1.5
                        },
                        title: {
                            display: true,
                            text: xTitle,
                            color: 'white',
                            font: {
                                size: 16,
                                weight: 'bold'
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: 'white',
                            precision: 0,
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.3)',
                            borderDash: [5, 5],
                            lineWidth: 1.5
                        },
                        title: {
                            display: true,
                            text: yTitle,
                            color: 'white',
                            font: {
                                size: 16,
                                weight: 'bold'
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: 'white',
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        }
                    },
                    tooltip: {
                        enabled: true,
                        backgroundColor: 'rgba(0, 0, 0, 0.7)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        titleFont: {
                            size: 16,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 14
                        },
                        callbacks: {
                            label: function(context) {
                                let value = context.raw || 0;
                                if (context.dataset.label.includes('Gain') || context.dataset.label.includes('Harga')) {
                                    return `Rp ${value.toLocaleString('id-ID')}`;
                                }
                                return value;
                            }
                        }
                    }
                }
            };
        }

        // --- Grafik Kuantitas Inventaris Produk ---
        var inventarisLabels = {!! json_encode($inventarisLabels) !!};
        var inventarisValues = {!! json_encode($inventarisValues) !!};

        var inventarisCtx = document.getElementById('inventarisChart').getContext('2d');
        var inventarisChart = new Chart(inventarisCtx, {
            type: 'bar',
            data: {
                labels: inventarisLabels,
                datasets: [{
                    label: 'Kuantitas Produk di Inventaris',
                    data: inventarisValues,
                    backgroundColor: chartColors.warning,
                    borderColor: chartColors.warningBorder,
                    borderWidth: 1,
                    tension: 0.1
                }]
            },
            options: getChartOptions('Produk', 'Kuantitas Inventaris')
        });

        // --- Grafik Total Gain per Vendor ---
        const vendorGainLabels = @json($vendorData->pluck('sk_vendor'));
        const vendorGainData = @json($vendorData->pluck('total_gain'));

        const ctxVendorGain = document.getElementById('chartVendorGain').getContext('2d');
        new Chart(ctxVendorGain, {
            type: 'bar',
            data: {
                labels: vendorGainLabels.map(label => `Vendor ${label}`),
                datasets: [{
                    label: 'Total Gain',
                    data: vendorGainData,
                    backgroundColor: chartColors.primary,
                    borderColor: chartColors.primaryBorder,
                    borderWidth: 2,
                    tension: 0.1
                }]
            },
            options: getChartOptions('Vendor', 'Total Gain (IDR)')
        });

        // --- Grafik Distribusi Total Gain (Doughnut) ---
        const vendorLabels = @json($vendorData->pluck('sk_vendor'));
        const vendorGain = @json($vendorData->pluck('total_gain'));

        const ctxVendor = document.getElementById('chartVendor').getContext('2d');
        new Chart(ctxVendor, {
            type: 'doughnut',
            data: {
                labels: vendorLabels.map(label => `Vendor ${label}`),
                datasets: [{
                    label: 'Distribusi Total Gain',
                    data: vendorGain,
                    backgroundColor: [
                        chartColors.primary,
                        chartColors.success,
                        chartColors.warning,
                        chartColors.danger,
                        chartColors.info,
                        // Tambahkan warna tambahan jika diperlukan
                    ],
                    borderColor: [
                        chartColors.primaryBorder,
                        chartColors.successBorder,
                        chartColors.warningBorder,
                        chartColors.dangerBorder,
                        chartColors.infoBorder,
                        // Tambahkan border color tambahan jika diperlukan
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: 'white',
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        }
                    },
                    tooltip: {
                        enabled: true,
                        backgroundColor: 'rgba(0, 0, 0, 0.7)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        titleFont: {
                            size: 16,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 14
                        },
                        callbacks: {
                            label: function(context) {
                                let value = context.raw || 0;
                                return `Rp ${value.toLocaleString('id-ID')}`;
                            }
                        }
                    }
                }
            }
        });

        // --- Grafik Jumlah Produk Terkirim per Stokis (Horizontal Stacked Bar) ---
        const stokisLabels = @json($stokisList); // [1,2,3,4,5,6]
        const categoryData = @json($categoryData); 
        // categoryData adalah object dengan key kategori dan array data: {1: [qty_stokis1,...], 2: [...], 3: [...],4: [...]}

        const ctxJumlahProdukTerkirim = document.getElementById('chartJumlahProdukTerkirim').getContext('2d');
        new Chart(ctxJumlahProdukTerkirim, {
            type: 'bar',
            data: {
                labels: stokisLabels.map(s => `Stokis ${s}`),
                datasets: [
                    @foreach($categoryNames as $c => $name)
                        {
                            label: '{{ $name }}',
                            data: categoryData[{{ $c }}],
                            backgroundColor: categoryColors[{{ $c }}].backgroundColor,
                            borderColor: categoryColors[{{ $c }}].borderColor,
                            borderWidth: 2
                        },
                    @endforeach
                ]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        stacked: true,
                        ticks: {
                            color: 'white',
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.3)',
                            borderDash: [5, 5],
                            lineWidth: 1.5
                        },
                        title: {
                            display: true,
                            text: 'Quantity',
                            color: 'white',
                            font: {
                                size: 16,
                                weight: 'bold'
                            }
                        }
                    },
                    y: {
                        stacked: true,
                        ticks: {
                            color: 'white',
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.3)',
                            borderDash: [5, 5],
                            lineWidth: 1.5
                        },
                        title: {
                            display: true,
                            text: 'Stokis',
                            color: 'white',
                            font: {
                                size: 16,
                                weight: 'bold'
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: 'white',
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        }
                    }
                }
            }
        });

        // --- Grafik Kuantitas Pengiriman per Bulan ---
        var kuantitasPengirimanLabels = {!! json_encode($kuantitasPengirimanLabels) !!};
        var kuantitasPengirimanData = {!! json_encode($kuantitasPengirimanData) !!};

        var kuantitasPengirimanCtx = document.getElementById('chartKuantitasPengirimanPerMonth').getContext('2d');
        var kuantitasPengirimanChart = new Chart(kuantitasPengirimanCtx, {
            type: 'line',
            data: {
                labels: kuantitasPengirimanLabels,
                datasets: [{
                    label: 'Kuantitas Pengiriman per Bulan',
                    data: kuantitasPengirimanData,
                    backgroundColor: chartColors.info,
                    borderColor: chartColors.infoBorder,
                    fill: true,
                    tension: 0.1,
                    pointRadius: 5,
                    pointBackgroundColor: chartColors.infoBorder,
                    pointBorderColor: '#fff',
                    pointHoverRadius: 7,
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: chartColors.infoBorder
                }]
            },
            options: getChartOptions('Bulan', 'Kuantitas Pengiriman')
        });

        // --- Grafik Total Gain per Bulan ---
        const lineChartLabels = @json($lineChartData->pluck('month'));
        const lineChartMonthlyGain = @json($lineChartData->pluck('total_gain_monthly'));

        const ctxGainPerMonth = document.getElementById('chartGainPerMonth').getContext('2d');
        new Chart(ctxGainPerMonth, {
            type: 'line',
            data: {
                labels: lineChartLabels,
                datasets: [{
                    label: 'Total Gain per Bulan',
                    data: lineChartMonthlyGain,
                    backgroundColor: chartColors.warning,
                    borderColor: chartColors.warningBorder,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.3,
                    pointRadius: 5,
                    pointBackgroundColor: chartColors.warningBorder,
                    pointBorderColor: '#fff',
                    pointHoverRadius: 7,
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: chartColors.warningBorder
                }]
            },
            options: getChartOptions('Bulan (YYYY-MM)', 'Total Gain (IDR)')
        });

        // --- Grafik Harga Total per Stokis ---
        const stokisListForHarga = @json($stokisList);
        const pengirimanHargaData = @json($pengirimanHargaData);

        const ctxHargaPerStokis = document.getElementById('chartHargaPerStokis').getContext('2d');
        new Chart(ctxHargaPerStokis, {
            type: 'bar',
            data: {
                labels: stokisListForHarga.map(s => `Stokis ${s}`),
                datasets: [{
                    label: `Harga Total (${categoryNames[{{ $selectedCategory }}]})`,
                    data: pengirimanHargaData,
                    backgroundColor: chartColors.warning,
                    borderColor: chartColors.warningBorder,
                    borderWidth: 2,
                    tension: 0.1
                }]
            },
            options: getChartOptions('Stokis', 'Harga Total (IDR)')
        });

        // --- Submit Form Saat Dropdown Berubah ---
        document.getElementById('quartile').addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });

        document.getElementById('cat').addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    </script>
@endsection