@extends('layouts.app')

@section('title', 'Daftar Mitra')

@section('content')
    <div class="mt-4">
        <h2>Daftar Mitra</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('mitras.create') }}" class="btn btn-primary mb-3">Tambah Mitra Baru</a>

        @if($mitras->isEmpty())
            <p>Belum ada mitra yang ditambahkan.</p>
        @else
            <table class="table table-bordered table-striped table-light">
                <thead>
                    <tr>
                        <th>Mitra ID</th>
                        <th>Nama Mitra</th>
                        <th>No HP</th>
                        <th>Lokasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mitras as $mitra)
                        <tr>
                            <td>{{ $mitra->mitra_id }}</td>
                            <td>{{ $mitra->nama_mitra }}</td>
                            <td>{{ $mitra->no_hp }}</td>
                            <td>{{ $mitra->lokasi }}</td>
                            <td>
                                <a href="{{ route('mitras.show', $mitra) }}" class="btn btn-info btn-sm">Lihat</a>
                                <a href="{{ route('mitras.edit', $mitra) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('mitras.destroy', $mitra) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus mitra ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection