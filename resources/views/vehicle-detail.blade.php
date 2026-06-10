@extends('layouts.app')

@section('title', 'Detail Kendaraan')

@push('styles')
<style>
    .tab-btn.active { border-bottom: 2px solid #0A174E; color: #0A174E; font-weight: 700; }
    .tab-content.active { display: block; }
    input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(0);
    }
    /* Swiper custom styles */
    .vehicle-swiper { --swiper-navigation-color: rgba(255, 255, 255, 0.5); }
    .swiper-button-next, .swiper-button-prev { background: transparent; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3)); transition: all 0.3s; }
    .swiper-button-next:hover, .swiper-button-prev:hover { --swiper-navigation-color: rgba(255, 255, 255, 1); }
    .swiper-button-next:after, .swiper-button-prev:after { font-size: 32px; font-weight: 900; }
    .swiper-button-next { right: 20px; }
    .swiper-button-prev { left: 20px; }
    .swiper-pagination-bullet-active { background: #0A174E !important; }
    .thumbnail-item.active { border-color: #0A174E !important; }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Breadcrumb (Uber style) --}}
    <nav class="flex items-center gap-2 text-xs font-bold text-[#8F8F7E] mb-8 uppercase tracking-widest">
        <a href="{{ route('home') }}" class="hover:text-[#0A174E] transition-colors">Beranda</a>
        <i class="fas fa-chevron-right text-[8px]"></i>
        <a href="{{ route('browse') }}" class="hover:text-[#0A174E] transition-colors">Armada</a>
        <i class="fas fa-chevron-right text-[8px]"></i>
        <span class="text-[#0A174E]">{{ $vehicle->name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 lg:gap-20">

        {{-- ===== LEFT: CONTENT ===== --}}
        <div class="lg:col-span-2">

            {{-- Main Image Slider --}}
            <div class="swiper vehicle-swiper rounded-xl overflow-hidden aspect-[16/9] relative border border-gray-100 bg-[#F9F9F5]">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img src="{{ $vehicle->image ? (strpos($vehicle->image, 'http') === 0 ? $vehicle->image : asset('storage/' . $vehicle->image)) : 'https://placehold.co/1200x800?text=No+Image' }}"
                            class="w-full h-full object-cover" alt="{{ $vehicle->name }}">
                    </div>
                    @foreach($vehicle->images as $img)
                    <div class="swiper-slide">
                        <img src="{{ asset('storage/' . $img->image_path) }}" class="w-full h-full object-cover" alt="{{ $vehicle->name }}">
                    </div>
                    @endforeach
                </div>
                
                {{-- Navigation Buttons --}}
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                
                {{-- Badges --}}
                <div class="absolute top-5 left-5 flex gap-2 z-10 pointer-events-none">
                    @if($vehicle->available_units_count >= 1)
                        <span class="bg-uber-white text-[#0A174E] text-[10px] font-bold px-3 py-1.5 rounded shadow-sm border border-gray-100 uppercase tracking-widest">Tersedia</span>
                    @else
                        <span class="bg-[#0A174E] text-uber-white text-[10px] font-bold px-3 py-1.5 rounded shadow-sm uppercase tracking-widest">Tidak Tersedia</span>
                    @endif
                </div>
            </div>
 
            {{-- Gallery Thumbnails --}}
            <div class="mt-4 flex gap-3 overflow-x-auto pb-2 scrollbar-none">
                <div class="thumbnail-item flex-shrink-0 w-24 aspect-video rounded-lg overflow-hidden border-2 active cursor-pointer bg-slate-100 transition-all" 
                     onclick="goToSlide(0)">
                    <img src="{{ $vehicle->image ? (strpos($vehicle->image, 'http') === 0 ? $vehicle->image : asset('storage/' . $vehicle->image)) : 'https://placehold.co/1200x800?text=No+Image' }}" class="w-full h-full object-cover">
                </div>
                @foreach($vehicle->images as $index => $img)
                <div class="thumbnail-item flex-shrink-0 w-24 aspect-video rounded-lg overflow-hidden border-2 border-transparent hover:border-gray-300 cursor-pointer bg-slate-100 transition-all font-bold" 
                     onclick="goToSlide({{ $index + 1 }})">
                    <img src="{{ asset('storage/' . $img->image_path) }}" class="w-full h-full object-cover">
                </div>
                @endforeach
            </div>

            {{-- Titles --}}
            <div class="mt-10 mb-8">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-4xl md:text-5xl font-bold text-[#0A174E] tracking-tighter">{{ $vehicle->name }}</h1>
                        <div class="flex items-center gap-2 mt-2 font-bold text-xs uppercase tracking-widest text-[#8F8F7E]">
                            <i class="fas fa-store"></i> Disediakan oleh: <span class="text-blue-600">{{ $vehicle->mitra->name ?? 'Jatara Official' }}</span>
                        </div>
                        <p class="text-uber-text font-medium mt-3 text-lg uppercase tracking-wide">
                            {{ $vehicle->type }} • {{ $vehicle->transmission }} • {{ $vehicle->fuel_type ?? 'Bensin' }} • {{ $vehicle->engine_capacity ?? '1500' }} CC
                        </p>
                        <div class="mt-4">
                            @if($vehicle->available_units_count >= 1)
                                <span class="bg-emerald-50 text-emerald-700 text-[10px] font-bold px-3 py-1.5 rounded-full border border-emerald-100 uppercase tracking-widest">
                                    <i class="fas fa-check-circle mr-1.5"></i> Tersedia
                                </span>
                            @else
                                <span class="bg-red-50 text-red-700 text-[10px] font-bold px-3 py-1.5 rounded-full border border-red-100 uppercase tracking-widest">
                                    <i class="fas fa-times-circle mr-1.5"></i> Tidak Tersedia
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="flex flex-col items-end">
                        <div class="flex items-center gap-1.5 text-[#0A174E] mb-1">
                            <i class="fas fa-star text-lg"></i>
                            <span class="text-xl font-bold">{{ $vehicle->rating }}</span>
                            <span class="text-sm font-medium text-[#8F8F7E] ml-0.5">({{ $vehicle->reviews_count }} Ulasan)</span>
                        </div>
                        <span class="text-xs font-bold text-[#8F8F7E] uppercase tracking-widest">Skor User</span>
                    </div>
                </div>
            </div>

            {{-- Tabs (Uber style: Flat Underline) --}}
            <div class="mt-8 border-b border-gray-200">
                <div class="flex gap-10">
                    <button class="tab-btn pb-4 text-sm font-bold text-[#8F8F7E] hover:text-[#0A174E] transition-all relative active" data-tab="tab-spek">Spesifikasi</button>
                    <button class="tab-btn pb-4 text-sm font-bold text-[#8F8F7E] hover:text-[#0A174E] transition-all relative" data-tab="tab-lokasi">Lokasi Pool</button>
                    <button class="tab-btn pb-4 text-sm font-bold text-[#8F8F7E] hover:text-[#0A174E] transition-all relative" data-tab="tab-ulasan">Ulasan Pengguna</button>
                    <button class="tab-btn pb-4 text-sm font-bold text-[#8F8F7E] hover:text-[#0A174E] transition-all relative" data-tab="tab-syarat">Ketentuan</button>
                </div>
            </div>

            {{-- Tab Content: Spesifikasi (Flat Cards) --}}
            <div id="tab-spek" class="tab-content py-10 active">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @php
                    $specs = [
                        ['icon' => 'fas fa-users', 'label' => 'Kapasitas', 'value' => $vehicle->seats . ' Penumpang'],
                        ['icon' => 'fas fa-cog', 'label' => 'Sistem Transmisi', 'value' => $vehicle->transmission],
                        ['icon' => 'fas fa-gas-pump', 'label' => 'Bahan Bakar', 'value' => $vehicle->fuel_type ?? 'Bensin'],
                        ['icon' => 'fas fa-tachometer-alt', 'label' => 'Kapasitas Mesin', 'value' => ($vehicle->engine_capacity ?? '1500') . ' CC'],
                        ['icon' => 'fas fa-map-marker-alt', 'label' => 'Lokasi Pool', 'value' => $vehicle->domicile ?? 'Jakarta'],
                        ['icon' => 'fas fa-store', 'label' => 'Penyedia (Mitra)', 'value' => $vehicle->mitra->name ?? 'Jatara Official'],
                        ['icon' => 'fas fa-shield-alt', 'label' => 'Status Keamanan', 'value' => 'Armada Terverifikasi'],
                        ['icon' => 'fas fa-check-circle', 'label' => 'Kondisi Unit', 'value' => 'Terawat & Bersih'],
                    ];
                    @endphp
                    @foreach($specs as $spec)
                    <div class="bg-gray-50 border border-gray-100 rounded-lg p-5 flex items-center gap-5">
                        <div class="w-12 h-12 bg-uber-white border border-gray-200 text-[#0A174E] rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm">
                            <i class="{{ $spec['icon'] }} text-lg"></i>
                        </div>
                        <div>
                            <p class="text-[10px] text-[#8F8F7E] font-bold uppercase tracking-widest mb-1">{{ $spec['label'] }}</p>
                            <p class="font-bold text-[#0A174E] text-sm">{{ $spec['value'] }}</p>
                            @if(isset($spec['note']))
                                <p class="text-[10px] text-[#8F8F7E] mt-0.5 italic font-medium opacity-80">{{ $spec['note'] }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            @php
                // Get pool directly from the Mitra who owns the vehicle
                $pool = $vehicle->mitra->pool ?? null;
            @endphp
            {{-- Tab Content: Lokasi Pool (Map) --}}
            <div id="tab-lokasi" class="tab-content py-10 hidden">
                <div class="space-y-6">
                    @if($pool && $pool->latitude && $pool->longitude)
            <div class="bg-gray-100/50 border border-gray-100 rounded-3xl p-8 mb-6 text-center md:text-left">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
                    <div class="flex items-center gap-5">
                        <div class="w-14 h-14 bg-white rounded-2xl shadow-sm border border-gray-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                            <i class="fas fa-map-marker-alt text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-[#8F8F7E] uppercase tracking-[0.2em] mb-1">Titik Penjemputan</p>
                            <p class="font-bold text-[#0A174E] text-lg leading-tight">{{ $pool->address ?? 'Alamat tidak tersedia' }}</p>
                        </div>
                    </div>
                    <a href="https://www.google.com/maps/search/?api=1&query={{ $pool->latitude }},{{ $pool->longitude }}" target="_blank" class="bg-white border border-gray-200 text-[#0A174E] font-bold px-6 py-3 rounded-xl text-xs hover:bg-gray-50 transition-all flex items-center gap-2 shadow-sm">
                        <i class="fas fa-directions"></i> PETUNJUK ARAH
                    </a>
                </div>
                <div id="pool-detail-map" class="w-full h-[450px] rounded-[2rem] border border-gray-200 overflow-hidden shadow-inner bg-gray-100"></div>
            </div>
            @elseif($pool)
            <div class="bg-gray-50 border border-dashed border-gray-200 rounded-3xl p-12 text-center">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm">
                    <i class="fas fa-map-pin text-gray-300 text-2xl"></i>
                </div>
                <p class="text-sm font-bold text-[#0A174E] mb-2">Koordinat Pool Belum Diatur</p>
                <p class="text-xs text-[#8F8F7E] max-w-xs mx-auto leading-relaxed">
                    Alamat terdaftar: <span class="text-[#0A174E]">{{ $pool->address }}</span>. 
                    Titik peta belum disetel oleh Mitra.
                </p>
            </div>
            @else
            <div class="py-20 text-center text-[#8F8F7E] bg-gray-50 rounded-3xl border border-dashed border-gray-200">
                <i class="fas fa-map-marked-alt text-5xl mb-6 opacity-20"></i>
                <p class="font-bold uppercase tracking-widest text-xs">Lokasi Pool Belum Tersedia</p>
            </div>
            @endif
        </div>
    </div>

            {{-- Tab Content: Syarat --}}
            <div id="tab-syarat" class="tab-content py-10 hidden">
                 <div class="max-w-2xl space-y-6">
                    @foreach (['KTP asli yang masih berlaku', 'SIM sesuai jenis kendaraan (A/C)', 'Deposit jaminan identitas', 'Minimal usia 21 tahun', 'Kendaraan dikembalikan dalam kondisi BBM awal'] as $s)
                    <div class="flex items-start gap-4 text-[#0A174E]">
                        <i class="fas fa-check mt-1 text-sm"></i>
                        <span class="text-sm font-bold leading-relaxed">{{ $s }}</span>
                    </div>
                    @endforeach
                 </div>
            </div>

            {{-- Tab Content: Ulasan --}}
            <div id="tab-ulasan" class="tab-content py-10 hidden">
                <div class="bg-[#0A174E] text-uber-white rounded-xl p-10 md:p-12 flex flex-col md:flex-row items-center gap-12 mb-10 overflow-hidden relative group/slider">
                    
                    {{-- Left: Score --}}
                    <div class="text-center md:text-left flex-shrink-0 z-10 border-b md:border-b-0 md:border-r border-white/10 pb-8 md:pb-0 md:pr-12 w-full md:w-auto">
                        <p class="text-7xl font-bold mb-2 tracking-tighter">{{ $vehicle->rating }}</p>
                        <p class="text-[10px] font-bold text-[#8F8F7E] uppercase tracking-[0.3em]">Peringkat Bintang</p>
                    </div>

                    {{-- Right: Reviews Slider --}}
                    <div class="flex-1 w-full relative z-10 overflow-hidden min-h-[140px] flex items-center">
                        <div id="review-slider" class="flex transition-transform duration-700 ease-in-out w-full">
                            @forelse($vehicle->bookings as $b)
                            <div class="flex-shrink-0 w-full">
                                 <p class="text-xl md:text-2xl font-medium leading-relaxed italic opacity-90 mb-6 line-clamp-3">
                                    "{{ $b->review }}"
                                 </p>
                                 <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 md:w-10 md:h-10 bg-white/10 rounded-full flex items-center justify-center text-sm font-bold border border-white/5 shadow-inner">
                                        {{ substr($b->customer->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-widest text-white">{{ $b->customer->name }}</p>
                                        <p class="text-[10px] font-bold text-[#8F8F7E] uppercase tracking-widest mt-0.5">{{ $b->created_at->format('d M Y') }}</p>
                                    </div>
                                 </div>
                            </div>
                            @empty
                            <div class="flex-shrink-0 w-full">
                                 <p class="text-xl md:text-2xl font-medium leading-relaxed italic opacity-90">
                                    "Kualitas kenyamanan dan keamanan armada dijamin oleh platform kami melalui pemeliharaan berkala setiap bulannya."
                                 </p>
                                 <p class="text-xs font-bold text-[#8F8F7E] uppercase tracking-widest mt-4">Pesan Layanan Kami</p>
                            </div>
                            @endforelse
                        </div>

                        {{-- Navigation Dots / Progress (Minimalist) --}}
                        @if($vehicle->bookings->count() > 1)
                        <div class="absolute bottom-0 right-0 flex gap-1.5">
                            @foreach($vehicle->bookings as $index => $b)
                            <div class="review-dot w-1.5 h-1.5 rounded-full transition-all duration-300 {{ $index === 0 ? 'bg-white w-4' : 'bg-white/20' }}"></div>
                            @endforeach
                        </div>
                        @endif

                        {{-- Simple Controls (Floating) --}}
                        @if($vehicle->bookings->count() > 1)
                        <div class="absolute inset-y-0 -left-2 -right-2 flex justify-between items-center opacity-0 group-hover/slider:opacity-100 transition-opacity pointer-events-none">
                            <button onclick="prevReview()" class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center pointer-events-auto transition-all backdrop-blur-sm border border-white/5">
                                <i class="fas fa-arrow-left text-[10px]"></i>
                            </button>
                            <button onclick="nextReview()" class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center pointer-events-auto transition-all backdrop-blur-sm border border-white/5">
                                <i class="fas fa-arrow-right text-[10px]"></i>
                            </button>
                        </div>
                        @endif
                    </div>
                </div>

            </div>

        </div>

        {{-- ===== RIGHT: BOOKING DRAWER (Uber Style) ===== --}}
        <div class="lg:col-span-1">
            <div class="bg-uber-white border border-gray-100 rounded-xl shadow-uber p-8 top-24">

                {{-- Price Banner --}}
                <div class="mb-10 text-center">
                    <p class="text-xs font-bold text-[#8F8F7E] uppercase tracking-[0.3em] mb-3">Tarif Harian</p>
                    <div class="flex items-baseline justify-center gap-2">
                        <span class="text-5xl font-bold text-[#0A174E] tracking-tighter">Rp {{ number_format($vehicle->price_per_day, 0, ',', '.') }}</span>
                        <span class="text-[#8F8F7E] font-bold">/ hari</span>
                    </div>
                </div>

                <hr class="border-gray-100 mb-10">

                {{-- Booking Form --}}
                @auth('customer')
                <form action="{{ route('checkout', $vehicle->id) }}" method="GET" class="space-y-6">
                    <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">

                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-[#8F8F7E] uppercase tracking-widest block pl-1">Penjemputan</label>
                        <div class="relative">
                            <i class="fas fa-calendar-alt absolute right-4 top-1/2 -translate-y-1/2 text-[#8F8F7E] z-10 pointer-events-none"></i>
                            <input type="text" name="start_date" id="book-start" required placeholder="YYYY-MM-DD HH:mm" class="w-full bg-[#F9F9F5] border-0 text-sm font-bold text-[#0A174E] px-4 py-3.5 rounded-lg focus:ring-2 focus:ring-uber-black transition-all cursor-pointer">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-[#8F8F7E] uppercase tracking-widest block pl-1">Pengembalian</label>
                        <div class="relative">
                            <i class="fas fa-calendar-check absolute right-4 top-1/2 -translate-y-1/2 text-[#8F8F7E] z-10 pointer-events-none"></i>
                            <input type="text" name="end_date" id="book-end" required placeholder="YYYY-MM-DD HH:mm" class="w-full bg-[#F9F9F5] border-0 text-sm font-bold text-[#0A174E] px-4 py-3.5 rounded-lg focus:ring-2 focus:ring-uber-black transition-all cursor-pointer">
                        </div>
                    </div>

                    {{-- Estimasi (Auto show) --}}
                    <div id="price-breakdown" class="hidden bg-gray-50 rounded-lg p-5 border border-gray-100 space-y-4 animate-in fade-in transition-all duration-300 overflow-hidden">
                        <div class="flex justify-between items-center text-sm font-bold">
                            <span class="text-[#8F8F7E]">Sewa <span id="days-count">0</span> hari</span>
                            <span id="subtotal" class="text-[#0A174E]">Rp 0</span>
                        </div>
                        <hr class="border-gray-200">
                        <div class="flex justify-between items-center pt-2">
                            <span class="text-sm font-bold text-[#0A174E] uppercase tracking-widest">Estimasi Total</span>
                            <span id="grand-total" class="text-2xl font-bold text-[#0A174E]">Rp 0</span>
                        </div>
                    </div>

                    @if($vehicle->available_units_count >= 1)
                        <button type="submit" class="w-full btn-primary py-5 text-base font-bold shadow-uber flex items-center justify-center gap-3">
                             Mulai Pesan Sekarang
                        </button>
                    @else
                        <button type="button" disabled class="w-full bg-[#F9F9F5] border border-gray-100 text-[#8F8F7E] py-5 text-base font-bold cursor-not-allowed flex items-center justify-center gap-3">
                             <i class="fas fa-times-circle"></i> Armada Sedang Tidak Tersedia
                        </button>
                    @endif
                    <p class="text-center text-[10px] font-bold text-[#8F8F7E] uppercase tracking-widest">Aman • Terpercaya • Cepat</p>
                </form>
                @else
                    <div class="space-y-6">
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-[#8F8F7E] uppercase tracking-widest block pl-1">Pilih Tanggal</label>
                            <input type="text" placeholder="Silahkan login untuk memilih tanggal" disabled class="w-full bg-[#F9F9F5] border-0 text-sm font-bold text-[#0A174E] px-4 py-3.5 rounded-lg opacity-50 cursor-not-allowed">
                        </div>
                        <a href="{{ route('login') }}" class="w-full btn-primary py-5 text-center block text-base font-bold shadow-uber">
                            Login
                        </a>
                    </div>
                @endauth

                <div class="mt-8 pt-8 border-t border-gray-100">
                    <a href="https://wa.me/6281234567890" target="_blank"
                        class="flex items-center justify-center gap-3 w-full bg-white border border-gray-200 text-[#0A174E] hover:bg-[#F9F9F5] font-bold py-4 rounded-lg transition-all text-sm">
                        <i class="fab fa-whatsapp text-lg"></i> Hubungi Customer Service
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Related (Uber List View) --}}
    <div class="mt-28 border-t border-gray-200 pt-20 pb-20">
         <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-4">
            <div>
                <h2 class="text-4xl font-bold text-[#0A174E] tracking-tight">Armada Lainnya</h2>
                <p class="text-uber-text font-medium mt-2">Mungkin kendaraan ini juga cocok untuk Anda.</p>
            </div>
            <a href="{{ route('browse') }}" class="text-xs font-bold text-[#0A174E] uppercase border-b-2 border-[#0A174E] pb-1">Lihat Semua Katalog</a>
         </div>

         @php
             $related = \App\Models\Vehicle::where('id', '!=', $vehicle->id)->where('type', $vehicle->type)->take(3)->get();
             if($related->count() < 3) {
                 $related = \App\Models\Vehicle::where('id', '!=', $vehicle->id)->latest()->take(3)->get();
             }
         @endphp
         
         <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            @foreach($related as $r)
            <a href="{{ route('vehicle.detail', $r->id) }}" class="group block bg-white border border-gray-200 hover:border-[#0A174E]/30 rounded-2xl p-4 transition-all cursor-pointer shadow-sm hover:shadow-md">
                <div class="block mb-6 relative aspect-video bg-[#F9F9F5] rounded-lg overflow-hidden">
                    <img src="{{ $r->image ? (strpos($r->image, 'http') === 0 ? $r->image : asset('storage/' . $r->image)) : 'https://placehold.co/600x400?text=' . urlencode($r->name) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" alt="{{ $r->name }}">
                </div>
                <div class="flex justify-between items-start mb-2">
                    <h3 class="text-xl font-bold text-[#0A174E]">{{ $r->name }}</h3>
                    <span class="font-bold text-[#0A174E]">Rp {{ number_format($r->price_per_day, 0, ',', '.') }}</span>
                </div>
                <p class="text-sm font-medium text-[#8F8F7E]">{{ $r->seats }} Kursi • {{ $r->transmission }}</p>
            </a>
            @endforeach
         </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    // Tab system
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => {
                c.classList.add('hidden');
                c.classList.remove('active');
            });
            this.classList.add('active');
            const target = document.getElementById(this.dataset.tab);
            target.classList.remove('hidden');
            target.classList.add('active');
        });
    });
    
    // Review Slider Logic
    let currentReview = 0;
    const sliderContainer = document.getElementById('review-slider');
    const dots = document.querySelectorAll('.review-dot');
    const totalReviews = {{ $vehicle->bookings->count() }};
    
    window.updateReviewSlider = function() {
        if(!sliderContainer) return;
        sliderContainer.style.transform = `translateX(-${currentReview * 100}%)`;
        
        dots.forEach((dot, idx) => {
            if(idx === currentReview) {
                dot.classList.add('bg-white', 'w-4');
                dot.classList.remove('bg-white/20');
            } else {
                dot.classList.remove('bg-white', 'w-4');
                dot.classList.add('bg-white/20', 'w-1.5');
            }
        });
    }

    window.nextReview = function() {
        if(totalReviews <= 1) return;
        currentReview = (currentReview + 1) % totalReviews;
        updateReviewSlider();
    }

    window.prevReview = function() {
        if(totalReviews <= 1) return;
        currentReview = (currentReview - 1 + totalReviews) % totalReviews;
        updateReviewSlider();
    }

    if(totalReviews > 1) {
        setInterval(nextReview, 6000);
    }

    // Price calculator
    const startInput = document.getElementById('book-start');
    const endInput   = document.getElementById('book-end');
    const priceBreakdown = document.getElementById('price-breakdown');
    const pricePerDay = {{ $vehicle->price_per_day }};

    // Flatpickr advanced date configuration
    const disabledDates = {!! json_encode($vehicle->getFullyBookedDates()) !!};
    let startPicker = null;
    let endPicker = null;

    if(startInput && endInput) {
        const today = new Date();
        const tomorrow = new Date(today); tomorrow.setDate(today.getDate() + 1);

        function updatePrice() {
            if(!startInput.value || !endInput.value) return;
            const s = new Date(startInput.value);
            const e = new Date(endInput.value);
            if (isNaN(s) || isNaN(e) || e <= s) { priceBreakdown.classList.add('hidden'); return; }

            const diffMs = e - s;
            const hours = Math.ceil(diffMs / (1000 * 60 * 60));
            const days = Math.ceil(hours / 24);
            const subtotal = days * pricePerDay;

            document.getElementById('days-count').textContent = days;
            document.getElementById('subtotal').textContent   = 'Rp ' + subtotal.toLocaleString('id-ID');
            document.getElementById('grand-total').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
            priceBreakdown.classList.remove('hidden');
        }

        startPicker = flatpickr(startInput, {
            dateFormat: "Y-m-d H:i",
            enableTime: true,
            time_24hr: true,
            minDate: "today",
            disable: disabledDates,
            defaultDate: today,
            onChange: function(selectedDates, dateStr, instance) {
                if(selectedDates[0]) {
                    const nextDate = new Date(selectedDates[0]);
                    nextDate.setDate(nextDate.getDate() + 1);
                    endPicker.set('minDate', nextDate);
                    
                    if(endPicker.selectedDates[0] <= selectedDates[0]) {
                        endPicker.setDate(nextDate);
                    }
                }
                updatePrice();
            }
        });

        endPicker = flatpickr(endInput, {
            dateFormat: "Y-m-d H:i",
            enableTime: true,
            time_24hr: true,
            minDate: tomorrow,
            disable: disabledDates,
            defaultDate: tomorrow,
            onChange: function() {
                updatePrice();
            }
        });

        updatePrice();
    }

    // Swiper Initialization
    const vehicleSwiper = new Swiper('.vehicle-swiper', {
        loop: true,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        on: {
            slideChange: function () {
                const thumbnails = document.querySelectorAll('.thumbnail-item');
                thumbnails.forEach((thumb, index) => {
                    if (index === this.realIndex) {
                        thumb.classList.add('active');
                    } else {
                        thumb.classList.remove('active');
                    }
                });
            }
        }
    });
 
    function goToSlide(index) {
        vehicleSwiper.slideToLoop(index);
    }
</script>
@endpush

@php
    $pool = $vehicle->mitra->pool ?? null;
@endphp

@if($pool && $pool->latitude && $pool->longitude)
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #pool-detail-map { 
        height: 450px !important; 
        width: 100% !important;
        display: block !important;
        z-index: 1;
        background: #f1f5f9;
        border-radius: 2rem;
    }
    .leaflet-container { height: 100% !important; width: 100% !important; border-radius: 2rem; }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    let detailMapTracker = null;

    // Fix Leaflet marker icon issue from CDN
    delete L.Icon.Default.prototype._getIconUrl;
    L.Icon.Default.mergeOptions({
        iconRetinaUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon-2x.png',
        iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
        shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
    });

    function renderMapNow() {
        if (detailMapTracker) {
            detailMapTracker.invalidateSize();
            return;
        }

        const lat = parseFloat("{{ number_format($pool->latitude, 8, '.', '') }}");
        const lng = parseFloat("{{ number_format($pool->longitude, 8, '.', '') }}");
        
        const container = document.getElementById('pool-detail-map');
        if (!container) return;

        try {
            detailMapTracker = L.map('pool-detail-map', {
                scrollWheelZoom: false,
                zoomControl: true
            }).setView([lat, lng], 16);

            L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; OpenStreetMap &copy; CARTO',
                subdomains: 'abcd',
                maxZoom: 20
            }).addTo(detailMapTracker);

            const marker = L.marker([lat, lng]).addTo(detailMapTracker);
            
            marker.bindPopup(`
                <div style="font-family: 'Inter', sans-serif; min-width: 150px;">
                    <p style="font-weight: 800; color: #121212; margin-bottom: 4px; font-size: 14px;">{{ $pool->name }}</p>
                    <p style="font-size: 11px; color: #5e5e5e; line-height: 1.4; margin: 0;">{{ $pool->address }}</p>
                </div>
            `).openPopup();
            
            // Re-render size after init to catch visibility changes
            setTimeout(() => detailMapTracker.invalidateSize(), 500);
        } catch (e) {
            console.error("Map initialization failed:", e);
        }
    }

    // Listener Tab - use delegation for robustness
    document.addEventListener('click', function(e) {
        let target = e.target;
        while (target && target !== document) {
            if (target.dataset && target.dataset.tab === 'tab-lokasi') {
                setTimeout(renderMapNow, 400);
                break;
            }
            target = target.parentNode;
        }
    });

    // Auto-fix if direct link or refresh
    document.addEventListener('DOMContentLoaded', function() {
        const activeTab = document.querySelector('.tab-btn.active');
        if (activeTab && activeTab.dataset.tab === 'tab-lokasi') {
            setTimeout(renderMapNow, 600);
        }
    });
</script>
@endpush
@endif
