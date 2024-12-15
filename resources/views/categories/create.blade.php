@extends('layouts.app')

@section('title', 'Tambah Kategori Baru')

@section('content')
<div class="container">
    <h1 class="btn btn-primary mb-3">Tambah Kategori Baru</h1>

    <!-- Tampilkan error validasi -->
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Tambah Kategori -->
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nama Kategori</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary mt-3">Batal</a>
    </form>
</div>
@endsection