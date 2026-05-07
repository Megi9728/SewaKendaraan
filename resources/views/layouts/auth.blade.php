<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">      
    <title>@yield('title', 'Autentikasi') - Jatara</title>

    {{-- Tailwind CSS & Inter Font --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        jatara: {
                            blue: '#0A174E',
                            yellow: '#F5D042',
                            light: '#EBEBDF',
                            gray: '#8F8F7E',
                            darkgray: '#D4D4C3'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style type="text/tailwindcss">
        @layer components {
            .input-jatara {
                @apply w-full px-4 py-3 bg-white border border-jatara-darkgray rounded-2xl text-jatara-blue font-semibold transition-all outline-none placeholder:font-medium placeholder:text-jatara-gray shadow-[0_2px_10px_rgba(0,0,0,0.02)];
            }
            .input-jatara:focus {
                @apply border-jatara-yellow ring-4 ring-jatara-yellow/20;
            }
            .btn-jatara-primary {
                @apply bg-jatara-blue text-white font-bold py-3.5 rounded-xl hover:bg-jatara-blue/90 active:scale-[0.98] transition-all shadow-[0_8px_20px_rgba(10,23,78,0.15)] flex justify-center items-center gap-2;
            }
            .btn-jatara-secondary {
                @apply bg-white border border-jatara-darkgray text-jatara-blue font-bold py-3.5 rounded-xl hover:border-jatara-yellow hover:bg-jatara-yellow/5 active:scale-[0.98] transition-all text-center flex justify-center items-center gap-2 shadow-sm;
            }
        }
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F9F9F5; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-form { animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) both; }

        
    </style>
</head>
<body class="min-h-screen flex overflow-x-hidden">

    {{-- Left Panel (Desktop Branding - Modern UI) --}}
    <div class="hidden lg:flex lg:w-[45%] bg-jatara-blue text-jatara-light flex-col justify-between p-12 xl:p-20 relative overflow-hidden">
        
        {{-- Modern decorative glowing orbs --}}
        <div class="absolute top-0 left-0 w-[500px] h-[500px] bg-jatara-yellow rounded-full mix-blend-multiply filter blur-[150px] opacity-20 pointer-events-none transform -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-[400px] h-[400px] bg-white rounded-full mix-blend-overlay filter blur-[120px] opacity-10 pointer-events-none transform translate-x-1/4 translate-y-1/4"></div>

        {{-- Big Graphic overlay --}}
        <div class="absolute -bottom-20 -right-20 opacity-10 pointer-events-none select-none">
            <i class="fas fa-car-side text-[350px] transform scale-x-[-1]"></i>
        </div>

        <div class="relative z-10 flex items-center gap-3">
            <div class="bg-white p-2.5 rounded-xl shadow-lg">
                <img src="{{ asset('logo.png') }}" onerror="this.outerHTML='<i class=\'fas fa-car text-jatara-blue text-xl\'></i>'" alt="Jatara Logo" class="h-8 w-auto">
            </div>
            <a href="{{ route('home') }}" class="text-3xl font-extrabold tracking-tight text-white">
                Jatara.
            </a>
        </div>

        <div class="relative z-10 max-w-lg mt-20 mb-auto">
            <h2 class="text-5xl xl:text-6xl font-extrabold leading-[1.1] tracking-tight mb-8 text-white"> 
                Perjalanan Premium<br><span class="text-jatara-yellow">Dimulai Dari Sini.</span>
            </h2>
            <p class="text-xl text-jatara-light/80 font-medium mb-12 leading-relaxed">
                Jelajahi dan sewa armada kendaraan terbaik dengan layanan kelas satu. Pilihan nomor satu untuk mobilitas Anda.
            </p>

            <div class="flex gap-10 bg-white/5 backdrop-blur-md border border-white/10 rounded-3xl p-8 inline-flex">
                <div>
                    <h3 class="text-2xl font-extrabold text-white uppercase tracking-tight">Eksklusif</h3>
                    <p class="text-[10px] font-bold text-jatara-yellow mt-1 uppercase tracking-widest">Armada Pilihan</p>
                </div>
                <div class="w-px bg-white/20"></div>
                <div>
                    <h3 class="text-2xl font-extrabold text-white uppercase tracking-tight">Terpercaya</h3>
                    <p class="text-[10px] font-bold text-jatara-yellow mt-1 uppercase tracking-widest">Layanan 24/7</p>
                </div>
            </div>
        </div>

        <div class="relative z-10 text-sm font-semibold text-jatara-light/60">
            &copy; {{ date('Y') }} Jatara Technologies Inc. Hak Cipta Dilindungi.
        </div>
    </div>

    {{-- Right Panel (Form) --}}
    <div class="flex-1 flex items-center justify-center p-4 sm:p-8 lg:p-10 relative">
        <div class="w-full max-w-[420px]">
            {{-- Mobile branding --}}
            <div class="flex items-center gap-3 mb-6 block lg:hidden">
                <div class="bg-jatara-blue p-2 rounded-xl shadow-md">
                    <img src="{{ asset('logo.png') }}" onerror="this.outerHTML='<i class=\'fas fa-car text-white text-lg\'></i>'" alt="Jatara Logo" class="h-6 w-auto">
                </div>
                <a href="{{ route('home') }}" class="text-2xl font-extrabold tracking-tight text-jatara-blue">
                    Jatara
                </a>
            </div>

            <div class="animate-form bg-white sm:shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:border border-jatara-darkgray/50 rounded-3xl sm:p-8">
                @yield('form-content')
            </div>
        </div>
    </div>

</body>
</html>