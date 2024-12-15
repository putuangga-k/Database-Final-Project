@extends('layouts.app')

@section('title', 'Detail Lokasi')

@section('content')
<div class="container mt-4">
    <h2>Detail Lokasi</h2>

    <table class="table table-bordered table-striped table-light">
        <tr>
            <th>Location ID</th>
            <td>{{ $location->location_id }}</td>
        </tr>
        <tr>
            <th>Lokasi</th>
            <td>{{ $location->lokasi }}</td>
        </tr>
    </table>

    <a href="{{ route('locations.edit', $location->location_id) }}" class="btn btn-warning">Edit</a>
    <a href="{{ route('locations.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection