@extends('layouts.main')

@section('title', 'Login Pelamar - Sukun Karir')

@section('content')
<div class="pt-32 pb-20 flex items-center justify-center px-5">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl border border-gray-100 p-8">
        <div class="text-center mb-8">
            <img src="{{ asset('images/sukun.png') }}" alt="Logo Sukun" class="h-14 mx-auto mb-4 grayscale">
            <h2 class="text-2xl font-bold text-blue-900">Selamat Datang!</h2>
            <p class="text-slate-500 text-sm mt-1">Masuk untuk melanjutkan proses lamaran.</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-red-50 text-red-600 text-xs">
                @foreach ($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Email</label>
                <input type="email" name="email" required placeholder="email@contoh.com"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition duration-200">
            </div>
            
            <div class="relative">
                <label class="block text-sm font-semibold text-slate-700 mb-1">Password</label>
                <input type="password" name="password" id="passwordInput" required placeholder="••••••••"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition duration-200">
                <button type="button" onclick="togglePassword()" class="absolute right-4 top-9 text-slate-400 hover:text-blue-600">
                    <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </button>
            </div>
            
            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center text-slate-600 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-2">
                    Ingat saya
                </label>
                <a href="#" class="text-blue-700 font-medium hover:underline">Lupa password?</a>
            </div>

            <button type="submit" class="w-full bg-blue-900 text-white font-bold py-3.5 rounded-xl shadow-lg hover:bg-blue-800 transform active:scale-[0.98] transition duration-200">
                Masuk Sekarang
            </button>
            
            <p class="text-center text-sm text-slate-600 mt-6">
                Tidak punya akun? 
                <a href="{{ route('register') }}" class="font-bold text-blue-700 hover:underline">Daftar</a>
            </p>
        </form>
    </div>
</div>

<script>
    function togglePassword() {
        const input = document.getElementById('passwordInput');
        input.type = input.type === 'password' ? 'text' : 'password';
    }
</script>
@endsection