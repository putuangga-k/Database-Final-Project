<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Menampilkan daftar kategori.
     */
    public function index()
    {
        $categories = Category::all();

        return view('categories.index', compact('categories'));
    }

    /**
     * Menampilkan form untuk membuat kategori baru.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Menyimpan kategori baru ke dalam database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        // Membuat kategori baru
        Category::create($validatedData);

        // Redirect dengan pesan sukses
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail kategori tertentu.
     */
    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

    /**
     * Menampilkan form untuk mengedit kategori.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Memperbarui kategori dalam database.
     */
    public function update(Request $request, Category $category)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        // Update kategori
        $category->update($validatedData);

        // Redirect dengan pesan sukses
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Menghapus kategori dari database.
     */
    public function destroy(Category $category)
    {
        // Hapus kategori
        $category->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}