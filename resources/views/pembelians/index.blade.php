@extends('layouts.app')

@section('title', 'Daftar Pembelian')

@section('content')
    <div class="mt-4">
        <h2>Daftar Pembelian</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('pembelians.create') }}" class="btn btn-primary mb-3">Tambah Pembelian Baru</a>

        @if($pembelians->isEmpty())
            <p>Belum ada pembelian yang ditambahkan.</p>
        @else
            <table class="table table-bordered table-striped table-light">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Produk</th>
                        {{-- <th>Vendor</th>
                        <th>Tanggal Pembelian</th> --}}
                        <th>Quantitas</th>
                        <th>Total Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pembelians as $pembelian)
                        <tr>
                            <td>{{ $pembelian->id }}</td>
                            <td>{{ $pembelian->produk->nama_produk }}</td>
                            {{-- <td>{{ $pembelian->vendor->vendor_nama }}</td>
                            <td>{{ $pembelian->tanggal_pembelian }}</td> --}}
                            <td>{{ $pembelian->quantitas_produk }}</td>
                            <td>Rp{{ number_format($pembelian->total_harga, 2, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('pembelians.show', $pembelian) }}" class="btn btn-info btn-sm">Lihat</a>
                                <a href="{{ route('pembelians.edit', $pembelian) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('pembelians.destroy', $pembelian) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pembelian ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection