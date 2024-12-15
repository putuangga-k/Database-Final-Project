<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\Produk;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendors = Vendor::with('produk')->get();
        return view('vendors.index', compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $produks = Produk::all();
        return view('vendors.create', compact('produks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request)
     {
         $request->validate([
             'vendor_nama' => 'required|string|max:255',
             'contact_info' => 'required|string|max:255',
             'lokasi' => 'required|string|max:255',
             'produk_id' => 'required|exists:produks,produk_id',
         ]);

         Vendor::create($request->all());

         return redirect()->route('vendors.index')
                          ->with('success', 'Vendor berhasil ditambahkan.');
     }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function show(Vendor $vendor)
    {
        return view('vendors.show', compact('vendor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function edit(Vendor $vendor)
    {
        $produks = Produk::all();
        return view('vendors.edit', compact('vendor', 'produks'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vendor $vendor)
    {
        $request->validate([
            'vendor_nama' => 'required|string|max:255',
            'contact_info' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'produk_id' => 'required|exists:produks,produk_id',
        ]);

        $vendor->update($request->all());

        return redirect()->route('vendors.index')
                         ->with('success', 'Vendor berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vendor $vendor)
    {
        $vendor->delete();

        return redirect()->route('vendors.index')
                         ->with('success', 'Vendor berhasil dihapus.');
    }
}