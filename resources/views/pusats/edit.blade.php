@extends('layouts.app')

@section('title', 'Edit Pusat')

@section('content')
    <div class="mt-4">
        <h2>Edit Pusat Logistik</h2>

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

        <form action="{{ route('pusats.update', $pusat->pust_id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nama_pusat">Nama Pusat</label>
                <input type="text" name="nama_pusat" class="form-control" id="nama_pusat" placeholder="Masukkan nama pusat" value="{{ old('nama_pusat', $pusat->nama_pusat) }}" required>
            </div>

            <div class="form-group">
                <label for="lokasi">Lokasi</label>
                <input type="text" name="lokasi" class="form-control" id="lokasi" placeholder="Masukkan lokasi pusat" value="{{ old('lokasi', $pusat->lokasi) }}" required>
            </div>

            <div class="form-group">
                <label for="contact_info">Contact Info</label>
                <input type="text" name="contact_info" class="form-control" id="contact_info" placeholder="Masukkan informasi kontak (email/telepon)" value="{{ old('contact_info', $pusat->contact_info) }}" required>
            </div>

            <div class="form-group">
                <label for="vendor_id">Vendor</label>
                <select name="vendor_id" id="vendor_id" class="form-control" required>
                    <option value="">-- Pilih Vendor --</option>
                    @foreach($vendors as $vendor)
                        <option value="{{ $vendor->vendor_id }}" {{ (old('vendor_id', $pusat->vendor_id) == $vendor->vendor_id) ? 'selected' : '' }}>{{ $vendor->vendor_nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="produk_id">Produk</label>
                <select name="produk_id" id="produk_id" class="form-control" required>
                    <option value="">-- Pilih Produk --</option>
                    @foreach($produks as $produk)
                        <option value="{{ $produk->produk_id }}" {{ (old('produk_id', $pusat->produk_id) == $produk->produk_id) ? 'selected' : '' }}>{{ $produk->nama_produk }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-warning">Perbarui</button>
            <a href="{{ route('pusats.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection