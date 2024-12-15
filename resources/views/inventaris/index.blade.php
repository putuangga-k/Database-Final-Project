@extends('layouts.app')

@section('title', 'Inventaris Produk')

@section('content')
    <div class="mt-4">
        <h2>Inventaris Produk</h2>

        @if($inventaris->isEmpty())
            <p>Tidak ada data inventaris.</p>
        @else
            <table class="table table-bordered table-striped table-light">
                <thead>
                    <tr>
                        <th>ID Produk</th>
                        <th>Nama Produk</th>
                        <th>Kuantitas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inventaris as $item)
                        <tr>
                            <td>{{ $item->produk->produk_id }}</td>
                            <td>{{ $item->produk->nama_produk }}</td>
                            <td>{{ $item->kuantitas }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection