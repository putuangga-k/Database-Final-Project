<?php

namespace App\Http\Controllers;

use App\Models\Stokis;
use App\Models\Produk;
use Illuminate\Http\Request;

class StokisController extends Controller
{
    public function index()
    {
        // Memuat relasi product agar nama produk dapat ditampilkan di daftar stokis
        $stokis = Stokis::with('product')->get();
        return view('stokis.index', compact('stokis'));
    }

    public function create()
    {
        $produks = Produk::all(); // Ambil daftar produk untuk dropdown
        return view('stokis.create', compact('produks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_stokis' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'lokasi' => 'required|string|max:255',
            'product_id' => 'required|exists:produks,produk_id',
        ]);

        Stokis::create($request->only(['nama_stokis', 'no_hp', 'lokasi', 'product_id']));

        return redirect()->route('stokis.index')->with('success', 'Stokis berhasil ditambahkan.');
    }

    public function show(Stokis $stokis)
    {
        // Relasi product telah didefinisikan di model Stokis
        // Stokis $stokis sudah memuat data stokis, jika ingin memuat product pakai load:
        $stokis->load('product');
        return view('stokis.show', compact('stokis'));
    }

    public function edit(Stokis $stokis)
    {
        $produks = Produk::all(); // Untuk dropdown produk
        return view('stokis.edit', compact('stokis', 'produks'));
    }

    public function update(Request $request, Stokis $stokis)
    {
        $request->validate([
            'nama_stokis' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'lokasi' => 'required|string|max:255',
            'product_id' => 'required|exists:produks,produk_id',
        ]);

        $stokis->update($request->only(['nama_stokis', 'no_hp', 'lokasi', 'product_id']));

        return redirect()->route('stokis.index')->with('success', 'Stokis berhasil diperbarui.');
    }

    public function destroy(Stokis $stokis)
    {
        $stokis->delete();

        return redirect()->route('stokis.index')->with('success', 'Stokis berhasil dihapus.');
    }

    public function search(Request $request)
    {
        $query = $request->get('query');
        $stokis = Stokis::where('nama_stokis', 'LIKE', "%{$query}%")->get();

        $output = '<ul class="list-group">';
        foreach ($stokis as $stokisItem) {
            $output .= '<li class="list-group-item stokis-item" data-id="'.$stokisItem->stokis_id.'">'.$stokisItem->nama_stokis.'</li>';
        }
        $output .= '</ul>';

        return $output;
    }
}