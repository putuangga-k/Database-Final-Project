@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Stokis Sold</h1>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Produk</th>
                <th>Stokis</th>
                <th>Tanggal Sold</th>
                <th>Harga</th>
                {{-- <th>Created At</th>
                <th>Updated At</th> --}}
            </tr>
        </thead>
        <tbody>
            @forelse($stokisSold as $sold)
                <tr>
                    <td>{{ $sold->id }}</td>
                    <td>{{ $sold->produk->nama_produk ?? 'N/A' }}</td>
                    <td>{{ $sold->stokis->nama_stokis ?? 'N/A' }}</td>
                    <td>{{ $sold->tanggal_sold }}</td>
                    <td>Rp {{ number_format($sold->harga, 0, ',', '.') }}</td>
                    {{-- <td>{{ $sold->created_at->format('Y-m-d H:i') }}</td>
                    <td>{{ $sold->updated_at->format('Y-m-d H:i') }}</td> --}}
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data stokis sold.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination links -->
    <div class="d-flex justify-content-center">
        {{ $stokisSold->links('pagination::simple-bootstrap-4') }}
    </div>
</div>
@endsection