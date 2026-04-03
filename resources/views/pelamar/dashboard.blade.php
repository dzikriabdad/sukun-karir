@extends('layouts.main')

@section('title', 'Dashboard Pelamar - ' . Auth::user()->name)

@section('content')
<div class="pt-32 pb-20 px-5 bg-gray-50 min-h-screen">
    <div class="max-w-screen-xl mx-auto">
        
        {{-- Pesan Sukses --}}
        @if(session('success'))
        <div class="mb-8 p-5 bg-green-50 border border-green-200 text-green-700 rounded-2xl flex items-center shadow-sm">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-bold">{{ session('success') }}</span>
        </div>
        @endif

        {{-- 3 Kotak Statistik --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Total Lamaran</p>
                <h3 class="text-3xl font-black text-blue-900">{{ $applications->count() }}</h3>
            </div>
            <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Sedang Diproses</p>
                <h3 class="text-3xl font-black text-amber-500">
                    {{ $applications->whereNotIn('status', ['hired', 'rejected'])->count() }}
                </h3>
            </div>
            <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Diterima (Hired)</p>
                <h3 class="text-3xl font-black text-green-600">
                    {{ $applications->where('status', 'hired')->count() }}
                </h3>
            </div>
        </div>

        {{-- Layout 2 Kolom --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- KOLOM KIRI (Besar): Riwayat Lamaran --}}
            <div class="lg:col-span-2 bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden self-start">
                <div class="p-8 border-b border-gray-50">
                    <h2 class="text-2xl font-black text-blue-900">Riwayat Lamaran Saya</h2>
                    <p class="text-slate-500 text-sm mt-1">Pantau progres seleksi kamu di sini.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left table-auto">
                        <thead>
                            <tr class="bg-slate-50 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
                                <th class="px-6 py-5 whitespace-nowrap">Posisi Pekerjaan</th>
                                <th class="px-6 py-5 text-center whitespace-nowrap">Tahapan Seleksi</th>
                                <th class="px-6 py-5 text-center w-32 whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($applications as $app)
                            <tr class="hover:bg-blue-50/30 transition">
                                <td class="px-6 py-6">
                                    <div class="font-bold text-gray-900 text-lg leading-tight">{{ $app->lowongan->title }}</div>
                                    <div class="text-[11px] text-slate-400 mt-1 font-medium">{{ $app->created_at->format('d M Y') }}</div>
                                </td>
                                <td class="px-6 py-6 text-center">
                                    @php
                                        $statusConfig = [
                                            'screening'      => ['label' => 'Screening', 'color' => 'bg-slate-100 text-slate-500'],
                                            'psikotes'       => ['label' => 'Psikotes', 'color' => 'bg-indigo-100 text-indigo-700'],
                                            'lgd'            => ['label' => 'LGD (Distribusi)', 'color' => 'bg-cyan-100 text-cyan-700'],
                                            'test_excel'     => ['label' => 'Test Excel (Distribusi)', 'color' => 'bg-teal-100 text-teal-700'],
                                            'wawancara_hrd'  => ['label' => 'Wawancara HRD', 'color' => 'bg-amber-100 text-amber-700'],
                                            'wawancara_user' => ['label' => 'Wawancara User', 'color' => 'bg-orange-100 text-orange-700'],
                                            'mcu_offering'   => ['label' => 'MCU & Offering', 'color' => 'bg-purple-100 text-purple-700'],
                                            'hired'          => ['label' => 'Diterima (Hired)', 'color' => 'bg-green-100 text-green-700'],
                                            'rejected'       => ['label' => 'Ditolak', 'color' => 'bg-red-100 text-red-700']
                                        ];
                                        $current = $statusConfig[$app->status] ?? ['label' => $app->status, 'color' => 'bg-gray-100'];
                                    @endphp
                                    <span class="whitespace-nowrap inline-flex items-center justify-center px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest {{ $current['color'] }}">
                                        {{ $current['label'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-6 text-center">
                                    {{-- INI YANG GUA BENERIN JADI PAKAI SLUG --}}
                                    <a href="{{ route('career.detail', $app->lowongan->slug) }}" class="text-xs font-black text-blue-900 hover:text-blue-700 underline underline-offset-4 uppercase tracking-tighter whitespace-nowrap">
                                        Detail Loker
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($applications->isEmpty())
                    <div class="p-16 text-center">
                        <p class="text-slate-400 font-medium italic">Belum ada lamaran.</p>
                        <a href="/careers" class="inline-block mt-4 text-blue-900 font-black uppercase text-xs tracking-widest">Cari Lowongan</a>
                    </div>
                @endif
            </div>

            {{-- KOLOM KANAN (Kecil): Profil CV --}}
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden self-start">
                <div class="p-8 border-b border-gray-50 bg-blue-900 text-white">
                    <h2 class="text-xl font-black">Informasi Profil</h2>
                </div>
                
                <div class="p-8">
                    @if(Auth::user()->cv)
                        <div class="space-y-4 mb-8">
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama Lengkap</p>
                                <p class="font-bold text-gray-800">{{ Auth::user()->name }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Universitas</p>
                                <p class="font-bold text-gray-800">{{ Auth::user()->cv->university }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">No. WhatsApp</p>
                                <p class="font-bold text-gray-800">+62 {{ Auth::user()->cv->phone_number }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pengalaman</p>
                                <p class="text-sm text-gray-600 whitespace-pre-line leading-relaxed italic">
                                    {{ Auth::user()->cv->experience }}
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3">
                            <a href="{{ asset('uploads/cv/' . Auth::user()->cv->file_cv) }}" target="_blank" class="w-full bg-blue-50 text-blue-900 font-bold py-3 rounded-xl text-center text-sm hover:bg-blue-100 transition shadow-sm">
                                <i class="bi bi-file-earmark-pdf mr-1"></i> Lihat File CV
                            </a>
                            
                            <a href="{{ route('pelamar.edit_cv') }}" class="w-full bg-amber-400 text-amber-900 font-bold py-3 rounded-xl text-center text-sm hover:bg-amber-500 transition shadow-sm">
                                <i class="bi bi-pencil-square mr-1"></i> Edit Profil & CV
                            </a>
                        </div>
                    @else
                        <div class="text-center py-6">
                            <div class="w-16 h-16 bg-red-100 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <h3 class="font-bold text-gray-800 mb-2">Profil Belum Lengkap</h3>
                            <p class="text-sm text-gray-500 mb-6">Lengkapi data diri dan unggah CV kamu untuk mulai melamar pekerjaan.</p>
                            <a href="{{ route('pelamar.create_cv') }}" class="inline-block px-6 py-3 bg-blue-900 text-white font-bold rounded-xl hover:bg-blue-800 transition">
                                Buat Profil Sekarang
                            </a>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection