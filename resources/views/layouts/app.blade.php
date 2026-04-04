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
                        uber: {
                            black: '#000000',
                            white: '#ffffff',
                            hover: '#e2e2e2',
                            chip: '#efefef',
                            text: '#4b4b4b',
                            muted: '#afafaf'
                        }
                    },
                    boxShadow: {
                        'uber': 'rgba(0, 0, 0, 0.12) 0px 4px 16px 0px',
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body { font-family: 'Inter', sans-serif; }
        .nav-link { @apply text-uber-black hover:bg-uber-chip font-medium transition-colors duration-200 text-sm px-4 py-2.5 rounded-full; }
        .btn-primary { @apply bg-uber-black hover:bg-gray-800 active:scale-95 text-uber-white font-medium px-6 py-3 rounded-full transition-all duration-200; }
        .btn-secondary { @apply bg-uber-chip hover:bg-uber-hover active:scale-95 text-uber-black font-medium px-6 py-3 rounded-full transition-all duration-200 text-sm; }
    </style>

    @stack('styles')
</head>
<body class="bg-uber-white text-uber-black antialiased">

    {{-- ===== NAVBAR ===== --}}
    <header id="navbar" class="bg-uber-black text-uber-white">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-[72px]">

                {{-- Kiri: Logo & Menu --}}
                <div class="flex items-center gap-8">
                    <a href="{{ route('home') }}" class="text-2xl font-bold tracking-tight text-white hover:opacity-80 transition">
                        RentDrive
                    </a>

                    {{-- Desktop Nav --}}
                    <div class="hidden md:flex items-center gap-1">
                        <a href="{{ route('home') }}" class="px-4 py-2 text-sm font-medium {{ request()->routeIs('home') ? 'bg-white/10' : 'text-gray-300 hover:text-white hover:bg-white/10' }} rounded-full transition">Beranda</a>
                        <a href="{{ route('browse') }}" class="px-4 py-2 text-sm font-medium {{ request()->routeIs('browse') || request()->routeIs('vehicle.detail') ? 'bg-white/10' : 'text-gray-300 hover:text-white hover:bg-white/10' }} rounded-full transition">Cari Kendaraan</a>
                        @auth
                            @if(Auth::user()->role !== 'admin')
                                <a href="{{ route('booking.history') }}" class="px-4 py-2 text-sm font-medium {{ request()->routeIs('booking.history') ? 'bg-white/10' : 'text-gray-300 hover:text-white hover:bg-white/10' }} rounded-full transition">Riwayat Sewa</a>
                            @endif
                        @endauth
                        <a href="{{ route('how.it.works') }}" class="px-4 py-2 text-sm font-medium {{ request()->routeIs('how.it.works') ? 'bg-white/10' : 'text-gray-300 hover:text-white hover:bg-white/10' }} rounded-full transition">Tentang</a>
                    </div>
                </div>

                {{-- Kanan: Aksi & Auth --}}
                <div class="hidden md:flex items-center gap-2 relative">
                    <a href="{{ route('help') }}" class="px-4 py-2 text-sm font-medium {{ request()->routeIs('help') ? 'bg-white/10' : 'text-gray-300 hover:text-white hover:bg-white/10' }} rounded-full transition">
                        Bantuan
                    </a>
                    
                    <button id="auth-dropdown-toggle" class="flex items-center gap-2 bg-white text-black hover:bg-gray-200 transition-colors rounded-full px-5 py-2.5 ml-2 font-bold text-sm">
                        <span>{{ Auth::check() ? Auth::user()->name : 'Masuk / Daftar' }}</span>
                    </button>
                    
                    <div id="auth-dropdown" class="hidden absolute top-full right-0 mt-3 w-64 bg-uber-white border border-gray-100 shadow-uber rounded-xl py-2 z-[60] text-uber-black">
                        @auth
                            <div class="px-6 py-4 border-b border-gray-50">
                                <p class="text-[10px] font-bold text-uber-muted uppercase tracking-[0.2em] mb-1 italic">Masuk Sebagai</p>
                                <p class="text-base font-bold text-uber-black truncate">{{ Auth::user()->name }}</p>
                            </div>
                            <div class="p-2">
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 text-sm font-bold text-uber-black hover:bg-uber-chip rounded-lg transition-all">Dashboard Admin</a>
                                @else
                                    <a href="{{ route('profile') }}" class="block px-4 py-3 text-sm font-bold text-uber-black hover:bg-uber-chip rounded-lg transition-all">Lihat Profil Akun</a>
                                @endif
                                
                                <button onclick="event.preventDefault(); document.getElementById('base-logout-form').submit();" class="w-full text-left block px-4 py-3 text-sm font-bold text-uber-black hover:bg-uber-chip rounded-lg transition-all">
                                    Keluar dari Sistem
                                </button>
                                <form id="base-logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                            </div>
                        @else
                            <div class="p-4 flex flex-col gap-3">
                                <a href="{{ route('login') }}" class="btn-primary w-full text-center py-3.5 text-sm font-bold">Masuk</a>
                                <a href="{{ route('register') }}" class="btn-secondary w-full text-center py-3.5 text-sm font-bold">Daftar Akun Baru</a>
                            </div>
                        @endauth
                    </div>
                </div>

                {{-- Mobile Hamburger --}}
                <button id="menu-toggle" class="md:hidden text-uber-white z-[80] relative focus:outline-none">
                    <i id="menu-icon" class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </nav>

        {{-- Mobile Overlay Menu (Uber Style) --}}
        <div id="mobile-menu" class="fixed inset-0 bg-uber-white z-[70] translate-x-full transition-transform duration-300 ease-in-out md:hidden overflow-y-auto">
            <div class="flex flex-col h-full pt-28 px-10 pb-16">
                {{-- Nav Links --}}
                <div class="flex flex-col gap-8 mb-12">
                     <a href="{{ route('home') }}" class="text-4xl font-bold text-uber-black tracking-tighter {{ request()->routeIs('home') ? 'underline underline-offset-8' : '' }}">Beranda</a>
                     <a href="{{ route('browse') }}" class="text-4xl font-bold text-uber-black tracking-tighter {{ request()->routeIs('browse') || request()->routeIs('vehicle.detail') ? 'underline underline-offset-8' : '' }}">Pesan</a>
                     @auth
                         @if(Auth::user()->role !== 'admin')
                             <a href="{{ route('booking.history') }}" class="text-4xl font-bold text-uber-black tracking-tighter {{ request()->routeIs('booking.history') ? 'underline underline-offset-8' : '' }}">Riwayat</a>
                         @endif
                     @endauth
                     <a href="{{ route('how.it.works') }}" class="text-4xl font-bold text-uber-black tracking-tighter {{ request()->routeIs('how.it.works') ? 'underline underline-offset-8' : '' }}">Tentang</a>
                     <a href="{{ route('help') }}" class="text-4xl font-bold text-uber-black tracking-tighter {{ request()->routeIs('help') ? 'underline underline-offset-8' : '' }}">Bantuan</a>

                     {{-- Simplified Admin Link --}}
                     @auth
                         @if(Auth::user()->role === 'admin')
                             <div class="mt-8 pt-8 border-t border-gray-100 flex flex-col gap-8">
                                 <a href="{{ route('admin.dashboard') }}" class="text-4xl font-bold text-uber-black tracking-tighter {{ request()->is('admin*') ? 'underline underline-offset-8' : '' }}">Panel Admin</a>
                             </div>
                         @endif
                     @endauth

                     {{-- Guest Auth Links (Visible immediately) --}}
                     @guest
                        <div class="mt-8 pt-8 border-t border-gray-100 flex flex-col gap-6">
                            <a href="{{ route('login') }}" class="text-4xl font-bold text-uber-black tracking-tighter">Masuk</a>
                            <a href="{{ route('register') }}" class="text-4xl font-bold text-uber-black tracking-tighter">Daftar Akun</a>
                        </div>
                     @endguest
                </div>

                {{-- Action / Profile --}}
                <div class="mt-auto pt-10 border-t border-gray-100">
                    @auth
                        <div class="mb-8 flex justify-between items-end">
                            <div>
                                <p class="text-sm font-bold text-uber-muted uppercase tracking-widest mb-1 italic">Masuk Sebagai</p>
                                <p class="text-2xl font-bold text-uber-black">{{ Auth::user()->name }}</p>
                            </div>
                            <button onclick="event.preventDefault(); document.getElementById('mobile-logout-form').submit();" class="text-sm font-bold text-red-600 uppercase tracking-widest border-b-2 border-red-600 pb-1">
                                Keluar
                            </button>
                            <form id="mobile-logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                        </div>
                        
                        @if(Auth::user()->role !== 'admin')
                            <a href="{{ route('profile') }}" class="btn-primary w-full text-center py-5 text-lg block">Lihat Profil Akun</a>
                        @endif
                    @else
                        <div class="bg-uber-chip p-6 rounded-2xl">
                            <p class="text-sm font-bold text-uber-black mb-1">Sudah jadi member?</p>
                            <p class="text-xs text-uber-text mb-4">Masuk untuk kemudahan pemesanan.</p>
                            <a href="{{ route('login') }}" class="btn-primary w-full text-center py-4 text-sm font-bold block">Masuk ke Akun</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    {{-- ===== KONTEN UTAMA ===== --}}
    <main>
        @yield('content')
    </main>

    {{-- ===== FOOTER ===== --}}
    <footer class="bg-uber-black text-uber-white pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-2xl font-bold mb-10">RentDrive</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-16">
                <div>
                    <h4 class="font-bold text-lg mb-6">Pesan Perjalanan</h4>
                    <ul class="space-y-4 text-uber-muted text-sm">
                        <li><a href="{{ route('browse') }}" class="hover:text-uber-white">Pesan Mobil</a></li>
                        <li><a href="{{ route('browse') }}" class="hover:text-uber-white">Pesan Motor</a></li>
                        <li><a href="#" class="hover:text-uber-white">Kota Layanan</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-6">Mitra Pengemudi</h4>
                    <ul class="space-y-4 text-uber-muted text-sm">
                        <li><a href="#" class="hover:text-uber-white">Jadi Sopir Kami</a></li>
                        <li><a href="#" class="hover:text-uber-white">Penghasilan</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-6">Perusahaan</h4>
                    <ul class="space-y-4 text-uber-muted text-sm">
                        <li><a href="#" class="hover:text-uber-white">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-uber-white">Karier</a></li>
                        <li><a href="#" class="hover:text-uber-white">Blog</a></li>
                    </ul>
                </div>
                <div>
                    <div class="flex gap-4 mb-6">
                        <a href="#" class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-800 transition"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-800 transition"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-800 transition"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-800 transition"><i class="fab fa-instagram"></i></a>
                    </div>
                    <div class="flex flex-col gap-2 text-uber-muted text-sm">
                        <span class="flex items-center gap-2"><i class="fas fa-globe"></i> Bahasa Indonesia</span>
                        <span class="flex items-center gap-2"><i class="fas fa-location-dot"></i> Jakarta, ID</span>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 flex flex-col items-center gap-4 text-uber-muted text-xs md:flex-row md:justify-between">
                <p>&copy; {{ date('Y') }} RentDrive Technologies Inc.</p>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-uber-white">Privasi</a>
                    <a href="#" class="hover:text-uber-white">Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>

    {{-- ===== VANILLA JS ===== --}}
    <script>
        const menuToggle = document.getElementById('menu-toggle');
        const menuIcon = document.getElementById('menu-icon');
        const mobileMenu = document.getElementById('mobile-menu');
        const authDropdownToggle = document.getElementById('auth-dropdown-toggle');
        const authDropdown = document.getElementById('auth-dropdown');

        // Toggle Mobile Menu
        if (menuToggle && mobileMenu) {
            menuToggle.addEventListener('click', () => {
                const isOpen = !mobileMenu.classList.contains('translate-x-full');
                if (isOpen) {
                    mobileMenu.classList.add('translate-x-full');
                    menuIcon.classList.replace('fa-times', 'fa-bars');
                    menuToggle.classList.replace('text-uber-black', 'text-uber-white');
                    document.body.classList.remove('overflow-hidden');
                } else {
                    mobileMenu.classList.remove('translate-x-full');
                    menuIcon.classList.replace('fa-bars', 'fa-times');
                    menuToggle.classList.replace('text-uber-white', 'text-uber-black');
                    document.body.classList.add('overflow-hidden');
                }
            });
        }

        // Desktop Auth Dropdown
        if (authDropdownToggle) {
            authDropdownToggle.addEventListener('click', (e) => {
                e.stopPropagation();
                authDropdown.classList.toggle('hidden');
            });
        }

        document.addEventListener('click', (e) => {
            if (authDropdown && !authDropdown.classList.contains('hidden') && !authDropdownToggle.contains(e.target) && !authDropdown.contains(e.target)) {
                authDropdown.classList.add('hidden');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>