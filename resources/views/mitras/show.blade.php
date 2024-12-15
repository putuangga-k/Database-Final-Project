@extends('layouts.app')

@section('title', 'Detail Mitra')

@section('content')
    <div class="mt-4">
        <h2>Detail Mitra</h2>

        <table class="table table-bordered table-striped table-light">
            <tr>
                <th>Mitra ID</th>
                <td>{{ $mitra->mitra_id }}</td>
            </tr>
            <tr>
                <th>Nama Mitra</th>
                <td>{{ $mitra->nama_mitra }}</td>
            </tr>
            <tr>
                <th>No HP</th>
                <td>{{ $mitra->no_hp }}</td>
            </tr>
            <tr>
                <th>Lokasi</th>
                <td>{{ $mitra->lokasi }}</td>
            </tr>
        </table>

        <a href="{{ route('mitras.edit', $mitra) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('mitras.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
@endsection