@extends('layouts.app')

@section('title', 'Edit Pengiriman')

@section('content')
    <div class="mt-4">
        <h2>Edit Pengiriman</h2>

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

        <form action="{{ route('pengirimans.update', $pengiriman) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="stokis_id">Stokis</label>
                <input type="text" name="stokis_name" id="stokis_search" class="form-control" placeholder="Cari Stokis..." autocomplete="off" value="{{ old('stokis_name', $pengiriman->stokis->nama_stokis) }}" required>
                <input type="hidden" name="stokis_id" id="stokis_id" value="{{ old('stokis_id', $pengiriman->stokis_id) }}">
                <div id="stokis_list"></div>
            </div>

            <div class="form-group">
                <label for="produk_id">Produk</label>
                <select name="produk_id" class="form-control" required>
                    <option value="">-- Pilih Produk --</option>
                    @foreach($produks as $produk)
                        <option value="{{ $produk->produk_id }}" {{ old('produk_id', $pengiriman->produk_id) == $produk->produk_id ? 'selected' : '' }}>
                            {{ $produk->nama_produk }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="quantitas_produk">Quantitas Produk</label>
                <input type="number" name="quantitas_produk" class="form-control" value="{{ old('quantitas_produk', $pengiriman->quantitas_produk) }}" min="1" required>
            </div>

            <div class="form-group">
                <label for="tanggal_pengiriman">Tanggal Pengiriman</label>
                <input type="date" name="tanggal_pengiriman" class="form-control" value="{{ old('tanggal_pengiriman', $pengiriman->tanggal_pengiriman) }}" required>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('pengirimans.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#stokis_search').on('keyup', function() {
            var query = $(this).val();
            $.ajax({
                url: "{{ route('stokis.search') }}",
                type: "GET",
                data: {'query': query},
                success: function(data){
                    $('#stokis_list').html(data);
                }
            });
        });

        $(document).on('click', '.stokis-item', function(){
            var stokis_id = $(this).data('id');
            var stokis_name = $(this).text();
            $('#stokis_id').val(stokis_id);
            $('#stokis_search').val(stokis_name);
            $('#stokis_list').html('');
        });
    });
</script>
@endsection