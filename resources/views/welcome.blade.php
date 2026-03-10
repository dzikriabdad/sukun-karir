@extends('layouts.main')

@section('title', 'Sukun Karir - Beranda')

@section('content')
    <section class="mx-5 mx-auto mt-20 bg-cover bg-center bg-blue-900 h-[380px] lg:h-[550px]">
      <div class="max-w-screen-lg mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 md:grid-cols-2 justify-between items-center pt-[40px] mx-5">
          <div class="flex flex-col gap-5 justify-center items-center lg:items-start text-center lg:text-left">
            <h4 class="text-4xl lg:text-5xl md:text-5xl font-bold text-neutral-100 leading-tight">
              Melangkah Bersama, Berkarya untuk Masa Depan
            </h4>
            <p class="text-neutral-200">
              Temukan semangat berkarya dan berinovasi bersama PT. Sukun Wartono
              Indonesia. Di sini, jadi bagian dari perjalanan hidup yang
              bermakna.
            </p>
          </div>
          <div class="flex justify-center items-center">
             <div class="lg:w-[350px] lg:h-[400px] bg-neutral-500/20 rounded-2xl hidden lg:block md:block md:h-[200px] md:w-[175px]"></div>
          </div>
        </div>
      </div>
    </section>

    <section class="mx-5 max-w-screen-lg mx-auto -mt-10 relative z-2">
      <div class="mx-5 bg-neutral-100 rounded-xl px-5 py-5 shadow-lg">
        <form action="{{ route('careers.index') }}" method="GET" class="flex flex-col md:flex-row items-center gap-4">
          
          <select name="kategori" class="w-full md:w-auto rounded-lg border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
            <option value="" disabled selected>Pilih Kategori</option>
            <option value="Fresh Graduate">Fresh Graduate</option>
            <option value="Experienced">Experienced</option>
          </select>

          <select name="bagian" class="w-full md:w-auto rounded-lg border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
            <option value="" disabled selected>Pilih Bagian</option>
            <option value="Marketing">Marketing</option>
            <option value="Produksi">Produksi</option>
            <option value="IT">IT</option>
            <option value="HRD">HRD</option>
            <option value="Keuangan">Keuangan</option>
          </select>

          <input type="text" name="search" placeholder="Cari Lowongan Kerja" class="w-full md:flex-1 rounded-lg border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />

          <button type="submit" class="w-full md:w-auto rounded-xl bg-blue-900 px-8 py-3 text-center text-white font-medium hover:bg-blue-800 transition">
            Search
          </button>
        </form>
      </div>

      <div class="flex flex-row justify-center items-center mt-10 mx-5">
        <h1 class="text-2xl font-semibold text-neutral-800">
          Lowongan Terbaru
        </h1>
      </div>

      <div class="mt-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 md:grid-cols-2 gap-6 max-w-[1000px] mx-auto px-5">
          @forelse($lowongans as $item)
          <a href="{{ route('career.detail', $item->id) }}" class="block rounded-lg p-5 shadow-md bg-white hover:bg-neutral-50 hover:-translate-y-1 transition-all duration-300 border border-transparent hover:border-blue-100 flex flex-col h-full cursor-pointer">
            <h2 class="text-lg font-bold text-slate-900 hover:text-blue-900 uppercase">
              {{ $item->title }}
            </h2>
            
            <div class="mt-2 mb-4 flex gap-1 flex-wrap">
               <span class="inline-block rounded-full bg-blue-100 px-3 py-1 text-[11px] font-bold text-blue-800 uppercase tracking-wider">
                {{ $item->category->name ?? 'Semua Kategori' }}
              </span>
              <span class="inline-block rounded-full bg-purple-100 px-3 py-1 text-[11px] font-bold text-purple-800 uppercase tracking-wider">
                {{ $item->experience }}
              </span>
            </div>
            
            <div class="mt-auto border-t border-gray-100 pt-4">
                <div class="flex items-center gap-2 text-slate-600 mb-2">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                 <p class="text-sm">{{ $item->location ?? 'Belum ditentukan' }}</p>
                </div>
                
                <div class="flex items-center gap-2 text-slate-600">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                  <p class="text-sm font-medium">
                     Batas: 
                     @if($item->deadline)
                        {{ \Carbon\Carbon::parse($item->deadline)->format('d M Y') }}
                     @elseif($item->end_date)
                        {{ \Carbon\Carbon::parse($item->end_date)->format('d M Y') }}
                     @else
                        Tidak ada batas
                     @endif
                  </p>
                </div>
            </div>
          </a>
          @empty
          <div class="col-span-full text-center py-10 bg-white rounded-xl shadow-sm border border-dashed border-gray-200">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <p class="text-slate-500 font-medium">Belum ada lowongan terbaru saat ini.</p>
          </div>
          @endforelse
        </div>
      </div>

      <div class="mt-10 flex items-center justify-center">
        <a href="/careers" class="text-sm font-bold text-blue-900 border-2 border-blue-900 rounded-lg px-6 py-2.5 flex items-center hover:bg-blue-50 transition">
          <span>Lihat Semua Lowongan</span>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </a>
      </div>
    </section>

    <section class="mt-20 py-10 bg-cover bg-center" style="background-image: url('{{ asset('images/banerskn3.png') }}');">
      <div class="max-w-screen-lg mx-auto bg-white/95 p-8 rounded-[2.5rem] shadow-sm backdrop-blur-sm mx-5">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
          <div class="flex justify-center h-full">
            <img src="{{ asset('images/banerskn.png') }}" alt="Kantor Pusat Sukun" 
                 class="w-full h-64 lg:h-80 object-cover object-right rounded-[2.5rem] shadow-md border border-gray-100" />
          </div>
          <div class="text-justify">
            <h1 class="text-3xl font-bold text-blue-900 mb-6">Tentang Kami</h1>
            <p class="text-sm text-slate-700 leading-relaxed">
              PT. Sukun Wartono Indonesia didirikan dengan sebuah filosofi yang mempercayai bahwa sumber daya manusia adalah faktor terpenting dalam mengembangkan kemajuan perusahaan...
            </p>
            <p class="text-sm mt-4 text-slate-700 leading-relaxed">
              Pengembangan diri tetap menjadi fokus utama kami seiring dengan perkembangan zaman yang ada...
            </p>
          </div>
        </div>
      </div>
    </section>

    <section class="my-20">
      <div class="max-w-screen-lg mx-auto px-5">
        <div class="bg-blue-900 bg-cover bg-center overflow-hidden rounded-2xl p-10 relative shadow-xl" style="background-image: url('https://static.vecteezy.com/system/resources/previews/014/031/972/non_2x/abstract-modern-wave-graphic-background-blue-background-abstract-wave-background-design-dark-poster-blue-background-illustration-vector.jpg');">
          <div class="absolute inset-0 bg-blue-900/40"></div>
          
          <div class="flex flex-col lg:flex-row justify-between items-center gap-5 relative z-10">
            <h4 class="text-2xl lg:text-3xl font-bold text-white lg:basis-2/3 text-center lg:text-left drop-shadow-md">
              Ayo Bergabung dan Bangun Masa Depanmu Bersama Kami!
            </h4>
            <a href="/careers" class="bg-white text-blue-900 rounded-xl px-8 py-4 font-bold hover:bg-neutral-100 transition whitespace-nowrap shadow-lg hover:-translate-y-1">
              Temukan Karirmu
            </a>
          </div>
        </div>
      </div>
    </section>
@endsection