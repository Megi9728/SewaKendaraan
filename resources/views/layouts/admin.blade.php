<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - RentDrive Admin Panel</title>
    <link rel="icon" href="data:,">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <style type="text/tailwindcss">
        @layer components {
            .sidebar { transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1); @apply -translate-x-full; }
            .sidebar-link { @apply flex items-center gap-3 px-5 py-3.5 rounded-2xl text-slate-400 hover:bg-white/10 hover:text-white transition-all text-sm font-medium border border-transparent; }
            .sidebar-link.active { @apply bg-blue-600 text-white font-bold shadow-lg shadow-blue-600/20 border-blue-500; }
            .sidebar-link .icon { @apply w-5 text-center text-lg; }
            
            .main-content { transition: padding 0.4s cubic-bezier(0.4, 0, 0.2, 1); @apply pl-0; }

            /* State: OPEN */
            body.sidebar-open .sidebar { @apply translate-x-0; }
            body.sidebar-open #sidebar-backdrop { @apply block lg:hidden pb-10; }
            
            @media (min-width: 1024px) {
                body.sidebar-open .main-content { @apply pl-80; }
            }

            .custom-scrollbar::-webkit-scrollbar { width: 5px; }
            .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
            .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
            .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.2); }
        }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-100 text-slate-900 antialiased overflow-x-hidden sidebar-open">

<div class="flex h-screen overflow-hidden relative">

    {{-- Backdrop for mobile --}}
    <div id="sidebar-backdrop" class="fixed inset-0 bg-slate-900/60 z-40 hidden backdrop-blur-sm transition-opacity" onclick="toggleSidebarMenu()"></div>

    @include('layouts.admin.sidebar')

    {{-- ===== MAIN AREA ===== --}}
    <div id="main-content" class="main-content flex-1 flex flex-col min-w-0 bg-slate-100">
        
        @include('layouts.admin.header')

        {{-- Content Area --}}
        <main class="flex-1 overflow-y-auto px-6 py-8 lg:px-10 lg:py-10">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>
    </div>
</div>

<script>
    function toggleSidebarMenu() {
        document.body.classList.toggle('sidebar-open');
        
        // Handle overflow-hidden on mobile to prevent scroll
        if (window.innerWidth < 1024) {
            if (document.body.classList.contains('sidebar-open')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        }
    }

    // Ensure state is clean on resize
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024) {
            document.body.style.overflow = '';
        } else if (document.body.classList.contains('sidebar-open')) {
            document.body.style.overflow = 'hidden';
        }
    });
</script>
@stack('scripts')
</body>
</html>
