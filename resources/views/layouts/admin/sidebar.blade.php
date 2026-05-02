<!-- Sidebar Backdrop -->
<div class="fixed inset-0 z-40 bg-black/50 lg:hidden"
     x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false" x-cloak>
</div>

<!-- Sidebar Layout TailAdmin -->
<aside class="absolute left-0 top-0 z-50 flex h-screen w-72 flex-col overflow-y-hidden bg-[#1c2434] duration-300 ease-linear lg:static lg:translate-x-0"
       :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
    
    <!-- Sidebar Header -->
    <div class="flex items-center justify-between gap-2 px-6 py-5 lg:py-6">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <div class="bg-white rounded-lg p-1.5 shadow-sm">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="w-8 h-auto">
            </div>
            <span class="text-white text-xl font-bold tracking-wide">Jatara<span class="text-primary align-top text-sm font-black text-rose-500">.</span></span>
        </a>
        
        <button @click="sidebarOpen = !sidebarOpen" class="block lg:hidden text-bodydark hover:text-white">
            <i class="fas fa-arrow-left text-xl"></i>
        </button>
    </div>

    <!-- Sidebar Menus -->
    <div class="no-scrollbar flex flex-col overflow-y-auto duration-300 ease-linear">
        <nav class="mt-5 py-4 px-4 lg:mt-9 lg:px-6">
            
            <h3 class="mb-4 ml-4 text-sm font-semibold text-bodydark2 uppercase tracking-wider">Menu Utama</h3>
            
            <ul class="mb-6 flex flex-col gap-1.5">
                @if (Auth::user()->role === 'admin' || Auth::user()->role === 'superadmin')
                    <li>
                        <a href="{{ route('admin.dashboard') }}"
                           class="group relative flex items-center gap-3 rounded-md px-4 py-2.5 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-white/10 {{ Request::routeIs('admin.dashboard') ? 'bg-white/10 text-white' : '' }}">
                            <i class="fas fa-chart-pie w-5 text-center {{ Request::routeIs('admin.dashboard') ? 'text-white' : 'text-bodydark2' }}"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.mitra.index') }}"
                           class="group relative flex items-center gap-3 rounded-md px-4 py-2.5 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-white/10 {{ Request::routeIs('admin.mitra.index') ? 'bg-white/10 text-white' : '' }}">
                            <i class="fas fa-users-gear w-5 text-center {{ Request::routeIs('admin.mitra.index') ? 'text-white' : 'text-bodydark2' }}"></i>
                            Kelola Mitra
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.kendaraan.index') }}"
                           class="group relative flex items-center gap-3 rounded-md px-4 py-2.5 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-white/10 {{ Request::routeIs('admin.kendaraan.*') ? 'bg-white/10 text-white' : '' }}">
                            <i class="fas fa-car-side w-5 text-center {{ Request::routeIs('admin.kendaraan.*') ? 'text-white' : 'text-bodydark2' }}"></i>
                            Semua Armada
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.booking.monitor') }}"
                           class="group relative flex items-center gap-3 rounded-md px-4 py-2.5 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-white/10 {{ Request::routeIs('admin.booking.monitor') ? 'bg-white/10 text-white' : '' }}">
                            <i class="fas fa-list-check w-5 text-center {{ Request::routeIs('admin.booking.monitor') ? 'text-white' : 'text-bodydark2' }}"></i>
                            Monitor Booking
                            @php $pendingCount = \App\Models\Booking::where('status', 'Pending')->count(); @endphp
                            @if ($pendingCount > 0)
                                <span class="absolute right-4 block rounded bg-primary px-2 py-0.5 text-xs font-medium text-white">{{ $pendingCount }}</span>
                            @endif
                        </a>
                    </li>
                @elseif(Auth::user()->role === 'mitra')
                    <li>
                        <a href="{{ route('mitra.dashboard') }}"
                           class="group relative flex items-center gap-3 rounded-md px-4 py-2.5 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-white/10 {{ Request::routeIs('mitra.dashboard') ? 'bg-white/10 text-white' : '' }}">
                            <i class="fas fa-desktop w-5 text-center {{ Request::routeIs('mitra.dashboard') ? 'text-white' : 'text-bodydark2' }}"></i>
                            Dashboard Mitra
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('mitra.monitoring') }}"
                           class="group relative flex items-center gap-3 rounded-md px-4 py-2.5 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-white/10 {{ Request::get('monitoring') || Request::routeIs('mitra.monitoring') ? 'bg-white/10 text-white' : '' }}">
                            <i class="fas fa-map-location-dot w-5 text-center {{ Request::get('monitoring') || Request::routeIs('mitra.monitoring') ? 'text-white' : 'text-bodydark2' }}"></i>
                            Monitoring GPS
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('mitra.vehicles.index') }}"
                           class="group relative flex items-center gap-3 rounded-md px-4 py-2.5 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-white/10 {{ Request::routeIs('mitra.vehicles.index') ? 'bg-white/10 text-white' : '' }}">
                            <i class="fas fa-car w-5 text-center {{ Request::routeIs('mitra.vehicles.index') ? 'text-white' : 'text-bodydark2' }}"></i>
                            Armada Saya
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('mitra.booking.index') }}"
                           class="group relative flex items-center gap-3 rounded-md px-4 py-2.5 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-white/10 {{ Request::routeIs('mitra.booking.index') ? 'bg-white/10 text-white' : '' }}">
                            <i class="fas fa-clipboard-list w-5 text-center {{ Request::routeIs('mitra.booking.index') ? 'text-white' : 'text-bodydark2' }}"></i>
                            Kelola Booking
                        </a>
                    </li>
                @endif
            </ul>

            <h3 class="mb-4 ml-4 text-sm font-semibold text-bodydark2 uppercase tracking-wider mt-10">Konfigurasi</h3>
            
            <ul class="mb-6 flex flex-col gap-1.5">
                @php
                    $profileRoute = Auth::user()->role === 'admin' ? 'admin.profile' : 'mitra.profile';
                @endphp
                <li>
                    <a href="{{ route($profileRoute) }}"
                       class="group relative flex items-center gap-3 rounded-md px-4 py-2.5 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-white/10 {{ Request::routeIs($profileRoute) ? 'bg-white/10 text-white' : '' }}">
                        <i class="fas fa-user-circle w-5 text-center {{ Request::routeIs($profileRoute) ? 'text-white' : 'text-bodydark2' }}"></i>
                        Profil Saya
                    </a>
                </li>
                <li>
                    <a href="{{ route('home') }}" target="_blank"
                       class="group relative flex items-center gap-3 rounded-md px-4 py-2.5 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-white/10">
                        <i class="fas fa-globe w-5 text-center text-bodydark2 group-hover:text-white"></i>
                        Lihat Website
                    </a>
                </li>
            </ul>

        </nav>
    </div>
</aside>