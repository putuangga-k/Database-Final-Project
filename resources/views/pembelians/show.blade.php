@extends('layouts.app')

@section('title', 'Detail Pembelian')

@section('content')
    <div class="mt-4">
        <h2>Detail Pembelian</h2>

        <table class="table table-bordered table-striped table-light">
            <tr>
                <th>ID</th>
                <td>{{ $pembelian->id }}</td>
            </tr>
            <tr>
                <th>Produk</th>
                <td>{{ $pembelian->produk->nama_produk }}</td>
            </tr>
            <tr>
                <th>Vendor</th>
                <td>{{ $pembelian->vendor->vendor_nama }}</td>
            </tr>
            <tr>
                <th>Tanggal Pembelian</th>
                <td>{{ $pembelian->tanggal_pembelian }}</td>
            </tr>
            <tr>
                <th>Harga Produk</th>
                <td>Rp{{ number_format($pembelian->harga_produk, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Quantitas Produk</th>
                <td>{{ $pembelian->quantitas_produk }}</td>
            </tr>
            <tr>
                <th>Total Harga</th>
                <td>Rp. {{ number_format($pembelian->total_harga, 2, ',', '.') }}</td>
            </tr>
        </table>

        <a href="{{ route('pembelians.edit', $pembelian) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('pembelians.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
@endsection