@extends('layouts.app')

@section('title', 'Daftar Pusat')

@section('content')
    <div class="mt-4">
        <h2>Daftar Pusat Logistik</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('pusats.create') }}" class="btn btn-primary mb-3">Tambah Pusat Baru</a>

        @if($pusats->isEmpty())
            <p>Belum ada pusat logistik yang ditambahkan.</p>
        @else
            <table class="table table-bordered table-striped table-light">
                <thead>
                    <tr>
                        <th>Pusat ID</th>
                        <th>Nama Pusat</th>
                        <th>Lokasi</th>
                        <th>Contact Info</th>
                        <th>Vendor</th>
                        <th>Produk</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pusats as $pusat)
                        <tr>
                            <td>{{ $pusat->pust_id }}</td>
                            <td>{{ $pusat->nama_pusat }}</td>
                            <td>{{ $pusat->lokasi }}</td>
                            <td>{{ $pusat->contact_info }}</td>
                            <td>{{ $pusat->vendor->vendor_nama ?? 'N/A' }}</td>
                            <td>{{ $pusat->produk->nama_produk ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('pusats.show', $pusat->pust_id) }}" class="btn btn-info btn-sm">Lihat</a>
                                <a href="{{ route('pusats.edit', $pusat->pust_id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('pusats.destroy', $pusat->pust_id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pusat ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection