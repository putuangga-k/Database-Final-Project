@extends('layouts.app')

@section('title', 'Edit Vendor')

@section('content')
    <div class="mt-4">
        <h2>Edit Vendor</h2>

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

        <form action="{{ route('vendors.update', $vendor->vendor_id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="vendor_nama">Nama Vendor</label>
                <input type="text" name="vendor_nama" class="form-control" id="vendor_nama" placeholder="Masukkan nama vendor" value="{{ old('vendor_nama', $vendor->vendor_nama) }}" required>
            </div>

            <div class="form-group">
                <label for="contact_info">Contact Info</label>
                <input type="text" name="contact_info" class="form-control" id="contact_info" placeholder="Masukkan informasi kontak (email/telepon)" value="{{ old('contact_info', $vendor->contact_info) }}" required>
            </div>

            <div class="form-group">
                <label for="lokasi">Lokasi</label>
                <input type="text" name="lokasi" class="form-control" id="lokasi" placeholder="Masukkan lokasi vendor" value="{{ old('lokasi', $vendor->lokasi) }}" required>
            </div>

            <div class="form-group">
                <label for="produk_id">Produk</label>
                <select name="produk_id" id="produk_id" class="form-control" required>
                    <option value="">-- Pilih Produk --</option>
                    @foreach($produks as $produk)
                        <option value="{{ $produk->produk_id }}" {{ (old('produk_id', $vendor->produk_id) == $produk->produk_id) ? 'selected' : '' }}>{{ $produk->nama_produk }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-warning">Perbarui</button>
            <a href="{{ route('vendors.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection