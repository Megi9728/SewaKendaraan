{{-- ===== SIDEBAR ===== --}}
<aside id="sidebar" class="sidebar fixed inset-y-0 left-0 z-50 w-80 bg-slate-900 flex flex-col shadow-2xl">
    
    {{-- Logo Section --}}
    <div class="p-8 mb-4">
        <a href="{{ route('home') }}" class="flex flex-col gap-3" target="_blank">
            <img src="{{ asset('logo.png') }}" alt="Jatara Logo" class=" w-auto">
            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.2em] block">Administrative Hub</span>
        </a>
    </div>

    {{-- Navigation Area --}}
    <nav class="flex-1 overflow-y-auto px-6 custom-scrollbar space-y-8">
        {{-- Group 1 --}}
        <div>
            <p class="px-2 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-4">Navigasi</p>
            <div class="space-y-1">
                @if(Auth::user()->role === 'admin' || Auth::user()->role === 'superadmin')
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="icon fas fa-chart-line"></i>
                        <span>Dashboard Admin</span>
                    </a>
                    <a href="{{ route('admin.mitra.index') }}" class="sidebar-link {{ Request::routeIs('admin.mitra.index') ? 'active' : '' }}">
                        <i class="icon fas fa-store"></i>
                        <span>Kelola Mitra</span>
                    </a>
                    <a href="{{ route('admin.booking.monitor') }}" class="sidebar-link {{ Request::routeIs('admin.booking.monitor') ? 'active' : '' }}">
                        <i class="icon fas fa-calendar-check"></i>
                        <span>Monitor Booking</span>
                    </a>
                @elseif(Auth::user()->role === 'mitra')
                    <a href="{{ route('mitra.dashboard') }}" class="sidebar-link {{ Request::routeIs('mitra.dashboard') ? 'active' : '' }}">
                        <i class="icon fas fa-chart-line"></i>
                        <span>Dashboard Mitra</span>
                    </a>
                    <a href="{{ route('mitra.vehicles.index') }}" class="sidebar-link {{ Request::routeIs('mitra.vehicles.index') ? 'active' : '' }}">
                        <i class="icon fas fa-car"></i>
                        <span>Armada Saya</span>
                    </a>

                    <a href="{{ route('mitra.booking.index') }}" class="sidebar-link {{ Request::routeIs('mitra.booking.index') ? 'active' : '' }}">
                        <i class="icon fas fa-calendar-check"></i>
                        <span>Kelola Booking</span>
                    </a>
                @endif
            </div>
        </div>

        {{-- Group 2 --}}
        <div>
            <p class="px-2 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-4">Konfigurasi</p>
            <div class="space-y-1">
                @php
                    $profileRoute = Auth::user()->role === 'admin' ? 'admin.profile' : 'mitra.profile';
                @endphp
                <a href="{{ route($profileRoute) }}" class="sidebar-link {{ Request::routeIs($profileRoute) ? 'active' : '' }}">
                    <i class="icon fas fa-user-gear"></i>
                    <span>Profil Saya</span>
                </a>
                <a href="{{ route('home') }}" target="_blank" class="sidebar-link">
                    <i class="icon fas fa-globe"></i>
                    <span>Lihat Website</span>
                </a>
            </div>
        </div>
    </nav>

    {{-- User Section at Bottom --}}
    <div class="p-4 border-t border-white/5 mx-2 mb-2">
        <div class="flex items-center gap-3 p-4 bg-white/5 rounded-3xl group">
            <div class="w-10 h-10 bg-blue-600/20 text-blue-500 flex items-center justify-center text-sm font-black rounded-2xl group-hover:bg-blue-600 group-hover:text-white transition-all">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs font-bold text-white truncate">{{ Auth::user()->name }}</p>
                <p class="text-[10px] text-slate-500 truncate">{{ Auth::user()->email }}</p>
            </div>
            <form id="logout-sidebar" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
            <button onclick="document.getElementById('logout-sidebar').submit()" class="w-8 h-8 flex items-center justify-center text-slate-500 hover:text-red-500 transition-colors" title="Keluar">
                <i class="fas fa-power-off text-sm"></i>
            </button>
        </div>
    </div>
</aside>
