@extends('layouts.app')

@section('title', 'Tambah Lokasi')

@section('content')
<div class="container mt-4">
    <h2>Tambah Lokasi Baru</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('locations.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="lokasi">Lokasi:</label>
            <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi') }}" required>
        </div>
        <button type="submit" class="btn btn-success btn-block">Simpan Lokasi</button>
        <a href="{{ route('locations.index') }}" class="btn btn-secondary btn-block">Batal</a>
    </form>
</div>
@endsection