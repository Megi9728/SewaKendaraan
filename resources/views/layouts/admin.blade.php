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
                        primary: '#3C50E0',
                        dark: '#1c2434',
                        stroke: '#E2E8F0',
                        whiten: '#F1F5F9',
                        body: '#64748B',
                        bodydark: '#AEB7C0',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
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
            <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
                @yield('content')
            </div>
        </main>
        
    </div>

</div>

@stack('scripts')
</body>
</html>