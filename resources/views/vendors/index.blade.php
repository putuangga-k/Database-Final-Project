@extends('layouts.app')

@section('title', 'Daftar Vendor')

@section('content')
    <div class="mt-4">
        <h2>Daftar Vendor</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('vendors.create') }}" class="btn btn-primary mb-3">Tambah Vendor Baru</a>

        @if($vendors->isEmpty())
            <p>Belum ada vendor yang ditambahkan.</p>
        @else
            <table class="table table-bordered table-striped table-light">
                <thead>
                    <tr>
                        <th>Vendor ID</th>
                        <th>Nama Vendor</th>
                        <th>Contact Info</th>
                        <th>Lokasi</th>
                        <th>Produk</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vendors as $vendor)
                        <tr>
                            <td>{{ $vendor->vendor_id }}</td>
                            <td>{{ $vendor->vendor_nama }}</td>
                            <td>{{ $vendor->contact_info }}</td>
                            <td>{{ $vendor->lokasi }}</td>
                            <td>{{ $vendor->produk->nama_produk ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('vendors.show', $vendor->vendor_id) }}" class="btn btn-info btn-sm">Lihat</a>
                                <a href="{{ route('vendors.edit', $vendor->vendor_id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('vendors.destroy', $vendor->vendor_id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus vendor ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection