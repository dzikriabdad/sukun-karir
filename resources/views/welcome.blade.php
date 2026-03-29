@extends('layouts.main')

@section('title', 'Sukun Karir - Beranda')

@section('content')
    {{-- HERO SECTION FULL WIDTH (Bebas Gap Putih, Mentok Kiri Kanan) --}}
    <section class="w-full pt-32 pb-20 bg-cover bg-center bg-blue-900 min-h-[450px] lg:min-h-[600px] flex items-center mt-0 relative z-0">
      <div class="max-w-screen-xl mx-auto w-full px-5 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 justify-between items-center w-full gap-10">
          <div class="flex flex-col gap-6 justify-center items-center lg:items-start text-center lg:text-left relative z-20">
            <h4 class="text-4xl lg:text-5xl md:text-5xl font-extrabold text-white leading-tight drop-shadow-md">
              Melangkah Bersama, Berkarya untuk Masa Depan
            </h4>
            <p class="text-blue-100 text-lg md:text-xl font-medium max-w-xl leading-relaxed">
              Temukan semangat berkarya dan berinovasi bersama PT. Sukun Wartono
              Indonesia. Di sini, jadi bagian dari perjalanan hidup yang
              bermakna.
            </p>
          </div>
          
          {{-- SLIDER FOTO DINAMIS (.jpeg) --}}
          <div class="flex justify-center lg:justify-end items-center mt-10 lg:mt-0 relative z-10">
             <div class="swiper heroSwiper w-full max-w-[380px] h-[300px] lg:h-[450px] rounded-[2rem] hidden md:block border border-white/20 shadow-2xl overflow-hidden group bg-white/5">
                <div class="swiper-wrapper">
                    <div class="swiper-slide flex items-center justify-center p-4">
                        <img src="{{ asset('images/fotho1.jpeg') }}" alt="Foto Sukun 1" class="w-full h-full object-cover rounded-[1.5rem]" />
                    </div>
                    <div class="swiper-slide flex items-center justify-center p-4">
                        <img src="{{ asset('images/fotho2.jpeg') }}" alt="Foto Sukun 2" class="w-full h-full object-cover rounded-[1.5rem]" />
                    </div>
                    <div class="swiper-slide flex items-center justify-center p-4">
                        <img src="{{ asset('images/fotho3.jpeg') }}" alt="Foto Sukun 3" class="w-full h-full object-cover rounded-[1.5rem]" />
                    </div>
                    <div class="swiper-slide flex items-center justify-center p-4">
                        <img src="{{ asset('images/fotho4.jpeg') }}" alt="Foto Sukun 4" class="w-full h-full object-cover rounded-[1.5rem]" />
                    </div>
                    <div class="swiper-slide flex items-center justify-center p-4">
                        <img src="{{ asset('images/fotho5.jpeg') }}" alt="Foto Sukun 5" class="w-full h-full object-cover rounded-[1.5rem]" />
                    </div>
                    <div class="swiper-slide flex items-center justify-center p-4">
                        <img src="{{ asset('images/fotho6.jpeg') }}" alt="Foto Sukun 6" class="w-full h-full object-cover rounded-[1.5rem]" />
                    </div>
                    <div class="swiper-slide flex items-center justify-center p-4">
                        <img src="{{ asset('images/fotho7.jpeg') }}" alt="Foto Sukun 7" class="w-full h-full object-cover rounded-[1.5rem]" />
                    </div>
                    <div class="swiper-slide flex items-center justify-center p-4">
                        <img src="{{ asset('images/fotho8.jpeg') }}" alt="Foto Sukun 8" class="w-full h-full object-cover rounded-[1.5rem]" />
                    </div>
                </div>
                
                {{-- Navigasi Panah --}}
                <div class="swiper-button-next text-white opacity-0 group-hover:opacity-100 transition-opacity !w-8 !h-8 after:text-xs bg-black/30 rounded-full"></div>
                <div class="swiper-button-prev text-white opacity-0 group-hover:opacity-100 transition-opacity !w-8 !h-8 after:text-xs bg-black/30 rounded-full"></div>
                
                {{-- Pagination Titik --}}
                <div class="swiper-pagination !bottom-4"></div>
             </div>
          </div>
        </div>
      </div>
    </section>

    {{-- KOTAK PENCARIAN REVISI LABEL --}}
    <section class="max-w-screen-xl mx-auto px-5 -mt-12 relative z-10">
      <div class="bg-white rounded-2xl px-6 py-6 shadow-xl border border-gray-100 relative z-30">
        <form action="{{ route('careers.index') }}" method="GET" class="flex flex-col md:flex-row items-center gap-4">
          
          {{-- Dropdown Level (Fresh Graduate, Experienced, dll) --}}
          <div class="w-full md:w-auto flex-1">
            <label class="text-[10px] font-bold text-slate-400 uppercase ml-1 mb-1 block">Level Pengalaman</label>
            <select name="kategori" class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 font-medium text-slate-700 cursor-pointer">
              <option value="" selected>Semua Level</option>
              @foreach($experiences as $exp)
                  <option value="{{ $exp->name }}">{{ $exp->name }}</option>
              @endforeach
            </select>
          </div>

          {{-- Dropdown Bidang Pekerjaan (IT, Produksi, dll) --}}
          <div class="w-full md:w-auto flex-1">
            <label class="text-[10px] font-bold text-slate-400 uppercase ml-1 mb-1 block">Bidang Pekerjaan</label>
            <select name="bagian" class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 font-medium text-slate-700 cursor-pointer">
              <option value="" selected>Semua Bidang</option>
              @foreach($categories as $cat)
                  <option value="{{ $cat->id }}">{{ $cat->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="w-full md:w-auto flex-[2] lg:mt-5">
            <input type="text" name="search" placeholder="Cari posisi kerja (contoh: Staff IT)..." class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50" />
          </div>

          <button type="submit" class="w-full md:w-auto lg:mt-5 rounded-xl bg-blue-900 px-8 py-3 text-center text-white font-bold hover:bg-blue-800 transition shadow-md hover:shadow-lg">
            Search
          </button>
        </form>
      </div>
    </section>

    {{-- LOWONGAN TERBARU --}}
    <section class="max-w-screen-xl mx-auto px-5 mt-16 mb-8 relative z-0">
      <div class="flex flex-row justify-center lg:justify-start items-center">
        <h1 class="text-3xl font-extrabold text-blue-900">
          Lowongan Terbaru
        </h1>
      </div>
    </section>

    <section class="mb-10 relative z-0">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-screen-xl mx-auto px-5">
        @forelse($lowongans as $item)
        <a href="{{ route('career.detail', $item->id) }}" class="block rounded-[1.5rem] p-6 shadow-sm bg-white hover:bg-blue-50/50 hover:-translate-y-1 transition-all duration-300 border border-gray-100 hover:border-blue-200 flex flex-col h-full cursor-pointer hover:shadow-md">
          <h2 class="text-xl font-black text-slate-800 hover:text-blue-900 uppercase tracking-tight">
            {{ $item->title }}
          </h2>
          
          <div class="mt-3 mb-5 flex gap-2 flex-wrap">
             <span class="inline-block whitespace-nowrap rounded-md bg-blue-100/80 px-3 py-1 text-[10px] font-black text-blue-800 uppercase tracking-widest">
              {{ $item->category->name ?? 'Semua Kategori' }}
            </span>
            <span class="inline-block whitespace-nowrap rounded-md bg-purple-100/80 px-3 py-1 text-[10px] font-black text-purple-800 uppercase tracking-widest">
              {{ $item->experience }}
            </span>
          </div>
          
          <div class="mt-auto border-t border-gray-100 pt-5 space-y-3">
              <div class="flex items-center gap-3 text-slate-500">
                <p class="text-sm font-medium whitespace-nowrap">{{ $item->location ?? 'Belum ditentukan' }}</p>
              </div>
              <div class="flex items-center gap-3 text-slate-500">
                <p class="text-sm font-medium whitespace-nowrap">
                   Batas: {{ $item->deadline ? \Carbon\Carbon::parse($item->deadline)->format('d M Y') : 'Tidak ada batas' }}
                </p>
              </div>
          </div>
        </a>
        @empty
        <div class="col-span-full text-center py-16 bg-white rounded-[2rem] border border-dashed border-gray-200">
            <p class="text-slate-500 font-bold text-lg">Belum ada lowongan terbaru saat ini.</p>
        </div>
        @endforelse
      </div>

      <div class="mt-12 flex items-center justify-center">
        <a href="/careers" class="text-sm font-black text-blue-900 bg-white border-2 border-blue-900 rounded-xl px-8 py-3 flex items-center hover:bg-blue-900 hover:text-white transition shadow-sm uppercase tracking-widest">
          <span>Lihat Semua Lowongan</span>
        </a>
      </div>
    </section>

    {{-- SECTION TENTANG KAMI (VERSI FULL LENGKAP) --}}
    <section class="mt-24 py-20 bg-cover bg-center relative z-0" style="background-image: url('{{ asset('images/banerskn3.png') }}');">
      <div class="max-w-screen-xl mx-auto bg-white/95 p-8 lg:p-12 rounded-[2.5rem] shadow-xl backdrop-blur-md mx-5">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
          <div class="flex justify-center h-full relative">
            <div class="absolute inset-0 bg-blue-900/10 rounded-[2rem] transform translate-x-4 translate-y-4"></div>
            <img src="{{ asset('images/banerskn.png') }}" alt="Kantor Pusat Sukun" 
                 class="w-full h-64 lg:h-96 object-cover object-right rounded-[2rem] shadow-lg border-4 border-white relative z-10" />
          </div>
          <div class="text-justify relative z-10">
            <h1 class="text-3xl lg:text-4xl font-extrabold text-blue-900 mb-6 border-b-4 border-amber-400 inline-block pb-2">Tentang Kami</h1>
            <p class="text-base text-slate-700 leading-relaxed font-medium">
              PT. Sukun Wartono Indonesia didirikan dengan sebuah filosofi yang mempercayai bahwa sumber daya manusia adalah faktor terpenting dalam mengembangkan kemajuan perusahaan. Hal ini lah yang membuat kami selalu berupaya menciptakan lingkungan kerja yang aman, nyaman, dan produktif bagi seluruh karyawan kami.
            </p>
            <p class="text-base mt-4 text-slate-700 leading-relaxed font-medium">
              Pengembangan diri tetap menjadi fokus utama kami seiring dengan perkembangan zaman yang ada. Melalui berbagai program pelatihan dan pengembangan, kami berkomitmen untuk membantu setiap individu mencapai potensi terbaiknya dan tumbuh bersama perusahaan dalam menghadapi tantangan di masa depan.
            </p>
          </div>
        </div>
      </div>
    </section>

    {{-- BANNER BAWAH --}}
    <section class="my-24 relative z-0">
      <div class="max-w-screen-xl mx-auto px-5">
        <div class="bg-blue-900 bg-cover bg-center overflow-hidden rounded-[2.5rem] p-10 lg:p-16 relative shadow-2xl" style="background-image: url('https://static.vecteezy.com/system/resources/previews/014/031/972/non_2x/abstract-modern-wave-graphic-background-blue-background-abstract-wave-background-design-dark-poster-blue-background-illustration-vector.jpg');">
          <div class="absolute inset-0 bg-blue-900/60 mix-blend-multiply"></div>
          <div class="flex flex-col lg:flex-row justify-between items-center gap-8 relative z-10">
            <h4 class="text-3xl lg:text-4xl font-extrabold text-white lg:basis-2/3 text-center lg:text-left drop-shadow-lg leading-tight">
              Ayo Bergabung dan Bangun Masa Depanmu Bersama Kami!
            </h4>
            <a href="/careers" class="bg-amber-400 text-amber-900 rounded-xl px-10 py-5 font-black uppercase tracking-widest hover:bg-amber-300 transition whitespace-nowrap shadow-xl hover:-translate-y-1">
              Temukan Karirmu
            </a>
          </div>
        </div>
      </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (document.querySelector(".heroSwiper")) {
            // Hancurkan instance lama kalau ada bentrok
            if (document.querySelector('.heroSwiper').swiper) {
                document.querySelector('.heroSwiper').swiper.destroy(true, true);
            }

            const swiper = new Swiper(".heroSwiper", {
                spaceBetween: 0,
                effect: "fade",
                fadeEffect: { 
                    crossFade: true // BIAR TIDAK BLANK
                },
                loop: true,
                speed: 1000,
                autoplay: {
                    delay: 4000, 
                    disableOnInteraction: false,
                },
                observer: true,
                observeParents: true,
                watchSlidesProgress: true,
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
                navigation: { 
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
            });
        }
    });
</script>
@endpush