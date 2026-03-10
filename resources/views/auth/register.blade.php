@extends('layouts.main')

@section('title', 'Daftar Akun Pelamar - Sukun Karir')

@section('content')
<div class="pt-32 pb-20 flex items-center justify-center px-5">
    <div class="max-w-lg w-full bg-white rounded-3xl shadow-xl border border-gray-100 p-8">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-blue-900">Buat Akun Baru</h2>
            <p class="text-slate-500 text-sm mt-1">Daftar untuk mulai melamar pekerjaan di PT. Sukun.</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-red-50 text-red-600 text-xs">
                @foreach ($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Nama sesuai KTP"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="contoh@gmail.com"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Password</label>
                    <input type="password" name="password" required placeholder="Min. 8 Karakter"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Ulangi Password</label>
                    <input type="password" name="password_confirmation" required placeholder="Konfirmasi"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-900 text-white font-bold py-3.5 rounded-xl shadow-lg hover:bg-blue-800 mt-4 transition">
                Daftar Akun
            </button>
            
            <p class="text-center text-sm text-slate-600 mt-6">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-bold text-blue-700 hover:underline">Masuk</a>
            </p>
        </form>
    </div>
</div>
@endsection