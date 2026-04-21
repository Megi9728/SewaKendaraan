@extends('layouts.auth')

@section('title', 'Daftar sebagai Mitra')

@section('form-content')
<div class="mb-10 text-center lg:text-left">
    <h1 class="text-5xl font-bold text-uber-black tracking-tighter mb-4">Daftar Mitra.</h1>
    <p class="text-lg text-uber-text font-medium leading-relaxed max-w-sm mx-auto lg:mx-0">
        Bergabunglah sebagai mitra dan mulai kelola armada rental mobil Anda dengan sistem profesional.
    </p>
</div>

<form class="space-y-6" action="{{ route('register.mitra.post') }}" method="POST">
    @csrf

    @if($errors->any())
    <div class="p-5 bg-uber-black text-uber-white rounded-lg text-xs font-bold uppercase tracking-widest leading-relaxed">
        <i class="fas fa-exclamation-triangle mr-2"></i> {{ $errors->first() }}
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Nama Pemilik --}}
        <div class="space-y-2">
            <label for="name" class="text-[10px] font-bold text-uber-muted uppercase tracking-[0.2em] block pl-1">Nama Pemilik</label>
            <input type="text" id="name" name="name" placeholder="Nama Lengkap" required class="input-uber">
        </div>

        {{-- Nama Rental --}}
        <div class="space-y-2">
            <label for="partner_name" class="text-[10px] font-bold text-uber-muted uppercase tracking-[0.2em] block pl-1">Nama Bisnis / Rental</label>
            <input type="text" id="partner_name" name="partner_name" placeholder="Contoh: Jatara Trans" required class="input-uber">
        </div>
    </div>

    {{-- No. HP --}}
    <div class="space-y-2">
        <label for="phone" class="text-[10px] font-bold text-uber-muted uppercase tracking-[0.2em] block pl-1">No. WhatsApp Bisnis</label>
        <input type="tel" id="phone" name="phone" placeholder="08xx..." required class="input-uber">
    </div>

    {{-- Email --}}
    <div class="space-y-2">
        <label for="email" class="text-[10px] font-bold text-uber-muted uppercase tracking-[0.2em] block pl-1">Email Bisnis</label>
        <input type="email" id="email" name="email" placeholder="nama@rental-anda.com" required class="input-uber">
    </div>

    {{-- Password --}}
    <div class="space-y-2">
        <label for="password" class="text-[10px] font-bold text-uber-muted uppercase tracking-[0.2em] block pl-1">Sandi Keamanan</label>
        <input type="password" id="password" name="password" placeholder="Min. 8 karakter" required class="input-uber">
    </div>

    {{-- Alamat --}}
    <div class="space-y-2">
        <label for="address" class="text-[10px] font-bold text-uber-muted uppercase tracking-[0.2em] block pl-1">Alamat Kantor / Pool</label>
        <textarea id="address" name="address" rows="3" placeholder="Alamat lengkap bisnis Anda" required class="input-uber py-4 h-auto"></textarea>
    </div>

    {{-- Submit --}}
    <button type="submit" class="w-full btn-uber-primary py-5 text-base shadow-uber">
        Daftar Sebagai Mitra
    </button>

    {{-- Footer --}}
    <p class="text-center text-sm font-medium text-uber-text pt-4">
        Daftar sebagai pelanggan biasa?
        <a href="{{ route('register') }}" class="text-uber-black hover:underline font-bold px-1">Daftar Di Sini</a>
    </p>
</form>
@endsection
