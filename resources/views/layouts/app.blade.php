<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - Beranda</title>
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    <!-- Meta viewport untuk responsif -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Tambahkan CSS Tambahan (Jika Diperlukan) -->
    <style>
        /* Anda dapat memasukkan CSS tambahan di sini jika diperlukan */
    </style>
</head>
<body>
    @auth
    <!-- Header (Navbar) -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <!-- Tombol Toggle Sidebar -->
            <button type="button" id="sidebarCollapse" class="btn btn-link text-white">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Profil di Pojok Kanan Atas -->
            <div class="dropdown ml-auto">
                <a href="#" class="btn btn-link dropdown-toggle text-white" id="profileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user-circle fa-2x"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="{{ route('profile') }}">Profile</a>
                    <form action="{{ route('logout') }}" method="POST" class="mb-0">
                        @csrf
                        <button class="dropdown-item" type="submit">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Wrapper -->
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('dashboard.combined') }}" class="text-white">
                    <i class="fas fa-home fa-lg mr-2"></i> Home
                </a>
            </div>
            <ul class="list-unstyled components">
                <li>
                    <a href="{{ route('categories.index') }}">Kategori</a>
                </li>
                <li>
                    <a href="{{ route('produk.index') }}">Produk</a>
                </li>
                <li>
                    <a href="{{ route('vendors.index') }}">Vendor</a>
                </li>
                {{-- <!-- <li>
                    <a href="{{ route('pusats.index') }}">Pusat</a>
                </li> --> --}}
                <li>
                    <a href="{{ route('locations.index') }}">Lokasi</a>
                </li>                
                <li>
                    <a href="{{ route('stokis.index') }}">Stokis</a>
                </li>
                <li>
                    <a href="{{ route('mitras.index') }}">Mitra</a>
                </li>
                <li>
                    <a href="{{ route('pembelians.index') }}">Pembelian</a>
                </li>
                <li>
                    <a href="{{ route('pengirimans.index') }}">Pengiriman</a>
                </li>
                <li>
                    <a href="{{ route('inventaris.index') }}">Inventaris</a>
                </li>
                <li>
                    <a href="{{ route('vendor_prices.index') }}">Harga Harian Vendor</a>
                </li>
                <li>
                    <a href="{{ route('dashboard.info') }}">Dashboard Lama</a>
                </li>                
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <!-- Konten Utama -->
            <div class="container-fluid mt-5 pt-3">
                @yield('content')
            </div>
        </div>
    </div>
    @else
        @yield('content')
    @endauth

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Script untuk Toggle Sidebar -->
    <script>
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar, #page-content-wrapper').toggleClass('active');
            });
        });
    </script>

    @yield('scripts')
</body>
</html>