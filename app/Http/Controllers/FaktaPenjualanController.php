<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FaktaPenjualanController extends Controller
{
    public function index(Request $request)
    {
        // Logika yang sudah ada (kuartal, ringkasan, vendorData, productData, dsb.)
        $kuartal = $request->input('quartile', 'all');
        $ringkasanQuery = DB::table('1fakta_penjualan_perquartil');
        if ($kuartal != 'all') {
            $ringkasanQuery->where('Quartile', $kuartal);
        }
    
        $totalProduk = (clone $ringkasanQuery)->distinct('sk_product')->count('sk_product');
        $totalVendor = (clone $ringkasanQuery)->distinct('sk_vendor')->count('sk_vendor');
        $totalGain = (clone $ringkasanQuery)->sum('total_gain'); 
    
        $vendorData = (clone $ringkasanQuery)
            ->select('sk_vendor', DB::raw('SUM(Total_gain) as total_gain'))
            ->groupBy('sk_vendor')
            ->get();
    
        $productData = (clone $ringkasanQuery)
            ->select('sk_product', DB::raw('SUM(Quantity) as total_quantity'))
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
        // =============================
        // Bagian baru untuk facta_pengiriman
        // =============================
        // Asumsi data stokis adalah integer 1-6 dan kategori 1-4
        // Jika ingin dinamis, bisa lakukan distinct query
    
        // Ambil data pengiriman (misalnya semua periode)
        $pengirimanData = DB::table('facta_pengiriman')
            ->select('sk_stokis', 'sk_categrory', DB::raw('SUM(quantitas_produk) as total_qty'))
            ->groupBy('sk_stokis', 'sk_categrory')
            ->get();
    
        // Tentukan stokis dan kategori
        $stokisList = [1,2,3,4,5,6];    // Bisa juga diambil distinct dari DB jika diperlukan
        $categories = [1,2,3,4];
    
        // Inisialisasi array data
        // Bentuknya: categoryData[cat] = [qty_stokis_1, qty_stokis_2, ...]
        $categoryData = [];
        foreach ($categories as $cat) {
            // Default 0 untuk setiap stokis
            $categoryData[$cat] = array_fill(0, count($stokisList), 0);
        }
    
        // Mapping pengirimanData ke array
        foreach ($pengirimanData as $row) {
            $cat = $row->sk_categrory;
            $stokisIndex = array_search($row->sk_stokis, $stokisList);
            if ($stokisIndex !== false) {
                $categoryData[$cat][$stokisIndex] = $row->total_qty;
            }
        }
    
        // Sekarang kita punya $categoryData untuk keperluan chart
        // $categoryData[1] adalah data kategori 1 untuk stokis 1-6
        // $categoryData[2], $categoryData[3], $categoryData[4] sama
        // Akan di-passing ke view
    
            // Menangani dropdown kategori untuk pengiriman harga total
        $selectedCategory = $request->input('cat', 1); // default category 1 jika tidak dipilih

    // Ambil data pengiriman berdasarkan kategori terpilih dari tabel facta_pengiriman
    // Asumsi tabel facta_pengiriman memiliki kolom Harga_total
        $pengirimanCategoryData = DB::table('facta_pengiriman')
        ->select('sk_stokis', DB::raw('SUM(Harga_total) as total_harga'))
        ->where('sk_categrory', $selectedCategory)
        ->groupBy('sk_stokis')
        ->get();

    // stokisList tetap sama atau bisa diambil distinct
        $stokisList = [1,2,3,4,5,6];

    // Mapping data ke array agar stokis tanpa data juga 0
        $pengirimanHargaData = array_fill(0, count($stokisList), 0);
        foreach ($pengirimanCategoryData as $row) {
            $stokisIndex = array_search($row->sk_stokis, $stokisList);
            if ($stokisIndex !== false) {
                $pengirimanHargaData[$stokisIndex] = $row->total_harga;
        }
    }

    return view('fakta_penjualan', compact(
        'vendorData',
        'productData',
        'quartiles',
        'kuartal',
        'totalProduk',
        'totalVendor',
        'totalGain',
        'stokisList',
        'categoryData', // Data sebelumnya untuk chart stacked bar
        'lineChartData',
        'selectedCategory',
        'pengirimanHargaData' // Data untuk chart baru berdasarkan kategori terpilih
        ));
    }   
}