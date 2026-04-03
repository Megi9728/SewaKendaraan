@extends('layouts.app')

@section('title', 'Sewa Kendaraan Cepat & Praktis')

@section('content')

{{-- ===== HERO SECTION (UBER STYLE: SPLIT LAYOUT) ===== --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-20 flex flex-col md:flex-row items-center gap-12 lg:gap-24 border-b border-gray-50">
    <div class="w-full md:w-[45%]">
        <h1 class="text-4xl md:text-[52px] font-bold text-uber-black leading-[1.1] mb-8 tracking-tighter">
            Jelajahi kota,<br>
            tanpa hambatan.
        </h1>
        
        <form action="{{ route('browse') }}" method="GET" class="max-w-md space-y-4 relative">
            <div class="relative z-10">
                <select name="domicile" class="w-full bg-uber-chip hover:bg-gray-200 outline-none rounded-lg font-bold text-uber-black px-4 py-3.5 transition border-r-8 border-transparent">
                    <option value="">Lokasi Pengambilan</option>
                    <option value="Jakarta">Jakarta</option>
                    <option value="Bogor">Bogor</option>
                    <option value="Depok">Depok</option>
                    <option value="Tangerang">Tangerang</option>
                    <option value="Bekasi">Bekasi</option>
                </select>
            </div>

            <div class="relative z-10">
                <select name="type" class="w-full bg-uber-chip hover:bg-gray-200 outline-none rounded-lg font-bold text-uber-black px-4 py-3.5 transition border-r-8 border-transparent">
                    <option value="">Tipe Kendaraan</option>
                    <option value="Mobil">Mobil</option>
                    <option value="Motor">Motor</option>
                    <option value="SUV">SUV</option>
                    <option value="MPV">MPV</option>
                </select>
            </div>

            <div class="relative z-10 flex flex-col sm:flex-row gap-2">
                <input type="date" name="start_date" class="w-full sm:w-1/2 bg-uber-chip hover:bg-gray-200 outline-none rounded-lg font-bold text-uber-black px-4 py-3.5 transition" min="{{ date('Y-m-d') }}" title="Mulai">
                <input type="date" name="end_date" class="w-full sm:w-1/2 bg-uber-chip hover:bg-gray-200 outline-none rounded-lg font-bold text-uber-black px-4 py-3.5 transition" min="{{ date('Y-m-d') }}" title="Selesai">
            </div>
            
            <button type="submit" class="btn-primary w-full sm:w-auto inline-block text-center mt-2 font-bold text-lg px-12 py-3.5 shadow-uber">
                Cari Sekarang
            </button>
        </form>
    </div>

    <div class="w-full md:w-[55%]">
        <div class="w-full rounded-2xl overflow-hidden bg-uber-chip aspect-video relative group border border-gray-100">
            <img src="https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?auto=format&fit=crop&w=1200&q=80" alt="Uber Style Driving" class="w-full h-full object-cover">
        </div>
    </div>
</section>

{{-- ===== CATEGORY QUICK LINKS (NEW) ===== --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <h2 class="text-3xl font-bold tracking-tight mb-10 text-uber-black">Kategori Populer</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @php
        $cats = [
            ['name' => 'Mobil Sedan', 'type' => 'sedan', 'icon' => 'fas fa-car-side'],
            ['name' => 'MPV / SUV', 'type' => 'suv', 'icon' => 'fas fa-truck-pickup'],
            ['name' => 'Motor', 'type' => 'motor', 'icon' => 'fas fa-motorcycle'],
            ['name' => 'Minibus', 'type' => 'minibus', 'icon' => 'fas fa-bus'],
        ];
        @endphp
        @foreach($cats as $cat)
        <a href="{{ route('browse', ['type' => $cat['type']]) }}" class="bg-gray-50 hover:bg-uber-black hover:text-uber-white p-8 rounded-xl transition-all duration-300 group">
            <i class="{{ $cat['icon'] }} text-3xl mb-4 text-uber-black group-hover:text-uber-white"></i>
            <p class="text-xl font-bold">{{ $cat['name'] }}</p>
        </a>
        @endforeach
    </div>
</section>

{{-- ===== WHY US (NEW) ===== --}}
<section class="bg-uber-chip py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-16">
            <div class="space-y-4">
                <i class="fas fa-shield-alt text-4xl text-uber-black"></i>
                <h3 class="text-2xl font-bold text-uber-black tracking-tight">Armada Terverifikasi</h3>
                <p class="text-uber-text font-medium leading-relaxed italic opacity-80">"Setiap unit dicek fisik dan mekanis secara berkala untuk memastikan standar keamanan tertinggi selama perjalanan Anda."</p>
            </div>
            <div class="space-y-4">
                <i class="fas fa-headset text-4xl text-uber-black"></i>
                <h3 class="text-2xl font-bold text-uber-black tracking-tight">Dukungan 24/7</h3>
                <p class="text-uber-text font-medium leading-relaxed italic opacity-80">"Tim bantuan kami selalu siaga kapan pun Anda membutuhkannya. Masalah di jalan bukan beban bagi Anda."</p>
            </div>
            <div class="space-y-4">
                <i class="fas fa-bolt text-4xl text-uber-black"></i>
                <h3 class="text-2xl font-bold text-uber-black tracking-tight">Konfirmasi Instan</h3>
                <p class="text-uber-text font-medium leading-relaxed italic opacity-80">"Tanpa menunggu lama. Begitu data Anda terverifikasi, unit langsung dapat dipesan tanpa prosedur administrasi yang berbelit."</p>
            </div>
        </div>
    </div>
</section>

{{-- ===== SIMPLE STEPS (NEW) ===== --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
    <div class="flex flex-col md:flex-row justify-between items-end gap-6 mb-16 border-b border-gray-100 pb-10">
        <div class="max-w-2xl">
            <h2 class="text-4xl md:text-5xl font-bold text-uber-black tracking-tighter">Cara pesannya gampang.</h2>
            <p class="text-xl text-uber-text font-medium mt-4">Cukup tiga langkah dari layar HP sampai unit di garasi Anda.</p>
        </div>
        <a href="{{ route('how.it.works') }}" class="text-xs font-bold text-uber-black uppercase border-b-2 border-uber-black pb-1 hover:opacity-70 transition">Pelajari Selengkapnya</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
        <div class="flex flex-col">
            <span class="text-7xl font-bold text-gray-100 mb-4 tracking-tighter select-none">01</span>
            <h4 class="text-2xl font-bold text-uber-black mb-2">Cari Unit</h4>
            <p class="text-uber-text font-medium leading-relaxed">Tentukan lokasi jemput, rentang tanggal, dan tipe armada idaman Anda.</p>
        </div>
        <div class="flex flex-col">
            <span class="text-7xl font-bold text-gray-100 mb-4 tracking-tighter select-none">02</span>
            <h4 class="text-2xl font-bold text-uber-black mb-2">Lengkapi Berkas</h4>
            <p class="text-uber-text font-medium leading-relaxed">Verifikasi identitas (KTP/SIM) sekali saja dan unit siap dipesan langsung.</p>
        </div>
        <div class="flex flex-col">
            <span class="text-7xl font-bold text-gray-100 mb-4 tracking-tighter select-none">03</span>
            <h4 class="text-2xl font-bold text-uber-black mb-2">Mulai Jalan</h4>
            <p class="text-uber-text font-medium leading-relaxed">Unit kami antar atau jemput di lokasi terdekat. Mulai perjalanan Anda dengan tenang.</p>
        </div>
    </div>
</section>

{{-- ===== APP PROMO (AS IS BUT REFINED) ===== --}}
@guest
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="bg-uber-black text-uber-white rounded-2xl p-10 md:p-16 flex flex-col md:flex-row items-center gap-12 shadow-uber">
        <div class="flex-1">
            <h2 class="text-4xl font-bold tracking-tighter mb-6 italic">Mau Sewa Armada?</h2>
            <p class="text-lg opacity-80 leading-relaxed font-medium mb-10 max-w-xl">
                Jadilah mitra penyewa kami untuk akses eksklusif ke berbagai unit premium. Dapatkan layanan antar-jemput armada khusus bagi member terverifikasi.
            </p>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('register') }}" class="px-10 py-4 bg-uber-white text-uber-black rounded-full font-bold hover:bg-gray-200 transition text-center shadow-lg">Daftar Sekarang</a>
                <a href="{{ route('login') }}" class="px-10 py-4 border border-white/30 text-white rounded-full font-bold hover:bg-white/10 transition text-center">Masuk ke Akun</a>
            </div>
        </div>
        <div class="hidden md:flex flex-shrink-0 bg-white p-6 rounded-2xl">
            <i class="fas fa-qrcode text-[140px] text-uber-black"></i>
        </div>
    </div>
</section>
@endguest

{{-- ===== VEHICLE CATALOGUE (PARTIAL) ===== --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 mb-16">
    <div class="flex justify-between items-end mb-12">
        <h2 class="text-4xl font-bold tracking-tight text-uber-black">Pilihan Teratas</h2>
        <a href="{{ route('browse') }}" class="text-sm font-bold text-uber-black hover:underline underline-offset-4 decoration-2">Lihat Semua Katalog <i class="fas fa-chevron-right text-[10px] ml-1"></i></a>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
        @foreach($vehicles as $v)
        <a href="{{ route('vehicle.detail', $v->id) }}" class="group block bg-uber-white transition-all duration-300 relative border-0 border-b border-gray-100 pb-10 md:border-0 md:pb-0">
            
            <div class="aspect-[16/10] w-full bg-uber-chip rounded-xl overflow-hidden relative mb-5">
                <img src="{{ $v->image ? (strpos($v->image, 'http') === 0 ? $v->image : asset('storage/' . $v->image)) : 'https://placehold.co/600x400?text=' . urlencode($v->name) }}" 
                     alt="{{ $v->name }}" 
                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                
                @if($v->status === 'Tersedia')
                    <span class="absolute top-4 left-4 bg-uber-white text-uber-black text-[10px] font-bold px-3 py-1.5 rounded shadow-sm border border-gray-100 uppercase tracking-widest">Tersedia</span>
                @else
                    <span class="absolute top-4 left-4 bg-uber-black text-uber-white text-[10px] font-bold px-3 py-1.5 rounded shadow-sm uppercase tracking-widest">Disewa</span>
                @endif
            </div>

            <div class="flex justify-between items-start mb-1">
                <h3 class="font-bold text-2xl text-uber-black truncate group-hover:underline underline-offset-4">{{ $v->name }}</h3>
                <div class="flex items-center gap-1 text-uber-black">
                     <i class="fas fa-star text-xs"></i>
                     <span class="text-sm font-bold">{{ $v->rating }}</span>
                </div>
            </div>
            
            <p class="text-uber-text font-medium text-sm mb-4">{{ $v->seats }} Kursi • {{ $v->transmission }}</p>
            <div class="flex items-center gap-2">
                <span class="font-bold text-lg text-uber-black">Rp {{ number_format($v->price_per_day, 0, ',', '.') }}</span>
                <span class="text-xs text-uber-muted font-bold uppercase tracking-widest">/ hari</span>
            </div>
        </a>
        @endforeach
    </div>
</section>

{{-- ===== STATS (NEW) ===== --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 mb-20">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-12 text-center md:text-left">
        <div>
            <p class="text-5xl font-bold text-uber-black tracking-tighter">500+</p>
            <p class="text-xs font-bold text-uber-muted uppercase tracking-[0.2em] mt-3">Armada Pilihan</p>
        </div>
        <div>
            <p class="text-5xl font-bold text-uber-black tracking-tighter">10k+</p>
            <p class="text-xs font-bold text-uber-muted uppercase tracking-[0.2em] mt-3">Penyewaan Sukses</p>
        </div>
        <div>
            <p class="text-5xl font-bold text-uber-black tracking-tighter">24hr</p>
            <p class="text-xs font-bold text-uber-muted uppercase tracking-[0.2em] mt-3">Emergency Support</p>
        </div>
        <div>
            <p class="text-5xl font-bold text-uber-black tracking-tighter">15m</p>
            <p class="text-xs font-bold text-uber-muted uppercase tracking-[0.2em] mt-3">Verifikasi Kilat</p>
        </div>
    </div>
</section>

@endsection