<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="RentDrive - Platform sewa kendaraan terpercaya di Indonesia. Pilih dari ratusan armada mobil dan motor berkualitas.">
    <title>@yield('title', 'RentDrive') - Sewa Kendaraan Terpercaya</title>

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50:  '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            900: '#1e3a8a',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body { font-family: 'Inter', sans-serif; }
        .nav-link { @apply text-slate-600 hover:text-blue-600 font-medium transition-colors duration-200 text-sm; }
        .btn-primary { @apply bg-blue-600 hover:bg-blue-700 active:scale-95 text-white font-semibold px-5 py-2.5 rounded-xl transition-all duration-200 shadow-sm; }
        .btn-ghost { @apply text-slate-600 hover:text-blue-600 hover:bg-blue-50 font-semibold px-4 py-2.5 rounded-xl transition-all duration-200 text-sm; }
    </style>

    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

    {{-- ===== NAVBAR ===== --}}
    <header id="navbar" class="fixed top-0 inset-x-0 z-50 transition-all duration-300">
        <nav class="bg-white/90 backdrop-blur-md border-b border-slate-200/80 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">

                    {{-- Logo --}}
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                        <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center shadow-md group-hover:shadow-blue-300 transition-shadow">
                            <i class="fas fa-car text-white text-sm"></i>
                        </div>
                        <span class="font-extrabold text-xl text-slate-900">Rent<span class="text-blue-600">Drive</span></span>
                    </a>

                    {{-- Desktop Nav --}}
                    <div class="hidden md:flex items-center gap-1">
                        <a href="{{ route('home') }}" class="nav-link px-4 py-2 rounded-xl hover:bg-slate-100">Beranda</a>
                        <a href="{{ route('browse') }}" class="nav-link px-4 py-2 rounded-xl hover:bg-slate-100">Jelajahi Armada</a>
                        <a href="{{ route('how.it.works') }}" class="nav-link px-4 py-2 rounded-xl hover:bg-slate-100">Cara Kerja</a>
                    </div>

                    {{-- Desktop CTA --}}
                    <div class="hidden md:flex items-center gap-3">
                        <a href="{{ route('login') }}" class="btn-ghost">Masuk</a>
                        <a href="{{ route('register') }}" class="btn-primary">Daftar Gratis</a>
                        {{-- Link testing admin --}}
                        <a href="{{ route('admin.dashboard') }}" class="text-xs text-slate-300 hover:text-blue-500 transition-colors ml-2" title="Admin Panel">
                            <i class="fas fa-lock"></i>
                        </a>
                    </div>

                    {{-- Mobile Hamburger --}}
                    <button id="menu-toggle" class="md:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100 transition">
                        <i id="menu-icon" class="fas fa-bars text-lg"></i>
                    </button>
                </div>
            </div>

            {{-- Mobile Dropdown Menu --}}
            <div id="mobile-menu" class="hidden md:hidden border-t border-slate-100">
                <div class="px-4 py-4 space-y-1">
                    <a href="{{ route('home') }}" class="block px-4 py-3 rounded-xl text-slate-700 font-medium hover:bg-blue-50 hover:text-blue-600 transition">
                        <i class="fas fa-home mr-2 w-4"></i> Beranda
                    </a>
                    <a href="{{ route('browse') }}" class="block px-4 py-3 rounded-xl text-slate-700 font-medium hover:bg-blue-50 hover:text-blue-600 transition">
                        <i class="fas fa-car mr-2 w-4"></i> Jelajahi Armada
                    </a>
                    <a href="{{ route('how.it.works') }}" class="block px-4 py-3 rounded-xl text-slate-700 font-medium hover:bg-blue-50 hover:text-blue-600 transition">
                        <i class="fas fa-info-circle mr-2 w-4"></i> Cara Kerja
                    </a>
                    <div class="pt-3 border-t border-slate-100 flex gap-3">
                        <a href="{{ route('login') }}" class="flex-1 text-center bg-slate-100 text-slate-700 font-semibold py-3 rounded-xl hover:bg-slate-200 transition text-sm">Masuk</a>
                        <a href="{{ route('register') }}" class="flex-1 text-center bg-blue-600 text-white font-semibold py-3 rounded-xl hover:bg-blue-700 transition text-sm">Daftar</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    {{-- Spacer for fixed navbar --}}
    <div class="h-16"></div>

    {{-- ===== KONTEN UTAMA ===== --}}
    <main>
        @yield('content')
    </main>

    {{-- ===== FOOTER ===== --}}
    <footer class="bg-slate-900 text-slate-400 mt-24">
        <div class="max-w-7xl mx-auto px-6 py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10">

                {{-- Brand --}}
                <div class="md:col-span-1">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center">
                            <i class="fas fa-car text-white text-sm"></i>
                        </div>
                        <span class="font-extrabold text-xl text-white">Rent<span class="text-blue-400">Drive</span></span>
                    </div>
                    <p class="text-sm leading-relaxed">Platform sewa kendaraan terpercaya di Indonesia. Armada terlengkap, harga transparan.</p>
                    <div class="flex gap-3 mt-5">
                        <a href="#" class="w-9 h-9 bg-slate-800 hover:bg-blue-600 rounded-lg flex items-center justify-center transition-colors"><i class="fab fa-instagram text-sm"></i></a>
                        <a href="#" class="w-9 h-9 bg-slate-800 hover:bg-blue-600 rounded-lg flex items-center justify-center transition-colors"><i class="fab fa-facebook-f text-sm"></i></a>
                        <a href="#" class="w-9 h-9 bg-slate-800 hover:bg-blue-600 rounded-lg flex items-center justify-center transition-colors"><i class="fab fa-whatsapp text-sm"></i></a>
                    </div>
                </div>

                {{-- Layanan --}}
                <div>
                    <h4 class="text-white font-bold text-sm uppercase tracking-wider mb-4">Layanan</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('browse') }}" class="hover:text-white hover:translate-x-1 inline-block transition-all">Sewa Mobil</a></li>
                        <li><a href="{{ route('browse') }}" class="hover:text-white hover:translate-x-1 inline-block transition-all">Sewa Motor</a></li>
                        <li><a href="#" class="hover:text-white hover:translate-x-1 inline-block transition-all">Sewa dengan Sopir</a></li>
                        <li><a href="#" class="hover:text-white hover:translate-x-1 inline-block transition-all">Sewa Jangka Panjang</a></li>
                    </ul>
                </div>

                {{-- Perusahaan --}}
                <div>
                    <h4 class="text-white font-bold text-sm uppercase tracking-wider mb-4">Perusahaan</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="#" class="hover:text-white hover:translate-x-1 inline-block transition-all">Tentang Kami</a></li>
                        <li><a href="{{ route('how.it.works') }}" class="hover:text-white hover:translate-x-1 inline-block transition-all">Cara Kerja</a></li>
                        <li><a href="#" class="hover:text-white hover:translate-x-1 inline-block transition-all">Blog</a></li>
                        <li><a href="#" class="hover:text-white hover:translate-x-1 inline-block transition-all">Karir</a></li>
                    </ul>
                </div>

                {{-- Kontak --}}
                <div>
                    <h4 class="text-white font-bold text-sm uppercase tracking-wider mb-4">Hubungi Kami</h4>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-start gap-3"><i class="fas fa-phone text-blue-400 mt-0.5"></i><span>+62 812-3456-7890</span></li>
                        <li class="flex items-start gap-3"><i class="fas fa-envelope text-blue-400 mt-0.5"></i><span>halo@rentdrive.id</span></li>
                        <li class="flex items-start gap-3"><i class="fas fa-map-marker-alt text-blue-400 mt-0.5"></i><span>Jl. Sudirman No. 88, Jakarta Pusat</span></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-slate-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-sm">
                <p>&copy; {{ date('Y') }} RentDrive Indonesia. Semua hak dilindungi.</p>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-white transition">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-white transition">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>

    {{-- ===== VANILLA JS: Mobile Menu & Navbar Scroll ===== --}}
    <script>
        // Mobile menu toggle
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        const menuIcon = document.getElementById('menu-icon');

        menuToggle.addEventListener('click', () => {
            const isHidden = mobileMenu.classList.toggle('hidden');
            menuIcon.className = isHidden ? 'fas fa-bars text-lg' : 'fas fa-times text-lg';
        });

        // Close mobile menu on outside click
        document.addEventListener('click', (e) => {
            if (!menuToggle.contains(e.target) && !mobileMenu.contains(e.target)) {
                mobileMenu.classList.add('hidden');
                menuIcon.className = 'fas fa-bars text-lg';
            }
        });
    </script>

    @stack('scripts')
</body>
</html>