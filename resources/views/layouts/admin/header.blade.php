<!-- Header TailAdmin -->
<header class="sticky top-0 z-30 flex w-full bg-white dark:bg-[#1c2434] shadow-sm tracking-wide border-b border-stroke dark:border-white/5">
    <div class="flex flex-grow items-center justify-between px-4 py-4 md:px-6 2xl:px-11">
        
        <!-- Hamburger Menu -->
        <div class="flex items-center gap-2 sm:gap-4 lg:hidden">
            <button @click.stop="sidebarOpen = !sidebarOpen" class="z-50 block rounded-sm border border-stroke bg-white p-1.5 shadow-sm dark:border-white/10 dark:bg-[#1c2434]">
                <i class="fas fa-bars w-5 h-5 text-black dark:text-white flex items-center justify-center"></i>
            </button>
            <a class="block flex-shrink-0 lg:hidden" href="{{ route('home') }}">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="w-8 h-8 rounded-full shadow-sm bg-white p-1">
            </a>
        </div>

        <div class="hidden sm:block">
            <h1 class="text-xl font-bold text-black dark:text-white drop-shadow-sm">Welcome, {{ Auth::user()->name }}</h1>
        </div>

        <div class="flex items-center gap-3 space-x-3 sm:space-x-5 lg:gap-5">
            
            <!-- Dark Mode Toggler -->
            <label class="relative m-0 block h-7.5 w-14 rounded-full bg-stroke dark:bg-primary cursor-pointer">
                <input type="checkbox"
                       @change="darkMode = !darkMode"
                       :checked="darkMode"
                       class="absolute top-0 z-50 m-0 h-full w-full cursor-pointer opacity-0" />
                <span class="absolute top-1/2 left-1 -translate-y-1/2 w-6 h-6 rounded-full bg-white transition-all duration-300 dark:left-7 flex items-center justify-center">
                    <i class="fas fa-sun text-yellow-500 text-xs" x-show="!darkMode"></i>
                    <i class="fas fa-moon text-blue-500 text-xs" x-show="darkMode" x-cloak></i>
                </span>
            </label>

            <!-- User Area -->
            <div class="relative" x-data="{ dropdownOpen: false }" @click.outside="dropdownOpen = false">
                <button class="flex items-center gap-3 focus:outline-none" @click="dropdownOpen = !dropdownOpen">
                    <span class="hidden text-right lg:block">
                        <span class="block text-sm font-semibold text-black dark:text-white">{{ Auth::user()->name }}</span>
                        <span class="block text-xs font-medium uppercase">{{ Auth::user()->role }}</span>
                    </span>

                    <span class="h-10 w-10 rounded-full border border-stroke dark:border-white/10 shrink-0 bg-gray-100 flex items-center justify-center text-primary font-bold text-lg shadow-sm">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </span>
                    <i class="fas fa-chevron-down text-sm text-bodydark hidden sm:block transition-transform" :class="dropdownOpen ? 'rotate-180' : ''"></i>
                </button>

                <!-- Dropdown -->
                <div x-show="dropdownOpen" x-transition.opacity
                     class="absolute right-0 mt-4 flex w-56 flex-col rounded-xl border border-stroke bg-white shadow-lg dark:border-white/10 dark:bg-[#1c2434]" x-cloak>
                    <ul class="flex flex-col gap-0 border-b border-stroke px-4 py-3 dark:border-white/10">
                        <li>
                            <a href="{{ route(Auth::user()->role === 'admin' ? 'admin.profile' : 'mitra.profile') }}" class="flex items-center gap-3 text-sm font-medium text-body hover:text-primary dark:hover:text-white rounded-lg px-2 py-2 hover:bg-gray-100 dark:hover:bg-white/5 transition-colors">
                                <i class="fas fa-user w-5 text-center"></i> Profil Saya
                            </a>
                        </li>
                    </ul>
                    <form action="{{ route('logout') }}" method="POST" class="p-3">
                        @csrf
                        <button type="submit" class="flex w-full items-center gap-3 px-2 py-2 text-sm font-bold text-red-500 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-500/10 rounded-lg transition-colors">
                            <i class="fas fa-arrow-right-from-bracket w-5 text-center"></i> Keluar
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</header>