@extends('layouts.main')

@section('title', 'Detail Lowongan - ' . $lowongan->title)

@section('content')
<div class="pt-32 pb-20 px-5 bg-gray-50 min-h-screen">
    <div class="max-w-screen-md mx-auto">
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-10 bg-blue-900 text-white">
                <span class="bg-blue-800 text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-lg">
                    {{ $lowongan->category->name ?? 'Umum' }}
                </span>
                <h1 class="text-3xl font-black mt-4">{{ $lowongan->title }}</h1>
                <div class="flex gap-4 mt-4 text-sm text-blue-100 font-medium">
                    <span class="flex items-center gap-1">📍 {{ $lowongan->location }}</span>
                    <span class="flex items-center gap-1">💼 {{ $lowongan->experience }}</span>
                </div>
            </div>

            <div class="p-10 space-y-10">
                <div>
                    <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-4">Deskripsi Pekerjaan</h3>
                    <div class="text-slate-700 leading-relaxed whitespace-pre-line">
                        {{ $lowongan->description }}
                    </div>
                </div>

                <div>
                    <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-4">Persyaratan</h3>
                    <div class="text-slate-700 leading-relaxed whitespace-pre-line">
                        {{ $lowongan->requirements }}
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100 flex items-center justify-between text-xs text-slate-400 font-bold uppercase tracking-widest">
                    <span>Deadline: {{ \Carbon\Carbon::parse($lowongan->deadline)->format('d M Y') }}</span>
                    <a href="{{ route('pelamar.dashboard') }}" class="text-blue-900 hover:underline">Kembali ke Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection