@extends('layouts.app')

@section('title', 'Dashboard Fakta Penjualan')

@section('content')
<div class="mt-4" style="text-align: justify;">
    <h1>Selamat Datang, {{ Auth::user()->name }}!</h1>
    <p class="lead">Silakan Memilih pada Dropdown Menu untuk Melihat Lebih Detail!</p>
</div>

<div class="mt-5" style="text-align: justify;">
    <h2 class="mb-4">Fakta Pembelian</h2>

    <!-- Dropdown Memilih Kuartal -->
    <div class="mb-4">
        <form action="{{ route('fakta_penjualan') }}" method="GET" id="filterForm">
            <label for="quartile">Pilih Kuartal:</label>
            <select name="quartile" id="quartile" class="form-control w-25 d-inline-block">
                <option value="all" {{ $kuartal == 'all' ? 'selected' : '' }}>Semua Kuartal</option>
                @foreach($quartiles as $q)
                    <option value="{{ $q }}" {{ $kuartal == $q ? 'selected' : '' }}>{{ $q }}</option>
                @endforeach
            </select>
        </form>
    </div>

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

        <!-- Pie Chart Distribusi Total Gain per Vendor -->
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

    <!-- Bar Chart (Total Gain per Vendor) -->
    <div class="card bg-dark text-white mb-4">
        <div class="card-header bg-primary text-white">
            <h4>Total Gain per Vendor</h4>
        </div>
        <div class="card-body">
            <div style="height: 400px;">
                <canvas id="chartVendorGain"></canvas>
            </div>
        </div>
    </div>

    <!-- Line Chart (Total Gain per Bulan) -->
    <div class="card bg-dark text-white mb-5">
        <div class="card-header bg-warning text-white">
            <h4>Total Gain per Bulan</h4>
        </div>
        <div class="card-body">
            <div style="height: 400px;">
                <canvas id="chartGainPerMonth"></canvas> 
            </div>
        </div>
    </div>

    <div class="mb-5"></div>

    <div class="mt-5" style="text-align: justify;">
        <h2 class="mb-4">Fakta Pengiriman</h2>
    </div>

    <!-- Dropdown Memilih Kategori untuk chart pengiriman harga total -->
    <div class="mb-4" style="text-align: justify;">
        <form action="{{ route('fakta_penjualan') }}" method="GET" id="categoryForm">
            <input type="hidden" name="quartile" value="{{ $kuartal }}">
            <label for="cat">Pilih Kategori:</label>
            <select name="cat" id="cat" class="form-control w-25 d-inline-block">
                @foreach([1,2,3,4] as $c)
                    <option value="{{ $c }}" {{ $selectedCategory == $c ? 'selected' : '' }}>Category {{ $c }}</option>
                @endforeach
            </select>
        </form>
    </div>

    <!-- Bar Chart Harga_total per Stokis untuk kategori terpilih -->
    <div class="card bg-dark text-white mb-4" style="text-align: justify;">
        <div class="card-header bg-secondary text-white">
            <h4>Harga Total per Stokis (Kategori {{ $selectedCategory }})</h4>
        </div>
        <div class="card-body">
            <div style="height: 400px;">
                <canvas id="chartHargaPerStokis"></canvas>
            </div>
        </div>
    </div>

    <!-- Horizontal Stacked Bar Chart (Pengiriman) -->
    <div class="card bg-dark text-white mb-4" style="text-align: justify;">
        <div class="card-header bg-secondary text-white">
            <h4>Jumlah Produk Terkirim per Stokis (by Category)</h4>
        </div>
        <div class="card-body">
            <div style="height: 400px;">
                <canvas id="chartPengiriman"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <!-- Tambahkan Chart.js dari CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Warna yang konsisten untuk semua chart dengan palet yang lebih baik
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

        // Fungsi untuk mengatur opsi dasar chart tanpa judul
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

        // Data untuk Chart Total Gain per Vendor
        const vendorGainLabels = @json($vendorData->pluck('sk_vendor'));
        const vendorGainData = @json($vendorData->pluck('total_gain'));

        // Chart Total Gain per Vendor
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

        // Data untuk Chart Distribusi Total Gain (Doughnut)
        const vendorLabels = @json($vendorData->pluck('sk_vendor'));
        const vendorGain = @json($vendorData->pluck('total_gain'));

        // Chart Distribusi Total Gain
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

        // Data untuk Horizontal Stacked Bar Chart (Pengiriman)
        const stokisLabels = @json($stokisList); // [1,2,3,4,5,6]
        const categoryData = @json($categoryData); 
        // categoryData adalah object dengan key kategori dan array data: {1: [qty_stokis1,...], 2: [...], 3: [...],4: [...]}

        // Chart Pengiriman (Horizontal Stacked Bar)
        const ctxPengiriman = document.getElementById('chartPengiriman').getContext('2d');
        new Chart(ctxPengiriman, {
            type: 'bar',
            data: {
                labels: stokisLabels.map(s => 'Stokis ' + s),
                datasets: [
                    {
                        label: 'Category 1',
                        data: categoryData[1],
                        backgroundColor: chartColors.danger,
                        borderColor: chartColors.dangerBorder,
                        borderWidth: 2
                    },
                    {
                        label: 'Category 2',
                        data: categoryData[2],
                        backgroundColor: chartColors.primary,
                        borderColor: chartColors.primaryBorder,
                        borderWidth: 2
                    },
                    {
                        label: 'Category 3',
                        data: categoryData[3],
                        backgroundColor: chartColors.success,
                        borderColor: chartColors.successBorder,
                        borderWidth: 2
                    },
                    {
                        label: 'Category 4',
                        data: categoryData[4],
                        backgroundColor: chartColors.info,
                        borderColor: chartColors.infoBorder,
                        borderWidth: 2
                    }
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

        // Data untuk Line Chart (Total Gain per Bulan)
        const lineChartLabels = @json($lineChartData->pluck('month'));
        const lineChartMonthlyGain = @json($lineChartData->pluck('total_gain_monthly'));

        // Chart Total Gain per Bulan (Line Chart)
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

        // Data untuk Chart Harga_total per Stokis
        const stokisListForHarga = @json($stokisList);
        const pengirimanHargaData = @json($pengirimanHargaData);

        // Chart Harga Total per Stokis
        const ctxHargaPerStokis = document.getElementById('chartHargaPerStokis').getContext('2d');
        new Chart(ctxHargaPerStokis, {
            type: 'bar',
            data: {
                labels: stokisListForHarga.map(s => `Stokis ${s}`),
                datasets: [{
                    label: `Harga Total (Category {{ $selectedCategory }})`,
                    data: pengirimanHargaData,
                    backgroundColor: chartColors.warning,
                    borderColor: chartColors.warningBorder,
                    borderWidth: 2,
                    tension: 0.1
                }]
            },
            options: getChartOptions('Stokis', 'Harga Total (IDR)')
        });

        // Submit form saat dropdown berubah
        document.getElementById('quartile').addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });

        document.getElementById('cat').addEventListener('change', function() {
            document.getElementById('categoryForm').submit();
        });
    </script>
@endsection