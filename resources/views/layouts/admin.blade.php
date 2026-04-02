<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - RentDrive Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-link { @apply flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-white/10 hover:text-white transition-all text-sm font-medium; }
        .sidebar-link.active { @apply bg-white/15 text-white font-semibold; }
        .sidebar-link .icon { @apply w-5 text-center; }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-100 text-white/80 antialiased">

<div class="flex h-screen overflow-hidden">

    {{-- ===== SIDEBAR ===== --}}
    <aside id="sidebar" class="w-64 bg-slate-900 flex flex-col flex-shrink-0 transition-all duration-300">

        {{-- Logo --}}
        <div class="p-6 border-b border-white/10">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5" target="_blank">
                <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-car text-white text-sm"></i>
                </div>
                <span class="font-extrabold text-lg text-white">Rent<span class="text-blue-400">Drive</span></span>
            </a>
            <span class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-1 block">Admin Panel</span>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
            <p class="text-[10px] text-slate-600 font-bold uppercase tracking-widest px-4 pt-2 pb-2">Menu Utama</p>

            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="icon fas fa-chart-pie"></i> Dashboard
            </a>

            <a href="{{ route('admin.kendaraan') }}"
               class="sidebar-link {{ Request::routeIs('admin.kendaraan') ? 'active' : '' }}">
                <i class="icon fas fa-car"></i> Kelola Armada
            </a>

            <a href="{{ route('admin.pemesanan') }}"
               class="sidebar-link {{ Request::routeIs('admin.pemesanan') ? 'active' : '' }}">
                <i class="icon fas fa-calendar-check"></i> Pemesanan
                <span class="ml-auto bg-blue-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">3</span>
            </a>

            <p class="text-[10px] text-slate-600 font-bold uppercase tracking-widest px-4 pt-4 pb-2">Lainnya</p>

            <a href="{{ route('home') }}" target="_blank" class="sidebar-link">
                <i class="icon fas fa-globe"></i> Lihat Website
            </a>

            <a href="#" class="sidebar-link text-red-400 hover:bg-red-500/10 hover:text-red-400">
                <i class="icon fas fa-sign-out-alt"></i> Keluar
            </a>
        </nav>

        {{-- Admin Badge --}}
        <div class="p-4 border-t border-white/10">
            <div class="flex items-center gap-3 px-4 py-3 bg-white/5 rounded-xl">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-sm">A</div>
                <div class="min-w-0">
                    <p class="text-white text-sm font-semibold truncate">Admin RentDrive</p>
                    <p class="text-slate-500 text-xs">Super Admin</p>
                </div>
            </div>
        </div>
    </aside>

    {{-- ===== MAIN AREA ===== --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Top Bar --}}
        <header class="bg-white border-b border-slate-200 px-8 h-16 flex items-center justify-between flex-shrink-0">
            <div class="flex items-center gap-4">
                <button id="sidebar-toggle" class="text-slate-40 hover:text-slate-700 transition-colors lg:hidden">
                    <i class="fas fa-bars"></i>
                </button>
                <div>
                    <h1 class="text-lg font-bold text-slate-900">@yield('page-title', 'Dashboard')</h1>
                    <p class="text-xs text-slate-400">@yield('page-subtitle', 'Ringkasan performa hari ini')</p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                {{-- Date --}}
                <span class="hidden sm:block text-xs text-slate-400 font-medium">
                    <i class="far fa-calendar mr-1"></i>
                    {{ now()->translatedFormat('l, d F Y') }}
                </span>

                {{-- Notification --}}
                <button class="relative w-9 h-9 bg-slate-100 hover:bg-slate-200 rounded-xl flex items-center justify-center text-slate-500 transition-all">
                    <i class="fas fa-bell text-sm"></i>
                    <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center">3</span>
                </button>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="flex-1 overflow-y-auto p-6 sm:p-8">
            @yield('content')
        </main>
    </div>
</div>

<script>
    // Mobile sidebar toggle
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sidebar');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });
    }
</script>
@stack('scripts')
</body>
</html>
