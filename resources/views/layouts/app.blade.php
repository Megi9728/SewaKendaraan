<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="RentDrive - Platform sewa kendaraan terpercaya di Indonesia. Pilih dari ratusan armada mobil dan motor berkualitas.">
    <title>@yield('title', 'RentDrive') - Sewa Kendaraan Terpercaya</title>
    <link rel="icon" href="data:,">

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50:  '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            900: '#1e3a8a',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body { font-family: 'Inter', sans-serif; }
        .nav-link { @apply text-slate-600 hover:text-blue-600 font-medium transition-colors duration-200 text-sm; }
        .btn-primary { @apply bg-blue-600 hover:bg-blue-700 active:scale-95 text-white font-semibold px-5 py-2.5 rounded-xl transition-all duration-200 shadow-sm; }
        .btn-ghost { @apply text-slate-600 hover:text-blue-600 hover:bg-blue-50 font-semibold px-4 py-2.5 rounded-xl transition-all duration-200 text-sm; }
    </style>

    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

    {{-- ===== NAVBAR ===== --}}
    <header id="navbar" class="fixed top-0 inset-x-0 z-50 transition-all duration-300">
        <nav class="bg-white/90 backdrop-blur-md border-b border-slate-200/80 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">

                    {{-- Logo --}}
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                        <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center shadow-md group-hover:shadow-blue-300 transition-shadow">
                            <i class="fas fa-car text-white text-sm"></i>
                        </div>
                        <span class="font-extrabold text-xl text-slate-900">Rent<span class="text-blue-600">Drive</span></span>
                    </a>

                    {{-- Desktop Nav --}}
                    <div class="hidden md:flex items-center gap-1">
                        <a href="{{ route('home') }}" class="nav-link px-4 py-2 rounded-xl hover:bg-slate-100">Beranda</a>
                        <a href="{{ route('browse') }}" class="nav-link px-4 py-2 rounded-xl hover:bg-slate-100">Jelajahi Armada</a>
                        <a href="{{ route('how.it.works') }}" class="nav-link px-4 py-2 rounded-xl hover:bg-slate-100">Cara Kerja</a>
                    </div>

                    {{-- Desktop CTA --}}
                    <div class="hidden md:flex items-center relative">
                        <button id="auth-dropdown-toggle" class="btn-primary flex items-center gap-2.5">
                            <i class="fas fa-user-circle"></i>
                            <span>{{ Auth::check() ? Auth::user()->name : 'Masuk' }}</span>
                            <i class="fas fa-chevron-down text-[10px] transition-transform duration-200" id="dropdown-chevron"></i>
                        </button>
                        
                        <div id="auth-dropdown" class="hidden absolute top-full right-0 mt-3 w-56 bg-white border border-slate-200 rounded-2xl shadow-xl py-2 z-[60] transform origin-top-right transition-all duration-200">
                            @auth
                                <div class="px-5 py-3 border-b border-slate-100">
                                    <div class="flex items-center justify-between mb-1">
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Akun Saya</p>
                                        @if(Auth::user()->role === 'admin')
                                            <span class="text-[9px] bg-red-100 text-red-600 px-1.5 py-0.5 rounded-md font-bold uppercase">Admin</span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-slate-900 font-bold truncate">{{ Auth::user()->email }}</p>
                                </div>
                                <div class="p-2">
                                    @if(Auth::user()->role === 'admin')
                                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-blue-600 rounded-xl transition-all">
                                            <i class="fas fa-th-large w-5 text-blue-600"></i> Dashboard Admin
                                        </a>
                                    @else
                                        <a href="#" class="flex items-center gap-3 px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-blue-600 rounded-xl transition-all">
                                            <i class="fas fa-history w-5"></i> Riwayat Sewa
                                        </a>
                                        <a href="{{ route('profile') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-blue-600 rounded-xl transition-all">
                                            <i class="fas fa-user-edit w-5"></i> Profil Saya
                                        </a>
                                    @endif
                                    
                                    <hr class="my-2 border-slate-100">
                                    <button onclick="event.preventDefault(); document.getElementById('base-logout-form').submit();" class="w-full flex items-center gap-3 px-3 py-2 text-sm font-bold text-red-500 hover:bg-red-50 rounded-xl transition-all text-left">
                                        <i class="fas fa-sign-out-alt w-5"></i> Keluar
                                    </button>
                                    <form id="base-logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                                </div>
                            @else
                                <div class="px-5 py-3 border-b border-slate-100">
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Selamat Datang</p>
                                    <p class="text-xs text-slate-500 mt-0.5">Silakan pilih akses anda</p>
                                </div>
                                <div class="p-2">
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-blue-600 rounded-xl transition-all">
                                        <i class="fas fa-user-shield w-5 text-blue-600"></i> Panel Admin
                                    </a>
                                    <a href="{{ route('login') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-blue-600 rounded-xl transition-all">
                                        <i class="fas fa-sign-in-alt w-5"></i> Masuk
                                    </a>
                                    <a href="{{ route('register') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-blue-600 rounded-xl transition-all">
                                        <i class="fas fa-user-plus w-5"></i> Daftar Baru
                                    </a>
                                </div>
                            @endauth
                        </div>
                    </div>

                    {{-- Mobile Hamburger --}}
                    <button id="menu-toggle" class="md:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100 transition">
                        <i id="menu-icon" class="fas fa-bars text-lg"></i>
                    </button>
                </div>
            </div>

            {{-- Mobile Dropdown Menu --}}
            <div id="mobile-menu" class="hidden md:hidden border-t border-slate-100 bg-white">
                <div class="px-4 py-6 space-y-2">
                    <a href="{{ route('home') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-slate-700 font-bold hover:bg-blue-50 hover:text-blue-600 transition tracking-tight">
                        <i class="fas fa-home w-5"></i> Beranda
                    </a>
                    <a href="{{ route('browse') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-slate-700 font-bold hover:bg-blue-50 hover:text-blue-600 transition tracking-tight">
                        <i class="fas fa-car w-5"></i> Jelajahi Armada
                    </a>
                    <a href="{{ route('how.it.works') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-slate-700 font-bold hover:bg-blue-50 hover:text-blue-600 transition tracking-tight">
                        <i class="fas fa-info-circle w-5"></i> Cara Kerja
                    </a>

                    <div class="pt-6 mt-4 border-t border-slate-100">
                        @auth
                            {{-- User Info Mobile --}}
                            <div class="px-4 py-4 mb-4 bg-slate-50 rounded-2xl flex items-center gap-4">
                                <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center text-white font-black text-lg">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-slate-900 font-black truncate leading-none mb-1">{{ Auth::user()->name }}</p>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.15em]">{{ Auth::user()->role === 'admin' ? 'Administrator' : 'Pelanggan Aktif' }}</span>
                                </div>
                            </div>

                            {{-- Dynamic Links Mobile --}}
                            <div class="space-y-1">
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-blue-600 font-black bg-blue-50 transition border border-blue-100">
                                        <i class="fas fa-th-large w-5"></i> Dashboard Admin
                                    </a>
                                @else
                                    <a href="#" class="flex items-center gap-4 px-4 py-3 rounded-xl text-slate-700 font-bold hover:bg-slate-50 transition">
                                        <i class="fas fa-history w-5"></i> Riwayat Sewa
                                    </a>
                                @endif

                                <a href="{{ route('profile') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-slate-700 font-bold hover:bg-slate-50 transition">
                                    <i class="fas fa-user-edit w-5"></i> Edit Profil
                                </a>

                                <hr class="my-4 border-slate-50">
                                
                                <button onclick="event.preventDefault(); document.getElementById('mobile-logout-form').submit();" class="w-full flex items-center gap-4 px-4 py-4 rounded-2xl text-red-500 font-black bg-red-50 hover:bg-red-100 transition shadow-sm shadow-red-100">
                                    <i class="fas fa-sign-out-alt w-5 text-lg"></i>
                                    KELUAR SEKARANG
                                </button>
                                <form id="mobile-logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                            </div>
                        @else
                            {{-- Guest Buttons Mobile --}}
                            <div class="flex flex-col gap-3">
                                <a href="{{ route('login') }}" class="w-full text-center bg-slate-100 text-slate-700 font-black py-4 rounded-2xl hover:bg-slate-200 transition text-sm">MASUK</a>
                                <a href="{{ route('register') }}" class="w-full text-center bg-blue-600 text-white font-black py-4 rounded-2xl hover:bg-blue-700 transition text-sm shadow-lg shadow-blue-100">DAFTAR AKUN</a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    </header>

    {{-- Spacer for fixed navbar --}}
    <div class="h-16"></div>

    {{-- ===== KONTEN UTAMA ===== --}}
    <main>
        @yield('content')
    </main>

    {{-- ===== FOOTER ===== --}}
    <footer class="bg-slate-900 text-slate-400 mt-24">
        <div class="max-w-7xl mx-auto px-6 py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10">

                {{-- Brand --}}
                <div class="md:col-span-1">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center">
                            <i class="fas fa-car text-white text-sm"></i>
                        </div>
                        <span class="font-extrabold text-xl text-white">Rent<span class="text-blue-400">Drive</span></span>
                    </div>
                    <p class="text-sm leading-relaxed">Platform sewa kendaraan terpercaya di Indonesia. Armada terlengkap, harga transparan.</p>
                    <div class="flex gap-3 mt-5">
                        <a href="#" class="w-9 h-9 bg-slate-800 hover:bg-blue-600 rounded-lg flex items-center justify-center transition-colors"><i class="fab fa-instagram text-sm"></i></a>
                        <a href="#" class="w-9 h-9 bg-slate-800 hover:bg-blue-600 rounded-lg flex items-center justify-center transition-colors"><i class="fab fa-facebook-f text-sm"></i></a>
                        <a href="#" class="w-9 h-9 bg-slate-800 hover:bg-blue-600 rounded-lg flex items-center justify-center transition-colors"><i class="fab fa-whatsapp text-sm"></i></a>
                    </div>
                </div>

                {{-- Layanan --}}
                <div>
                    <h4 class="text-white font-bold text-sm uppercase tracking-wider mb-4">Layanan</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('browse') }}" class="hover:text-white hover:translate-x-1 inline-block transition-all">Sewa Mobil</a></li>
                        <li><a href="{{ route('browse') }}" class="hover:text-white hover:translate-x-1 inline-block transition-all">Sewa Motor</a></li>
                        <li><a href="#" class="hover:text-white hover:translate-x-1 inline-block transition-all">Sewa dengan Sopir</a></li>
                        <li><a href="#" class="hover:text-white hover:translate-x-1 inline-block transition-all">Sewa Jangka Panjang</a></li>
                    </ul>
                </div>

                {{-- Perusahaan --}}
                <div>
                    <h4 class="text-white font-bold text-sm uppercase tracking-wider mb-4">Perusahaan</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="#" class="hover:text-white hover:translate-x-1 inline-block transition-all">Tentang Kami</a></li>
                        <li><a href="{{ route('how.it.works') }}" class="hover:text-white hover:translate-x-1 inline-block transition-all">Cara Kerja</a></li>
                        <li><a href="#" class="hover:text-white hover:translate-x-1 inline-block transition-all">Blog</a></li>
                        <li><a href="#" class="hover:text-white hover:translate-x-1 inline-block transition-all">Karir</a></li>
                    </ul>
                </div>

                {{-- Kontak --}}
                <div>
                    <h4 class="text-white font-bold text-sm uppercase tracking-wider mb-4">Hubungi Kami</h4>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-start gap-3"><i class="fas fa-phone text-blue-400 mt-0.5"></i><span>+62 812-3456-7890</span></li>
                        <li class="flex items-start gap-3"><i class="fas fa-envelope text-blue-400 mt-0.5"></i><span>halo@rentdrive.id</span></li>
                        <li class="flex items-start gap-3"><i class="fas fa-map-marker-alt text-blue-400 mt-0.5"></i><span>Jl. Sudirman No. 88, Jakarta Pusat</span></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-slate-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-sm">
                <p>&copy; {{ date('Y') }} RentDrive Indonesia. Semua hak dilindungi.</p>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-white transition">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-white transition">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>

    {{-- ===== VANILLA JS: Mobile Menu & Navbar Scroll ===== --}}
    <script>
        // Elements
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        const menuIcon = document.getElementById('menu-icon');
        const authDropdownToggle = document.getElementById('auth-dropdown-toggle');
        const authDropdown = document.getElementById('auth-dropdown');
        const dropdownChevron = document.getElementById('dropdown-chevron');

        // Mobile menu toggle
        if (menuToggle) {
            menuToggle.addEventListener('click', (e) => {
                e.stopPropagation();
                const isHidden = mobileMenu.classList.toggle('hidden');
                menuIcon.className = isHidden ? 'fas fa-bars text-lg' : 'fas fa-times text-lg';
            });
        }

        // Auth dropdown toggle
        if (authDropdownToggle) {
            authDropdownToggle.addEventListener('click', (e) => {
                e.stopPropagation();
                const isHidden = authDropdown.classList.toggle('hidden');
                dropdownChevron.classList.toggle('rotate-180', !isHidden);
            });
        }

        // Close dropdowns on outside click
        document.addEventListener('click', (e) => {
            // Close mobile menu
            if (mobileMenu && !mobileMenu.classList.contains('hidden') && !menuToggle.contains(e.target) && !mobileMenu.contains(e.target)) {
                mobileMenu.classList.add('hidden');
                menuIcon.className = 'fas fa-bars text-lg';
            }
            
            // Close auth dropdown
            if (authDropdown && !authDropdown.classList.contains('hidden') && !authDropdownToggle.contains(e.target) && !authDropdown.contains(e.target)) {
                authDropdown.classList.add('hidden');
                dropdownChevron.classList.remove('rotate-180');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>