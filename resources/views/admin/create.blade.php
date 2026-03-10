@extends('layouts.main')

@section('title', 'Admin - Tambah Lowongan Kerja')

@section('content')
<div class="pt-32 pb-20 px-5 bg-gray-50 min-h-screen">
    <div class="max-w-screen-md mx-auto">
        <h1 class="text-2xl font-bold text-blue-900 mb-8">Tambah Lowongan Pekerjaan Baru</h1>

        @if(session('success'))
            <div class="bg-green-50 text-green-700 p-4 rounded-xl mb-6 text-sm border border-green-100 font-medium">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 text-sm border border-red-100 font-medium">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
            <form action="{{ route('admin.lowongan.store') }}" method="POST">
                @csrf
                
                <div class="mb-6">
                    <label for="title" class="block mb-2 text-sm font-bold text-gray-700">Nama Posisi / Pekerjaan</label>
                    <input type="text" name="title" id="title" class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5" placeholder="Contoh: Junior Full Stack" required value="{{ old('title') }}">
                </div>

                <div class="mb-6">
    <label class="block mb-2 text-sm font-bold text-gray-700">Pengalaman</label>
    <select name="experience" class="bg-gray-50 border border-gray-200 text-sm rounded-xl block w-full p-3.5" required>
        <option value="" disabled selected>Pilih Level Pengalaman</option>
        @foreach($experiences as $exp)
            <option value="{{ $exp->name }}">{{ $exp->name }}</option>
        @endforeach
    </select>
</div>

    <div class="mb-6">
             <label class="block mb-2 text-sm font-bold text-gray-700">Kategori Pekerjaan</label>
            <select name="category_id" class="bg-gray-50 border border-gray-200 text-sm rounded-xl block w-full p-3.5" required>
             <option value="" disabled selected>Pilih Kategori</option>
              @foreach($categories as $cat)
            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
        @endforeach
    </select>
</div>

                    <div>
                        <label for="category_id" class="block mb-2 text-sm font-bold text-gray-700">Kategori Pekerjaan</label>
                        <select name="category_id" id="category_id" class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="deskripsi" class="block mb-2 text-sm font-bold text-gray-700">Deskripsi Pekerjaan</label>
                    <textarea name="deskripsi" id="deskripsi" rows="5" class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5" required>{{ old('deskripsi') }}</textarea>
                </div>

                <div class="mb-6">
                    <label for="persyaratan" class="block mb-2 text-sm font-bold text-gray-700">Persyaratan</label>
                    <textarea name="persyaratan" id="persyaratan" rows="5" class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5" required>{{ old('persyaratan') }}</textarea>
                </div>

                <div class="mb-8">
                    <label for="status" class="block mb-2 text-sm font-bold text-gray-700">Status Lowongan</label>
                    <select name="status" id="status" class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5" required>
                        <option value="aktif">Aktif (Ditampilkan ke pelamar)</option>
                        <option value="tutup">Tutup (Disembunyikan)</option>
                    </select>
                </div>

                <button type="submit" class="w-full text-white bg-blue-900 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-xl text-sm px-5 py-4 text-center transition">
                    Simpan Lowongan Kerja
                </button>
            </form>
        </div>
    </div>
</div>
@endsection