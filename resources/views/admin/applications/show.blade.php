@extends('layouts.main')

@section('title', 'Detail Pelamar - ' . $application->user->name)

@section('content')
<div class="pt-32 pb-20 px-5 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
        
        {{-- Header Navigation & Info Tanggal --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-blue-900">Detail Lamaran: {{ $application->user->name }}</h1>
                <p class="text-slate-500 mt-1 flex items-center gap-2">
                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest">
                        Posisi: {{ $application->lowongan->title }}
                    </span>
                    <span class="text-xs font-bold text-slate-400">
                        • Masuk pada: {{ $application->created_at->format('d F Y | H:i') }}
                    </span>
                </p>
            </div>
            <a href="{{ route('admin.applications.index') }}" class="bg-white border border-gray-200 text-gray-700 px-6 py-2.5 rounded-xl font-bold text-sm shadow-sm hover:bg-gray-50 transition">
                &larr; Kembali ke Daftar
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            {{-- KOLOM KIRI: Profil & Jejak Digital (Riwayat) --}}
            <div class="col-span-1 flex flex-col gap-6">
                
                {{-- Box Informasi Profil --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-lg font-bold text-slate-800 mb-6 border-b pb-2 text-center">Informasi Profil</h2>
                    
                    @if($application->user->cv)
                        <div class="space-y-6">
                            
                            {{-- NIK (Diumpetin dulu pakai komentar Blade) --}}
                            {{-- 
                            <div>
                                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">NIK / No. KTP</p>
                                <p class="text-slate-800 font-medium">{{ $application->user->cv->identity_number ?? '-' }}</p>
                            </div> 
                            --}}

                            {{-- TTL (Sesuai database: place_of_birth & date_of_birth) --}}
                            <div>
                                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Tempat, Tanggal Lahir</p>
                                <p class="text-slate-800 font-medium">
                                    {{ $application->user->cv->place_of_birth ?? '-' }}, 
                                    {{ $application->user->cv->date_of_birth ? \Carbon\Carbon::parse($application->user->cv->date_of_birth)->format('d F Y') : '-' }}
                                </p>
                            </div>

                            {{-- Alamat Lengkap --}}
                            <div>
                                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Alamat Lengkap</p>
                                <p class="text-slate-800 font-medium">{{ $application->user->cv->address ?? '-' }}</p>
                            </div>

                            {{-- Gender & Agama (Bersebelahan) --}}
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Jenis Kelamin</p>
                                    <p class="text-slate-800 font-medium">{{ $application->user->cv->gender ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Agama</p>
                                    <p class="text-slate-800 font-medium">{{ $application->user->cv->religion ?? '-' }}</p>
                                </div>
                            </div>

                            {{-- WA --}}
                            <div>
                                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">No. WhatsApp</p>
                                <p class="text-slate-800 font-medium">+62 {{ $application->user->cv->phone_number }}</p>
                            </div>
                            
                            {{-- Pendidikan --}}
                            <div>
                                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Pendidikan</p>
                                <p class="text-slate-800 font-medium text-sm">{{ $application->user->cv->university }}</p>
                                <p class="text-[11px] text-slate-500">{{ $application->user->cv->major }} (IPK: {{ $application->user->cv->gpa }})</p>
                            </div>
                            
                            {{-- Pengalaman --}}
                            <div>
                                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Pengalaman Kerja</p>
                                <p class="text-slate-800 font-medium text-sm whitespace-pre-line leading-relaxed italic">
                                    {{ $application->user->cv->experience ?? 'Tidak ada data.' }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t">
                            <a href="{{ asset('uploads/cv/' . $application->user->cv->file_cv) }}" target="_blank" class="w-full block text-center bg-blue-50 text-blue-700 font-bold py-3 rounded-xl border border-blue-100 hover:bg-blue-100 transition">
                                <i class="bi bi-file-earmark-pdf mr-1"></i> Lihat CV Pelamar (PDF)
                            </a>
                        </div>
                    @endif
                </div>

                {{-- BOX JEJAK DIGITAL (Riwayat Lamaran) --}}
                <div class="bg-blue-900 rounded-[2rem] shadow-xl p-8 text-white relative overflow-hidden">
                    {{-- Dekorasi Belakang --}}
                    <div class="absolute -right-4 -top-4 w-20 h-20 bg-white/10 rounded-full blur-2xl"></div>
                    
                    <h2 class="text-sm font-black uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Riwayat Lamaran
                    </h2>
                    
                    @if($history->isEmpty())
                        <div class="py-4 text-center border border-white/20 rounded-2xl bg-white/5">
                            <p class="text-xs text-blue-200 italic font-medium">Ini adalah lamaran pertama<br>user ini di sistem.</p>
                        </div>
                    @else
                        <div class="space-y-6 relative">
                            {{-- Garis Timeline --}}
                            <div class="absolute left-[7px] top-2 bottom-2 w-[2px] bg-blue-700/50"></div>

                            @foreach($history as $old)
                            <div class="relative pl-6">
                                {{-- Titik Timeline --}}
                                <div class="absolute left-0 top-1.5 w-3.5 h-3.5 bg-blue-400 rounded-full border-4 border-blue-900 shadow-sm"></div>
                                
                                <p class="text-xs font-black uppercase text-blue-100 leading-tight">{{ $old->lowongan->title }}</p>
                                <div class="flex items-center justify-between mt-1">
                                    <span class="text-[10px] text-blue-300 font-bold">{{ $old->created_at->format('d M Y') }}</span>
                                    <span class="text-[9px] px-2 py-0.5 rounded bg-white/10 text-white font-black uppercase tracking-tighter">
                                        {{ $old->status }}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <p class="mt-8 text-[10px] text-blue-300 font-bold text-center border-t border-white/10 pt-4 uppercase tracking-widest">
                            Total: {{ $history->count() + 1 }} Lamaran
                        </p>
                    @endif
                </div>
            </div>

            {{-- KOLOM KANAN: Update Status & Jawaban Form --}}
            <div class="lg:col-span-2 flex flex-col gap-6">
                
                {{-- UPDATE TAHAPAN --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 w-full border-l-4 border-l-amber-400">
                    <h2 class="text-lg font-black text-slate-800 mb-4 border-b pb-2">Proses Tahapan Seleksi</h2>
                    
                    <form action="{{ route('admin.applications.update', $application->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <div class="flex flex-col md:flex-row items-end gap-4">
                            <div class="flex-1 w-full">
                                <label class="block text-sm font-bold text-slate-700 mb-2">Pindahkan Pelamar ke Tahap:</label>
                                <select name="status" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none bg-gray-50 font-bold text-slate-700 cursor-pointer">
                                    <option value="screening" {{ $application->status == 'screening' ? 'selected' : '' }}>1. Screening</option>
                                    <option value="psikotes" {{ $application->status == 'psikotes' ? 'selected' : '' }}>2. Psikotes</option>
                                    <option value="lgd" {{ $application->status == 'lgd' ? 'selected' : '' }}>3. LGD (Distri)</option>
                                    <option value="test_excel" {{ $application->status == 'test_excel' ? 'selected' : '' }}>4. Test Excel (Distri)</option>
                                    <option value="wawancara_hrd" {{ $application->status == 'wawancara_hrd' ? 'selected' : '' }}>5. Wawancara HRD</option>
                                    <option value="wawancara_user" {{ $application->status == 'wawancara_user' ? 'selected' : '' }}>6. Wawancara End User</option>
                                    <option value="mcu_offering" {{ $application->status == 'mcu_offering' ? 'selected' : '' }}>7. MCU & Offering</option>
                                    <option value="hired" {{ $application->status == 'hired' ? 'selected' : '' }}>8. Terima (Hired)</option>
                                    <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>9. Tolak Lamaran</option>
                                </select>
                            </div>
                            <button type="submit" class="w-full md:w-auto bg-amber-400 text-amber-900 font-bold px-8 py-3 rounded-xl hover:bg-amber-500 transition shadow-sm">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Formulir Jawaban Pendaftaran --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 w-full">
                    <h2 class="text-lg font-bold text-slate-800 mb-6 border-b pb-2">Jawaban Formulir Pendaftaran</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100">
                            <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-2">Ekspektasi Gaji</p>
                            @if($application->expected_salary == 0 || is_null($application->expected_salary))
                                <span class="bg-gray-200 text-gray-700 px-3 py-1 rounded-md text-xs font-black uppercase tracking-widest">Negosiasi</span>
                            @else
                                <p class="text-2xl text-slate-800 font-black">Rp{{ number_format($application->expected_salary, 0, ',', '.') }}</p>
                            @endif
                        </div>

                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100">
                            <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-2">Kesiapan Relokasi</p>
                            @if($application->relocation_ready)
                                <span class="inline-block bg-green-100 text-green-700 px-4 py-2 rounded-md text-xs font-black uppercase tracking-widest">Bersedia</span>
                            @else
                                <span class="inline-block bg-red-100 text-red-700 px-4 py-2 rounded-md text-xs font-black uppercase tracking-widest">Tidak Bersedia</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-8">
                        <p class="text-xs text-gray-400 font-black uppercase tracking-widest mb-3 italic">"Mengapa Anda melamar posisi ini?"</p>
                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 text-slate-700 leading-relaxed text-lg italic">
                            "{{ $application->application_reason ?? 'Tidak ada jawaban.' }}"
                        </div>
                    </div>

                    <div>
                        <p class="text-xs text-gray-400 font-black uppercase tracking-widest mb-3 italic">"Sebutkan komitmen Anda jika bergabung bersama kami!"</p>
                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 text-slate-700 leading-relaxed text-lg italic">
                            "{{ $application->commitment ?? 'Tidak ada jawaban.' }}"
                        </div>
                    </div>
                </div>

            </div> 
        </div> 
    </div>
</div>
@endsection