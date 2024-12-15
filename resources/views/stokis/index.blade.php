@extends('layouts.app')

@section('title', 'Daftar Stokis')

@section('content')
    <div class="mt-4">
        <h2>Daftar Stokis</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('stokis.create') }}" class="btn btn-primary mb-3">Tambah Stokis Baru</a>

        @if($stokis->isEmpty())
            <p>Belum ada stokis yang ditambahkan.</p>
        @else
            <table class="table table-bordered table-striped table-light">
                <thead>
                    <tr>
                        <th>Stokis ID</th>
                        <th>Nama Stokis</th>
                        <th>No HP</th>
                        <th>Lokasi</th>
                        <th>Produk</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stokis as $s)
                        <tr>
                            <td>{{ $s->stokis_id }}</td>
                            <td>{{ $s->nama_stokis }}</td>
                            <td>{{ $s->no_hp }}</td>
                            <td>{{ $s->lokasi }}</td>
                            <td>{{ $s->product->nama_produk ?? 'Produk tidak ditemukan' }}</td>
                            <td>
                                <a href="{{ route('stokis.show', $s) }}" class="btn btn-info btn-sm">Lihat</a>
                                <a href="{{ route('stokis.edit', $s) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('stokis.destroy', $s) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus stokis ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection