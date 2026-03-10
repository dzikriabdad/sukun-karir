@extends('layouts.main')

@section('title', 'Admin - Manajemen Master Data')

@section('content')
<div class="pt-32 pb-20 px-5 bg-gray-50 min-h-screen">
    <div class="max-w-screen-xl mx-auto">
        <h1 class="text-3xl font-extrabold text-blue-900 mb-10">Manajemen Master Data</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <div class="bg-white p-10 rounded-[2rem] shadow-sm border border-gray-50">
                <h3 class="text-xl font-bold mb-8 text-gray-800">Daftar Kategori Departemen</h3>
                
                <form action="{{ route('admin.master.category.store') }}" method="POST" class="flex gap-3 mb-8">
                    @csrf
                    <input type="text" name="name" placeholder="Tambah kategori baru..." class="flex-1 bg-gray-50 border border-gray-200 rounded-xl px-5 py-3 text-sm focus:ring-blue-500 focus:border-blue-500" required>
                    <button type="submit" class="bg-blue-900 text-white px-8 py-3 rounded-xl text-sm font-bold hover:bg-blue-800 transition">Simpan</button>
                </form>

                <div class="space-y-4">
                    @foreach($categories as $cat)
                    <div class="flex justify-between items-center bg-white border border-gray-100 p-5 rounded-2xl shadow-sm">
                        <span class="text-sm font-medium text-slate-700">{{ $cat->name }}</span>
                        <form action="{{ route('admin.master.category.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 text-[11px] font-black tracking-widest uppercase">Hapus</button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white p-10 rounded-[2rem] shadow-sm border border-gray-50">
                <h3 class="text-xl font-bold mb-8 text-gray-800">Daftar Level Pengalaman</h3>
                
                <form action="{{ route('admin.master.experience.store') }}" method="POST" class="flex gap-3 mb-8">
                    @csrf
                    <input type="text" name="name" placeholder="Contoh: Senior (5+ Tahun)" class="flex-1 bg-gray-50 border border-gray-200 rounded-xl px-5 py-3 text-sm focus:ring-blue-500 focus:border-blue-500" required>
                    <button type="submit" class="bg-blue-900 text-white px-8 py-3 rounded-xl text-sm font-bold hover:bg-blue-800 transition">Simpan</button>
                </form>

                <div class="space-y-4">
                    @foreach($experiences as $exp)
                    <div class="flex justify-between items-center bg-white border border-gray-100 p-5 rounded-2xl shadow-sm">
                        <span class="text-sm font-medium text-slate-700">{{ $exp->name }}</span>
                        <form action="{{ route('admin.master.experience.destroy', $exp->id) }}" method="POST" onsubmit="return confirm('Hapus level pengalaman ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 text-[11px] font-black tracking-widest uppercase">Hapus</button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection