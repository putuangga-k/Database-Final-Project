<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StokisSold;

class StokisSoldController extends Controller
{
    /**
     * Menampilkan daftar stokis sold.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mengambil semua data stokis_sold dengan relasi produk dan stokis
        $stokisSold = StokisSold::with(['produk', 'stokis'])->paginate(15); // Gunakan paginate jika data banyak

        return view('stokis_sold.index', compact('stokisSold'));
    }
}