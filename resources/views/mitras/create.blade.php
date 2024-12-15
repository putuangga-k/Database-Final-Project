@extends('layouts.app')

@section('title', 'Tambah Mitra Baru')

@section('content')
    <div class="mt-4">
        <h2>Tambah Mitra Baru</h2>

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

        <form action="{{ route('mitras.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="nama_mitra">Nama Mitra</label>
                <input type="text" name="nama_mitra" class="form-control" id="nama_mitra" placeholder="Masukkan nama mitra" value="{{ old('nama_mitra') }}" required>
            </div>

            <div class="form-group">
                <label for="no_hp">No HP</label>
                <input type="text" name="no_hp" class="form-control" id="no_hp" placeholder="Masukkan nomor HP" value="{{ old('no_hp') }}" required>
            </div>

            <div class="form-group">
                <label for="lokasi">Lokasi</label>
                <input type="text" name="lokasi" class="form-control" id="lokasi" placeholder="Masukkan lokasi mitra" value="{{ old('lokasi') }}" required>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('mitras.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection