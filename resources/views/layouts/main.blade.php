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

    <style>
        /* Memaksa semua badge/label warna-warni biar teksnya lurus satu baris dan nggak numpuk ke bawah */
        .bg-green-100, .bg-blue-100, .bg-red-100, .bg-amber-100, .bg-gray-100, .bg-slate-100, .bg-yellow-100, .bg-indigo-100 {
            white-space: nowrap !important;
        }
    </style>
</head>
<body class="font-['DM_Sans'] bg-neutral-50">

<nav id="main-navbar" class="fixed start-0 top-0 z-50 w-full border-0 bg-blue-900 transition-all duration-300">
    <div class="mx-auto flex max-w-screen-lg flex-wrap items-center justify-between px-5 py-4">
        
        <a href="/" class="flex items-center">
            <img src="{{ asset('images/sukun.png') }}" class="h-11" alt="Sukun Logo" />
        </a>

        <button data-collapse-toggle="navbar-sticky" type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-lg p-2 text-white hover:bg-white/20 focus:outline-none md:hidden transition-colors" aria-controls="navbar-sticky" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="h-5 w-5 burger-icon" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
            </svg>
        </button>

        <div class="hidden w-full md:block md:w-auto" id="navbar-sticky">
            <ul class="mt-4 flex flex-col rounded-lg bg-blue-900 p-4 font-medium md:mt-0 md:flex-row md:items-center md:space-x-8 md:border-0 md:bg-transparent md:p-0">
                <li>
                    <a href="/" class="block rounded py-2 pl-3 pr-4 md:p-0 hover:bg-white/10 md:hover:bg-transparent">
                        <span class="text-white transition-colors duration-300 nav-text">Home</span>
                    </a>
                </li>
                <li>
                    <a href="/careers" class="block rounded py-2 pl-3 pr-4 md:p-0 hover:bg-white/10 md:hover:bg-transparent">
                        <span class="text-white transition-colors duration-300 nav-text">Karir</span>
                    </a>
                </li>
                
                @auth
                    <li class="relative">
                        <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar" class="flex w-full items-center justify-between rounded py-2 pl-3 pr-4 font-bold hover:bg-white/10 md:w-auto md:p-0 md:hover:bg-transparent text-white nav-text">
                            <span>{{ Auth::user()->role === 'admin' ? 'Admin HRD' : Auth::user()->name }}</span>
                            <svg class="ms-2.5 h-2.5 w-2.5 nav-icon text-white transition-colors duration-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                        </button>

                        <div id="dropdownNavbar" class="z-50 hidden w-full font-normal md:w-max md:min-w-[260px] bg-white divide-y divide-gray-100 rounded-xl shadow-xl border border-gray-100 mt-2 md:absolute md:right-0">
                            
                            @if(Auth::user()->role === 'admin')
                                <div class="px-4 py-3 text-[10px] text-blue-900 font-bold bg-blue-50 rounded-t-xl uppercase tracking-widest">
                                    Panel Kendali HRD
                                </div>
                                
                                <ul class="py-2 text-sm text-gray-700">
                                    <li>
                                        <a href="{{ route('admin.lowongan.index') }}" class="flex items-center px-4 py-2.5 hover:bg-blue-50 transition text-blue-900 font-medium">
                                            Kelola Lowongan
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.applications.index') }}" class="flex items-center px-4 py-2.5 hover:bg-blue-50 transition text-blue-900 font-medium">
                                            Lamaran Masuk
                                        </a>
                                    </li>
                                    
                                    <li class="border-t border-gray-100 my-1"></li>
                                    
                                    <li>
                                        <a href="{{ route('admin.master.index') }}" class="flex items-center px-4 py-2.5 hover:bg-blue-50 transition text-blue-900 font-medium">
                                                Master Data (Kategori/Experience)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-2.5 hover:bg-blue-50 transition text-blue-900 font-medium">
                                                Kelola Admin
                                        </a>
                                    </li>
                                </ul>
                            @else
                                <div class="px-4 py-3 text-[10px] text-slate-500 font-bold bg-slate-50 rounded-t-xl uppercase tracking-widest">
                                    Menu Pelamar
                                </div>
                                <ul class="py-2 text-sm text-gray-700">
                                    <li>
                                        <a href="/dashboard" class="flex items-center px-4 py-2.5 hover:bg-gray-100 transition font-medium text-slate-700">
                                            Dashboard Saya
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/careers" class="flex items-center px-4 py-2.5 hover:bg-gray-100 transition font-medium text-slate-700">
                                            Cari Lowongan
                                        </a>
                                    </li>
                                </ul>
                            @endif

                            <div class="py-2">
                                <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Yakin ingin keluar?')">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 font-medium hover:bg-red-50 transition">
                                        Logout / Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </li>
                @else
                    <li>
                        <a href="/login" class="block rounded py-2 pl-3 pr-4 md:p-0 hover:bg-white/10 md:hover:bg-transparent">
                            <span class="text-white font-bold nav-text transition-colors duration-300">Login</span>
                        </a>
                    </li>
                @endauth
            </ul>
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
    const navTexts = navbar.querySelectorAll(".nav-text"); 
    const navIcons = navbar.querySelectorAll(".nav-icon");
    const burgerIcon = navbar.querySelector(".burger-icon");

    window.addEventListener("scroll", () => {
        if (window.scrollY > 10) {
            navbar.classList.remove("bg-blue-900");
            navbar.classList.add("bg-white", "shadow-md");
            
            navTexts.forEach((el) => {
                el.classList.remove("text-white");
                el.classList.add("text-slate-800");
            });
            
            navIcons.forEach((el) => {
                el.classList.remove("text-white");
                el.classList.add("text-slate-800");
            });

            if(burgerIcon) {
                burgerIcon.classList.remove("text-white");
                burgerIcon.classList.add("text-slate-800");
            }

        } else {
            navbar.classList.add("bg-blue-900");
            navbar.classList.remove("bg-white", "shadow-md");
            
            navTexts.forEach((el) => {
                el.classList.remove("text-slate-800");
                el.classList.add("text-white");
            });

            navIcons.forEach((el) => {
                el.classList.remove("text-slate-800");
                el.classList.add("text-white");
            });

            if(burgerIcon) {
                burgerIcon.classList.remove("text-slate-800");
                burgerIcon.classList.add("text-white");
            }
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