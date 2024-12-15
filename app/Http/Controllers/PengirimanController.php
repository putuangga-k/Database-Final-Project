<?php

namespace App\Http\Controllers;

use App\Models\Pengiriman;
use App\Models\Stokis;
use App\Models\Produk;
use App\Models\Inventaris;
use Illuminate\Http\Request;

class PengirimanController extends Controller
{
    /**
     * Display a listing of the pengirimans.
     */
    public function index()
    {
        $pengirimans = Pengiriman::with('stokis', 'produk')->get();
        return view('pengirimans.index', compact('pengirimans'));
    }

    /**
     * Show the form for creating a new pengiriman.
     */
    public function create()
    {
        $stokisList = Stokis::all();
        $produks = Produk::all();
        return view('pengirimans.create', compact('stokisList', 'produks'));
    }

    /**
     * Store a newly created pengiriman in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'stokis_id' => 'required|exists:stokis,stokis_id',
            'produk_id' => 'required|exists:produks,produk_id',
            'quantitas_produk' => 'required|integer|min:1',
            'tanggal_pengiriman' => 'required|date',
        ]);

        // Mulai transaksi
        \DB::beginTransaction();

        try {
            // Simpan pengiriman
            $pengiriman = Pengiriman::create($request->all());

            // Perbarui inventaris
            $inventaris = Inventaris::where('produk_id', $request->produk_id)->first();

            if ($inventaris) {
                // Pastikan kuantitas tidak negatif
                if ($inventaris->kuantitas < $request->quantitas_produk) {
                    return redirect()->back()->withErrors('Stok produk tidak mencukupi untuk pengiriman ini.');
                }

                $inventaris->decrement('kuantitas', $request->quantitas_produk);
            } else {
                // Jika tidak ada data inventaris, tidak bisa melakukan pengiriman
                return redirect()->back()->withErrors('Produk tidak tersedia di inventaris.');
            }

            // Commit transaksi
            \DB::commit();

            return redirect()->route('pengirimans.index')->with('success', 'Pengiriman berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Rollback transaksi
            \DB::rollback();

            return redirect()->back()->withErrors('Terjadi kesalahan saat menyimpan data pengiriman.');
        }
    }

    /**
     * Display the specified pengiriman.
     */
    public function show(Pengiriman $pengiriman)
    {
        $pengiriman->load('stokis', 'produk');
        return view('pengirimans.show', compact('pengiriman'));
    }

    /**
     * Show the form for editing the specified pengiriman.
     */
    public function edit(Pengiriman $pengiriman)
    {
        $stokisList = Stokis::all();
        $produks = Produk::all();
        return view('pengirimans.edit', compact('pengiriman', 'stokisList', 'produks'));
    }

    /**
     * Update the specified pengiriman in storage.
     */
    public function update(Request $request, Pengiriman $pengiriman)
    {
        // Validasi input
        $request->validate([
            'stokis_id' => 'required|exists:stokis,stokis_id',
            'produk_id' => 'required|exists:produks,produk_id',
            'quantitas_produk' => 'required|integer|min:1',
            'tanggal_pengiriman' => 'required|date',
        ]);

        // Mulai transaksi
        \DB::beginTransaction();

        try {
            // Hitung selisih quantitas
            $quantityDifference = $request->quantitas_produk - $pengiriman->quantitas_produk;

            // Update pengiriman
            $pengiriman->update($request->all());

            // Perbarui inventaris
            $inventaris = Inventaris::where('produk_id', $request->produk_id)->first();

            if ($inventaris) {
                // Jika quantityDifference negatif, tambahkan kuantitas
                if ($quantityDifference < 0) {
                    $inventaris->increment('kuantitas', abs($quantityDifference));
                } else {
                    // Pastikan kuantitas tidak negatif
                    if ($inventaris->kuantitas < $quantityDifference) {
                        return redirect()->back()->withErrors('Stok produk tidak mencukupi untuk pengiriman ini.');
                    }
                    $inventaris->decrement('kuantitas', $quantityDifference);
                }
            } else {
                return redirect()->back()->withErrors('Produk tidak tersedia di inventaris.');
            }

            // Commit transaksi
            \DB::commit();

            return redirect()->route('pengirimans.index')->with('success', 'Pengiriman berhasil diperbarui.');
        } catch (\Exception $e) {
            // Rollback transaksi
            \DB::rollback();

            return redirect()->back()->withErrors('Terjadi kesalahan saat memperbarui data pengiriman.');
        }
    }

    /**
     * Remove the specified pengiriman from storage.
     */
    public function destroy(Pengiriman $pengiriman)
    {
        // Mulai transaksi
        \DB::beginTransaction();

        try {
            // Perbarui inventaris
            $inventaris = Inventaris::where('produk_id', $pengiriman->produk_id)->first();

            if ($inventaris) {
                $inventaris->increment('kuantitas', $pengiriman->quantitas_produk);
            } else {
                // Jika tidak ada data inventaris, buat baru
                Inventaris::create([
                    'produk_id' => $pengiriman->produk_id,
                    'kuantitas' => $pengiriman->quantitas_produk,
                ]);
            }

            // Hapus pengiriman
            $pengiriman->delete();

            // Commit transaksi
            \DB::commit();

            return redirect()->route('pengirimans.index')->with('success', 'Pengiriman berhasil dihapus.');
        } catch (\Exception $e) {
            // Rollback transaksi
            \DB::rollback();

            return redirect()->back()->withErrors('Terjadi kesalahan saat menghapus data pengiriman.');
        }
    }
}