@extends('layouts.app')

@section('title', 'Detail Kendaraan')

@push('styles')
<style>
    .tab-btn.active { border-bottom: 2px solid #000000; color: #000000; font-weight: 700; }
    .tab-content.active { display: block; }
    input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(0);
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Breadcrumb (Uber style) --}}
    <nav class="flex items-center gap-2 text-xs font-bold text-uber-muted mb-8 uppercase tracking-widest">
        <a href="{{ route('home') }}" class="hover:text-uber-black transition-colors">Beranda</a>
        <i class="fas fa-chevron-right text-[8px]"></i>
        <a href="{{ route('browse') }}" class="hover:text-uber-black transition-colors">Armada</a>
        <i class="fas fa-chevron-right text-[8px]"></i>
        <span class="text-uber-black">{{ $vehicle->name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 lg:gap-20">

        {{-- ===== LEFT: CONTENT ===== --}}
        <div class="lg:col-span-2">

            {{-- Main Image (No heavy shadow, clean border-radius) --}}
            <div class="bg-uber-chip rounded-xl overflow-hidden aspect-[16/9] relative border border-gray-100">
                <img id="main-image" src="{{ $vehicle->image ? (strpos($vehicle->image, 'http') === 0 ? $vehicle->image : asset('storage/' . $vehicle->image)) : 'https://placehold.co/1200x800?text=No+Image' }}"
                    class="w-full h-full object-cover" alt="{{ $vehicle->name }}">

                {{-- Badges --}}
                <div class="absolute top-5 left-5 flex gap-2">
                    @if($vehicle->available_units_count >= 1)
                        <span class="bg-uber-white text-uber-black text-[10px] font-bold px-3 py-1.5 rounded shadow-sm border border-gray-100 uppercase tracking-widest">Tersedia</span>
                    @else
                        <span class="bg-uber-black text-uber-white text-[10px] font-bold px-3 py-1.5 rounded shadow-sm uppercase tracking-widest">Tidak Tersedia</span>
                    @endif
                    @if($vehicle->rating >= 4.8)
                    <span class="bg-uber-black text-uber-white text-[10px] font-bold px-3 py-1.5 rounded shadow-sm uppercase tracking-widest">
                        ⭐ Unggulan
                    </span>
                    @endif
                </div>
            </div>

            {{-- Gallery Thumbnails --}}
            @if($vehicle->images->count() > 0)
            <div class="mt-4 flex gap-3 overflow-x-auto pb-2 scrollbar-none">
                <div class="thumbnail-item flex-shrink-0 w-24 aspect-video rounded-lg overflow-hidden border-2 border-uber-black cursor-pointer bg-slate-100" 
                     onclick="changeMainImg('{{ $vehicle->image ? (strpos($vehicle->image, 'http') === 0 ? $vehicle->image : asset('storage/' . $vehicle->image)) : 'https://placehold.co/1200x800?text=No+Image' }}', this)">
                    <img src="{{ $vehicle->image ? (strpos($vehicle->image, 'http') === 0 ? $vehicle->image : asset('storage/' . $vehicle->image)) : 'https://placehold.co/1200x800?text=No+Image' }}" class="w-full h-full object-cover">
                </div>
                @foreach($vehicle->images as $img)
                <div class="thumbnail-item flex-shrink-0 w-24 aspect-video rounded-lg overflow-hidden border-2 border-transparent hover:border-gray-300 cursor-pointer bg-slate-100 transition-all" 
                     onclick="changeMainImg('{{ asset('storage/' . $img->image_path) }}', this)">
                    <img src="{{ asset('storage/' . $img->image_path) }}" class="w-full h-full object-cover">
                </div>
                @endforeach
            </div>
            @endif

            {{-- Titles --}}
            <div class="mt-10 mb-8">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-4xl md:text-5xl font-bold text-uber-black tracking-tighter">{{ $vehicle->name }}</h1>
                        <p class="text-uber-text font-medium mt-2 text-lg uppercase tracking-wide">
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
                        <div class="flex items-center gap-1.5 text-uber-black mb-1">
                            <i class="fas fa-star text-lg"></i>
                            <span class="text-xl font-bold">{{ $vehicle->rating }}</span>
                            <span class="text-sm font-medium text-uber-muted ml-0.5">({{ $vehicle->reviews_count }} Ulasan)</span>
                        </div>
                        <span class="text-xs font-bold text-uber-muted uppercase tracking-widest">Skor User</span>
                    </div>
                </div>
            </div>

            {{-- Tabs (Uber style: Flat Underline) --}}
            <div class="mt-8 border-b border-gray-200">
                <div class="flex gap-10">
                    <button class="tab-btn pb-4 text-sm font-bold text-uber-muted hover:text-uber-black transition-all relative active" data-tab="tab-spek">Spesifikasi</button>
                    <button class="tab-btn pb-4 text-sm font-bold text-uber-muted hover:text-uber-black transition-all relative" data-tab="tab-ulasan">Ulasan Pengguna</button>
                    <button class="tab-btn pb-4 text-sm font-bold text-uber-muted hover:text-uber-black transition-all relative" data-tab="tab-syarat">Ketentuan</button>
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
                        ['icon' => 'fas fa-car-side', 'label' => 'Unit Tersedia', 'value' => ($vehicle->available_units_count ?? '1') . ' Unit'],
                        ['icon' => 'fas fa-map-marker-alt', 'label' => 'Lokasi Penempatan', 'value' => $vehicle->domicile ?? 'Jakarta'],
                        ['icon' => 'fas fa-user-tie', 'label' => 'Layanan Sopir', 'value' => 'Tersedia (+Rp ' . number_format($vehicle->driver_price, 0, ',', '.') . '/hari)'],
                        ['icon' => 'fas fa-shield-alt', 'label' => 'Status Keamanan', 'value' => 'Armada Terverifikasi'],
                        ['icon' => 'fas fa-check-circle', 'label' => 'Kondisi Unit', 'value' => 'Terawat & Bersih'],
                    ];
                    @endphp
                    @foreach($specs as $spec)
                    <div class="bg-gray-50 border border-gray-100 rounded-lg p-5 flex items-center gap-5">
                        <div class="w-12 h-12 bg-uber-white border border-gray-200 text-uber-black rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm">
                            <i class="{{ $spec['icon'] }} text-lg"></i>
                        </div>
                        <div>
                            <p class="text-[10px] text-uber-muted font-bold uppercase tracking-widest mb-1">{{ $spec['label'] }}</p>
                            <p class="font-bold text-uber-black text-sm">{{ $spec['value'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Tab Content: Syarat --}}
            <div id="tab-syarat" class="tab-content py-10 hidden">
                 <div class="max-w-2xl space-y-6">
                    @foreach (['KTP asli yang masih berlaku', 'SIM sesuai jenis kendaraan (A/C)', 'Deposit jaminan identitas', 'Minimal usia 21 tahun', 'Kendaraan dikembalikan dalam kondisi BBM awal'] as $s)
                    <div class="flex items-start gap-4 text-uber-black">
                        <i class="fas fa-check mt-1 text-sm"></i>
                        <span class="text-sm font-bold leading-relaxed">{{ $s }}</span>
                    </div>
                    @endforeach
                 </div>
            </div>

            {{-- Tab Content: Ulasan --}}
            <div id="tab-ulasan" class="tab-content py-10 hidden">
                <div class="bg-uber-black text-uber-white rounded-xl p-10 md:p-12 flex flex-col md:flex-row items-center gap-12 mb-10 overflow-hidden relative group/slider">
                    
                    {{-- Left: Score --}}
                    <div class="text-center md:text-left flex-shrink-0 z-10 border-b md:border-b-0 md:border-r border-white/10 pb-8 md:pb-0 md:pr-12 w-full md:w-auto">
                        <p class="text-7xl font-bold mb-2 tracking-tighter">{{ $vehicle->rating }}</p>
                        <p class="text-[10px] font-bold text-uber-muted uppercase tracking-[0.3em]">Peringkat Bintang</p>
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
                                        {{ substr($b->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-widest text-white">{{ $b->user->name }}</p>
                                        <p class="text-[10px] font-bold text-uber-muted uppercase tracking-widest mt-0.5">{{ $b->created_at->format('d M Y') }}</p>
                                    </div>
                                 </div>
                            </div>
                            @empty
                            <div class="flex-shrink-0 w-full">
                                 <p class="text-xl md:text-2xl font-medium leading-relaxed italic opacity-90">
                                    "Kualitas kenyamanan dan keamanan armada dijamin oleh platform kami melalui pemeliharaan berkala setiap bulannya."
                                 </p>
                                 <p class="text-xs font-bold text-uber-muted uppercase tracking-widest mt-4">Pesan Layanan Kami</p>
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
            <div class="bg-uber-white border border-gray-100 rounded-xl shadow-uber p-8 sticky top-24">

                {{-- Price Banner --}}
                <div class="mb-10 text-center">
                    <p class="text-xs font-bold text-uber-muted uppercase tracking-[0.3em] mb-3">Tarif Harian</p>
                    <div class="flex items-baseline justify-center gap-2">
                        <span class="text-5xl font-bold text-uber-black tracking-tighter">Rp {{ number_format($vehicle->price_per_day, 0, ',', '.') }}</span>
                        <span class="text-uber-muted font-bold">/ hari</span>
                    </div>
                </div>

                <hr class="border-gray-100 mb-10">

                {{-- Booking Form --}}
                @auth
                <form action="{{ route('checkout', $vehicle->id) }}" method="GET" class="space-y-6">
                    <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">

                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-uber-muted uppercase tracking-widest block pl-1">Penjemputan</label>
                        <div class="relative">
                            <i class="fas fa-calendar-alt absolute right-4 top-1/2 -translate-y-1/2 text-uber-muted"></i>
                            <input type="date" name="start_date" id="book-start" required class="w-full bg-uber-chip border-0 text-sm font-bold text-uber-black px-4 py-3.5 rounded-lg focus:ring-2 focus:ring-uber-black transition-all">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-uber-muted uppercase tracking-widest block pl-1">Pengembalian</label>
                        <div class="relative">
                            <i class="fas fa-calendar-check absolute right-4 top-1/2 -translate-y-1/2 text-uber-muted"></i>
                            <input type="date" name="end_date" id="book-end" required class="w-full bg-uber-chip border-0 text-sm font-bold text-uber-black px-4 py-3.5 rounded-lg focus:ring-2 focus:ring-uber-black transition-all">
                        </div>
                    </div>

                    {{-- Estimasi (Auto show) --}}
                    <div id="price-breakdown" class="hidden bg-gray-50 rounded-lg p-5 border border-gray-100 space-y-4 animate-in fade-in transition-all duration-300 overflow-hidden">
                        <div class="flex justify-between items-center text-sm font-bold">
                            <span class="text-uber-muted">Sewa <span id="days-count">0</span> hari</span>
                            <span id="subtotal" class="text-uber-black">Rp 0</span>
                        </div>
                        <div class="flex justify-between items-center text-sm font-bold">
                            <span class="text-uber-muted">Biaya Operasional</span>
                            <span class="text-uber-black">Rp 50.000</span>
                        </div>
                        <hr class="border-gray-200">
                        <div class="flex justify-between items-center pt-2">
                            <span class="text-sm font-bold text-uber-black uppercase tracking-widest">Estimasi Total</span>
                            <span id="grand-total" class="text-2xl font-bold text-uber-black">Rp 0</span>
                        </div>
                    </div>

                    @if($vehicle->available_units_count >= 1)
                        <button type="submit" class="w-full btn-primary py-5 text-base font-bold shadow-uber flex items-center justify-center gap-3">
                             Mulai Pesan Sekarang
                        </button>
                    @else
                        <button type="button" disabled class="w-full bg-uber-chip border border-gray-100 text-uber-muted py-5 text-base font-bold cursor-not-allowed flex items-center justify-center gap-3">
                             <i class="fas fa-times-circle"></i> Armada Sedang Tidak Tersedia
                        </button>
                    @endif
                    <p class="text-center text-[10px] font-bold text-uber-muted uppercase tracking-widest">Aman • Terpercaya • Cepat</p>
                </form>
                @else
                    <div class="space-y-6">
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-uber-muted uppercase tracking-widest block pl-1">Pilih Tanggal</label>
                            <input type="text" placeholder="Gunakan akun Anda untuk memesan" disabled class="w-full bg-uber-chip border-0 text-sm font-bold text-uber-black px-4 py-3.5 rounded-lg opacity-50 cursor-not-allowed">
                        </div>
                        <a href="{{ route('login') }}" class="w-full btn-primary py-5 text-center block text-base font-bold shadow-uber">
                            Login Untuk Pesan
                        </a>
                    </div>
                @endauth

                <div class="mt-8 pt-8 border-t border-gray-100">
                    <a href="https://wa.me/6281234567890" target="_blank"
                        class="flex items-center justify-center gap-3 w-full bg-white border border-gray-200 text-uber-black hover:bg-uber-chip font-bold py-4 rounded-lg transition-all text-sm">
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
                <h2 class="text-4xl font-bold text-uber-black tracking-tight">Armada Lainnya</h2>
                <p class="text-uber-text font-medium mt-2">Mungkin kendaraan ini juga cocok untuk Anda.</p>
            </div>
            <a href="{{ route('browse') }}" class="text-xs font-bold text-uber-black uppercase border-b-2 border-uber-black pb-1">Lihat Semua Katalog</a>
         </div>

         @php
             $related = \App\Models\Vehicle::where('id', '!=', $vehicle->id)->where('type', $vehicle->type)->take(3)->get();
             if($related->count() < 3) {
                 $related = \App\Models\Vehicle::where('id', '!=', $vehicle->id)->latest()->take(3)->get();
             }
         @endphp
         
         <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            @foreach($related as $r)
            <div class="group border-0 border-b border-gray-100 pb-8 md:border-0 md:pb-0">
                <a href="{{ route('vehicle.detail', $r->id) }}" class="block mb-6 relative aspect-video bg-uber-chip rounded-lg overflow-hidden">
                    <img src="{{ $r->image ? (strpos($r->image, 'http') === 0 ? $r->image : asset('storage/' . $r->image)) : 'https://placehold.co/600x400?text=' . urlencode($r->name) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" alt="{{ $r->name }}">
                </a>
                <div class="flex justify-between items-start mb-2">
                    <h3 class="text-xl font-bold text-uber-black">{{ $r->name }}</h3>
                    <span class="font-bold text-uber-black">Rp {{ number_format($r->price_per_day, 0, ',', '.') }}</span>
                </div>
                <p class="text-sm font-medium text-uber-muted">{{ $r->seats }} Kursi • {{ $r->transmission }}</p>
                <a href="{{ route('vehicle.detail', $r->id) }}" class="mt-4 inline-block text-xs font-bold uppercase tracking-widest text-uber-black hover:underline underline-offset-4">Detail Unit <i class="fas fa-chevron-right text-[8px] ml-1"></i></a>
            </div>
            @endforeach
         </div>
    </div>
</div>
@endsection

@push('scripts')
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
    const serviceFee  = 50000;

    if(startInput && endInput) {
        const fmt = d => d.toISOString().split('T')[0];
        const today = new Date();
        const tomorrow = new Date(today); tomorrow.setDate(today.getDate() + 1);
        startInput.value = fmt(today);
        startInput.min = fmt(today);
        endInput.value   = fmt(tomorrow);
        endInput.min = fmt(tomorrow);
        updatePrice();

        function updatePrice() {
            const s = new Date(startInput.value);
            const e = new Date(endInput.value);
            if (isNaN(s) || isNaN(e) || e <= s) { priceBreakdown.classList.add('hidden'); return; }

            const days = Math.ceil((e - s) / (1000*60*60*24));
            const subtotal = days * pricePerDay;
            const total = subtotal + serviceFee;

            document.getElementById('days-count').textContent = days;
            document.getElementById('subtotal').textContent   = 'Rp ' + subtotal.toLocaleString('id-ID');
            document.getElementById('grand-total').textContent = 'Rp ' + total.toLocaleString('id-ID');
            priceBreakdown.classList.remove('hidden');
        }

        startInput.addEventListener('change', function() {
            endInput.min = this.value;
            if (endInput.value && endInput.value <= this.value) {
                const next = new Date(this.value); next.setDate(next.getDate()+1);
                endInput.value = fmt(next);
            }
            updatePrice();
        });
        endInput.addEventListener('change', updatePrice);
    }

    // Gallery Switcher
    function changeMainImg(src, el) {
        document.getElementById('main-image').src = src;
        document.querySelectorAll('.thumbnail-item').forEach(item => {
            item.classList.remove('border-uber-black');
            item.classList.add('border-transparent');
        });
        el.classList.add('border-uber-black');
        el.classList.remove('border-transparent');
    }
</script>
@endpush
