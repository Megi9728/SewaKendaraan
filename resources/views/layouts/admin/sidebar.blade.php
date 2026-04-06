{{-- ===== SIDEBAR ===== --}}
<aside id="sidebar" class="sidebar fixed inset-y-0 left-0 z-50 w-80 bg-slate-900 flex flex-col shadow-2xl">
    
    {{-- Logo Section --}}
    <div class="p-8 mb-4">
        <a href="{{ route('home') }}" class="flex items-center gap-3" target="_blank">
            <div class="w-10 h-10 bg-blue-600 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-blue-600/30">
                <i class="fas fa-car-rear"></i>
            </div>
            <div>
                <span class="block font-black text-xl text-white leading-none">Rent<span class="text-blue-500">Drive</span></span>
                <span class="text-[9px] font-bold text-slate-500 uppercase tracking-widest mt-1 block">Administrative Hub</span>
            </div>
        </a>
    </div>

    {{-- Navigation Area --}}
    <nav class="flex-1 overflow-y-auto px-6 custom-scrollbar space-y-8">
        {{-- Group 1 --}}
        <div>
            <p class="px-2 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-4">Utama</p>
            <div class="space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="icon fas fa-chart-line"></i>
                    <span>Statistik</span>
                </a>
                <a href="{{ route('admin.kendaraan') }}" class="sidebar-link {{ Request::routeIs('admin.kendaraan') ? 'active' : '' }}">
                    <i class="icon fas fa-car"></i>
                    <span>Kelola Armada</span>
                </a>
                <a href="{{ route('admin.drivers.index') }}" class="sidebar-link {{ Request::routeIs('admin.drivers.index') ? 'active' : '' }}">
                    <i class="icon fas fa-user-tie"></i>
                    <span>Kelola Driver</span>
                </a>
                <a href="{{ route('admin.pemesanan') }}" class="sidebar-link {{ Request::routeIs('admin.pemesanan') ? 'active' : '' }}">
                    <i class="icon fas fa-calendar-check"></i>
                    <span class="flex-1">Pemesanan</span>
                    @php $pendingCount = \App\Models\Booking::where('status', 'Pending')->count(); @endphp
                    @if($pendingCount > 0)
                        <span class="bg-red-500 text-white text-[10px] font-black px-2 py-0.5 rounded-full ring-4 ring-slate-900">{{ $pendingCount }}</span>
                    @endif
                </a>
            </div>
        </div>

        {{-- Group 2 --}}
        <div>
            <p class="px-2 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-4">Konfigurasi</p>
            <div class="space-y-1">
                <a href="{{ route('admin.profile') }}" class="sidebar-link {{ Request::routeIs('admin.profile') ? 'active' : '' }}">
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
