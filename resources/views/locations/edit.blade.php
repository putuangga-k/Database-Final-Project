@extends('layouts.app')

@section('title', 'Edit Lokasi')

@section('content')
<div class="container mt-4">
    <h2>Edit Lokasi</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('locations.update', $location->location_id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="lokasi">Lokasi:</label>
            <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi', $location->lokasi) }}" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Perbarui Lokasi</button>
        <a href="{{ route('locations.index') }}" class="btn btn-secondary btn-block">Batal</a>
    </form>
</div>
@endsection