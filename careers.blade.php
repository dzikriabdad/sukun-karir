@extends('layouts.main')

@section('title', 'Semua Lowongan - Sukun Karir')

@section('content')
<div class="bg-slate-50 min-h-screen pt-28 pb-24">
    
    <div class="max-w-screen-xl mx-auto px-6 mb-10">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h1 class="text-3xl md:text-5xl font-extrabold text-blue-900 mb-4 tracking-tight">Eksplorasi Karir</h1>
                <p class="text-lg text-slate-600 max-w-2xl">Temukan peluang terbaik untuk berkembang dan berkarya bersama PT. Sukun Wartono Indonesia.</p>
            </div>
            <div class="bg-blue-100 text-blue-800 px-5 py-2.5 rounded-full font-bold text-sm shadow-sm border border-blue-200 inline-flex items-center gap-2 w-fit">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" />
                    <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
                </svg>
                Semua Lowongan Tersedia
            </div>
        </div>
    </div>

    <div class="max-w-screen-xl mx-auto px-6 mb-12">
        <form action="{{ route('careers.index') }}" method="GET" class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200 flex flex-col md:flex-row gap-3">
            
            {{-- 1. Dropdown Pengalaman (Dinamic dari Database) --}}
            <div class="md:w-1/4">
                <select name="kategori" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-xl px-4 py-3.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition font-medium cursor-pointer">
                    <option value="">Semua Kategori</option>
                    @foreach($experiences as $exp)
                        <option value="{{ $exp->name }}" {{ request('kategori') == $exp->name ? 'selected' : '' }}>
                            {{ $exp->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 2. Dropdown Departemen/Category (Dinamic dari Database) --}}
            <div class="md:w-1/4">
                <select name="departemen" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-xl px-4 py-3.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition font-medium cursor-pointer">
                    <option value="">Semua Departemen</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('departemen') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 3. Kolom Pencarian --}}
            <div class="md:w-2/4 relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari posisi pekerjaan..." class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl pl-11 pr-4 py-3.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
            </div>

            <div class="md:w-auto">
                <button type="submit" class="w-full md:w-auto bg-blue-900 hover:bg-blue-800 text-white font-bold rounded-xl px-8 py-3.5 transition shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                    Cari
                </button>
            </div>
        </form>
    </div>

    <div class="max-w-screen-xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($lowongans as $item)
            
            <a href="{{ route('career.detail', $item->id) }}" class="group bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1 flex flex-col h-full relative cursor-pointer">
                
                <div class="absolute top-0 left-0 w-full h-1.5 bg-blue-900 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>

                <div class="p-6 md:p-8 flex flex-col flex-grow">
                    <div class="flex flex-wrap gap-2 mb-5">
                        <span class="bg-blue-50 text-blue-700 border border-blue-100 text-[11px] font-bold px-3 py-1.5 rounded-md uppercase tracking-wide">
                            {{ $item->category->name ?? 'Umum' }}
                        </span>
                        <span class="bg-purple-50 text-purple-700 border border-purple-100 text-[11px] font-bold px-3 py-1.5 rounded-md uppercase tracking-wide">
                            {{ $item->experience }}
                        </span>
                    </div>

                    <h2 class="text-xl font-extrabold text-slate-900 group-hover:text-blue-900 transition-colors uppercase mb-1 line-clamp-2">
                        {{ $item->title }}
                    </h2>
                    <p class="text-sm font-semibold text-slate-500 mb-6">PT. Sukun Wartono Indonesia</p>

                    <div class="mt-auto space-y-3">
                        <div class="flex items-center gap-3 text-slate-600">
                            <div class="bg-slate-100 p-1.5 rounded-md text-slate-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            </div>
                            <span class="text-sm font-medium">{{ $item->location ?? 'Belum ditentukan' }}</span>
                        </div>
                        
                        <div class="flex items-center gap-3 text-slate-600">
                            <div class="bg-slate-100 p-1.5 rounded-md text-slate-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                            <span class="text-sm font-medium">
                                Batas: 
                                @if($item->deadline)
                                    {{ \Carbon\Carbon::parse($item->deadline)->format('d M Y') }}
                                @elseif($item->end_date)
                                    {{ \Carbon\Carbon::parse($item->end_date)->format('d M Y') }}
                                @else
                                    Tidak ada batas
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-50 border-t border-slate-100 px-6 py-4 flex justify-between items-center group-hover:bg-blue-50 transition-colors">
                    <span class="text-sm font-bold text-blue-900">Lihat Detail Posisi</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-900 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                </div>
            </a>

            @empty
            <div class="col-span-full flex flex-col items-center justify-center py-20 px-4 text-center bg-white rounded-3xl border border-dashed border-slate-300 shadow-sm">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-5 border border-slate-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-2">Pencarian Tidak Ditemukan</h3>
                <p class="text-slate-500 max-w-md">Maaf, kami tidak menemukan lowongan yang sesuai dengan kriteria pencarian Anda. Silakan coba kata kunci atau kategori lain.</p>
                <a href="{{ route('careers.index') }}" class="mt-6 bg-blue-900 text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-800 transition shadow-md">
                    Reset Pencarian
                </a>
            </div>
            @endforelse
        </div>
        
        {{-- Nampilin Pagination kalau datanya banyak --}}
        <div class="mt-10">
            {{ $lowongans->links() }}
        </div>
    </div>
</div>
@endsection