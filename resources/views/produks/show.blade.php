@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')
    <div class="mt-4">
        <h2>Detail Produk</h2>

        <table class="table table-bordered table-striped table-light">
            <tr>
                <th>Produk ID</th>
                <td>{{ $produk->produk_id }}</td>
            </tr>
            <tr>
                <th>Nama Produk</th>
                <td>{{ $produk->nama_produk }}</td>
            </tr>
            <tr>
                <th>Kategori</th>
                <td>{{ $produk->category->name ?? 'Tidak ada kategori' }}</td>
            </tr>            
            <tr>
                <th>Deskripsi</th>
                <td>{{ $produk->deskripsi ?? 'Tidak ada deskripsi.' }}</td>
            </tr>
            <tr>
                <th>Unit</th>
                <td>{{ $produk->unit }}</td>
            </tr>
        </table>

        <a href="{{ route('produk.edit', $produk->produk_id) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('produk.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
@endsection