@extends('layouts.auth')

@section('title', 'Masuk ke Akun Anda')

@section('form-content')
<div class="mb-10 text-center lg:text-left">
    <h1 class="text-5xl font-bold text-uber-black tracking-tighter mb-4">Selamat Datang.</h1>
    <p class="text-lg text-uber-text font-medium leading-relaxed max-w-sm mx-auto lg:mx-0">
        Gunakan akun Anda untuk menikmati akses eksklusif ke armada terbaik kami.
    </p>
</div>

<form class="space-y-6" action="{{ route('login.post') }}" method="POST">
    @csrf

    @if($errors->any())
    <div class="p-5 bg-uber-black text-uber-white rounded-lg text-xs font-bold uppercase tracking-widest leading-relaxed">
        <i class="fas fa-exclamation-triangle mr-2"></i> {{ $errors->first() }}
    </div>
    @endif

    {{-- Email --}}
    <div class="space-y-2">
        <label for="email" class="text-[10px] font-bold text-uber-muted uppercase tracking-[0.2em] block pl-1">Alamat Email</label>
        <div class="relative">
            <input type="email" id="email" name="email" placeholder="nama@email.com" required class="input-uber">
        </div>
    </div>

    {{-- Password --}}
    <div class="space-y-2">
        <div class="flex justify-between items-center pl-1">
            <label for="password" class="text-[10px] font-bold text-uber-muted uppercase tracking-[0.2em] block">Sandi Keamanan</label>
            <a href="#" class="text-[10px] text-uber-black hover:underline font-bold uppercase tracking-widest">Lupa?</a>
        </div>
        <div class="relative">
            <input type="password" id="password" name="password" placeholder="••••••••" required class="input-uber pr-12">
            <button type="button" id="toggle-password" class="absolute inset-y-0 right-5 flex items-center text-uber-muted hover:text-uber-black transition-colors focus:outline-none">
                <i class="fas fa-eye-slash text-sm" id="eye-icon"></i>
            </button>
        </div>
    </div>

    {{-- Remember Me (Uber Minimalist) --}}
    <div class="flex items-center gap-3">
        <input type="checkbox" name="remember" id="remember" class="w-4 h-4 accent-uber-black border-2 border-gray-100 rounded-sm">
        <label for="remember" class="text-xs text-uber-text font-bold uppercase tracking-widest cursor-pointer select-none">Biarkan tetap masuk</label>
    </div>

    {{-- Submit --}}
    <button type="submit" class="w-full btn-uber-primary py-5 text-base shadow-uber">
        Masuk Sekarang
    </button>

    {{-- Divider --}}
    <div class="relative flex items-center gap-6 py-4">
        <div class="flex-1 h-px bg-gray-100"></div>
        <span class="text-[10px] text-uber-muted font-bold uppercase tracking-[0.2em]">atau</span>
        <div class="flex-1 h-px bg-gray-100"></div>
    </div>

    {{-- Register link --}}
    <p class="text-center text-sm font-medium text-uber-text">
        Belum punya akun?
        <a href="{{ route('register') }}" class="text-uber-black hover:underline font-bold px-1">Daftar Akun Baru</a>
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
