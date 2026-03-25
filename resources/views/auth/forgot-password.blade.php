@extends('layouts.main')
@section('title', 'Lupa Password')
@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-md p-8">
        <h2 class="text-2xl font-bold text-center text-blue-900 mb-2">Lupa Password?</h2>
        <p class="text-sm text-gray-500 text-center mb-6">Masukkan email kamu yang terdaftar, kami akan mengirimkan link untuk membuat password baru.</p>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded-xl mb-4 text-sm">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded-xl mb-4 text-sm">{{ session('error') }}</div>
        @endif

        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                <input type="email" name="email" required class="w-full px-4 py-2 border rounded-xl focus:ring-blue-500 focus:border-blue-500">
                @error('email') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>
            <button type="submit" class="w-full bg-blue-900 text-white font-bold py-3 rounded-xl hover:bg-blue-800 transition">Kirim Link Reset</button>
        </form>
        <div class="mt-4 text-center">
            <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:underline">Kembali ke halaman Login</a>
        </div>
    </div>
</div>
@endsection