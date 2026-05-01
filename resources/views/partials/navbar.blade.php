@php
    $isHome = request()->routeIs('home');
    $user = auth('customer')->user() ?? auth('mitra')->user() ?? auth('admin')->user();
    $role = auth('admin')->check() ? 'Admin' : (auth('mitra')->check() ? 'Mitra' : (auth('customer')->check() ? 'Customer' : null));
    $dashboardRoute = auth('admin')->check() ? route('admin.dashboard') : (auth('mitra')->check() ? route('mitra.dashboard') : route('booking.history'));
    $isLoggedIn = !is_null($user);
@endphp

<header id="navbar" class="fixed top-0 inset-x-0 z-[100] transition-all duration-300 pointer-events-none">
    <nav class="max-w-[1240px] mx-auto bg-white flex items-center justify-between px-6 md:px-8 h-[80px] relative z-[60] rounded-b-[24px] pointer-events-auto shadow-[0_4px_24px_rgba(0,0,0,0.04)]">

        <!-- 1. LEFT: LINKS (Desktop) -->
        <div class="hidden lg:flex items-center pl-6 gap-8 flex-1">
            <a href="{{ route('home') }}"
                class="text-[15px] font-medium transition-colors flex items-center gap-1 {{ request()->routeIs('home') ? 'text-[#0A174E]' : 'text-[#0A174E]/70 hover:text-[#0A174E]' }}">
                Beranda
            </a>
            <a href="{{ route('browse') }}"
                class="text-[15px] font-medium transition-colors flex items-center gap-1 {{ request()->routeIs('browse') || request()->routeIs('vehicle.detail') ? 'text-[#0A174E]' : 'text-[#0A174E]/70 hover:text-[#0A174E]' }}">
                Kendaraan
            </a>
            <a href="{{ route('how.it.works') }}"
                class="text-[15px] font-medium transition-colors {{ request()->routeIs('how.it.works') ? 'text-[#0A174E]' : 'text-[#0A174E]/70 hover:text-[#0A174E]' }}">
                Layanan
            </a>
            <a href="{{ route('help') }}"
                class="text-[15px] font-medium transition-colors {{ request()->routeIs('help') ? 'text-[#0A174E]' : 'text-[#0A174E]/70 hover:text-[#0A174E]' }}">
                Bantuan
            </a>
            @if(auth('customer')->check())
                <a href="{{ route('booking.history') }}"
                    class="text-[15px] font-medium transition-colors {{ request()->routeIs('booking.history') ? 'text-[#0A174E]' : 'text-[#0A174E]/70 hover:text-[#0A174E]' }}">
                    Riwayat
                </a>
            @endif
        </div>

        <!-- 2. CENTER: LOGO (Desktop & Mobile) -->
        <div class="flex-shrink-0 flex items-center lg:justify-center lg:absolute lg:left-1/2 lg:-translate-x-1/2 pl-2 lg:pl-0">
            <a href="{{ route('home') }}" class="flex items-center hover:opacity-80 transition-opacity gap-2">
                <img src="{{ asset('logo.png') }}" alt="Jatara Logo" class="h-6 md:h-7 w-auto object-contain">
                <span class="font-bold text-[18px] text-[#0A174E] tracking-tight">Jatara</span>
            </a>
        </div>

        <!-- 3. RIGHT: AUTH & CTA (Desktop) -->
        <div class="hidden lg:flex items-center justify-end pr-2 gap-4 flex-1">
            @if($isLoggedIn)
                <div class="relative">
                    <button id="auth-dropdown-toggle"
                        class="text-[15px] font-medium text-[#0A174E]/70 hover:text-[#0A174E] px-3 py-2 flex items-center gap-2 transition-colors">
                        <span class="truncate max-w-[120px]">{{ $user->name }}</span>
                        <i class="fas fa-chevron-down text-[10px] text-[#8F8F7E]"></i>
                    </button>

                    <!-- Dropdown Akun -->
                    <div id="auth-dropdown"
                        class="hidden absolute top-[calc(100%+1rem)] right-0 w-56 bg-white border border-[#EBEBDF] shadow-[0_16px_40px_-10px_rgba(0,0,0,0.1)] rounded-2xl py-2 z-[60]">
                        <div class="px-5 py-3 border-b border-[#EBEBDF]/50 flex items-center gap-3">
                            <div class="h-8 w-8 bg-[#EBEBDF] rounded-full flex items-center justify-center text-[#0A174E] font-bold text-xs">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="overflow-hidden">
                                <p class="text-sm font-bold text-[#0A174E] truncate">{{ $user->name }}</p>
                                <p class="text-xs text-[#8F8F7E] truncate">{{ $role }}</p>
                            </div>
                        </div>
                        <div class="p-2 flex flex-col gap-1">
                            @if(auth('admin')->check())
                                <a href="{{ route('admin.dashboard') }}"
                                    class="flex items-center px-4 py-2.5 text-sm font-medium text-[#0A174E]/80 hover:bg-[#EBEBDF]/30 rounded-xl transition-all">Dashboard Admin</a>
                                <a href="{{ route('admin.profile') }}"
                                    class="flex items-center px-4 py-2.5 text-sm font-medium text-[#0A174E]/80 hover:bg-[#EBEBDF]/30 rounded-xl transition-all">Pengaturan Profil</a>
                            @elseif(auth('mitra')->check())
                                <a href="{{ route('mitra.dashboard') }}"
                                    class="flex items-center px-4 py-2.5 text-sm font-medium text-[#0A174E]/80 hover:bg-[#EBEBDF]/30 rounded-xl transition-all">Dashboard Mitra</a>
                                <a href="{{ route('mitra.profile') }}"
                                    class="flex items-center px-4 py-2.5 text-sm font-medium text-[#0A174E]/80 hover:bg-[#EBEBDF]/30 rounded-xl transition-all">Pengaturan Profil</a>
                            @else
                                <a href="{{ route('booking.history') }}"
                                    class="flex items-center px-4 py-2.5 text-sm font-medium text-[#0A174E]/80 hover:bg-[#EBEBDF]/30 rounded-xl transition-all">Riwayat Sewa</a>
                                <a href="{{ route('profile') }}"
                                    class="flex items-center px-4 py-2.5 text-sm font-medium text-[#0A174E]/80 hover:bg-[#EBEBDF]/30 rounded-xl transition-all">Pengaturan Profil</a>
                            @endif
                            <button onclick="event.preventDefault(); document.getElementById('base-logout-form').submit();"
                                class="flex items-center w-full text-left px-4 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50 rounded-xl transition-all">Keluar Sistem</button>
                            <form id="base-logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                        </div>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="text-[15px] font-medium text-[#0A174E]/70 hover:text-[#0A174E] px-4 transition-colors">Masuk</a>
            @endif

            @if($isLoggedIn)
                <a href="{{ $dashboardRoute }}"
                    class="bg-[#F5D042] hover:opacity-90 text-[#0A174E] rounded-full px-6 py-2.5 text-[14px] font-bold transition-all flex items-center gap-2 shadow-[0_4px_14px_rgba(245,208,66,0.4)] hover:shadow-[0_6px_20px_rgba(245,208,66,0.6)] hover:-translate-y-0.5 duration-300">
                    Beranda <i class="fas fa-arrow-right text-xs ml-1"></i>
                </a>
            @else
                <a href="{{ route('register') }}"
                    class="bg-[#F5D042] hover:opacity-90 text-[#0A174E] rounded-full px-6 py-2.5 text-[14px] font-bold transition-all flex items-center gap-2 shadow-[0_4px_14px_rgba(245,208,66,0.4)] hover:shadow-[0_6px_20px_rgba(245,208,66,0.6)] hover:-translate-y-0.5 duration-300">
                    Daftar Akun <i class="fas fa-arrow-right text-xs ml-1"></i>
                </a>
            @endif
        </div>

        <!-- Togle Menu Mobile -->
        <button id="menu-toggle" type="button" onclick="openMobileMenu()" class="lg:hidden bg-transparent text-[#0A174E]/80 hover:bg-[#EBEBDF]/30 p-3 rounded-full transition focus:outline-none ml-auto">
            <i id="menu-icon" class="fas fa-bars text-lg"></i>
        </button>
    </nav>


    <!-- MENU MOBILE OVERLAY -->
    <div id="mobile-menu-overlay" onclick="closeMobileMenu()" class="fixed inset-0 bg-[#0A174E]/40 backdrop-blur-sm z-[90] opacity-0 pointer-events-none transition-opacity duration-500"></div>

    <div id="mobile-menu" class="fixed top-0 inset-x-0 bg-white z-[110] transform -translate-y-full transition-transform duration-500 ease-[cubic-bezier(0.22,1,0.36,1)] rounded-b-[2rem] shadow-[0_4px_24px_rgba(0,0,0,0.06)]">
        <!-- Header Mobile Menu -->
        <div class="flex items-center justify-between px-6 py-5 pb-2">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <img src="{{ asset('logo.png') }}" alt="Jatara" class="h-6 w-auto">
                <span class="font-bold text-[18px] text-[#0A174E] tracking-tight">Jatara</span>
            </a>
            <button id="close-menu-toggle" type="button" onclick="closeMobileMenu()" class="bg-[#F9F9F5] text-[#0A174E]/60 hover:bg-[#D4D4C3] p-2 rounded-full transition transform hover:rotate-90 duration-300">
                <i class="fas fa-times text-xl w-6 h-6 flex items-center justify-center"></i>
            </button>
        </div>

        <!-- Content Mobile Menu -->
        <div class="px-6 py-4 flex flex-col">
            <div class="flex flex-col text-lg space-y-1 mb-8">
                <a href="{{ route('home') }}" class="py-4 border-b border-[#EBEBDF] text-[#0A174E] font-medium hover:text-[#F5D042] transition-colors flex items-center justify-between group">
                    Beranda <i class="fas fa-arrow-right opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all text-sm text-[#F5D042]"></i>
                </a>
                <a href="{{ route('browse') }}" class="py-4 border-b border-[#EBEBDF] text-[#0A174E] font-medium flex justify-between items-center hover:text-[#F5D042] transition-colors group">
                    Kendaraan Rental <i class="fas fa-chevron-down text-xs text-[#8F8F7E] group-hover:text-[#F5D042] transition-colors"></i>
                </a>
                <a href="{{ route('how.it.works') }}" class="py-4 border-b border-[#EBEBDF] text-[#0A174E] font-medium hover:text-[#F5D042] transition-colors flex items-center justify-between group">
                    Layanan & Area <i class="fas fa-arrow-right opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all text-sm text-[#F5D042]"></i>
                </a>
                <a href="{{ route('help') }}" class="py-4 border-b border-[#EBEBDF] text-[#0A174E] font-medium hover:text-[#F5D042] transition-colors flex items-center justify-between group">
                    Bantuan Pelanggan <i class="fas fa-arrow-right opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all text-sm text-[#F5D042]"></i>
                </a>
            </div>

            <div class="flex items-center justify-between pb-8">
                @if($isLoggedIn)
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 bg-[#EBEBDF] rounded-full flex items-center justify-center text-[#0A174E] font-bold">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-[#0A174E]">{{ $user->name }}</p>
                            <p class="text-xs text-red-500 hover:underline cursor-pointer" onclick="event.preventDefault(); document.getElementById('mobile-logout-form').submit();">Keluar</p>
                            <form id="mobile-logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-[#0A174E] font-medium text-base hover:text-[#F5D042] transition-colors">Masuk</a>
                    <a href="{{ route('register') }}" class="bg-[#F5D042] text-[#0A174E] px-6 py-3 rounded-full font-bold text-sm shadow-[0_4px_14px_rgba(245,208,66,0.4)] flex items-center gap-2 hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
                        Daftar Akun <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                @endif
            </div>

            @if($isLoggedIn)
                <div class="pb-6">
                    <a href="{{ $dashboardRoute }}" class="bg-[#F5D042] text-[#0A174E] w-full py-3.5 flex justify-center items-center gap-2 rounded-full font-bold text-sm shadow-md hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
                        Dashboard <i class="fas fa-arrow-right text-xs ml-1"></i>
                    </a>
                </div>
            @endif
        </div>
    </div>
</header>
