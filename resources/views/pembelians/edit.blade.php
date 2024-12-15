@extends('layouts.app')

@section('title', 'Edit Pembelian')

@section('content')
    <div class="mt-4">
        <h2>Edit Pembelian</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Terjadi kesalahan!</strong> Silakan perbaiki input di bawah ini.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pembelians.update', $pembelian) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="produk_id">Produk</label>
                <select name="produk_id" class="form-control" required>
                    <option value="">-- Pilih Produk --</option>
                    @foreach($produks as $produk)
                        <option value="{{ $produk->produk_id }}" data-harga="{{ $produk->harga ?? 0 }}"
                            {{ old('produk_id', $pembelian->produk_id) == $produk->produk_id ? 'selected' : '' }}>
                            {{ $produk->nama_produk }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="vendor_id">Vendor</label>
                <select name="vendor_id" class="form-control" required>
                    <option value="">-- Pilih Vendor --</option>
                    @foreach($vendors as $vendor)
                        <option value="{{ $vendor->vendor_id }}"
                            {{ old('vendor_id', $pembelian->vendor_id) == $vendor->vendor_id ? 'selected' : '' }}>
                            {{ $vendor->vendor_nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="tanggal_pembelian">Tanggal Pembelian</label>
                <input type="date" name="tanggal_pembelian" class="form-control"
                    value="{{ old('tanggal_pembelian', $pembelian->tanggal_pembelian) }}" required>
            </div>

            <div class="form-group">
                <label for="harga_produk">Harga Produk (Rp)</label>
                <input type="number" name="harga_produk" id="harga_produk" class="form-control"
                    value="{{ old('harga_produk', $pembelian->harga_produk) }}" min="0" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="quantitas_produk">Quantitas Produk</label>
                <input type="number" name="quantitas_produk" id="quantitas_produk" class="form-control"
                    value="{{ old('quantitas_produk', $pembelian->quantitas_produk) }}" min="1" required>
            </div>

            <div class="form-group">
                <label for="total_harga">Total Harga (Rp)</label>
                <input type="number" name="total_harga" id="total_harga" class="form-control"
                    value="{{ old('total_harga', $pembelian->total_harga) }}" readonly>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('pembelians.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection

@section('scripts')
<script>
    function calculateTotal() {
        var harga = parseFloat(document.getElementById('harga_produk').value) || 0;
        var quantitas = parseInt(document.getElementById('quantitas_produk').value) || 0;
        var total = harga * quantitas;
        document.getElementById('total_harga').value = total.toFixed(2);
    }

    document.getElementById('harga_produk').addEventListener('input', calculateTotal);
    document.getElementById('quantitas_produk').addEventListener('input', calculateTotal);

    // Optional: Auto-fill harga_produk based on selected product
    document.querySelector('select[name="produk_id"]').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var harga = selectedOption.getAttribute('data-harga') || 0;
        document.getElementById('harga_produk').value = harga;
        calculateTotal();
    });

    // Calculate total on page load
    calculateTotal();
</script>
@endsection