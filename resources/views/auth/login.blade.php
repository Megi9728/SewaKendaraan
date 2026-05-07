@extends('layouts.auth')

@section('title', 'Autentikasi')

@section('form-content')

    <div class="relative w-full overflow-hidden" id="auth-container">
        {{-- Form Slider Wrapper --}}
        <div id="form-slider"
            class="flex w-[200%] transition-transform duration-700 ease-[cubic-bezier(0.22,1,0.36,1)] {{ request()->routeIs('register') || old('_tab') == 'register' ? '-translate-x-1/2' : 'translate-x-0' }}">

            {{-- ============================== --}}
            {{-- LOGIN PANEL --}}
            {{-- ============================== --}}
            <div class="w-1/2 flex-shrink-0 px-1">
                <div class="mb-8 text-center lg:text-left">
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-[#0A174E] tracking-tighter mb-2">Selamat Datang.</h1>
                    <p class="text-[15px] sm:text-base text-[#8F8F7E] font-medium leading-relaxed max-w-sm mx-auto lg:mx-0">
                        Masuk ke akun Anda untuk akses eksklusif menikmati perjalanan premium.
                    </p>
                </div>

                {{-- OAUTH PLACEHOLDERS --}}
                <div class="grid grid-cols-1 gap-3 mb-6">
                    <a href="{{ route('auth.google') }}"
                        class="w-full flex items-center justify-center gap-3 py-3 border border-[#EBEBDF] rounded-xl text-[#0A174E] font-bold hover:bg-[#F9F9F5] transition-all active:scale-[0.98] shadow-sm relative overflow-hidden group">
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5 relative z-10"
                            alt="Google">
                        <span class="relative z-10">Lanjutkan dengan Google</span>
                    </a>
                </div>

                <div class="relative flex items-center gap-6 py-2 mb-6">
                    <div class="flex-1 h-px bg-[#EBEBDF]"></div>
                    <span class="text-[10px] text-[#8F8F7E] font-bold uppercase tracking-[0.2em] bg-white px-2">Atau
                        Email</span>
                    <div class="flex-1 h-px bg-[#EBEBDF]"></div>
                </div>

                <form class="space-y-4" action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <input type="hidden" name="_tab" value="login">

                    @if ($errors->any() && old('_tab') != 'register')
                        <div
                            class="p-3 bg-red-50 border border-red-100 text-red-600 rounded-xl text-xs font-bold leading-relaxed flex items-start gap-2">
                            <i class="fas fa-exclamation-triangle mt-0.5"></i>
                            <span>{{ $errors->first() }}</span>
                        </div>
                    @endif

                    {{-- Email --}}
                    <div class="space-y-1.5">
                        <label for="login-email"
                            class="text-[10px] font-bold text-[#8F8F7E] uppercase tracking-[0.2em] block pl-1">Alamat
                            Email</label>
                        <div class="relative group">
                            <input type="email" id="login-email" name="email"
                                value="{{ old('_tab') != 'register' ? old('email') : '' }}" placeholder="nama@email.com"
                                required class="input-jatara group-hover:border-[#0A174E]/30">
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="space-y-1.5">
                        <div class="flex justify-between items-center pl-1">
                            <label for="login-password"
                                class="text-[10px] font-bold text-[#8F8F7E] uppercase tracking-[0.2em] block">Sandi</label>
                            <a href="#"
                                class="text-[10px] text-[#0A174E] hover:text-[#F5D042] font-bold uppercase tracking-widest transition-colors">Lupa?</a>
                        </div>
                        <div class="relative group">
                            <input type="password" id="login-password" name="password" placeholder="••••••••" required
                                class="input-jatara pr-12 group-hover:border-[#0A174E]/30">
                            <button type="button" onclick="togglePwd('login-password', 'eye-login')"
                                class="absolute inset-y-0 right-5 flex items-center text-[#8F8F7E] hover:text-[#0A174E] transition-colors focus:outline-none">
                                <i class="fas fa-eye-slash text-sm" id="eye-login"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Remember Me --}}
                    <div class="flex items-center gap-3 pt-1">
                        <input type="checkbox" name="remember" id="remember"
                            class="w-4 h-4 rounded text-[#0A174E] focus:ring-[#F5D042] border-[#D4D4C3] cursor-pointer">
                        <label for="remember"
                            class="text-xs text-[#8F8F7E] font-bold uppercase tracking-widest cursor-pointer select-none">Ingat
                            saya</label>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                        class="w-full btn-jatara-primary font-extrabold mt-2 hover:shadow-[0_12px_24px_rgba(10,23,78,0.2)]">
                        Masuk Ke Panel
                    </button>
                </form>

                <p class="text-center text-sm font-semibold text-[#8F8F7E] mt-6">
                    Belum punya akun?
                    <button type="button" onclick="switchTab('register')"
                        class="text-[#0A174E] hover:text-[#F5D042] transition-colors font-bold px-1 relative after:absolute after:bottom-0 after:left-0 after:w-full after:h-px after:bg-[#0A174E] hover:after:bg-[#F5D042] after:transition-colors">Daftar
                        Baru</button>
                </p>
            </div>


            {{-- ============================== --}}
            {{-- REGISTER PANEL --}}
            {{-- ============================== --}}
            <div class="w-1/2 flex-shrink-0 px-1 pt-2 sm:pt-0">
                <div class="mb-6 text-center lg:text-left">
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-[#0A174E] tracking-tighter mb-2">Daftar Akun.</h1>
                    <p class="text-[15px] sm:text-base text-[#8F8F7E] font-medium leading-relaxed max-w-sm mx-auto lg:mx-0">
                        Mulai petualangan tanpa batas dengan mendaftar gratis sekarang.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-3 mb-6">
                    <a href="{{ route('auth.google') }}"
                        class="w-full flex items-center justify-center gap-3 py-3 border border-[#EBEBDF] rounded-xl text-[#0A174E] font-bold hover:bg-[#F9F9F5] transition-all active:scale-[0.98] shadow-sm relative overflow-hidden group">
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5 relative z-10"
                            alt="Google">
                        <span class="relative z-10">Daftar dengan Google</span>
                    </a>
                </div>

                <div class="relative flex items-center gap-6 py-2 mb-6">
                    <div class="flex-1 h-px bg-[#EBEBDF]"></div>
                    <span class="text-[10px] text-[#8F8F7E] font-bold uppercase tracking-[0.2em] bg-white px-2">Atau
                        Email</span>
                    <div class="flex-1 h-px bg-[#EBEBDF]"></div>
                </div>

                <form class="space-y-4" action="{{ route('register.post') }}" method="POST">
                    @csrf
                    <input type="hidden" name="_tab" value="register">

                    @if ($errors->any() && old('_tab') == 'register')
                        <div
                            class="p-3 bg-red-50 border border-red-100 text-red-600 rounded-xl text-xs font-bold leading-relaxed flex items-start gap-2">
                            <i class="fas fa-exclamation-triangle mt-0.5"></i>
                            <span>{{ $errors->first() }}</span>
                        </div>
                    @endif

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5 group">
                            <label for="reg-name"
                                class="text-[10px] font-bold text-[#8F8F7E] uppercase tracking-[0.2em] block pl-1">Nama
                                Lengkap</label>
                            <input type="text" id="reg-name" name="name"
                                value="{{ old('_tab') == 'register' ? old('name') : '' }}" required
                                class="input-jatara group-hover:border-[#0A174E]/30">
                        </div>

                        <div class="space-y-1.5 group">
                            <label for="reg-phone"
                                class="text-[10px] font-bold text-[#8F8F7E] uppercase tracking-[0.2em] block pl-1">Whatsapp</label>
                            <input type="tel" id="reg-phone" name="phone"
                                value="{{ old('_tab') == 'register' ? old('phone') : '' }}" required
                                class="input-jatara group-hover:border-[#0A174E]/30">
                        </div>
                    </div>

                    <div class="space-y-1.5 group">
                        <label for="reg-email"
                            class="text-[10px] font-bold text-[#8F8F7E] uppercase tracking-[0.2em] block pl-1">Alamat
                            Email</label>
                        <input type="email" id="reg-email" name="email"
                            value="{{ old('_tab') == 'register' ? old('email') : '' }}" required
                            class="input-jatara group-hover:border-[#0A174E]/30">
                    </div>

                    <div class="space-y-1.5 group">
                        <label for="reg-password"
                            class="text-[10px] font-bold text-[#8F8F7E] uppercase tracking-[0.2em] block pl-1">Sandi
                            Baru</label>
                        <div class="relative">
                            <input type="password" id="reg-password" name="password" required
                                class="input-jatara pr-12 group-hover:border-[#0A174E]/30">
                            <button type="button" onclick="togglePwd('reg-password', 'eye-reg')"
                                class="absolute inset-y-0 right-5 flex items-center text-[#8F8F7E] hover:text-[#0A174E] transition-colors focus:outline-none">
                                <i class="fas fa-eye-slash text-sm" id="eye-reg"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full btn-jatara-primary font-extrabold mt-4 hover:shadow-[0_12px_24px_rgba(10,23,78,0.2)]">
                        Buat Akun
                    </button>
                </form>

                <p class="text-center text-sm font-semibold text-[#8F8F7E] mt-6">
                    Sudah terdaftar?
                    <button type="button" onclick="switchTab('login')"
                        class="text-[#0A174E] hover:text-[#F5D042] transition-colors font-bold px-1 relative after:absolute after:bottom-0 after:left-0 after:w-full after:h-px after:bg-[#0A174E] hover:after:bg-[#F5D042] after:transition-colors">Masuk
                        Sini</button>
                </p>

                <div class="mt-8 pt-6 border-t border-[#EBEBDF] text-center">
                    <p class="text-[13px] font-medium text-[#8F8F7E]">
                        Punya armada mobil nganggur? <br class="sm:hidden">
                        <a href="{{ route('register.mitra') }}"
                            class="text-[#0A174E] hover:text-[#F5D042] font-bold transition-colors inline-block mt-1 sm:mt-0 sm:ml-1">Daftar
                            Menjadi Mitra Jatara <i class="fas fa-arrow-right ml-1 text-[10px]"></i></a>
                    </p>
                </div>
            </div>

        </div>
    </div>

    <script>
        function togglePwd(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'fas fa-eye text-sm';
            } else {
                input.type = 'password';
                icon.className = 'fas fa-eye-slash text-sm';
            }
        }

        function switchTab(mode) {
            const slider = document.getElementById('form-slider');
            if (mode === 'register') {
                slider.classList.remove('translate-x-0');
                slider.classList.add('-translate-x-1/2');
                history.pushState(null, '', '{{ route('register') }}');
                document.title = 'Daftar Akun - Jatara';
            } else {
                slider.classList.remove('-translate-x-1/2');
                slider.classList.add('translate-x-0');
                history.pushState(null, '', '{{ route('login') }}');
                document.title = 'Masuk - Jatara';
            }
        }
    </script>
@endsection
