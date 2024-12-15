<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Menampilkan daftar lokasi.
     */
    public function index()
    {
        $locations = Location::all();
        return view('locations.index', compact('locations'));
    }

    /**
     * Menampilkan form untuk membuat lokasi baru.
     */
    public function create()
    {
        return view('locations.create');
    }

    /**
     * Menyimpan lokasi baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'lokasi' => 'required|string|max:255',
        ]);

        Location::create([
            'lokasi' => $request->lokasi,
        ]);

        return redirect()->route('locations.index')->with('success', 'Lokasi berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail lokasi tertentu (opsional).
     */
    public function show(Location $location)
    {
        return view('locations.show', compact('location'));
    }

    /**
     * Menampilkan form untuk mengedit lokasi tertentu.
     */
    public function edit(Location $location)
    {
        return view('locations.edit', compact('location'));
    }

    /**
     * Memperbarui lokasi tertentu di database.
     */
    public function update(Request $request, Location $location)
    {
        $request->validate([
            'lokasi' => 'required|string|max:255',
        ]);

        $location->update([
            'lokasi' => $request->lokasi,
        ]);

        return redirect()->route('locations.index')->with('success', 'Lokasi berhasil diperbarui.');
    }

    /**
     * Menghapus lokasi tertentu dari database.
     */
    public function destroy(Location $location)
    {
        $location->delete();
        return redirect()->route('locations.index')->with('success', 'Lokasi berhasil dihapus.');
    }
}
