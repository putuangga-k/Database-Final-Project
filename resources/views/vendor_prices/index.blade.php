@extends('layouts.app')

@section('title', 'Harga Harian Vendor')

@section('content')
<div class="container">
    <h1 class="my-4">Daftar Harga Harian Vendor</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('vendor_prices.create') }}" class="btn btn-primary mb-3">Import & Tambah Harga Harian</a>

    @if($vendorPrices->isEmpty())
        <p>Belum ada data harga harian vendor.</p>
    @else
        <table class="table table-bordered table-striped table-light">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Vendor</th>
                    <th>Tanggal Berlaku</th>
                    <th>Harga Laku</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vendorPrices as $vp)
                <tr>
                    <td>{{ $vp->produk->nama_produk ?? 'Produk tidak ditemukan' }}</td>
                    <td>{{ $vp->vendor->vendor_nama ?? 'Vendor tidak ditemukan' }}</td>
                    <td>{{ $vp->tanggal_berlaku }}</td>
                    <td>{{ number_format($vp->harga_laku, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('vendor_prices.edit', $vp->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('vendor_prices.destroy', $vp->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection