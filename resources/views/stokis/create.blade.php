@extends('layouts.app')

@section('title', 'Tambah Stokis Baru')

@section('content')
    <div class="mt-4">
        <h2>Tambah Stokis Baru</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Terjadi kesalahan!</strong> Silakan perbaiki input di bawah ini.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('stokis.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="nama_stokis">Nama Stokis</label>
                <input type="text" name="nama_stokis" class="form-control" id="nama_stokis" placeholder="Masukkan nama stokis" value="{{ old('nama_stokis') }}" required>
            </div>

            <div class="form-group">
                <label for="no_hp">No HP</label>
                <input type="text" name="no_hp" class="form-control" id="no_hp" placeholder="Masukkan nomor HP" value="{{ old('no_hp') }}" required>
            </div>

            <div class="form-group">
                <label for="lokasi">Lokasi</label>
                <input type="text" name="lokasi" class="form-control" id="lokasi" placeholder="Masukkan lokasi stokis" value="{{ old('lokasi') }}" required>
            </div>

            <!-- Dropdown Produk -->
            <div class="form-group">
                <label for="product_id">Produk</label>
                <select name="product_id" id="product_id" class="form-control" required>
                    <option value="">Pilih Produk</option>
                    @foreach($produks as $produk)
                        <option value="{{ $produk->produk_id }}" {{ old('product_id') == $produk->produk_id ? 'selected' : '' }}>
                            {{ $produk->nama_produk }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('stokis.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
