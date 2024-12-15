<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use Illuminate\Http\Request;

class MitraController extends Controller
{
    /**
     * Display a listing of the mitras.
     */
    public function index()
    {
        $mitras = Mitra::all();
        return view('mitras.index', compact('mitras'));
    }

    /**
     * Show the form for creating a new mitra.
     */
    public function create()
    {
        return view('mitras.create');
    }

    /**
     * Store a newly created mitra in storage.
     */
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'nama_mitra' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'lokasi' => 'required|string|max:255',
        ]);

        // Save mitra
        Mitra::create($request->all());

        return redirect()->route('mitras.index')->with('success', 'Mitra berhasil ditambahkan.');
    }

    /**
     * Display the specified mitra.
     */
    public function show(Mitra $mitra)
    {
        return view('mitras.show', compact('mitra'));
    }

    /**
     * Show the form for editing the specified mitra.
     */
    public function edit(Mitra $mitra)
    {
        return view('mitras.edit', compact('mitra'));
    }

    /**
     * Update the specified mitra in storage.
     */
    public function update(Request $request, Mitra $mitra)
    {
        // Validate input
        $request->validate([
            'nama_mitra' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'lokasi' => 'required|string|max:255',
        ]);

        // Update mitra
        $mitra->update($request->all());

        return redirect()->route('mitras.index')->with('success', 'Mitra berhasil diperbarui.');
    }

    /**
     * Remove the specified mitra from storage.
     */
    public function destroy(Mitra $mitra)
    {
        $mitra->delete();

        return redirect()->route('mitras.index')->with('success', 'Mitra berhasil dihapus.');
    }
}