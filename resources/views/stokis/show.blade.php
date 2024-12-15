@extends('layouts.app')

@section('title', 'Detail Stokis')

@section('content')
    <div class="mt-4">
        <h2>Detail Stokis</h2>

        <table class="table table-bordered table-striped table-light">
            <tr>
                <th>Stokis ID</th>
                <td>{{ $stokis->stokis_id }}</td>
            </tr>
            <tr>
                <th>Nama Stokis</th>
                <td>{{ $stokis->nama_stokis }}</td>
            </tr>
            <tr>
                <th>No HP</th>
                <td>{{ $stokis->no_hp }}</td>
            </tr>
            <tr>
                <th>Lokasi</th>
                <td>{{ $stokis->lokasi }}</td>
            </tr>
            <tr>
                <th>Produk</th>
                <td>{{ $stokis->product->nama_produk ?? 'Produk tidak ditemukan' }}</td>
            </tr>
        </table>

        <a href="{{ route('stokis.edit', $stokis) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('stokis.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
@endsection