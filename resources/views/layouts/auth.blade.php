<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Login') - RentDrive</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen flex">

    {{-- Left Panel --}}
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-blue-900 to-blue-600 text-white flex-col justify-between p-12 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-80 h-80 bg-white rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-300 rounded-full blur-3xl"></div>
        </div>
        <div class="relative z-10">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-car text-white"></i>
                </div>
                <span class="font-extrabold text-2xl">Rent<span class="text-blue-200">Drive</span></span>
            </a>
        </div>
        <div class="relative z-10">
            <h2 class="text-4xl font-black leading-tight mb-4">Mulai Perjalanan<br>Anda Hari Ini</h2>
            <p class="text-blue-200 text-lg">Armada terlengkap, harga transparan, pengalaman sewa yang menyenangkan.</p>
            <div class="grid grid-cols-3 gap-4 mt-10">
                <div class="bg-white/15 backdrop-blur-sm rounded-2xl p-4 text-center">
                    <p class="text-2xl font-black">500+</p>
                    <p class="text-blue-200 text-xs mt-1">Armada Unit</p>
                </div>
                <div class="bg-white/15 backdrop-blur-sm rounded-2xl p-4 text-center">
                    <p class="text-2xl font-black">50K+</p>
                    <p class="text-blue-200 text-xs mt-1">Pelanggan</p>
                </div>
                <div class="bg-white/15 backdrop-blur-sm rounded-2xl p-4 text-center">
                    <p class="text-2xl font-black">4.9⭐</p>
                    <p class="text-blue-200 text-xs mt-1">Rating</p>
                </div>
            </div>
        </div>
        <div class="relative z-10 text-sm text-blue-200">
            &copy; {{ date('Y') }} RentDrive Indonesia
        </div>
    </div>

    {{-- Right: Form --}}
    <div class="flex-1 flex items-center justify-center p-6 sm:p-12">
        <div class="w-full max-w-md">
            {{-- Mobile logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2 mb-10 lg:hidden">
                <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-car text-white text-sm"></i>
                </div>
                <span class="font-extrabold text-xl">Rent<span class="text-blue-600">Drive</span></span>
            </a>

            @yield('form-content')
        </div>
    </div>

</body>
</html>
