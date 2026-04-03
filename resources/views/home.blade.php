@extends('layouts.app')

@section('title', 'Sewa Kendaraan Cepat & Praktis')

@section('content')

{{-- ===== HERO SECTION (UBER STYLE: SPLIT LAYOUT) ===== --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-20 flex flex-col md:flex-row items-center gap-12 lg:gap-24">
    <div class="w-full md:w-[45%]">
        <h1 class="text-4xl md:text-[52px] font-bold text-uber-black leading-[1.1] mb-8 tracking-tight">
            Pergi ke mana pun,<br>
            kapan pun.
        </h1>
        
        <form action="{{ route('browse') }}" method="GET" class="max-w-md space-y-4 relative">
            <div class="relative z-10 hidden sm:block">
                <select name="domicile" class="w-full bg-uber-chip hover:bg-gray-200 outline-none rounded-lg font-bold text-uber-black px-4 py-3.5 transition border-r-8 border-transparent">
                    <option value="">Semua Lokasi Pengambilan</option>
                    <option value="Jakarta">Jakarta</option>
                    <option value="Bogor">Bogor</option>
                    <option value="Depok">Depok</option>
                    <option value="Tangerang">Tangerang</option>
                    <option value="Bekasi">Bekasi</option>
                </select>
            </div>

            <div class="relative z-10 hidden sm:block">
                <select name="type" class="w-full bg-uber-chip hover:bg-gray-200 outline-none rounded-lg font-bold text-uber-black px-4 py-3.5 transition border-r-8 border-transparent">
                    <option value="">Semua Tipe Kendaraan</option>
                    <option value="Mobil">Mobil</option>
                    <option value="Motor">Motor</option>
                    <option value="Minibus">Minibus</option>
                    <option value="SUV">SUV</option>
                    <option value="MPV">MPV</option>
                </select>
            </div>

            <div class="relative z-10 hidden sm:flex gap-2">
                <input type="date" name="start_date" class="w-1/2 bg-uber-chip hover:bg-gray-200 outline-none rounded-lg font-bold text-uber-black px-4 py-3.5 transition" min="{{ date('Y-m-d') }}" title="Tanggal Mulai">
                <input type="date" name="end_date" class="w-1/2 bg-uber-chip hover:bg-gray-200 outline-none rounded-lg font-bold text-uber-black px-4 py-3.5 transition" min="{{ date('Y-m-d') }}" title="Tanggal Selesai">
            </div>
            
            <button type="submit" class="btn-primary w-full sm:w-auto inline-block text-center mt-2 font-bold text-lg px-8 py-3">
                Cari Kendaraan
            </button>
        </form>
    </div>

    <div class="w-full md:w-[55%]">
        {{-- Warm illustration/photo full bleed right container --}}
        <div class="w-full rounded-[12px] overflow-hidden bg-uber-chip aspect-video relative group">
            <img src="https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&w=1200&q=80" alt="Mobil Uber Style" class="w-full h-full object-cover">
        </div>
    </div>
</section>

{{-- ===== APP PROMO COMPONENT ===== --}}
@guest
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="bg-gray-50 rounded-[12px] p-8 md:p-12 flex flex-col md:flex-row items-center gap-8 border border-gray-100">
        <div class="w-full md:w-2/3">
            <h2 class="text-3xl font-bold tracking-tight mb-4 text-uber-black">Sewa armada kami.</h2>
            <p class="text-uber-text font-medium leading-relaxed max-w-xl">
                Lakukan penyewaan melalui dashboard Anda dan dapatkan armada bersih yang terverifikasi. Kami siap mengantar kendaraan langsung ke lokasi Anda di wilayah Jabodetabek.
            </p>
            <div class="flex gap-4 mt-6">
                <a href="{{ route('register') }}" class="px-6 py-3 bg-uber-white border border-uber-black rounded-full text-uber-black font-bold hover:bg-uber-chip transition">Daftar Akun</a>
            </div>
        </div>
        <div class="w-full md:w-1/3 flex justify-center md:justify-end">
            <i class="fas fa-qrcode text-[120px] text-uber-black"></i>
        </div>
    </div>
</section>
@endguest

{{-- ===== VEHICLE CATALOGUE ===== --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 mb-16">
    <h2 class="text-3xl font-bold tracking-tight mb-8 text-uber-black">Katalog Kendaraan</h2>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($vehicles as $v)
        <div class="group bg-uber-white p-4 rounded-[12px] hover:shadow-uber transition duration-300 relative border border-transparent hover:border-gray-100 flex flex-col">
            
            <div class="aspect-[16/10] w-full bg-uber-chip rounded-lg overflow-hidden relative mb-4">
                <img src="{{ $v->image ? (strpos($v->image, 'http') === 0 ? $v->image : asset('storage/' . $v->image)) : 'https://placehold.co/600x400?text=' . urlencode($v->name) }}" 
                     alt="{{ $v->name }}" 
                     class="w-full h-full object-cover">
                
                @if($v->status === 'Tersedia')
                    <span class="absolute top-3 left-3 bg-uber-white text-uber-black text-xs font-bold px-3 py-1.5 rounded-full shadow-sm uppercase tracking-wider">
                        Tersedia
                    </span>
                @else
                    <span class="absolute top-3 left-3 bg-uber-black text-uber-white text-xs font-bold px-3 py-1.5 rounded-full shadow-sm uppercase tracking-wider">
                        Disewa
                    </span>
                @endif
            </div>

            <div class="flex justify-between items-start mb-1">
                <h3 class="font-bold text-xl text-uber-black truncate">{{ $v->name }}</h3>
                <span class="font-bold text-lg text-uber-black whitespace-nowrap">Rp {{ number_format($v->price_per_day, 0, ',', '.') }}</span>
            </div>
            
            <p class="text-uber-text font-medium text-sm mb-6">{{ $v->seats }} Kursi • {{ $v->transmission }}</p>

            <div class="mt-auto flex gap-3">
                <a href="{{ route('vehicle.detail', $v->id) }}" class="btn-secondary flex-1 text-center font-bold">Detail</a>
                <a href="{{ route('vehicle.detail', $v->id) }}" class="btn-primary flex-1 text-center font-bold px-0">Pesan</a>
            </div>
            
        </div>
        @endforeach
    </div>
</section>

@endsection