@extends('layouts.app')

@section('title', 'Import dan Tambah Harga Harian Vendor')

@section('content')
<div class="container">
    <h1 class="my-4">Import dan Tambah Harga Harian Vendor</h1>

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

    {{-- Formulir Impor CSV --}}
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            Import Harga Harian dari CSV
        </div>
        <div class="card-body">
            <form action="{{ route('vendor_prices.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="csv_file" class="text-dark">File CSV:</label>
                    <input type="file" name="csv_file" id="csv_file" class="form-control" required>
                    <small class="form-text text-muted">Format: produk_id,tanggal_berlaku (YYYY-MM-DD),vendor_id,harga_laku</small>
                </div>
                <button type="submit" class="btn btn-success">Impor CSV</button>
            </form>
        </div>
    </div>

    {{-- Formulir Tambah Entri Manual --}}
    <div class="card">
        <div class="card-header bg-success text-white">
            Tambah Harga Harian Secara Manual
        </div>
        <div class="card-body">
            <form action="{{ route('vendor_prices.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="produk_id" class="text-dark">Produk:</label>
                    <select name="produk_id" id="produk_id" class="form-control" required>
                        <option value="">-- Pilih Produk --</option>
                        @foreach($produks as $produk)
                            <option value="{{ $produk->produk_id }}">{{ $produk->nama_produk }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="vendor_id" class="text-dark">Vendor:</label>
                    <select name="vendor_id" id="vendor_id" class="form-control" required>
                        <option value="">-- Pilih Vendor --</option>
                        @foreach($vendors as $vendor)
                            <option value="{{ $vendor->vendor_id }}">{{ $vendor->vendor_nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="tanggal_berlaku" class="text-dark">Tanggal Berlaku:</label>
                    <input type="date" name="tanggal_berlaku" id="tanggal_berlaku" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="harga_laku" class="text-dark">Harga Laku:</label>
                    <input type="number" name="harga_laku" id="harga_laku" class="form-control" min="0" step="0.01" required>
                </div>

                <button type="submit" class="btn btn-primary">Tambah</button>
                <a href="{{ route('vendor_prices.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection