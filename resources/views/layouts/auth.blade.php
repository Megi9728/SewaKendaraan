<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Autentikasi') - RentDrive</title>
    
    {{-- Tailwind CSS & Inter Font --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        uber: {
                            black: '#000000',
                            white: '#ffffff',
                            chip: '#efefef',
                            text: '#4b4b4b',
                            muted: '#afafaf'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body { font-family: 'Inter', sans-serif; }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-form { animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) both; }

        .input-uber { 
            @apply w-full px-6 py-4 bg-uber-chip border-2 border-transparent rounded-lg text-uber-black font-bold transition-all outline-none placeholder:font-medium placeholder:text-uber-muted; 
        }
        .input-uber:focus {
            @apply border-uber-black bg-uber-white;
        }
        .btn-uber-primary { @apply bg-uber-black text-uber-white font-bold py-4 rounded-full hover:bg-gray-800 active:scale-95 transition-all shadow-lg shadow-black/10 text-center; }
        .btn-uber-secondary { @apply bg-uber-white border border-gray-200 text-uber-black font-bold py-4 rounded-full hover:bg-uber-chip active:scale-95 transition-all text-center; }
    </style>
</head>
<body class="bg-uber-white min-h-screen flex">

    {{-- Left Panel (Desktop Branding) --}}
    <div class="hidden lg:flex lg:w-1/2 bg-uber-black text-uber-white flex-col justify-between p-20 relative overflow-hidden">
        {{-- Decorative background text (Brutalist style) --}}
        <div class="absolute -bottom-10 -left-10 text-[20rem] font-black opacity-5 select-none pointer-events-none">
            DRIVE
        </div>

        <div class="relative z-10">
            <a href="{{ route('home') }}" class="text-3xl font-black tracking-tighter">
                RentDrive.
            </a>
        </div>

        <div class="relative z-10 max-w-lg">
            <h2 class="text-6xl font-bold leading-[1.1] tracking-tighter mb-8">
                Kebebasan Jalan Ada di Tangan Anda.
            </h2>
            <p class="text-xl text-uber-muted font-medium mb-12">
                Bergabunglah dengan ribuan pengemudi yang telah mempercayakan perjalanan mereka bersama kami.
            </p>
            
            <div class="grid grid-cols-2 gap-10 border-t border-white/10 pt-10">
                <div>
                    <p class="text-4xl font-bold tracking-tighter">500+</p>
                    <p class="text-[10px] font-bold text-uber-muted uppercase tracking-[0.2em] mt-2">Armada Unit</p>
                </div>
                <div>
                    <p class="text-4xl font-bold tracking-tighter">15m</p>
                    <p class="text-[10px] font-bold text-uber-muted uppercase tracking-[0.2em] mt-2">Verifikasi</p>
                </div>
            </div>
        </div>

        <div class="relative z-10 text-xs font-bold text-uber-muted uppercase tracking-widest">
            &copy; {{ date('Y') }} RentDrive Technologies Inc.
        </div>
    </div>

    {{-- Right Panel (Form) --}}
    <div class="flex-1 flex items-center justify-center p-8 md:p-16">
        <div class="w-full max-w-md">
            {{-- Mobile logo --}}
            <a href="{{ route('home') }}" class="text-2xl font-black tracking-tighter mb-12 block lg:hidden">
                RentDrive.
            </a>

            <div class="animate-form">
                @yield('form-content')
            </div>
        </div>
    </div>

</body>
</html>
