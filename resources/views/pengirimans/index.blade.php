@extends('layouts.app')

@section('title', 'Daftar Pengiriman')

@section('content')
    <div class="mt-4">
        <h2>Daftar Pengiriman</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('pengirimans.create') }}" class="btn btn-primary mb-3">Tambah Pengiriman Baru</a>

        @if($pengirimans->isEmpty())
            <p>Belum ada pengiriman yang ditambahkan.</p>
        @else
            <table class="table table-bordered table-striped table-light">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Stokis</th>
                        <th>Nama Produk</th>
                        <th>Quantitas Produk</th>
                        <th>Tanggal Pengiriman</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pengirimans as $pengiriman)
                        <tr>
                            <td>{{ $pengiriman->pengiriman_id }}</td>
                            <td>{{ $pengiriman->stokis->nama_stokis }}</td>
                            <td>{{ $pengiriman->produk->nama_produk }}</td>
                            <td>{{ $pengiriman->quantitas_produk }}</td>
                            <td>{{ $pengiriman->tanggal_pengiriman }}</td>
                            <td>
                                <a href="{{ route('pengirimans.show', $pengiriman) }}" class="btn btn-info btn-sm">Lihat</a>
                                <a href="{{ route('pengirimans.edit', $pengiriman) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('pengirimans.destroy', $pengiriman) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pengiriman ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection