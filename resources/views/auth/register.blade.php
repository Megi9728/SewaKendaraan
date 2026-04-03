@extends('layouts.auth')

@section('title', 'Daftar Akun Baru')

@section('form-content')
<div class="mb-10 text-center lg:text-left">
    <h1 class="text-5xl font-bold text-uber-black tracking-tighter mb-4">Daftar Akun.</h1>
    <p class="text-lg text-uber-text font-medium leading-relaxed max-w-sm mx-auto lg:mx-0">
        Mulai petualangan Anda sekarang. Bergabung dengan ekosistem sewa armada terpercaya di Indonesia.
    </p>
</div>

<form class="space-y-6" action="{{ route('register.post') }}" method="POST">
    @csrf

    @if($errors->any())
    <div class="p-5 bg-uber-black text-uber-white rounded-lg text-xs font-bold uppercase tracking-widest leading-relaxed">
        <i class="fas fa-exclamation-triangle mr-2"></i> {{ $errors->first() }}
    </div>
    @endif

    {{-- Nama Lengkap --}}
    <div class="space-y-2">
        <label for="name" class="text-[10px] font-bold text-uber-muted uppercase tracking-[0.2em] block pl-1">Nama Lengkap</label>
        <input type="text" id="name" name="name" placeholder="Nama sesuai identitas" required class="input-uber">
    </div>

    {{-- No. HP --}}
    <div class="space-y-2">
        <label for="phone" class="text-[10px] font-bold text-uber-muted uppercase tracking-[0.2em] block pl-1">No. WhatsApp</label>
        <input type="tel" id="phone" name="phone" placeholder="08xx..." required class="input-uber">
    </div>

    {{-- Email --}}
    <div class="space-y-2">
        <label for="email" class="text-[10px] font-bold text-uber-muted uppercase tracking-[0.2em] block pl-1">Alamat Email</label>
        <input type="email" id="email" name="email" placeholder="nama@email.com" required class="input-uber">
    </div>

    {{-- Password --}}
    <div class="space-y-2">
        <label for="password" class="text-[10px] font-bold text-uber-muted uppercase tracking-[0.2em] block pl-1">Sandi Keamanan</label>
        <div class="relative">
            <input type="password" id="password" name="password" placeholder="Min. 8 karakter" required class="input-uber pr-12">
            <button type="button" id="toggle-password" class="absolute inset-y-0 right-5 flex items-center text-uber-muted hover:text-uber-black transition-colors focus:outline-none">
                <i class="fas fa-eye-slash text-sm" id="eye-icon"></i>
            </button>
        </div>
    </div>

    {{-- Terms --}}
    <div class="flex items-start gap-3">
        <input type="checkbox" name="terms" id="terms" required class="w-4 h-4 accent-uber-black border-2 border-gray-100 rounded-sm mt-0.5">
        <label for="terms" class="text-[10px] text-uber-text font-bold uppercase tracking-widest leading-relaxed cursor-pointer select-none">
            Saya menyetujui <span class="text-uber-black border-b border-uber-black">Ketentuan Layanan</span> dan <span class="text-uber-black border-b border-uber-black">Kebijakan Privasi</span>.
        </label>
    </div>

    {{-- Submit --}}
    <button type="submit" class="w-full btn-uber-primary py-5 text-base shadow-uber">
        Daftar Akun Gratis
    </button>

    {{-- Footer --}}
    <p class="text-center text-sm font-medium text-uber-text pt-4">
        Sudah memiliki akun?
        <a href="{{ route('login') }}" class="text-uber-black hover:underline font-bold px-1">Masuk Sekarang</a>
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
