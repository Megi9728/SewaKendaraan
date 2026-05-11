<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Jatara - Platform sewa kendaraan terpercaya di Indonesia. Pilih dari ratusan armada mobil dan motor berkualitas.">
    <title>@yield('title', 'Jatara') - Sewa Kendaraan Terpercaya</title>
    <link rel="icon" href="data:,">

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        uber: {
                            black: '#000000',
                            white: '#ffffff',
                            hover: '#e2e2e2',
                            chip: '#efefef',
                            text: '#4b4b4b',
                            muted: '#afafaf'
                        }
                    },
                    boxShadow: {
                        'uber': 'rgba(0, 0, 0, 0.12) 0px 4px 16px 0px',
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .nav-link {
            @apply text-[#0A174E] hover:bg-[#EBEBDF] font-medium transition-colors duration-200 text-sm px-4 py-2.5 rounded-full;
        }

        .btn-primary {
            @apply bg-[#0A174E] hover:bg-gray-800 active:scale-95 text-white font-medium px-6 py-3 rounded-full transition-all duration-200;
        }

        .btn-secondary {
            @apply bg-[#EBEBDF] hover:bg-[#D4D4C3] active:scale-95 text-[#0A174E] font-medium px-6 py-3 rounded-full transition-all duration-200 text-sm;
        }
    </style>

    @stack('styles')

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-white text-[#0A174E] antialiased">
    @include('partials.navbar')

    {{-- ===== KONTEN UTAMA ===== --}}
    <main>
        @yield('content')
    </main>

            {{-- ===== FOOTER ===== --}}
    <footer class="px-4 md:px-8 pb-4">
        <div class="max-w-[1400px] mx-auto bg-[#0A174E] text-[#EBEBDF] rounded-[2rem] p-10 md:p-16 lg:p-20 relative overflow-hidden">
            <!-- Dekorasi Blur Latar Belakang -->
            <div class="absolute top-0 left-0 w-64 h-64 bg-[#F5D042] rounded-full mix-blend-multiply filter blur-[128px] opacity-10 pointer-events-none"></div>
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 relative z-10">
                <!-- Sisi Kiri: Logo & Newsletter -->
                <div class="lg:col-span-5 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-3 mb-10">
                            <!-- Logo Box Putih Kecil untuk Kontras -->
                            <div class="bg-white p-2 rounded-xl">
                                <img src="{{ asset('logo.png') }}" alt="Jatara Logo" class="h-8 w-auto">
                            </div>
                            <span class="text-white text-3xl font-bold tracking-tight font-sans">Jatara</span>
                        </div>
                        
                        <div class="mb-10 lg:mb-0">
                            <h4 class="text-white text-xl font-bold mb-4">Berlangganan buletin kami</h4>
                            <form class="flex flex-col sm:flex-row gap-3">
                                <input type="email" placeholder="Masukkan alamat email Anda" class="w-full sm:flex-1 bg-white/10 border border-white/10 text-white placeholder-gray-400 px-5 py-3.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#F5D042] transition">
                                <button type="submit" class="bg-[#F5D042] hover:bg-[#ebc532] text-[#0A174E] font-bold px-7 py-3.5 rounded-xl transition duration-300 whitespace-nowrap">Berlangganan!</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Bagian Kanan Lanjutan (3 Kolom Menu) -->
                <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-3 gap-10">
                    <!-- Kolom 1 -->
                    <div>
                        <h4 class="text-white text-lg font-bold mb-6">Halaman</h4>
                        <ul class="space-y-4 font-medium text-sm text-[#EBEBDF]/80">
                            <li><a href="{{ route('home') }}" class="hover:text-[#F5D042] transition-colors {{ request()->routeIs('home') ? 'text-[#F5D042]' : '' }}">Beranda</a></li>
                            <li><a href="{{ route('how.it.works') }}" class="hover:text-[#F5D042] transition-colors {{ request()->routeIs('how.it.works') ? 'text-[#F5D042]' : '' }}">Tentang</a></li>
                            <li><a href="{{ route('browse') }}" class="hover:text-[#F5D042] transition-colors {{ request()->routeIs('browse') ? 'text-[#F5D042]' : '' }}">Kendaraan</a></li>
                            <li><a href="#" class="hover:text-[#F5D042] transition-colors">Kontak</a></li>
                            <li><a href="#" class="hover:text-[#F5D042] transition-colors">Blog</a></li>
                        </ul>
                    </div>
                    
                    <!-- Kolom 2 -->
                    <div>
                        <h4 class="text-white text-lg font-bold mb-6">Layanan</h4>
                        <ul class="space-y-4 font-medium text-sm text-[#EBEBDF]/80">
                            <li><a href="#" class="hover:text-[#F5D042] transition-colors">Syarat & Ketentuan</a></li>
                            <li><a href="{{ route('help') }}" class="hover:text-[#F5D042] transition-colors {{ request()->routeIs('help') ? 'text-[#F5D042]' : '' }}">Bantuan</a></li>
                            <li><a href="#" class="hover:text-[#F5D042] transition-colors">Lisensi</a></li>
                            <li><a href="#" class="hover:text-[#F5D042] transition-colors">Kebijakan Privasi</a></li>
                            <li><a href="#" class="hover:text-[#F5D042] transition-colors">Link in Bio</a></li>
                        </ul>
                    </div>

                    <!-- Kolom 3 -->
                    <div>
                        <h4 class="text-white text-lg font-bold mb-6">Lainnya</h4>
                        <ul class="space-y-4 font-medium text-sm text-[#EBEBDF]/80">
                            <li><a href="#" class="hover:text-[#F5D042] transition-colors">Segera Hadir</a></li>
                            <li><a href="#" class="hover:text-[#F5D042] transition-colors">Dilindungi Sandi</a></li>
                            <li><a href="#" class="hover:text-[#F5D042] transition-colors">Error 404</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="mt-16 pt-8 border-t border-white/10 flex flex-col md:flex-row justify-between items-center gap-6 relative z-10">
                <p class="text-sm font-medium text-[#EBEBDF]/60">Dibuat oleh <a href="#" class="text-[#F5D042] hover:underline">SewaKendaraan</a>. Didukung oleh <a href="https://laravel.com" target="_blank" class="text-[#F5D042] hover:underline">Laravel</a></p>
                <div class="flex gap-4">
                    <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-white hover:bg-[#F5D042] hover:text-[#0A174E] transition-all duration-300">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-white hover:bg-[#F5D042] hover:text-[#0A174E] transition-all duration-300">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-white hover:bg-[#F5D042] hover:text-[#0A174E] transition-all duration-300">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    {{-- ===== VANILLA JS ===== --}}
    <script>
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');

        window.openMobileMenu = function() {
            if (mobileMenu && mobileMenuOverlay) {
                mobileMenuOverlay.classList.remove('pointer-events-none');
                setTimeout(() => {
                    mobileMenuOverlay.classList.remove('opacity-0');
                    mobileMenu.classList.remove('-translate-y-full');
                }, 10);
                document.body.classList.add('overflow-hidden');
            }
        };

        window.closeMobileMenu = function() {
            if (mobileMenu && mobileMenuOverlay) {
                mobileMenuOverlay.classList.add('opacity-0');
                mobileMenu.classList.add('-translate-y-full');
                setTimeout(() => {
                    mobileMenuOverlay.classList.add('pointer-events-none');
                }, 500);
                document.body.classList.remove('overflow-hidden');
            }
        };
    </script>

    @stack('scripts')
</body>

</html>
