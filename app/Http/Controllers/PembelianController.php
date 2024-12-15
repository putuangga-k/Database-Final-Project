<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Produk;
use App\Models\Vendor;
use App\Models\Inventaris; 
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    /**
     * Display a listing of the pembelians.
     */
    public function index()
    {
        $pembelians = Pembelian::with('produk', 'vendor')->get();
        return view('pembelians.index', compact('pembelians'));
    }

    /**
     * Show the form for creating a new pembelian.
     */
    public function create()
    {
        $produks = Produk::all();
        $vendors = Vendor::all();
        return view('pembelians.create', compact('produks', 'vendors'));
    }

    /**
     * Store a newly created pembelian in storage.
     */
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'produk_id' => 'required|exists:produks,produk_id',
            'vendor_id' => 'required|exists:vendors,vendor_id',
            'tanggal_pembelian' => 'required|date',
            'harga_produk' => 'required|numeric|min:0',
            'quantitas_produk' => 'required|integer|min:1',
        ]);

        // Calculate total_harga
        $total_harga = $request->harga_produk * $request->quantitas_produk;

        // Begin transaction
        \DB::beginTransaction();

        try {
            // Create pembelian
            $pembelian = Pembelian::create([
                'produk_id' => $request->produk_id,
                'vendor_id' => $request->vendor_id,
                'tanggal_pembelian' => $request->tanggal_pembelian,
                'harga_produk' => $request->harga_produk,
                'quantitas_produk' => $request->quantitas_produk,
                'total_harga' => $total_harga,
            ]);

            // Update inventaris
            $inventaris = Inventaris::firstOrCreate(
                ['produk_id' => $request->produk_id],
                ['kuantitas' => 0]
            );

            $inventaris->increment('kuantitas', $request->quantitas_produk);

            // Commit transaction
            \DB::commit();

            return redirect()->route('pembelians.index')->with('success', 'Pembelian berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Rollback transaction
            \DB::rollback();

            return redirect()->back()->withErrors('Terjadi kesalahan saat menyimpan data pembelian.');
        }
    }

    /**
     * Display the specified pembelian.
     */
    public function show(Pembelian $pembelian)
    {
        $pembelian->load('produk', 'vendor');
        return view('pembelians.show', compact('pembelian'));
    }

    /**
     * Show the form for editing the specified pembelian.
     */
    public function edit(Pembelian $pembelian)
    {
        $produks = Produk::all();
        $vendors = Vendor::all();
        return view('pembelians.edit', compact('pembelian', 'produks', 'vendors'));
    }

    /**
     * Update the specified pembelian in storage.
     */
    public function update(Request $request, Pembelian $pembelian)
    {
        // Validate input
        $request->validate([
            'produk_id' => 'required|exists:produks,produk_id',
            'vendor_id' => 'required|exists:vendors,vendor_id',
            'tanggal_pembelian' => 'required|date',
            'harga_produk' => 'required|numeric|min:0',
            'quantitas_produk' => 'required|integer|min:1',
        ]);

        // Calculate total_harga
        $total_harga = $request->harga_produk * $request->quantitas_produk;

        // Begin transaction
        \DB::beginTransaction();

        try {
            // Calculate quantity difference
            $quantityDifference = $request->quantitas_produk - $pembelian->quantitas_produk;

            // Update pembelian
            $pembelian->update([
                'produk_id' => $request->produk_id,
                'vendor_id' => $request->vendor_id,
                'tanggal_pembelian' => $request->tanggal_pembelian,
                'harga_produk' => $request->harga_produk,
                'quantitas_produk' => $request->quantitas_produk,
                'total_harga' => $total_harga,
            ]);

            // Update inventaris
            $inventaris = Inventaris::where('produk_id', $request->produk_id)->first();

            if ($inventaris) {
                $inventaris->increment('kuantitas', $quantityDifference);
            } else {
                // Jika tidak ada data inventaris, buat baru
                Inventaris::create([
                    'produk_id' => $request->produk_id,
                    'kuantitas' => $request->quantitas_produk,
                ]);
            }

            // Commit transaction
            \DB::commit();

            return redirect()->route('pembelians.index')->with('success', 'Pembelian berhasil diperbarui.');
        } catch (\Exception $e) {
            // Rollback transaction
            \DB::rollback();

            return redirect()->back()->withErrors('Terjadi kesalahan saat memperbarui data pembelian.');
        }
    }

    /**
     * Remove the specified pembelian from storage.
     */
    public function destroy(Pembelian $pembelian)
    {
        // Begin transaction
        \DB::beginTransaction();

        try {
            // Update inventaris
            $inventaris = Inventaris::where('produk_id', $pembelian->produk_id)->first();

            if ($inventaris) {
                $inventaris->decrement('kuantitas', $pembelian->quantitas_produk);
            }

            // Delete pembelian
            $pembelian->delete();

            // Commit transaction
            \DB::commit();

            return redirect()->route('pembelians.index')->with('success', 'Pembelian berhasil dihapus.');
        } catch (\Exception $e) {
            // Rollback transaction
            \DB::rollback();

            return redirect()->back()->withErrors('Terjadi kesalahan saat menghapus data pembelian.');
        }
    }
}