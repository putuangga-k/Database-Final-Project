@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
    <div class="mt-4">
        <h2>Daftar Produk</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('produk.create') }}" class="btn btn-primary mb-3">Tambah Produk Baru</a>

        @if($produks->isEmpty())
            <p>Belum ada produk yang ditambahkan.</p>
        @else
            <table class="table table-bordered table-striped table-light">
                </thead>
                <thead>
                     <tr>
                        <th>Produk ID</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Unit</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produks as $produk)
                        <tr>
                            <td>{{ $produk->produk_id }}</td>
                            <td>{{ $produk->nama_produk }}</td>
                            <td>{{ $produk->category->name ?? 'Tidak ada kategori' }}</td>
                            <td>{{ $produk->unit }}</td>
                            <td>
                                <a href="{{ route('produk.show', $produk->produk_id) }}" class="btn btn-info btn-sm">Lihat</a>
                                <a href="{{ route('produk.edit', $produk->produk_id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('produk.destroy', $produk->produk_id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection