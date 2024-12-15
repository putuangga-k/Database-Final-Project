@extends('layouts.app')

@section('title', 'Tambah Pengiriman Baru')

@section('content')
    <div class="mt-4">
        <h2>Tambah Pengiriman Baru</h2>

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

        <form action="{{ route('pengirimans.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="stokis_id">Stokis</label>
                <select name="stokis_id" class="form-control" required>
                    <option value="">-- Pilih Stokis --</option>
                    @foreach($stokisList as $stokis)
                        <option value="{{ $stokis->stokis_id }}" {{ old('stokis_id') == $stokis->stokis_id ? 'selected' : '' }}>
                            {{ $stokis->nama_stokis }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="produk_id">Produk</label>
                <select name="produk_id" class="form-control" required>
                    <option value="">-- Pilih Produk --</option>
                    @foreach($produks as $produk)
                        <option value="{{ $produk->produk_id }}" {{ old('produk_id') == $produk->produk_id ? 'selected' : '' }}>
                            {{ $produk->nama_produk }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="quantitas_produk">Quantitas Produk</label>
                <input type="number" name="quantitas_produk" class="form-control" value="{{ old('quantitas_produk') }}" min="1" required>
            </div>

            <div class="form-group">
                <label for="tanggal_pengiriman">Tanggal Pengiriman</label>
                <input type="date" name="tanggal_pengiriman" class="form-control" value="{{ old('tanggal_pengiriman') }}" required>
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