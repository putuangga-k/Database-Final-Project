<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Menampilkan daftar semua produk.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produks = Produk::with('category')->get();
        return view('produks.index', compact('produks'));
    }     

    /**
     * Menampilkan form untuk membuat produk baru.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('produks.create', compact('categories'));
    }    

    /**
     * Menyimpan produk baru ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'deskripsi' => 'nullable|string',
            'unit' => 'required|integer|min:0',
        ]);
        

        // Menyimpan produk
        Produk::create($request->only(['nama_produk', 'deskripsi', 'category_id', 'unit']));

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail produk tertentu.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function show(Produk $produk)
    {
        $produk->load('category');
        return view('produks.show', compact('produk'));
    }    

    /**
     * Menampilkan form untuk mengedit produk tertentu.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function edit(Produk $produk)
    {
        $categories = Category::all();
        return view('produks.edit', compact('produk', 'categories'));
    }     

    /**
     * Memperbarui produk tertentu di database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produk $produk)
    {
        // Validasi input
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'deskripsi' => 'nullable|string',
            'unit' => 'required|integer|min:0',
        ]);        

        // Memperbarui produk
        $produk->update($request->only(['nama_produk', 'deskripsi', 'category_id', 'unit']));

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Menghapus produk tertentu dari database.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produk $produk)
    {
        $produk->delete();
    
        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}