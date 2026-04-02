@extends('layouts.auth')

@section('title', 'Daftar Akun Baru')

@section('form-content')
<div>
    <h1 class="text-3xl font-black text-slate-900">Buat Akun Gratis 🚀</h1>
    <p class="text-slate-500 mt-2">Bergabung dengan 50.000+ pengguna RentDrive</p>
</div>

<form class="mt-8 space-y-4" action="#" method="POST">
    @csrf

    {{-- Nama Lengkap --}}
    <div>
        <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                <i class="fas fa-user text-slate-400 text-sm"></i>
            </div>
            <input type="text" id="name" name="name" placeholder="Nama lengkap Anda" required
                class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-medium text-sm
                       focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 focus:bg-white transition-all">
        </div>
    </div>

    {{-- No. HP --}}
    <div>
        <label for="phone" class="block text-sm font-semibold text-slate-700 mb-2">No. WhatsApp</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                <i class="fab fa-whatsapp text-slate-400 text-sm"></i>
            </div>
            <input type="tel" id="phone" name="phone" placeholder="08xx-xxxx-xxxx" required
                class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-medium text-sm
                       focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 focus:bg-white transition-all">
        </div>
    </div>

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
        <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                <i class="fas fa-lock text-slate-400 text-sm"></i>
            </div>
            <input type="password" id="password" name="password" placeholder="Min. 8 karakter" required minlength="8"
                class="w-full pl-11 pr-12 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-medium text-sm
                       focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 focus:bg-white transition-all">
            <button type="button" id="toggle-password" class="absolute inset-y-0 right-4 flex items-center text-slate-400 hover:text-slate-600">
                <i class="fas fa-eye-slash text-sm" id="eye-icon"></i>
            </button>
        </div>

        {{-- Password Strength --}}
        <div class="flex gap-1.5 mt-2" id="strength-bars">
            <div class="h-1.5 flex-1 rounded-full bg-slate-200 strength-bar"></div>
            <div class="h-1.5 flex-1 rounded-full bg-slate-200 strength-bar"></div>
            <div class="h-1.5 flex-1 rounded-full bg-slate-200 strength-bar"></div>
            <div class="h-1.5 flex-1 rounded-full bg-slate-200 strength-bar"></div>
        </div>
        <p class="text-xs text-slate-400 mt-1" id="strength-label">Kekuatan password</p>
    </div>

    {{-- Terms --}}
    <label class="flex items-start gap-3 cursor-pointer mt-2">
        <input type="checkbox" name="terms" required class="w-4 h-4 accent-blue-600 mt-0.5">
        <span class="text-sm text-slate-600 font-medium leading-relaxed">
            Saya setuju dengan <a href="#" class="text-blue-600 hover:underline">Syarat & Ketentuan</a>
            dan <a href="#" class="text-blue-600 hover:underline">Kebijakan Privasi</a> RentDrive
        </span>
    </label>

    {{-- Submit --}}
    <button type="submit"
        class="w-full bg-blue-600 hover:bg-blue-700 active:scale-95 text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-blue-200 text-sm mt-2">
        <i class="fas fa-user-plus mr-2"></i>Buat Akun Sekarang
    </button>

    {{-- Divider --}}
    <div class="relative flex items-center gap-4">
        <div class="flex-1 h-px bg-slate-200"></div>
        <span class="text-xs text-slate-400 font-medium">atau</span>
        <div class="flex-1 h-px bg-slate-200"></div>
    </div>

    {{-- Login link --}}
    <p class="text-center text-sm text-slate-500">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-bold">Masuk di sini</a>
    </p>
</form>

<script>
    // Password visibility toggle
    document.getElementById('toggle-password').addEventListener('click', function() {
        const input = document.getElementById('password');
        const icon  = document.getElementById('eye-icon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'fas fa-eye text-sm';
        } else {
            input.type = 'password';
            icon.className = 'fas fa-eye-slash text-sm';
        }
    });

    // Password strength indicator
    document.getElementById('password').addEventListener('input', function() {
        const val = this.value;
        let strength = 0;
        if (val.length >= 8) strength++;
        if (/[A-Z]/.test(val)) strength++;
        if (/[0-9]/.test(val)) strength++;
        if (/[^A-Za-z0-9]/.test(val)) strength++;

        const bars   = document.querySelectorAll('.strength-bar');
        const colors = ['bg-red-400','bg-orange-400','bg-yellow-400','bg-green-500'];
        const labels = ['Sangat Lemah','Sedang','Kuat','Sangat Kuat'];
        const lcls   = ['text-red-500','text-orange-500','text-yellow-600','text-green-600'];

        bars.forEach((bar, i) => {
            bar.className = 'h-1.5 flex-1 rounded-full ' + (i < strength ? colors[strength-1] : 'bg-slate-200');
        });

        const lbl = document.getElementById('strength-label');
        lbl.textContent  = strength > 0 ? labels[strength-1] : 'Kekuatan password';
        lbl.className    = 'text-xs mt-1 ' + (strength > 0 ? lcls[strength-1] : 'text-slate-400');
    });
</script>
@endsection
