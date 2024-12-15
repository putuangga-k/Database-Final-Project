@extends('layouts.app')

@section('title', 'Daftar Lokasi')

@section('content')
<div class="container mt-4">
    <h2>Daftar Lokasi</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('locations.create') }}" class="btn btn-primary mb-3">Tambah Lokasi Baru</a>

    @if($locations->isEmpty())
        <p>Belum ada lokasi yang ditambahkan.</p>
    @else
        <table class="table table-bordered table-striped table-light">
            <thead>
                <tr>
                    <th>Location ID</th>
                    <th>Lokasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($locations as $location)
                <tr>
                    <td>{{ $location->location_id }}</td>
                    <td>{{ $location->lokasi }}</td>
                    <td>
                        <a href="{{ route('locations.show', $location->location_id) }}" class="btn btn-info btn-sm">Lihat</a>
                        <a href="{{ route('locations.edit', $location->location_id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('locations.destroy', $location->location_id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus lokasi ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection