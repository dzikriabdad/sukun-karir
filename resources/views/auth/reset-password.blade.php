@extends('layouts.main')
@section('title', 'Reset Password')
@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-md p-8">
        <h2 class="text-2xl font-bold text-center text-blue-900 mb-6">Buat Password Baru</h2>

        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ $email ?? old('email') }}" readonly class="w-full px-4 py-2 border bg-gray-100 rounded-xl">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                <input type="password" name="password" required class="w-full px-4 py-2 border rounded-xl focus:ring-blue-500">
                @error('password') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" required class="w-full px-4 py-2 border rounded-xl focus:ring-blue-500">
            </div>

            <button type="submit" class="w-full bg-blue-900 text-white font-bold py-3 rounded-xl hover:bg-blue-800 transition">Simpan Password Baru</button>
        </form>
    </div>
</div>
@endsection