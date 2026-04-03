@extends('layouts.main')

@section('title', 'Admin - Manajemen Master Data')

@section('content')
<div class="pt-32 pb-20 px-5 bg-blue-50/30 min-h-screen">
    <div class="max-w-screen-xl mx-auto">
        {{-- Header Halaman --}}
        <div class="flex items-center gap-4 mb-10">
            <div class="h-12 w-2 bg-blue-900 rounded-full shadow-sm"></div>
            <h1 class="text-3xl font-extrabold text-blue-900 tracking-tight">Manajemen Master Data</h1>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            
            {{-- KARTU KIRI: MASTER DEPARTEMEN --}}
            <div class="bg-white p-10 rounded-[2.5rem] shadow-xl shadow-blue-900/5 border border-blue-100">
                <div class="flex items-center gap-3 mb-8">
                    <div class="p-3 bg-blue-50 rounded-2xl">
                        <i class="fa-solid fa-building-user text-2xl text-blue-900"></i>
                    </div>
                    <h3 class="text-xl font-bold text-blue-900">Daftar Departemen & Divisi</h3>
                </div>
                
                <form action="{{ route('admin.master.category.store') }}" method="POST" class="flex gap-3 mb-10">
                    @csrf
                    <input type="text" name="name" placeholder="Tambah departemen (contoh: Produksi, IT)..." 
                           class="flex-1 bg-white border-2 border-blue-50 rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-blue-900 focus:border-blue-900 outline-none transition-all font-medium text-slate-700" required>
                    <button type="submit" class="bg-blue-900 text-white px-8 py-4 rounded-2xl text-sm font-black uppercase tracking-widest hover:bg-blue-800 transition shadow-lg shadow-blue-900/20">
                        Simpan
                    </button>
                </form>

                <div class="space-y-4">
                    @foreach($categories as $cat)
                    <div class="flex justify-between items-center bg-blue-50/30 border border-blue-100 p-6 rounded-[1.5rem] hover:bg-white hover:shadow-md transition-all group">
                        <span class="text-sm font-black text-blue-900 uppercase tracking-tight">{{ $cat->name }}</span>
                        <form action="{{ route('admin.master.category.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Hapus departemen ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-blue-400 hover:text-blue-900 text-[10px] font-black tracking-widest uppercase transition-colors">Hapus</button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- KARTU KANAN: MASTER JENJANG PENGALAMAN --}}
            <div class="bg-white p-10 rounded-[2.5rem] shadow-xl shadow-blue-900/5 border border-blue-100">
                <div class="flex items-center gap-3 mb-8">
                    <div class="p-3 bg-blue-50 rounded-2xl">
                        <i class="fa-solid fa-briefcase text-2xl text-blue-900"></i>
                    </div>
                    <h3 class="text-xl font-bold text-blue-900">Jenjang & Kriteria Pengalaman</h3>
                </div>
                
                <form action="{{ route('admin.master.experience.store') }}" method="POST" class="flex gap-3 mb-10">
                    @csrf
                    <input type="text" name="name" placeholder="Tambah kriteria (contoh: Fresh Graduate)..." 
                           class="flex-1 bg-white border-2 border-blue-50 rounded-2xl px-5 py-4 text-sm focus:ring-2 focus:ring-blue-900 focus:border-blue-900 outline-none transition-all font-medium text-slate-700" required>
                    <button type="submit" class="bg-blue-900 text-white px-8 py-4 rounded-2xl text-sm font-black uppercase tracking-widest hover:bg-blue-800 transition shadow-lg shadow-blue-900/20">
                        Simpan
                    </button>
                </form>

                <div class="space-y-4">
                    @foreach($experiences as $exp)
                    <div class="flex justify-between items-center bg-blue-50/30 border border-blue-100 p-6 rounded-[1.5rem] hover:bg-white hover:shadow-md transition-all group">
                        <span class="text-sm font-black text-blue-900 uppercase tracking-tight">{{ $exp->name }}</span>
                        <form action="{{ route('admin.master.experience.destroy', $exp->id) }}" method="POST" onsubmit="return confirm('Hapus jenjang pengalaman ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-blue-400 hover:text-blue-900 text-[10px] font-black tracking-widest uppercase transition-colors">Hapus</button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>
@endsection