<?php

namespace App\Http\Controllers;

use App\Models\Pusat;
use App\Models\Vendor;
use App\Models\Produk;
use Illuminate\Http\Request;

class PusatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pusats = Pusat::with(['vendor', 'produk'])->get();
        return view('pusats.index', compact('pusats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vendors = Vendor::all();
        $produks = Produk::all();
        return view('pusats.create', compact('vendors', 'produks'));
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
             'nama_pusat' => 'required|string|max:255',
             'lokasi' => 'required|string|max:255',
             'contact_info' => 'required|string|max:255',
             'vendor_id' => 'required|exists:vendors,vendor_id',
             'produk_id' => 'required|exists:produks,produk_id',
         ]);

         Pusat::create($request->all());

         return redirect()->route('pusats.index')
                          ->with('success', 'Pusat berhasil ditambahkan.');
     }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pusat  $pusat
     * @return \Illuminate\Http\Response
     */
    public function show(Pusat $pusat)
    {
        return view('pusats.show', compact('pusat'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pusat  $pusat
     * @return \Illuminate\Http\Response
     */
    public function edit(Pusat $pusat)
    {
        $vendors = Vendor::all();
        $produks = Produk::all();
        return view('pusats.edit', compact('pusat', 'vendors', 'produks'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pusat  $pusat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pusat $pusat)
    {
        $request->validate([
            'nama_pusat' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'contact_info' => 'required|string|max:255',
            'vendor_id' => 'required|exists:vendors,vendor_id',
            'produk_id' => 'required|exists:produks,produk_id',
        ]);

        $pusat->update($request->all());

        return redirect()->route('pusats.index')
                         ->with('success', 'Pusat berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pusat  $pusat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pusat $pusat)
    {
        $pusat->delete();

        return redirect()->route('pusats.index')
                         ->with('success', 'Pusat berhasil dihapus.');
    }
}