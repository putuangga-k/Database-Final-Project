<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use App\Models\Produk;
use Illuminate\Http\Request;

class InventarisController extends Controller
{
    /**
     * Display a listing of the inventory.
     */
    public function index()
    {
        // Ambil data inventaris dengan relasi produk
        $inventaris = Inventaris::with('produk')->get();

        return view('inventaris.index', compact('inventaris'));
    }
}