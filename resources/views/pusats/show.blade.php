@extends('layouts.app')

@section('title', 'Detail Pusat')

@section('content')
    <div class="mt-4">
        <h2>Detail Pusat Logistik</h2>

        <div class="card">
            <div class="card-header">
                {{ $pusat->nama_pusat }}
            </div>
            <div class="card-body">
                <p><strong>Pusat ID:</strong> {{ $pusat->pust_id }}</p>
                <p><strong>Lokasi:</strong> {{ $pusat->lokasi }}</p>
                <p><strong>Contact Info:</strong> {{ $pusat->contact_info }}</p>
                <p><strong>Vendor:</strong> {{ $pusat->vendor->vendor_nama ?? 'N/A' }}</p>
                <p><strong>Produk:</strong> {{ $pusat->produk->nama_produk ?? 'N/A' }}</p>
            </div>
        </div>

        <a href="{{ route('pusats.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </div>
@endsection