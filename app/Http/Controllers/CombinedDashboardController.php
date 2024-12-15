<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\Pengiriman;
use App\Models\Inventaris;
use App\Models\Produk;
use App\Models\Vendor;
use App\Models\Stokis;
use App\Models\Mitra;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CombinedDashboardController extends Controller
{
    public function index(Request $request)
    {
        // --- Logika Dashboard ---
        
        // Menghitung total produk, vendor, stokis, dan mitra
        $produkCount = Produk::count();
        $vendorCount = Vendor::count();
        $stokisCount = Stokis::count();
        $mitraCount = Mitra::count();

        // Data pembelian per bulan
        $pembelianPerBulan = Pembelian::selectRaw('MONTH(tanggal_pembelian) as bulan, SUM(quantitas_produk) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $pembelianLabels = [];
        $pembelianData = [];

        foreach ($pembelianPerBulan as $data) {
            $bulanNama = Carbon::create()->month($data->bulan)->translatedFormat('F');
            $pembelianLabels[] = $bulanNama;
            $pembelianData[] = $data->total;
        }

        // Data pengiriman per bulan
        $pengirimanPerBulan = Pengiriman::selectRaw('MONTH(tanggal_pengiriman) as bulan, SUM(quantitas_produk) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $pengirimanLabels = [];
        $pengirimanData = [];

        foreach ($pengirimanPerBulan as $data) {
            $bulanNama = Carbon::create()->month($data->bulan)->translatedFormat('F');
            $pengirimanLabels[] = $bulanNama;
            $pengirimanData[] = $data->total;
        }

        // Data inventaris per produk
        $inventarisData = Inventaris::with('produk')->get();
        $inventarisLabels = $inventarisData->pluck('produk.nama_produk')->toArray();
        $inventarisValues = $inventarisData->pluck('kuantitas')->toArray();

        // --- Logika Fakta Penjualan ---

        // Mengambil input dari request
        $kuartal = $request->input('quartile', 'all');
        $selectedCategory = $request->input('cat', 1); // default kategori 1 jika tidak dipilih

        // Query untuk ringkasan fakta penjualan
        $ringkasanQuery = DB::table('1fakta_penjualan_perquartil');
        if ($kuartal != 'all') {
            $ringkasanQuery->where('Quartile', $kuartal);
        }

        $totalProduk = (clone $ringkasanQuery)->distinct('sk_product')->count('sk_product');
        $totalVendor = (clone $ringkasanQuery)->distinct('sk_vendor')->count('sk_vendor');
        $totalGain = (clone $ringkasanQuery)->sum('total_gain');

        $vendorData = (clone $ringkasanQuery)
            ->select('sk_vendor', DB::raw('SUM(total_gain) as total_gain'))
            ->groupBy('sk_vendor')
            ->get();

        $productData = (clone $ringkasanQuery)
            ->select('sk_product', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('sk_product')
            ->get();

        $quartiles = DB::table('1fakta_penjualan_perquartil')
            ->select('Quartile')
            ->distinct()
            ->pluck('Quartile');

        $lineChartData = DB::table('1fakta_penjualan_perquartil')
            ->select(
                DB::raw('DATE_FORMAT(tanggal, "%Y-%m") as month'),
                DB::raw('SUM(total_gain) as total_gain_monthly')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // --- Logika Fakta Pengiriman ---

        $pengirimanDataFP = DB::table('facta_pengiriman')
            ->select('sk_stokis', 'sk_categrory', DB::raw('SUM(quantitas_produk) as total_qty'))
            ->groupBy('sk_stokis', 'sk_categrory')
            ->get();

        $stokisList = [1,2,3,4,5,6];    // Bisa juga diambil distinct dari DB jika diperlukan
        $categories = [1,2,3,4];

        $categoryData = [];
        foreach ($categories as $cat) {
            $categoryData[$cat] = array_fill(0, count($stokisList), 0);
        }

        foreach ($pengirimanDataFP as $row) {
            $cat = $row->sk_categrory;
            $stokisIndex = array_search($row->sk_stokis, $stokisList);
            if ($stokisIndex !== false) {
                $categoryData[$cat][$stokisIndex] = $row->total_qty;
            }
        }

        // Mengambil data pengiriman berdasarkan kategori terpilih
        $pengirimanCategoryData = DB::table('facta_pengiriman')
            ->select('sk_stokis', DB::raw('SUM(harga_total) as total_harga'))
            ->where('sk_categrory', $selectedCategory)
            ->groupBy('sk_stokis')
            ->get();

        $pengirimanHargaData = array_fill(0, count($stokisList), 0);
        foreach ($pengirimanCategoryData as $row) {
            $stokisIndex = array_search($row->sk_stokis, $stokisList);
            if ($stokisIndex !== false) {
                $pengirimanHargaData[$stokisIndex] = $row->total_harga;
            }
        }

        // --- Data Kuantitas Pengiriman per Bulan ---
        $kuantitasPengirimanPerBulan = Pengiriman::selectRaw('MONTH(tanggal_pengiriman) as bulan, SUM(quantitas_produk) as total_quantity')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $kuantitasPengirimanLabels = [];
        $kuantitasPengirimanData = [];

        foreach ($kuantitasPengirimanPerBulan as $data) {
            // Hanya menampilkan nama bulan tanpa tahun
            $bulanNama = Carbon::create()->month($data->bulan)->translatedFormat('F');
            $kuantitasPengirimanLabels[] = $bulanNama;
            $kuantitasPengirimanData[] = $data->total_quantity;
        }

        // Mengirim semua data ke view
        return view('dashboard_combined', compact(
            // Data Dashboard
            'produkCount',
            'vendorCount',
            'stokisCount',
            'mitraCount',
            'pembelianLabels',
            'pembelianData',
            'pengirimanLabels',
            'pengirimanData',
            'inventarisLabels',
            'inventarisValues',

            // Data Fakta Penjualan
            'kuartal',
            'totalProduk',
            'totalVendor',
            'totalGain',
            'vendorData',
            'productData',
            'quartiles',
            'lineChartData',

            // Data Fakta Pengiriman
            'stokisList',
            'categoryData',
            'selectedCategory',
            'pengirimanHargaData',

            // Data Kuantitas Pengiriman per Bulan
            'kuantitasPengirimanLabels',
            'kuantitasPengirimanData'
        ));
    }
}