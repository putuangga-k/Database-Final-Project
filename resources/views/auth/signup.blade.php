<!-- resources/views/auth/signup.blade.php -->

@extends('layouts.app')

@section('title', 'Sign Up')

@section('content')
<div class="auth-page">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4>Sign Up</h4>
            </div>
            <div class="card-body">
                <!-- Menampilkan Pesan Sukses -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Menampilkan Pesan Error -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form Sign Up -->
                <form action="{{ route('signup.post') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nama:</label>
                        <input type="text" name="name" class="form-control" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Kata Sandi:</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Kata Sandi:</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">Sign Up</button>
                    <p class="mt-3">Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Jika diperlukan, tambahkan script di sini
</script>
@endsection