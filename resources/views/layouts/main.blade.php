<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Sukun Karir')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/sukun.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet" />

    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="font-['DM_Sans'] bg-neutral-50">

<nav id="main-navbar" class="fixed start-0 top-0 z-20 w-full border-0 bg-blue-900 transition-all duration-300">
    <div class="mx-auto flex max-w-screen-lg items-center px-5 py-5">
        
        <a href="/" class="flex items-center">
            <img src="{{ asset('images/sukun.png') }}" class="h-11" alt="Sukun Logo" />
        </a>

        <div class="hidden w-full md:flex md:flex-1 md:items-center md:justify-end" id="navbar-sticky">
            <ul class="flex flex-col md:flex-row md:items-center md:space-x-10 font-medium mt-4 md:mt-0">
                <li>
                    <a href="/" class="block py-2 md:p-0">
                        <span class="text-white transition-colors duration-300">Home</span>
                    </a>
                </li>
                <li>
                    <a href="/careers" class="block py-2 md:p-0">
                        <span class="text-white transition-colors duration-300">Karir</span>
                    </a>
                </li>
                
                @auth
                    <li class="relative">
                        <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar" class="flex items-center justify-between w-full py-2 px-3 text-white font-bold md:p-0 md:w-auto">
                            <span>{{ Auth::user()->role === 'admin' ? 'Admin HRD' : Auth::user()->name }}</span>
                            <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                        </button>

                        <div id="dropdownNavbar" class="z-30 hidden font-normal bg-white divide-y divide-gray-100 rounded-xl shadow-xl w-60 mt-2 border border-gray-100">
                            
                            @if(Auth::user()->role === 'admin')
                                <div class="px-4 py-3 text-[10px] text-blue-900 font-bold bg-blue-50 rounded-t-xl uppercase tracking-widest">
                                    Panel Kendali HRD
                                </div>
                                <ul class="py-2 text-sm text-gray-700">
                                    <li>
                                        <a href="{{ route('admin.lowongan.index') }}" class="flex items-center px-4 py-2 hover:bg-blue-50 transition text-blue-900 font-medium">
                                            Kelola Lowongan
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.applications.index') }}" class="flex items-center px-4 py-2 hover:bg-blue-50 transition text-blue-900 font-medium">
                                            Lamaran Masuk
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.master.index') }}" class="flex items-center px-4 py-2 hover:bg-blue-50 transition text-blue-900 font-bold border-t border-gray-100 mt-1 pt-3">
                                             Master Data (Kategori/Experience)
                                        </a>
                                    </li>
                                    {{-- INI FITUR BARUNYA BOS --}}
                                    <li>
                                        <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-2 hover:bg-blue-50 transition text-blue-900 font-bold">
                                             Kelola Admin
                                        </a>
                                    </li>
                                </ul>
                            @else
                                <div class="px-4 py-3 text-[10px] text-slate-400 font-bold uppercase tracking-widest">
                                    Menu Pelamar
                                </div>
                                <ul class="py-2 text-sm text-gray-700">
                                    <li>
                                        <a href="/dashboard" class="flex items-center px-4 py-2 hover:bg-gray-100 transition">
                                            Dashboard Saya
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/careers" class="flex items-center px-4 py-2 hover:bg-gray-100 transition">
                                            Cari Lowongan
                                        </a>
                                    </li>
                                </ul>
                            @endif

                            <div class="py-1">
                                <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Yakin ingin keluar?')">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 font-bold hover:bg-red-50 transition">
                                        Logout / Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </li>
                @else
                    <li>
                        <a href="/login" class="block py-2 md:p-0 transition-colors">
                            <span class="text-white font-bold">Login</span>
                        </a>
                    </li>
                @endauth
            </ul>
        </div>

        <div class="md:hidden ml-auto">
            <button data-collapse-toggle="navbar-sticky" type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-lg p-2 text-gray-400 hover:bg-white/10 focus:outline-none">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
        </div>

    </div>
</nav>

<main class="min-h-screen">
    @yield('content')
</main>

<section id="footer" class="mx-auto bg-blue-900 z-10 relative">
    <div class="py-20 max-w-screen-lg mx-auto px-5">
        <div class="grid grid-cols-1 lg:grid-cols-3 md:grid-cols-3 gap-10">
            <div class="flex flex-col gap-y-3">
                <span class="font-bold text-slate-200 text-xl">PT. Sukun Wartono Indonesia</span>
                <span class="font-light text-slate-200 text-sm text-start block italic">Jl. Raya PR Sukun No. 1-2 Gondosari, Gebog, Kabupaten Kudus, Jawa Tengah 59354, Indonesia</span>
                <ul class="mt-5 text-sm text-slate-200">
                    <li>
                        <a href="mailto:karir@sukunsigaret.com" class="flex items-center hover:text-white transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-4 h-4 mr-2" viewBox="0 0 24 24">
                                <path d="M12 12.713l-11.985-7.713v13.5c0 1.104.896 2 2 2h19.97c1.104 0 2-.896 2-2v-13.5l-11.985 7.713zm11.985-9.713c0-1.104-.896-2-2-2h-19.97c-1.104 0-2 .896-2 2v.217l12 7.732 11.985-7.732v-.217z" />
                            </svg>
                            karir@sukunsigaret.com
                        </a>
                    </li>
                </ul>
            </div>
            <div></div>
           <div class="flex flex-row space-x-6 text-white mt-4 justify-end">
    <a href="https://www.instagram.com/pt.sukun/" target="_blank" class="hover:text-pink-400 transition transform hover:scale-110 flex items-center gap-2">
        <i class="fa-brands fa-instagram text-3xl"></i>
        <span class="text-sm">Instagram</span>
    </a>
    
    <a href="https://www.linkedin.com/company/pt-sukun/" target="_blank" class="hover:text-blue-400 transition transform hover:scale-110 flex items-center gap-2">
        <i class="fa-brands fa-linkedin text-3xl"></i>
        <span class="text-sm">LinkedIn</span>
    </a>
</div>
            </div>
        </div>
    </div>
    <div class="flex justify-center bg-blue-950 py-4 border-t border-blue-800">
        <span class="text-xs text-neutral-400 text-center">&copy; 2026 Crafted by IT PT. Sukun Wartono Indonesia. All rights reserved.</span>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

<script>
    const navbar = document.getElementById("main-navbar");
    const navLinks = navbar.querySelectorAll("a span, button span");

    window.addEventListener("scroll", () => {
        if (window.scrollY > 10) {
            navbar.classList.remove("bg-blue-900");
            navbar.classList.add("bg-white", "shadow-md");
            navLinks.forEach((link) => {
                link.classList.remove("text-white");
                link.classList.add("text-slate-800");
            });
        } else {
            navbar.classList.add("bg-blue-900");
            navbar.classList.remove("bg-white", "shadow-md");
            navLinks.forEach((link) => {
                link.classList.remove("text-slate-800");
                link.classList.add("text-white");
            });
        }
    });

    if (document.querySelector(".swiper")) {
        new Swiper(".swiper", {
            loop: true,
            autoplay: { delay: 5000, disableOnInteraction: false },
            pagination: { el: ".swiper-pagination", clickable: true },
            navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
        });
    }
</script>

@stack('scripts')
</body>
</html>