@extends('layouts.main')

@section('title', 'Admin - Manajemen Seleksi Pelamar')

@section('content')
<div class="pt-32 pb-20 px-5 bg-gray-50 min-h-screen">
    <div class="max-w-screen-xl mx-auto">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-blue-900">Manajemen Seleksi Pelamar</h1>
                <p class="text-slate-600 mt-2">Kelola tahapan rekrutmen mulai dari Review hingga Kontrak Kerja.</p>
            </div>
            <div class="bg-blue-100 text-blue-800 px-5 py-3 rounded-2xl font-bold text-sm border border-blue-200 shadow-sm">
                Total: {{ $applications->count() }} Lamaran
            </div>
        </div>

        {{-- Pesan Sukses --}}
        @if(session('success'))
        <div class="mb-8 p-5 bg-green-50 border border-green-200 text-green-700 rounded-2xl flex items-center shadow-sm">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-bold">{{ session('success') }}</span>
        </div>
        @endif

        {{-- KOTAK FILTER & PENCARIAN --}}
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 mb-8">
            <form action="{{ route('admin.applications.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-5 items-end">
                
                {{-- Fitur Baru: Kolom Cari Nama --}}
                <div>
                    <label class="block mb-2 text-xs font-black text-slate-400 uppercase tracking-widest">Cari Nama Pelamar</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik nama pelamar..." class="bg-gray-50 border border-gray-200 text-sm rounded-xl block w-full p-3 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>

                {{-- Filter Posisi Lowongan --}}
                <div>
                    <label class="block mb-2 text-xs font-black text-slate-400 uppercase tracking-widest">Filter Posisi</label>
                    <select name="lowongan_id" class="bg-gray-50 border border-gray-200 text-sm rounded-xl block w-full p-3 focus:ring-blue-500 focus:border-blue-500 outline-none">
                        <option value="">Semua Lowongan</option>
                        @foreach($lowongans as $loker)
                            <option value="{{ $loker->id }}" {{ request('lowongan_id') == $loker->id ? 'selected' : '' }}>{{ $loker->title }}</option>
                        @endforeach
                    </select>
                </div>
                
                {{-- Tombol Aksi --}}
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 bg-blue-900 text-white font-bold py-3 rounded-xl hover:bg-blue-800 transition shadow-lg shadow-blue-900/20 text-sm">
                        Cari & Filter
                    </button>
                    <a href="{{ route('admin.applications.index') }}" class="bg-gray-100 text-gray-500 font-bold py-3 px-6 rounded-xl hover:bg-gray-200 transition text-sm flex items-center">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- TABEL DATA PELAMAR --}}
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-50 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-blue-900 text-white text-[11px] font-black uppercase tracking-[0.15em]">
                            <th class="px-8 py-6">Data Pelamar</th>
                            <th class="px-8 py-6">Posisi & Tgl. Lamar</th>
                            <th class="px-8 py-6">Ekspektasi Gaji</th>
                            <th class="px-8 py-6 text-center">Status Tahapan</th>
                            <th class="px-8 py-6 text-center">Update Tahap</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($applications as $app)
                        <tr class="hover:bg-blue-50/40 transition">
                            {{-- 1. Data Pelamar --}}
                            <td class="px-8 py-6">
                                <a href="{{ route('admin.applications.show', $app->id) }}" class="font-bold text-blue-900 hover:text-blue-700 hover:underline transition block">
                                    {{ $app->user->name }}
                                </a>
                                <div class="text-[11px] text-slate-400 font-medium mb-3">{{ $app->user->email }}</div>
                                <div class="flex gap-2">
                                    <button onclick="openModal('modal-{{ $app->id }}')" class="text-[10px] bg-slate-100 hover:bg-slate-200 text-slate-600 font-black py-1.5 px-3 rounded-lg flex items-center gap-1 transition uppercase tracking-widest">
                                        alasan melamar
                                    </button>
                                    @if($app->user?->cv?->file_cv) 
                                        <a href="{{ asset('uploads/cv/' . $app->user->cv->file_cv) }}" target="_blank" class="text-[10px] bg-blue-50 hover:bg-blue-100 text-blue-700 font-black py-1.5 px-3 rounded-lg flex items-center gap-1 transition uppercase tracking-widest">
                                            BUKA CV
                                        </a>
                                    @else
                                        <button disabled class="text-[10px] bg-gray-50 text-gray-400 font-black py-1.5 px-3 rounded-lg flex items-center gap-1 uppercase tracking-widest cursor-not-allowed" title="Pelamar belum upload CV">
                                            NO CV
                                        </button>
                                    @endif
                                </div>
                            </td>

                            {{-- 2. Posisi & Tanggal Lamar --}}
                            <td class="px-8 py-6">
                                <span class="text-sm font-bold text-blue-900 block">{{ $app->lowongan->title }}</span>
                                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">
                                    Diterima: {{ $app->created_at->format('d M Y | H:i') }}
                                </span>
                            </td>

                            {{-- 3. Ekspektasi Gaji --}}
                            <td class="px-8 py-6">
                                @if($app->expected_salary == 0 || is_null($app->expected_salary))
                                    <div class="text-[11px] font-black text-gray-500 uppercase tracking-widest bg-gray-100 inline-block px-2 py-1 rounded">Negosiasi</div>
                                @else
                                    <div class="text-sm font-black text-gray-800">Rp{{ number_format($app->expected_salary, 0, ',', '.') }}</div>
                                @endif

                                <div class="mt-1">
                                    @if($app->relocation_ready)
                                        <span class="text-[9px] bg-green-100 text-green-700 font-black px-2 py-0.5 rounded uppercase tracking-tighter">Siap Relokasi</span>
                                    @else
                                        <span class="text-[9px] bg-red-100 text-red-600 font-black px-2 py-0.5 rounded uppercase tracking-tighter">Tidak Relokasi</span>
                                    @endif
                                </div>
                            </td>

                            {{-- 4. Status Tahapan (Badge) --}}
                            <td class="px-8 py-6 text-center">
                                @php
                                    $statusClasses = [
                                        'screening'      => 'bg-slate-100 text-slate-500',
                                        'psikotes'       => 'bg-indigo-100 text-indigo-700',
                                        'lgd'            => 'bg-cyan-100 text-cyan-700',
                                        'test_excel'     => 'bg-teal-100 text-teal-700',
                                        'wawancara_hrd'  => 'bg-amber-100 text-amber-700',
                                        'wawancara_user' => 'bg-orange-100 text-orange-700',
                                        'mcu_offering'   => 'bg-purple-100 text-purple-700',
                                        'hired'          => 'bg-green-100 text-green-700 font-bold',
                                        'rejected'       => 'bg-red-100 text-red-700'
                                    ];
                                    $statusLabel = [
                                        'screening'      => 'Screening',
                                        'psikotes'       => 'Psikotes',
                                        'lgd'            => 'LGD',
                                        'test_excel'     => 'Test Excel',
                                        'wawancara_hrd'  => 'Wawancara HRD',
                                        'wawancara_user' => 'Wawancara User',
                                        'mcu_offering'   => 'MCU & Offering',
                                        'hired'          => 'Hired',
                                        'rejected'       => 'Rejected'
                                    ];
                                @endphp
                                <span class="px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-[0.1em] {{ $statusClasses[$app->status] ?? 'bg-gray-100' }}">
                                    {{ $statusLabel[$app->status] ?? $app->status }}
                                </span>
                            </td>

                            {{-- 5. Update Tahap (Dropdown) --}}
                            <td class="px-8 py-6">
                                <form action="{{ route('admin.applications.update', $app->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" class="w-full text-[11px] font-bold bg-gray-50 border border-gray-100 rounded-xl p-3 focus:ring-blue-500 cursor-pointer outline-none">
                                        <option value="screening" {{ $app->status == 'screening' ? 'selected' : '' }}>1. Screening</option>
                                        <option value="psikotes" {{ $app->status == 'psikotes' ? 'selected' : '' }}>2. Psikotes</option>
                                        <option value="lgd" {{ $app->status == 'lgd' ? 'selected' : '' }}>3. LGD (Distri)</option>
                                        <option value="test_excel" {{ $app->status == 'test_excel' ? 'selected' : '' }}>4. Test Excel (Distri)</option>
                                        <option value="wawancara_hrd" {{ $app->status == 'wawancara_hrd' ? 'selected' : '' }}>5. Wawancara HRD</option>
                                        <option value="wawancara_user" {{ $app->status == 'wawancara_user' ? 'selected' : '' }}>6. Wawancara End User</option>
                                        <option value="mcu_offering" {{ $app->status == 'mcu_offering' ? 'selected' : '' }}>7. MCU & Offering</option>
                                        <option value="hired" {{ $app->status == 'hired' ? 'selected' : '' }}>8. Terima (Hired)</option>
                                        <option value="rejected" {{ $app->status == 'rejected' ? 'selected' : '' }}>9. Tolak Lamaran</option>
                                    </select>
                                </form>
                            </td>
                        </tr>

                        {{-- MODAL ALASAN --}}
                        <div id="modal-{{ $app->id }}" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
                            <div class="bg-white rounded-[2rem] max-w-lg w-full p-10 shadow-2xl border border-gray-100">
                                <div class="flex justify-between items-center mb-8">
                                    <h3 class="text-xl font-black text-blue-900 uppercase tracking-tight">Motivasi Pelamar</h3>
                                    <button onclick="closeModal('modal-{{ $app->id }}')" class="text-slate-300 hover:text-red-500 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                    </button>
                                </div>
                                <div class="space-y-8">
                                    <div>
                                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Alasan Melamar:</label>
                                        <div class="text-sm text-slate-700 leading-relaxed bg-slate-50 p-5 rounded-2xl border border-slate-100 italic">
                                            "{{ $app->application_reason }}"
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Komitmen Kerja:</label>
                                        <div class="text-sm text-slate-700 leading-relaxed bg-slate-50 p-5 rounded-2xl border border-slate-100 italic">
                                            "{{ $app->commitment }}"
                                        </div>
                                    </div>
                                </div>
                                <button onclick="closeModal('modal-{{ $app->id }}')" class="w-full mt-10 bg-blue-900 text-white font-black py-4 rounded-2xl hover:bg-blue-800 transition uppercase text-xs tracking-widest shadow-lg shadow-blue-900/20">
                                    Kembali ke Daftar
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($applications->isEmpty())
                <div class="py-24 text-center">
                    <div class="text-slate-300 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <p class="text-slate-400 font-bold">Tidak ada data pelamar yang sesuai dengan pencarian atau filter kamu.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
        document.getElementById(id).classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
    function closeModal(id) {
        document.getElementById(id).classList.remove('flex');
        document.getElementById(id).classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
</script>
@endsection