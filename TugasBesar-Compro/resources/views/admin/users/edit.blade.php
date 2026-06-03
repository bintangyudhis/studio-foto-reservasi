@extends('admin.layouts.app')

@section('title', 'Edit Admin - Dashboard')

@section('content')
    <div class="mb-4">
        <a href="{{ route('admin.users') }}" class="btn btn-secondary btn-sm">&larr; Kembali</a>
    </div>

    <div class="card stat-card p-4 border-0">
        <h5 class="fw-bold mb-4" style="color: #00A99D;">Edit Data Admin</h5>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" id="name" value="{{ $user->name }}" disabled>
                <small class="text-muted">Tidak bisa diubah</small>
            </div>

            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" value="{{ $user->username }}" disabled>
                <small class="text-muted">Tidak bisa diubah</small>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                    name="email" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password Baru (kosongkan jika tidak diubah)</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                    name="password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('admin.users') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection
