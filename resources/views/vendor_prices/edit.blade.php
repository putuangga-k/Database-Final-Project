@extends('layouts.app')

@section('title', 'Edit Harga Harian Vendor')

@section('content')
<div class="container">
    <h1 class="my-4">Edit Harga Harian Vendor</h1>

    {{-- Menampilkan Pesan Error --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulir Edit --}}
    <form action="{{ route('vendor_prices.update', $vendorPrice->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="produk_id">Produk:</label>
            <select name="produk_id" id="produk_id" class="form-control" required>
                <option value="">-- Pilih Produk --</option>
                @foreach($produks as $produk)
                    <option value="{{ $produk->produk_id }}" {{ $vendorPrice->produk_id == $produk->produk_id ? 'selected' : '' }}>
                        {{ $produk->nama_produk }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="vendor_id">Vendor:</label>
            <select name="vendor_id" id="vendor_id" class="form-control" required>
                <option value="">-- Pilih Vendor --</option>
                @foreach($vendors as $vendor)
                    <option value="{{ $vendor->vendor_id }}" {{ $vendorPrice->vendor_id == $vendor->vendor_id ? 'selected' : '' }}>
                        {{ $vendor->vendor_nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="tanggal_berlaku">Tanggal Berlaku:</label>
            <input type="date" name="tanggal_berlaku" id="tanggal_berlaku" class="form-control" value="{{ $vendorPrice->tanggal_berlaku }}" required>
        </div>

        <div class="form-group">
            <label for="harga_laku">Harga Laku:</label>
            <input type="number" name="harga_laku" id="harga_laku" class="form-control" min="0" step="0.01" value="{{ $vendorPrice->harga_laku }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Perbarui</button>
        <a href="{{ route('vendor_prices.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection