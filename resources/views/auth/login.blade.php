@extends('layouts.auth')

@section('title', 'Masuk ke Akun Anda')

@section('form-content')
<div>
    <h1 class="text-3xl font-black text-slate-900">Selamat Datang! 👋</h1>
    <p class="text-slate-500 mt-2">Masuk ke akun RentDrive Anda</p>
</div>

<form class="mt-8 space-y-5" action="{{ route('login.post') }}" method="POST">
    @csrf

    @if($errors->any())
    <div class="p-4 bg-red-50 border border-red-100 text-red-600 rounded-xl text-xs font-semibold">
        {{ $errors->first() }}
    </div>
    @endif

    {{-- Email --}}
    <div>
        <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                <i class="fas fa-envelope text-slate-400 text-sm"></i>
            </div>
            <input type="email" id="email" name="email" placeholder="nama@email.com" required
                class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-medium text-sm
                       focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 focus:bg-white transition-all">
        </div>
    </div>

    {{-- Password --}}
    <div>
        <div class="flex justify-between items-center mb-2">
            <label for="password" class="block text-sm font-semibold text-slate-700">Password</label>
            <a href="#" class="text-xs text-blue-600 hover:underline font-semibold">Lupa Password?</a>
        </div>
        <div class="relative">
            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                <i class="fas fa-lock text-slate-400 text-sm"></i>
            </div>
            <input type="password" id="password" name="password" placeholder="••••••••" required
                class="w-full pl-11 pr-12 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-medium text-sm
                       focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 focus:bg-white transition-all">
            <button type="button" id="toggle-password" class="absolute inset-y-0 right-4 flex items-center text-slate-400 hover:text-slate-600">
                <i class="fas fa-eye-slash text-sm" id="eye-icon"></i>
            </button>
        </div>
    </div>

    {{-- Remember Me --}}
    <label class="flex items-center gap-3 cursor-pointer">
        <input type="checkbox" name="remember" class="w-4 h-4 accent-blue-600 rounded">
        <span class="text-sm text-slate-600 font-medium">Ingat saya di perangkat ini</span>
    </label>

    {{-- Submit --}}
    <button type="submit"
        class="w-full bg-blue-600 hover:bg-blue-700 active:scale-95 text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-blue-200 text-sm">
        <i class="fas fa-sign-in-alt mr-2"></i>Masuk ke Akun
    </button>

    {{-- Divider --}}
    <div class="relative flex items-center gap-4 py-2">
        <div class="flex-1 h-px bg-slate-200"></div>
        <span class="text-xs text-slate-400 font-medium">atau lanjutkan dengan</span>
        <div class="flex-1 h-px bg-slate-200"></div>
    </div>

    {{-- Social --}}
    <div class="grid grid-cols-2 gap-3">
        <button type="button" class="flex items-center justify-center gap-2 border border-slate-200 hover:bg-slate-50 rounded-xl py-3 text-sm font-semibold text-slate-600 transition-all">
            <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" class="w-5 h-5">
            Google
        </button>
        <button type="button" class="flex items-center justify-center gap-2 border border-slate-200 hover:bg-slate-50 rounded-xl py-3 text-sm font-semibold text-slate-600 transition-all">
            <i class="fab fa-facebook-f text-blue-600"></i>
            Facebook
        </button>
    </div>

    {{-- Register link --}}
    <p class="text-center text-sm text-slate-500 pt-2">
        Belum punya akun?
        <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-bold">Daftar Gratis</a>
    </p>
</form>

<script>
    document.getElementById('toggle-password').addEventListener('click', function() {
        const input = document.getElementById('password');
        const icon = document.getElementById('eye-icon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'fas fa-eye text-sm';
        } else {
            input.type = 'password';
            icon.className = 'fas fa-eye-slash text-sm';
        }
    });
</script>
@endsection
