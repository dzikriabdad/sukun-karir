@extends('layouts.main')

@section('title', 'Login HRD - Sukun Karir')

@section('content')
<div class="pt-32 pb-20 px-5 bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
        
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-blue-900 mb-2">Portal HRD Sukun</h1>
            <p class="text-sm text-gray-500">Gunakan kredensial administrator Anda</p>
        </div>

        @if($errors->any())
            <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 text-sm border border-red-100 font-medium">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.login') }}" method="POST">
            @csrf
            
            <div class="mb-5">
                <label for="email" class="block mb-2 text-sm font-bold text-gray-700">Email Perusahaan</label>
                <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5" placeholder="admin@sukunsigaret.com" required value="{{ old('email') }}">
            </div>
            
            <div class="mb-6">
                <label for="password" class="block mb-2 text-sm font-bold text-gray-700">Password</label>
                <input type="password" name="password" id="password" class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5" placeholder="••••••••" required>
            </div>

            <button type="submit" class="w-full text-white bg-blue-900 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-xl text-sm px-5 py-4 text-center transition">
                Masuk ke Panel Admin
            </button>
            
        </form>

        <div class="mt-6 text-center">
            <a href="/login" class="text-sm text-blue-600 hover:underline font-medium">Kembali ke Login Pelamar</a>
        </div>
    </div>
</div>
@endsection