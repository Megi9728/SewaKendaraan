@php($isHome = request()->routeIs('home'))

<header id="navbar" class="{{ $isHome ? 'absolute inset-x-0 top-0 z-50 pt-5 md:pt-8 px-4 md:px-8' : 'bg-white border-b border-gray-100 sticky top-0 z-50' }}">
    <nav class="max-w-[1240px] mx-auto {{ $isHome ? 'bg-white/95 backdrop-blur-xl rounded-full shadow-[0_20px_40px_-15px_rgba(0,0,0,0.15)] border border-white/60 px-4 md:px-6' : 'px-4 md:px-8' }}">
        <div class="flex items-center justify-between h-[72px] md:h-[80px]">
            
            <!-- 1. IDENTITAS (LOGO) -->
            <div class="flex-shrink-0 flex items-center z-50">
                <a href="{{ route('home') }}" class="flex items-center hover:opacity-80 transition-opacity">
                    <!-- Logo dipastikan tampil 100% natural tanpa filter, karena background sudah putih/terang -->
                    <img src="{{ asset('logo.png') }}" alt="Jatara Logo" class="h-8 md:h-10 w-auto object-contain">
                </a>
            </div>

            <!-- 2. NAVIGASI UTAMA TATA LETAK TENGAH -->
            <div class="hidden md:flex items-center justify-center flex-1 ml-8">
                <div class="flex items-center gap-1.5">
                    <a href="{{ route('home') }}" class="px-5 py-2.5 text-[14px] font-bold rounded-full transition-all duration-300 {{ request()->routeIs('home') ? 'bg-[#EBEBDF] text-[#0A174E]' : 'text-gray-600 hover:text-[#0A174E] hover:bg-[#EBEBDF]/40' }}">Beranda</a>
                    
                    <a href="{{ route('browse') }}" class="px-5 py-2.5 text-[14px] font-bold rounded-full transition-all duration-300 {{ request()->routeIs('browse') || request()->routeIs('vehicle.detail') ? 'bg-[#EBEBDF] text-[#0A174E]' : 'text-gray-600 hover:text-[#0A174E] hover:bg-[#EBEBDF]/40' }}">Cari Kendaraan</a>
                    
                    @auth
                        <a href="{{ route('booking.history') }}" class="px-5 py-2.5 text-[14px] font-bold rounded-full transition-all duration-300 {{ request()->routeIs('booking.history') ? 'bg-[#EBEBDF] text-[#0A174E]' : 'text-gray-600 hover:text-[#0A174E] hover:bg-[#EBEBDF]/40' }}">Riwayat</a>
                    @endauth
                    
                    <a href="{{ route('how.it.works') }}" class="px-5 py-2.5 text-[14px] font-bold rounded-full transition-all duration-300 {{ request()->routeIs('how.it.works') ? 'bg-[#EBEBDF] text-[#0A174E]' : 'text-gray-600 hover:text-[#0A174E] hover:bg-[#EBEBDF]/40' }}">Tentang</a>
                    
                    <a href="{{ route('help') }}" class="px-5 py-2.5 text-[14px] font-bold rounded-full transition-all duration-300 {{ request()->routeIs('help') ? 'bg-[#EBEBDF] text-[#0A174E]' : 'text-gray-600 hover:text-[#0A174E] hover:bg-[#EBEBDF]/40' }}">Bantuan</a>
                </div>
            </div>

            <!-- 3. AKSI & AKUN TATA LETAK KANAN -->
            <div class="hidden md:flex items-center justify-end flex-shrink-0 relative">
                <button id="auth-dropdown-toggle" class="flex items-center gap-2 bg-[#0A174E] text-[#F5D042] hover:bg-[#0A174E]/90 transition-all duration-300 rounded-full px-7 py-3 font-bold text-sm shadow-[0_4px_14px_rgba(10,23,78,0.25)] hover:shadow-[0_6px_20px_rgba(10,23,78,0.4)] hover:-translate-y-0.5">
                    <span>{{ Auth::check() ? Auth::user()->name : 'Masuk / Daftar' }}</span>
                </button>

                <!-- Dropdown Akun -->
                <div id="auth-dropdown" class="hidden absolute top-[calc(100%+0.5rem)] right-0 w-64 bg-white border border-[#EBEBDF] shadow-[0_20px_40px_-15px_rgba(10,23,78,0.2)] rounded-2xl py-2 z-[60] text-[#0A174E]">
                    @auth
                        <div class="px-6 py-4 border-b border-gray-100">
                            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-[0.2em] mb-1">Masuk Sebagai</p>
                            <p class="text-base font-extrabold text-[#0A174E] truncate">{{ Auth::user()->name }}</p>
                        </div>
                        <div class="p-3 flex flex-col gap-1">
                            @if (Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2.5 text-sm font-bold text-[#0A174E] hover:bg-[#EBEBDF] rounded-xl transition-all">Dashboard Admin</a>
                            @else
                                <a href="{{ route('booking.history') }}" class="flex items-center px-4 py-2.5 text-sm font-bold text-[#0A174E] hover:bg-[#EBEBDF] rounded-xl transition-all">Riwayat Sewa</a>
                                <a href="{{ route('profile') }}" class="flex items-center px-4 py-2.5 text-sm font-bold text-[#0A174E] hover:bg-[#EBEBDF] rounded-xl transition-all">Lihat Profil</a>
                            @endif
                            <button onclick="event.preventDefault(); document.getElementById('base-logout-form').submit();" class="flex items-center w-full text-left px-4 py-2.5 text-sm font-bold text-red-600 hover:bg-red-50 rounded-xl transition-all mt-1">Keluar Sistem</button>
                            <form id="base-logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                        </div>
                    @else
                        <div class="p-4 flex flex-col gap-2.5">
                            <a href="{{ route('login') }}" class="bg-[#0A174E] text-[#F5D042] hover:opacity-95 rounded-xl w-full text-center py-3 text-sm font-bold transition">Masuk</a>
                            <a href="{{ route('register') }}" class="bg-[#EBEBDF]/50 text-[#0A174E] hover:bg-[#EBEBDF] rounded-xl w-full text-center py-3 text-sm font-bold transition">Daftar Akun Baru</a>
                        </div>
                    @endauth
                </div>
            </div>

            <!-- Togle Menu Mobile -->
            <button id="menu-toggle" class="md:hidden bg-[#EBEBDF]/50 text-[#0A174E] hover:bg-[#EBEBDF] p-2.5 rounded-full transition focus:outline-none z-[80] relative">
                <i id="menu-icon" class="fas fa-bars text-xl"></i>
            </button>
        </div>
    </nav>

    <!-- MENU MOBILE FULL-SCREEN -->
    <div id="mobile-menu" class="fixed inset-0 bg-white z-[70] translate-x-full transition-transform duration-300 ease-out md:hidden overflow-y-auto">
        <div class="flex flex-col h-full pt-28 px-8 pb-10">
            <div class="flex flex-col gap-6 mb-12">
                <a href="{{ route('home') }}" class="text-3xl font-extrabold text-[#0A174E] tracking-tight flex items-center justify-between pb-4 border-b border-gray-100 {{ request()->routeIs('home') ? 'text-[#F5D042]' : '' }}">Beranda <i class="fas fa-chevron-right text-sm text-gray-300"></i></a>
                <a href="{{ route('browse') }}" class="text-3xl font-extrabold text-[#0A174E] tracking-tight flex items-center justify-between pb-4 border-b border-gray-100 {{ request()->routeIs('browse') || request()->routeIs('vehicle.detail') ? 'text-[#F5D042]' : '' }}">Cari Kendaraan <i class="fas fa-chevron-right text-sm text-gray-300"></i></a>
                @auth
                    <a href="{{ route('booking.history') }}" class="text-3xl font-extrabold text-[#0A174E] tracking-tight flex items-center justify-between pb-4 border-b border-gray-100 {{ request()->routeIs('booking.history') ? 'text-[#F5D042]' : '' }}">Riwayat Sewa <i class="fas fa-chevron-right text-sm text-gray-300"></i></a>
                @endauth
                <a href="{{ route('how.it.works') }}" class="text-3xl font-extrabold text-[#0A174E] tracking-tight flex items-center justify-between pb-4 border-b border-gray-100 {{ request()->routeIs('how.it.works') ? 'text-[#F5D042]' : '' }}">Tentang Kami <i class="fas fa-chevron-right text-sm text-gray-300"></i></a>
                <a href="{{ route('help') }}" class="text-3xl font-extrabold text-[#0A174E] tracking-tight flex items-center justify-between pb-4 border-b border-gray-100 {{ request()->routeIs('help') ? 'text-[#F5D042]' : '' }}">Bantuan <i class="fas fa-chevron-right text-sm text-gray-300"></i></a>
            </div>
            
            <div class="mt-auto">
                @auth
                    <div class="mb-4 p-6 bg-[#F9F9F5] rounded-3xl border border-[#EBEBDF]">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Akun Terhubung</p>
                        <p class="text-2xl font-black text-[#0A174E] mb-4">{{ Auth::user()->name }}</p>
                        <div class="flex flex-col gap-3">
                            @if (Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="bg-white px-4 py-3 rounded-xl border border-gray-200 text-sm font-bold text-[#0A174E] text-center">Dashboard Admin</a>
                            @else
                                <a href="{{ route('profile') }}" class="bg-white px-4 py-3 rounded-xl border border-gray-200 text-sm font-bold text-[#0A174E] text-center">Pengaturan Profil</a>
                            @endif
                            <button onclick="event.preventDefault(); document.getElementById('mobile-logout-form').submit();" class="w-full text-center py-3 bg-red-50 text-red-600 font-bold rounded-xl text-sm border border-red-100">Keluar Sistem</button>
                        </div>
                    </div>
                    <form id="mobile-logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                @else
                    <div class="flex flex-col gap-3">
                        <a href="{{ route('login') }}" class="w-full text-center py-4 bg-[#0A174E] text-[#F5D042] font-black rounded-2xl text-lg hover:opacity-95 transition shadow-xl">Masuk Sistem</a>
                        <a href="{{ route('register') }}" class="w-full text-center py-4 bg-[#EBEBDF] text-[#0A174E] font-bold rounded-2xl text-lg hover:bg-[#D4D4C3] transition">Daftar Akun Baru</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</header>
