@extends('layouts.app')

@section('title', 'Detail Kategori')

@section('content')
<div class="container">
    <h1 class="my-4">Detail Kategori</h1>

    <p><strong>Nama Kategori:</strong> {{ $category->name }}</p>

    <!-- Tampilkan produk dalam kategori ini (jika ada) -->
    @if($category->products->count() > 0)
        <h3>Produk dalam Kategori Ini:</h3>
        <ul>
            @foreach($category->products as $product)
                <li>{{ $product->nama_produk }}</li>
            @endforeach
        </ul>
    @else
        <p>Tidak ada produk dalam kategori ini.</p>
    @endif

    <a href="{{ route('categories.index') }}" class="btn btn-secondary mt-3">Kembali ke Daftar Kategori</a>
</div>
@endsection