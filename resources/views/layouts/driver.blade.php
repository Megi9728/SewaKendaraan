<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Driver') - Jatara Driver Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <style type="text/tailwindcss">
        @layer base {
            body { font-family: 'Inter', sans-serif; @apply bg-slate-50 text-slate-900 antialiased; }
        }
    </style>
    @stack('styles')
</head>
<body>

    {{-- Simple Driver Header --}}
    <header class="h-20 bg-white border-b border-slate-100 px-6 lg:px-12 flex items-center justify-between sticky top-0 z-50">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-100">
                <i class="fas fa-steering-wheel text-lg"></i>
            </div>
            <div>
                <h1 class="text-lg font-black text-slate-900 leading-none">Driver Hub</h1>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Jatara Rental</p>
            </div>
        </div>

        <div class="flex items-center gap-6">
            <div class="hidden sm:flex flex-col items-end">
                <span class="text-xs font-black text-slate-900 uppercase tracking-widest">{{ now()->translatedFormat('l') }}</span>
                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">{{ now()->translatedFormat('d F') }}</span>
            </div>
            
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-2 bg-slate-900 hover:bg-red-600 text-white px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all shadow-lg shadow-slate-200">
                    <i class="fas fa-power-off"></i>
                    <span class="hidden md:inline">Keluar</span>
                </button>
            </form>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="max-w-7xl mx-auto px-6 py-10 lg:py-16">
        @yield('content')
    </main>

    <footer class="py-10 text-center border-t border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">
        &copy; {{ date('Y') }} Jatara Rental System &bull; Driver Monitoring Panel
    </footer>

    @stack('scripts')
</body>
</html>
