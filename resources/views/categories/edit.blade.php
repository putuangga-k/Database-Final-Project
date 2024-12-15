@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
<div class="container">
    <h1 class="my-4">Edit Kategori</h1>

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

    <!-- Form Edit Kategori -->
    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nama Kategori</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $category->name) }}" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Perbarui</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary mt-3">Batal</a>
    </form>
</div>
@endsection