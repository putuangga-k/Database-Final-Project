@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
    <div class="mt-4">
        <h2>Tambah Produk Baru</h2>

        <!-- Menampilkan Pesan Error -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('produk.store') }}" method="POST">
            @csrf

            <!-- Input untuk Kategori -->
            <div class="form-group">
                <label for="category_id">Kategori:</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ (old('category_id') == $category->id) ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Input untuk Nama Produk -->
            <div class="form-group">
                <label for="nama_produk">Nama Produk:</label>
                <input type="text" name="nama_produk" class="form-control" value="{{ old('nama_produk') }}" required>
            </div>

            <!-- Input untuk Deskripsi -->
            <div class="form-group">
                <label for="deskripsi">Deskripsi:</label>
                <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="form-group">
                <label for="unit">Unit:</label>
                <input type="number" name="unit" id="unit" class="form-control" value="{{ old('unit') }}" min="0" required>
            </div>

            <!-- Tombol Submit -->
            <button type="submit" class="btn btn-success btn-block">Simpan Produk</button>
            <a href="{{ route('produk.index') }}" class="btn btn-secondary btn-block">Batal</a>
        </form>
    </div>
@endsection