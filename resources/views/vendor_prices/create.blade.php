@extends('layouts.app')

@section('title', 'Import Harga Harian Vendor')

@section('content')
<div class="container">
    <h1 class="my-4">Import Harga Harian Vendor</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('vendor_prices.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="csv_file">File CSV:</label>
            <input type="file" name="csv_file" id="csv_file" class="form-control" required>
            <small class="form-text text-muted">Format: produk_id,tanggal_berlaku (YYYY-MM-DD),vendor_id,harga_laku</small>
        </div>
        <button type="submit" class="btn btn-success btn-block">Import</button>
        <a href="{{ route('vendor_prices.index') }}" class="btn btn-secondary btn-block">Batal</a>
    </form>
</div>
@endsection