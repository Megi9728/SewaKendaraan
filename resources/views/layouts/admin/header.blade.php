{{-- Header Bar --}}
<header class="h-20 lg:h-24 px-6 lg:px-10 flex items-center justify-between flex-shrink-0 bg-white border-b border-slate-200 sticky top-0 z-30">
    <div class="flex items-center gap-4">
        <button onclick="toggleSidebarMenu()" class="w-10 h-10 flex items-center justify-center text-slate-500 hover:bg-slate-100 rounded-xl transition-all">
            <i class="fas fa-bars-staggered"></i>
        </button>
        <div>
            <h1 class="text-xl font-black text-slate-900 tracking-tight">@yield('page-title', 'Dashboard')</h1>
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">@yield('page-subtitle', 'Monitoring Panel')</p>
        </div>
    </div>

    <div class="flex items-center gap-5">
        {{-- Date --}}
        <div class="hidden md:flex flex-col items-end mr-2">
            <span class="text-[10px] font-black text-slate-900 uppercase tracking-widest">{{ now()->translatedFormat('l') }}</span>
            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">{{ now()->translatedFormat('d F Y') }}</span>
        </div>

        {{-- Alert --}}
        <div class="relative">
            <button class="w-10 h-10 bg-slate-50 text-slate-500 flex items-center justify-center rounded-xl hover:bg-slate-100 transition-all">
                <i class="fas fa-bell text-sm"></i>
            </button>
            <span class="absolute top-0 right-0 w-3 h-3 bg-red-500 border-2 border-white rounded-full"></span>
        </div>
    </div>
</header>
