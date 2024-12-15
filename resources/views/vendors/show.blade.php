@extends('layouts.app')

@section('title', 'Detail Vendor')

@section('content')
    <div class="mt-4">
        <h2>Detail Vendor</h2>

        <div class="card">
            <div class="card-header">
                {{ $vendor->vendor_nama }}
            </div>
            <div class="card-body">
                <p><strong>Vendor ID:</strong> {{ $vendor->vendor_id }}</p>
                <p><strong>Contact Info:</strong> {{ $vendor->contact_info }}</p>
                <p><strong>Lokasi:</strong> {{ $vendor->lokasi }}</p>
                <p><strong>Produk:</strong> {{ $vendor->produk->nama_produk ?? 'N/A' }}</p>
            </div>
        </div>

        <a href="{{ route('vendors.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </div>
@endsection