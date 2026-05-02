@php
    // New Multi-Guard Logic from Main
    $user = auth('admin')->user() ?? auth('mitra')->user();
    $role = auth('admin')->check() ? 'admin' : (auth('mitra')->check() ? 'mitra' : null);
    $is_admin = auth('admin')->check();
    
    // Theme configurations from Redesign
    $theme = [
        'bg' => $is_admin 
            ? 'bg-gradient-to-b from-[#1a1c2e] via-[#0f111a] to-[#0a0c14]' 
            : 'bg-gradient-to-b from-[#0d1f1f] via-[#0f111a] to-[#0a0c14]',
        'accent' => $is_admin ? 'indigo' : 'teal',
        'accent_hex' => $is_admin ? '#6366f1' : '#14b8a6',
        'label' => $is_admin ? 'Super Admin' : 'Mitra Jatara'
    ];
@endphp

<!-- Sidebar Backdrop -->
<div class="fixed inset-0 z-40 bg-black/60 backdrop-blur-sm lg:hidden"
     x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false" x-cloak>
</div>

<!-- Sidebar Layout -->
<aside class="absolute left-0 top-0 z-50 flex h-screen w-60 flex-col overflow-y-hidden {{ $theme['bg'] }} border-r border-white/5 duration-300 ease-linear lg:static lg:translate-x-0 shadow-2xl"
       :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
    
    <!-- Sidebar Header -->
    <div class="flex items-center justify-between gap-2 px-8 py-6 lg:py-8 relative overflow-hidden">
        {{-- Decorative Glow --}}
        <div class="absolute -top-10 -left-10 w-32 h-32 bg-{{ $theme['accent'] }}-500/10 rounded-full blur-3xl"></div>
        
        <a href="{{ route('home') }}" class="flex items-center gap-3 relative z-10">
            <div class="bg-white/10 backdrop-blur-md rounded-xl p-1.5 shadow-xl border border-white/10 group hover:scale-110 transition-transform">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="w-7 h-auto">
            </div>
            <div class="flex flex-col">
                <span class="text-white text-lg font-black tracking-tight leading-none">Jatara<span class="text-{{ $theme['accent'] }}-500">.</span></span>
                <span class="text-[9px] font-bold text-gray-500 uppercase tracking-[0.2em] mt-1">{{ $theme['label'] }}</span>
            </div>
        </a>
        
        <button @click="sidebarOpen = !sidebarOpen" class="block lg:hidden text-gray-400 hover:text-white transition-colors">
            <i class="fas fa-times text-xl"></i>
        </button>
    </div>

    <!-- Sidebar Menus -->
    <div class="no-scrollbar flex flex-col flex-1 overflow-y-auto px-4">
        <nav class="py-4">
            
            <div class="flex items-center gap-3 mb-6 px-4">
                <div class="h-px flex-1 bg-gradient-to-r from-transparent to-white/5"></div>
                <span class="text-[9px] font-black text-gray-500 uppercase tracking-[0.3em]">Main Menu</span>
                <div class="h-px flex-1 bg-gradient-to-l from-transparent to-white/5"></div>
            </div>
            
            <ul class="flex flex-col gap-1.5">
                @if ($is_admin)
                    @php
                        $adminMenus = [
                            ['route' => 'admin.dashboard', 'icon' => 'fas fa-th-large', 'label' => 'Dashboard'],
                            ['route' => 'admin.mitra.index', 'icon' => 'fas fa-users-viewfinder', 'label' => 'Kelola Mitra'],
                            ['route' => 'admin.kendaraan.index', 'icon' => 'fas fa-car-rear', 'label' => 'Semua Armada'],
                            ['route' => 'admin.booking.monitor', 'icon' => 'fas fa-clock-rotate-left', 'label' => 'Monitor Booking'],
                        ];
                    @endphp

                    @foreach($adminMenus as $menu)
                        @php $isActive = Request::routeIs($menu['route']) || (strpos($menu['route'], 'kendaraan') !== false && Request::routeIs('admin.kendaraan.*')); @endphp
                        <li>
                            <a href="{{ route($menu['route']) }}"
                               class="group relative flex items-center gap-3.5 rounded-xl px-4 py-3 text-sm font-bold transition-all duration-300 {{ $isActive ? 'bg-white/5 text-white shadow-lg' : 'text-gray-400 hover:text-white hover:bg-white/[0.02]' }}">
                                
                                @if($isActive)
                                    <div class="absolute left-0 top-2 bottom-2 w-1 bg-{{ $theme['accent'] }}-500 rounded-full shadow-[0_0_10px_{{ $theme['accent_hex'] }}]"></div>
                                @endif

                                <i class="{{ $menu['icon'] }} w-5 text-center text-base {{ $isActive ? 'text-'.$theme['accent'].'-400' : 'group-hover:text-white' }} transition-colors"></i>
                                {{ $menu['label'] }}

                                @if($menu['route'] === 'admin.booking.monitor')
                                    @php $pendingCount = \App\Models\Booking::where('status', 'Pending')->count(); @endphp
                                    @if ($pendingCount > 0)
                                        <span class="ml-auto flex h-5 w-5 items-center justify-center rounded-lg bg-{{ $theme['accent'] }}-500 text-[10px] font-black text-white shadow-lg shadow-{{ $theme['accent'] }}-500/20">{{ $pendingCount }}</span>
                                    @endif
                                @endif
                            </a>
                        </li>
                    @endforeach
                @else
                    @php
                        $mitraMenus = [
                            ['route' => 'mitra.dashboard', 'icon' => 'fas fa-gauge-high', 'label' => 'Dashboard'],
                            ['route' => 'mitra.monitoring', 'icon' => 'fas fa-location-crosshairs', 'label' => 'GPS Tracking'],
                            ['route' => 'mitra.vehicles.index', 'icon' => 'fas fa-car-side', 'label' => 'Armada Saya'],
                            ['route' => 'mitra.drivers.index', 'icon' => 'fas fa-id-card', 'label' => 'Kelola Sopir'],
                            ['route' => 'mitra.booking.index', 'icon' => 'fas fa-calendar-check', 'label' => 'Kelola Booking'],
                        ];
                    @endphp

                    @foreach($mitraMenus as $menu)
                        @php $isActive = Request::routeIs($menu['route']) || (isset($menu['query']) && Request::get($menu['query'])); @endphp
                        <li>
                            <a href="{{ route($menu['route']) }}"
                               class="group relative flex items-center gap-3.5 rounded-xl px-4 py-3 text-sm font-bold transition-all duration-300 {{ $isActive ? 'bg-white/5 text-white shadow-lg' : 'text-gray-400 hover:text-white hover:bg-white/[0.02]' }}">
                                
                                @if($isActive)
                                    <div class="absolute left-0 top-2 bottom-2 w-1 bg-{{ $theme['accent'] }}-500 rounded-full shadow-[0_0_10px_{{ $theme['accent_hex'] }}]"></div>
                                @endif

                                <i class="{{ $menu['icon'] }} w-5 text-center text-base {{ $isActive ? 'text-'.$theme['accent'].'-400' : 'group-hover:text-white' }} transition-colors"></i>
                                {{ $menu['label'] }}
                            </a>
                        </li>
                    @endforeach
                @endif
            </ul>

            <div class="flex items-center gap-3 mb-6 px-4 mt-10">
                <div class="h-px flex-1 bg-gradient-to-r from-transparent to-white/5"></div>
                <span class="text-[9px] font-black text-gray-500 uppercase tracking-[0.3em]">Settings</span>
                <div class="h-px flex-1 bg-gradient-to-l from-transparent to-white/5"></div>
            </div>
            
            <ul class="flex flex-col gap-1.5 mb-8">
                @php $profileRoute = $is_admin ? 'admin.profile' : 'mitra.profile'; @endphp
                <li>
                    <a href="{{ route($profileRoute) }}"
                       class="group flex items-center gap-3.5 rounded-xl px-4 py-3 text-sm font-bold transition-all {{ Request::routeIs($profileRoute) ? 'bg-white/5 text-white' : 'text-gray-400 hover:text-white hover:bg-white/[0.02]' }}">
                        <i class="fas fa-circle-user w-5 text-center text-base {{ Request::routeIs($profileRoute) ? 'text-'.$theme['accent'].'-400' : 'group-hover:text-white' }}"></i>
                        Pengaturan Profil
                    </a>
                </li>
                <li>
                    <a href="{{ route('home') }}" target="_blank"
                       class="group flex items-center gap-3.5 rounded-xl px-4 py-3 text-sm font-bold text-gray-400 hover:text-white hover:bg-white/[0.02] transition-all">
                        <i class="fas fa-up-right-from-square w-5 text-center text-base group-hover:text-white"></i>
                        Pratinjau Situs
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Sidebar Footer / Account Card -->
    <div class="p-4 mt-auto">
        <div class="bg-white/5 rounded-2xl p-4 border border-white/5 relative overflow-hidden group">
            {{-- Background Decor --}}
            <div class="absolute -right-6 -bottom-6 w-20 h-20 bg-{{ $theme['accent'] }}-500/10 rounded-full blur-xl group-hover:scale-150 transition-transform duration-700"></div>
            
            <div class="flex items-center gap-3 relative z-10">
                <div class="w-10 h-10 rounded-xl bg-{{ $theme['accent'] }}-500/20 flex items-center justify-center text-{{ $theme['accent'] }}-400 border border-{{ $theme['accent'] }}-500/20 shadow-inner">
                    <i class="fas fa-user-gear"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-bold text-white truncate">{{ $user->name ?? 'User' }}</p>
                    <p class="text-[9px] font-medium text-gray-500 uppercase tracking-wider truncate">{{ $role }}</p>
                </div>
            </div>
            
            <form action="{{ route('logout') }}" method="POST" class="mt-4 relative z-10">
                @csrf
                <button type="submit" class="w-full py-2 px-4 bg-white/5 hover:bg-error-500 hover:text-white text-gray-400 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all active:scale-95 flex items-center justify-center gap-2 border border-white/5">
                    <i class="fas fa-power-off text-[9px]"></i>
                    Logout System
                </button>
            </form>
        </div>
    </div>
</aside>