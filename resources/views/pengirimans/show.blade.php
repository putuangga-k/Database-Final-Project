@extends('layouts.app')

@section('title', 'Detail Pengiriman')

@section('content')
    <div class="mt-4">
        <h2>Detail Pengiriman</h2>

        <table class="table table-bordered table-striped table-light">
            <tr>
                <th>ID</th>
                <td>{{ $pengiriman->pengiriman_id }}</td>
            </tr>
            <tr>
                <th>Nama Stokis</th>
                <td>{{ $pengiriman->stokis->nama_stokis }}</td>
            </tr>
            <tr>
                <th>Nama Produk</th>
                <td>{{ $pengiriman->produk->nama_produk }}</td>
            </tr>
            <tr>
                <th>Quantitas Produk</th>
                <td>{{ $pengiriman->quantitas_produk }}</td>
            </tr>
            <tr>
                <th>Tanggal Pengiriman</th>
                <td>{{ $pengiriman->tanggal_pengiriman }}</td>
            </tr>
        </table>

        <a href="{{ route('pengirimans.edit', $pengiriman) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('pengirimans.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
@endsection