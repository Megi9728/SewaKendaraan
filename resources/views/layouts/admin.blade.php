<!DOCTYPE html>
<html lang="id" class="antialiased" x-data="{ sidebarOpen: false, darkMode: false }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - Jatara Admin Panel</title>
    <link rel="icon" href="data:,">
    
    <!-- AlpineJS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#465fff',
                        brand: {
                            50: '#ecf3ff',
                            100: '#dde9ff',
                            200: '#c2d6ff',
                            300: '#9cb9ff',
                            400: '#7592ff',
                            500: '#465fff',
                            600: '#3641f5',
                            700: '#2a31d8',
                            800: '#252dae',
                            900: '#262e89',
                        },
                        gray: {
                            25: '#fcfcfd',
                            50: '#f9fafb',
                            100: '#f2f4f7',
                            200: '#e4e7ec',
                            300: '#d0d5dd',
                            400: '#98a2b3',
                            500: '#667085',
                            600: '#475467',
                            700: '#344054',
                            800: '#1d2939',
                            900: '#101828',
                        },
                        success: {
                            50: '#ecfdf3',
                            500: '#12b76a',
                            600: '#039855',
                        },
                        error: {
                            50: '#fef3f2',
                            500: '#f04438',
                            600: '#d92d20',
                        },
                        warning: {
                            50: '#fffaeb',
                            500: '#f79009',
                            600: '#dc6803',
                        },
                        dark: '#101828',
                        boxdark: '#1D2939',
                        stroke: '#e4e7ec',
                        whiten: '#F9FAFB',
                        body: '#475467',
                        bodydark: '#98A2B3',
                    },
                    fontFamily: {
                        sans: ['Outfit', 'Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Google Fonts & FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #E2E8F0; border-radius: 10px; }
        .dark ::-webkit-scrollbar-thumb { background: #333A48; }
        
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
</head>
<body class="bg-whiten dark:bg-dark text-body dark:text-bodydark overflow-hidden">

<div class="flex h-screen overflow-hidden">

    <!-- Sidebar -->
    @include('layouts.admin.sidebar')

    <!-- Content Area -->
    <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">
        
        <!-- Header -->
        @include('layouts.admin.header')

        <!-- Main Content -->
        <main>
            <div class="mx-auto max-w-screen-2xl p-4 md:p-6">
                @yield('content')
            </div>
        </main>
        
    </div>

</div>

@stack('scripts')
</body>
</html>