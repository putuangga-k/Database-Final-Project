@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <h2>Edit Profile</h2>

    <!-- Menampilkan Pesan Sukses -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Menampilkan Error -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Edit Profile -->
    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="company_name">Nama Perusahaan:</label>
            <input type="text" name="company_name" class="form-control" value="{{ old('company_name', $user->company_name) }}">
        </div>
        <div class="form-group">
            <label for="admin_name">Nama Admin:</label>
            <input type="text" name="admin_name" class="form-control" value="{{ old('admin_name', $user->admin_name) }}">
        </div>
        <div class="form-group">
            <label for="phone">No. HP:</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
        </div>
        <div class="form-group">
            <label for="address">Alamat:</label>
            <input type="text" name="address" class="form-control" value="{{ old('address', $user->address) }}">
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
@endsection

@section('scripts')
    <script>
        // Script untuk toggle sidebar
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar, #content').toggleClass('active');
            });
        });
    </script>
@endsection
