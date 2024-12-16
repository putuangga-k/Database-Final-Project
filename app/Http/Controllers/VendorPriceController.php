<?php

namespace App\Http\Controllers;

use App\Models\VendorPrice;
use App\Models\Produk;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorPriceController extends Controller
{
    /**
     * Tampilkan daftar semua harga vendor.
     */
    public function index()
    {
        // Ambil semua vendor price dengan relasi produk dan vendor
        $vendorPrices = VendorPrice::with(['produk', 'vendor'])->get();
        return view('vendor_prices.index', compact('vendorPrices'));
    }

    /**
     * Tampilkan formulir untuk mengimpor CSV dan membuat entri baru.
     */
    public function create()
    {
        $produks = Produk::all();
        $vendors = Vendor::all();
        return view('vendor_prices.create', compact('produks', 'vendors'));
    }

    /**
     * Simpan entri baru yang dibuat secara manual.
     */
    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,produk_id',
            'vendor_id' => 'required|exists:vendors,vendor_id',
            'tanggal_berlaku' => 'required|date',
            'harga_laku' => 'required|numeric|min:0',
        ]);

        VendorPrice::create($request->all());

        return redirect()->route('vendor_prices.index')->with('success', 'Data Harga Vendor berhasil ditambahkan.');
    }

    /**
     * Tampilkan formulir untuk mengedit entri tertentu.
     */
    public function edit($id)
    {
        $vendorPrice = VendorPrice::findOrFail($id);
        $produks = Produk::all();
        $vendors = Vendor::all();
        return view('vendor_prices.edit', compact('vendorPrice', 'produks', 'vendors'));
    }

    /**
     * Update entri tertentu.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,produk_id',
            'vendor_id' => 'required|exists:vendors,vendor_id',
            'tanggal_berlaku' => 'required|date',
            'harga_laku' => 'required|numeric|min:0',
        ]);

        $vendorPrice = VendorPrice::findOrFail($id);
        $vendorPrice->update($request->all());

        return redirect()->route('vendor_prices.index')->with('success', 'Data Harga Vendor berhasil diperbarui.');
    }

    /**
     * Hapus entri tertentu.
     */
    public function destroy($id)
    {
        $vendorPrice = VendorPrice::findOrFail($id);
        $vendorPrice->delete();

        return redirect()->route('vendor_prices.index')->with('success', 'Data Harga Vendor berhasil dihapus.');
    }

    /**
     * Impor data harga vendor dari file CSV.
     */
    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();

        // Buka file CSV
        if (($handle = fopen($path, 'r')) !== false) {
            // Lewati baris header
            fgetcsv($handle); 

            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                // Pastikan jumlah kolom sesuai
                if (count($data) < 4) {
                    continue; // Lewati baris yang tidak lengkap
                }

                $produk_id = $data[0];
                $tanggal_berlaku = $data[1]; 
                $vendor_id = $data[2];
                $harga_laku = $data[3];

                // Cek apakah produk dan vendor ada
                $produk = Produk::find($produk_id);
                $vendor = Vendor::find($vendor_id);

                if ($produk && $vendor) {
                    VendorPrice::create([
                        'produk_id' => $produk_id,
                        'vendor_id' => $vendor_id,
                        'tanggal_berlaku' => $tanggal_berlaku,
                        'harga_laku' => $harga_laku,
                    ]);
                }
            }

            fclose($handle);
        }

        return redirect()->route('vendor_prices.index')->with('success', 'Data Harga Harian Vendor berhasil diimpor.');
    }
}