@extends('layouts.app')

@section('title', 'Daftar Kategori')

@section('content')
<div class="container category-page">
    <h1 class="my-4">Daftar Kategori</h1>


    <!-- Tampilkan pesan sukses -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tombol Tambah Kategori -->
    <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Tambah Kategori Baru</a>

    <!-- Tabel Kategori -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
            <tr>
                <td>{{ $category->name }}</td>
                <td>
                    <!-- Tombol Edit -->
                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Edit</a>

                    <!-- Tombol Hapus -->
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="2">Tidak ada kategori.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
