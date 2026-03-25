@extends('layouts.main')

@section('title', 'Detail Lowongan - ' . $lowongan->title)

@section('content')
    <div class="flex flex-col gap-y-10 lg:flex-row justify-center mt-20 bg-white py-10">
      
      <div class="flex justify-center px-4 w-full lg:w-[800px]">
        <div class="w-full bg-white rounded-2xl shadow-md border p-6 md:p-10">
          
          <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6 uppercase">
            {{ $lowongan->title }}
          </h1>

          @if($lowongan->gambar)
            <div class="w-full mb-8 rounded-xl overflow-hidden shadow-sm border border-gray-100 bg-slate-50 flex justify-center">
              <img src="{{ asset('uploads/loker/' . $lowongan->gambar) }}" 
                   alt="Banner {{ $lowongan->title }}" 
                   class="w-full max-h-[500px] object-contain">
            </div>
          @endif

          <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-y-4 pb-6 border-b border-gray-100">
            <div class="flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
              <p class="text-sm md:text-base font-medium text-slate-600">
                {{ \Carbon\Carbon::parse($lowongan->start_date)->format('d M Y') }} - 
                {{ \Carbon\Carbon::parse($lowongan->deadline)->format('d M Y') }}
              </p>
            </div>

            <div class="flex gap-2 flex-wrap">
              <span class="bg-blue-50 text-blue-700 border border-blue-200 text-[11px] font-bold px-3 py-1.5 rounded-full uppercase tracking-wider">
                {{ $lowongan->experience }}
              </span>
              <span class="bg-purple-50 text-purple-700 border border-purple-200 text-[11px] font-bold px-3 py-1.5 rounded-full uppercase tracking-wider">
                {{ $lowongan->category->name ?? 'N/A' }}
              </span>
            </div>
          </div>

          <div class="mb-8">
            <h3 class="text-lg font-bold text-slate-800 mb-3">Deskripsi Pekerjaan:</h3>
            <div class="text-base text-slate-600 whitespace-pre-line leading-relaxed">
              {{ $lowongan->description }}
            </div>
          </div>

          <div class="mb-8">
            <h3 class="text-lg font-bold text-slate-800 mb-3">Persyaratan:</h3>
            <div class="text-base text-slate-600 whitespace-pre-line leading-relaxed">
              {{ $lowongan->requirements }}
            </div>
          </div>

          <div class="bg-slate-50 p-5 rounded-xl border border-slate-100 mt-8">
            <h3 class="text-sm font-semibold text-slate-800 mb-2">Alternatif Pendaftaran:</h3>
            <p class="text-sm text-slate-600 leading-relaxed">
              Kirimkan CV terbaru Anda ke 
              <a href="mailto:karir@sukunsigaret.com" class="text-blue-700 font-bold hover:underline transition">karir@sukunsigaret.com</a><br>
              dengan subjek email: <span class="font-bold text-slate-800">{{ $lowongan->title }} - [Nama Anda]</span>
            </p>
          </div>

        </div>
      </div>

      <div class="flex flex-col gap-y-6 px-4 w-full lg:w-96">
        
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
          <h1 class="text-sm uppercase tracking-wider font-bold text-slate-400 mb-4">Lokasi Penempatan</h1>
          <div class="flex items-start gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-900 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <p class="text-lg text-slate-800 font-bold">{{ $lowongan->location }}</p>
          </div>
        </div>

        <div class="bg-amber-50 rounded-2xl shadow-sm p-6 border border-amber-200">
          <div class="flex items-center gap-3 mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <h2 class="text-base font-bold text-amber-900">Peringatan Rekrutmen</h2>
          </div>
          <p class="text-sm text-amber-800 leading-relaxed">
            Proses rekrutmen PT. Sukun Wartono Indonesia <strong>tidak dipungut biaya apapun</strong>. Harap berhati-hati terhadap penipuan yang mengatasnamakan perusahaan.
          </p>
        </div>

        {{-- AREA TOMBOL AKSI --}}
        <div class="flex flex-col gap-3 mt-2">
            @auth
                @if(Auth::user()->role == 'admin')
                    {{-- 1. TOMBOL UNTUK ADMIN --}}
                    <div class="text-center p-3 border border-dashed border-gray-300 rounded-xl bg-gray-50 mb-2">
                        <p class="text-xs text-gray-500 font-bold uppercase tracking-widest">Mode Admin</p>
                    </div>
                    <a href="{{ route('admin.applications.index') }}" class="w-full block text-center bg-slate-800 text-white font-bold py-4 rounded-xl hover:bg-slate-900 transition shadow-lg uppercase text-sm tracking-wider">
                        Kelola Pelamar Loker Ini
                    </a>

                @elseif($lowongan->status !== 'aktif')
                    {{-- 2. LOKER DITUTUP --}}
                    <button disabled class="w-full text-center bg-red-50 text-red-600 font-bold py-4 px-6 rounded-xl border-2 border-red-200 cursor-not-allowed uppercase tracking-wider text-sm flex items-center justify-center gap-2">
                        <i class="bi bi-x-circle"></i> Lowongan Ditutup
                    </button>

                @elseif(isset($isRejected) && $isRejected)
                    {{-- 3. PELAMAR PERNAH DITOLAK (RE-APPLY) --}}
                    <div class="p-3 bg-amber-100 border border-amber-300 rounded-xl text-xs text-amber-800 font-medium text-center">
                        Lamaran sebelumnya belum lolos. Silakan coba lagi.
                    </div>
                    <a href="{{ route('pelamar.apply', $lowongan->id) }}" class="w-full text-center bg-amber-500 text-white font-bold py-4 px-6 rounded-xl shadow-lg shadow-amber-500/20 hover:bg-amber-600 hover:-translate-y-0.5 transition-all duration-300 uppercase tracking-wider text-sm">
                        Lamar Ulang
                    </a>

                @elseif(isset($hasActiveApplication) && $hasActiveApplication)
                    {{-- 4. PELAMAR SUDAH DAFTAR & MASIH DIPROSES --}}
                    <button disabled class="w-full text-center bg-green-50 text-green-700 border-2 border-green-200 font-bold py-4 px-6 rounded-xl cursor-not-allowed uppercase tracking-wider text-sm flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                        Sedang Diproses
                    </button>

                @else
                    {{-- 5. BOLEH DAFTAR --}}
                    <a href="{{ route('pelamar.apply', $lowongan->id) }}" class="w-full text-center bg-blue-900 text-white font-bold py-4 px-6 rounded-xl shadow-lg shadow-blue-900/20 hover:bg-blue-800 hover:-translate-y-0.5 transition-all duration-300 uppercase tracking-wider text-sm">
                        Lamar Sekarang
                    </a>
                @endif
            @else
                {{-- 6. GUEST (Belum Login) --}}
                <a href="/login" class="w-full text-center bg-blue-900 text-white font-bold py-4 px-6 rounded-xl shadow-lg shadow-blue-900/20 hover:bg-blue-800 hover:-translate-y-0.5 transition-all duration-300 uppercase tracking-wider text-sm">
                    Login Untuk Melamar
                </a>
            @endauth

            <a href="/careers" class="w-full block text-center mt-2 bg-white text-slate-600 font-bold py-4 px-6 rounded-xl border border-slate-200 hover:bg-slate-50 hover:text-slate-900 transition-all duration-300 text-sm">
                Kembali ke Daftar Lowongan
            </a>
        </div>
      </div>
    </div>
@endsection