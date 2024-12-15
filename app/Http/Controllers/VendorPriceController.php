<?php

namespace App\Http\Controllers;

use App\Models\VendorPrice;
use App\Models\Produk;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorPriceController extends Controller
{

    public function index()
    {
        // Ambil semua vendor price dengan relasi produk dan vendor
        $vendorPrices = VendorPrice::with(['produk', 'vendor'])->get();
        return view('vendor_prices.index', compact('vendorPrices'));
    }


    public function create()
    {
        return view('vendor_prices.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();

        // Buka file CSV
        if (($handle = fopen($path, 'r')) !== false) {
            
            fgetcsv($handle); 
            
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                $produk_id = $data[0];
                $tanggal_berlaku = $data[1]; 
                $vendor_id = $data[2];
                $harga_laku = $data[3];


                VendorPrice::create([
                    'produk_id' => $produk_id,
                    'vendor_id' => $vendor_id,
                    'tanggal_berlaku' => $tanggal_berlaku,
                    'harga_laku' => $harga_laku,
                ]);
            }

            fclose($handle);
        }

        return redirect()->route('vendor_prices.index')->with('success', 'Data Harga Harian Vendor berhasil diimpor.');
    }
}