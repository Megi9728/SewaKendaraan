@extends('layouts.app')

@section('title', 'Detail Kendaraan')

@push('styles')
<style>
    .thumb-img { transition: all 0.2s; cursor: pointer; }
    .thumb-img.active { border-color: #2563eb; }
    .tab-btn.active { border-bottom: 2px solid #2563eb; color: #2563eb; font-weight: 700; }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-slate-400 mb-8">
        <a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors font-medium">Beranda</a>
        <i class="fas fa-chevron-right text-[10px]"></i>
        <a href="{{ route('browse') }}" class="hover:text-blue-600 transition-colors font-medium">Jelajahi</a>
        <i class="fas fa-chevron-right text-[10px]"></i>
        <span class="text-slate-900 font-bold tracking-tight">{{ $vehicle->name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

        {{-- ===== LEFT: GALLERY & DETAILS ===== --}}
        <div class="lg:col-span-2">

            {{-- Main Image --}}
            <div class="bg-white border border-slate-100 rounded-3xl overflow-hidden h-[450px] relative shadow-sm group">
                <img id="main-image" src="{{ $vehicle->image ? (strpos($vehicle->image, 'http') === 0 ? $vehicle->image : asset('storage/' . $vehicle->image)) : 'https://placehold.co/900x600?text=No+Image' }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-all duration-700" alt="{{ $vehicle->name }}">

                {{-- Badge --}}
                <div class="absolute top-6 left-6 flex gap-2">
                    <span class="{{ $vehicle->status == 'Tersedia' ? 'bg-green-500' : 'bg-blue-600' }} text-white text-[11px] font-bold px-4 py-2 rounded-xl flex items-center gap-2 shadow-xl shadow-black/10 uppercase tracking-widest">
                        <i class="fas {{ $vehicle->status == 'Tersedia' ? 'fa-check-circle' : 'fa-clock' }}"></i> {{ $vehicle->status }}
                    </span>
                    <span class="bg-slate-900/80 backdrop-blur-md text-white text-[11px] font-bold px-4 py-2 rounded-xl flex items-center gap-2 shadow-xl shadow-black/10 uppercase tracking-widest">
                        <i class="fas fa-certificate text-blue-400"></i> Premium
                    </span>
                </div>
            </div>

            {{-- Tabs --}}
            <div class="mt-10 border-b border-slate-200">
                <div class="flex gap-8">
                    @foreach(['Spesifikasi' => 'tab-spek', 'Syarat Sewa' => 'tab-syarat', 'Ulasan' => 'tab-ulasan'] as $label => $tabId)
                    <button class="tab-btn pb-4 text-sm font-bold text-slate-400 hover:text-blue-600 transition-all relative {{ $loop->first ? 'active' : '' }}"
                        data-tab="{{ $tabId }}">
                        {{ $label }}
                    </button>
                    @endforeach
                </div>
            </div>

            {{-- Tab Content: Spesifikasi --}}
            <div id="tab-spek" class="tab-content py-8">
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-5">
                    @php
                    $specs = [
                        ['icon' => 'fas fa-users', 'label' => 'Kapasitas', 'value' => $vehicle->seats . ' Penumpang'],
                        ['icon' => 'fas fa-cog', 'label' => 'Transmisi', 'value' => $vehicle->transmission],
                        ['icon' => 'fas fa-gas-pump', 'label' => 'Kategori', 'value' => $vehicle->type],
                        ['icon' => 'fas fa-map-marker-alt', 'label' => 'Domisili', 'value' => $vehicle->domicile ?? 'Jakarta'],
                        ['icon' => 'fas fa-star', 'label' => 'Rating', 'value' => $vehicle->rating . ' / 5.0'],
                        ['icon' => 'fas fa-shield-alt', 'label' => 'Asuransi', 'value' => 'Terlindungi'],
                    ];
                    @endphp
                    @foreach($specs as $spec)
                    <div class="bg-white border border-slate-50 rounded-2xl p-5 flex items-center gap-4 shadow-sm">
                        <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="{{ $spec['icon'] }} text-sm"></i>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-0.5">{{ $spec['label'] }}</p>
                            <p class="font-extrabold text-slate-800 text-sm leading-tight">{{ $spec['value'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Tab Content: Syarat Sewa --}}
            <div id="tab-syarat" class="tab-content py-8 hidden space-y-4">
                @foreach (['KTP asli yang masih berlaku', 'SIM A yang masih berlaku (untuk mobil)', 'Jaminan identitas asli', 'Minimal usia 21 tahun', 'Dilarang membawa barang berbau tajam'] as $s)
                <div class="flex items-center gap-4 text-slate-600 bg-slate-50 p-4 rounded-xl border border-slate-100">
                    <i class="fas fa-check-circle text-blue-600"></i>
                    <span class="text-sm font-medium">{{ $s }}</span>
                </div>
                @endforeach
            </div>

            {{-- Tab Content: Ulasan --}}
            <div id="tab-ulasan" class="tab-content py-8 hidden">
                @php
                    $reviews = \App\Models\Booking::where('vehicle_id', $vehicle->id)
                        ->whereNotNull('rating')
                        ->where('review', '!=', '')
                        ->with('user')
                        ->latest()
                        ->take(10)
                        ->get();
                @endphp

                <div class="bg-blue-600 rounded-3xl p-8 text-white flex flex-col md:flex-row items-center gap-10 shadow-lg shadow-blue-200 mb-8 overflow-hidden">
                    <div class="text-center md:text-left flex-shrink-0">
                        <p class="text-6xl font-black mb-2">{{ number_format((float) $vehicle->rating, 1, '.', '') }}</p>
                        <div class="flex gap-1 text-yellow-400 mb-2 justify-center md:justify-start">
                            @for($i=1; $i<=5; $i++) <i class="fas fa-star text-sm {{ $i <= round((float)$vehicle->rating) ? '' : 'opacity-40 text-white' }}"></i> @endfor
                        </div>
                        <p class="text-xs font-bold opacity-80 uppercase tracking-widest">Skor Kepuasan</p>
                    </div>
                    <div class="h-px md:h-32 w-full md:w-px bg-white/20 flex-shrink-0"></div>
                    
                    <div class="flex-1 w-full min-w-0 relative group" id="review-carousel-container">
                        @if($reviews->count() > 0)
                            <div class="overflow-hidden w-full h-full relative">
                                <div id="review-slider" class="flex transition-transform duration-500 ease-out w-full items-center h-full">
                                    @foreach($reviews as $r)
                                    <div class="w-full flex-shrink-0 px-4 flex flex-col justify-center">
                                        <div class="flex items-center gap-4 mb-4">
                                            <div class="w-12 h-12 rounded-full bg-white/20 text-white flex items-center justify-center font-bold text-lg flex-shrink-0 shadow-inner">
                                                {{ substr($r->user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="flex items-center gap-2">
                                                    <h5 class="font-bold text-white">{{ $r->user->name }}</h5>
                                                    <span class="text-[10px] text-white/60">• {{ $r->updated_at->diffForHumans() }}</span>
                                                </div>
                                                <div class="flex gap-1 text-yellow-400 mt-1 text-[10px]">
                                                    @for($i=1; $i<=5; $i++)
                                                        <i class="fas fa-star {{ $i <= $r->rating ? '' : 'opacity-30 text-white' }}"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-base leading-relaxed opacity-95 italic font-medium">"{{ $r->review }}"</p>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            @if($reviews->count() > 1)
                                {{-- Carousel Controls --}}
                                <button id="prev-review" class="absolute left-0 top-1/2 -translate-y-1/2 bg-black/20 hover:bg-black/40 text-white rounded-full w-8 h-8 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity z-10 -ml-2 focus:outline-none backdrop-blur-sm"><i class="fas fa-chevron-left text-xs"></i></button>
                                <button id="next-review" class="absolute right-0 top-1/2 -translate-y-1/2 bg-black/20 hover:bg-black/40 text-white rounded-full w-8 h-8 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity z-10 -mr-2 focus:outline-none backdrop-blur-sm"><i class="fas fa-chevron-right text-xs"></i></button>
                                
                                {{-- Dots --}}
                                <div class="absolute -bottom-2 left-1/2 -translate-x-1/2 flex gap-1.5 opacity-0 group-hover:opacity-100 transition-opacity" id="review-dots">
                                    @foreach($reviews as $k => $r)
                                        <button class="w-1.5 h-1.5 rounded-full bg-white/40 hover:bg-white transition-colors dot-btn" data-index="{{ $k }}"></button>
                                    @endforeach
                                </div>
                            @endif
                        @else
                            <div class="flex flex-col justify-center h-full px-4">
                                <p class="text-base leading-relaxed opacity-95 italic font-medium">"Rating ini didapatkan dari akumulasi penilaian kondisi armada dan kepuasan pelanggan."</p>
                                <p class="text-xs opacity-75 mt-3"><i class="fas fa-info-circle"></i> Belum ada ulasan tertulis terbaru.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        {{-- ===== RIGHT: BOOKING CARD ===== --}}
        <div class="lg:col-span-1">
            <div class="bg-white border border-slate-100 rounded-[2.5rem] shadow-2xl p-8 top-24">

                {{-- Price --}}
                <div class="mb-8">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-2">Harga Sewa</p>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-black text-slate-900 leading-none">Rp {{ number_format($vehicle->price_per_day, 0, ',', '.') }}</span>
                        <span class="text-slate-400 font-bold">/ hari</span>
                    </div>
                </div>

                {{-- Booking Form --}}
                @auth
                <form action="{{ route('checkout', $vehicle->id) }}" method="GET">
                    <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">

                    {{-- Date Picker --}}
                    <div class="space-y-4 mb-8">
                        <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100 space-y-4">
                            <div>
                                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest block mb-2">Tanggal Mulai</label>
                                <input type="date" name="start_date" id="book-start" required class="w-full bg-transparent text-slate-900 font-bold focus:outline-none text-sm p-0">
                            </div>
                            <hr class="border-slate-200">
                            <div>
                                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest block mb-2">Tanggal Selesai</label>
                                <input type="date" name="end_date" id="book-end" required class="w-full bg-transparent text-slate-900 font-bold focus:outline-none text-sm p-0">
                            </div>
                        </div>
                    </div>



                    {{-- Price Breakdown --}}
                    <div id="price-breakdown" class="bg-blue-50/50 rounded-2xl p-6 mb-8 space-y-3 text-sm hidden border border-blue-100/50 transition-all duration-500">
                        <div class="flex justify-between text-slate-600">
                            <span class="font-medium text-xs">Sewa {{ number_format($vehicle->price_per_day, 0, ',', '.') }} × <span id="days-count" class="font-bold">0</span> hari</span>
                            <span id="subtotal" class="font-bold text-slate-900">Rp 0</span>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <span class="font-medium text-xs">Biaya Layanan & Pajak</span>
                            <span class="font-bold text-slate-900">Rp 50.000</span>
                        </div>
                        <div class="pt-4 border-t border-blue-200/50 flex justify-between items-center text-slate-900">
                            <span class="font-bold">Total Pembayaran</span>
                            <span id="grand-total" class="text-xl font-black text-blue-600">Rp 0</span>
                        </div>
                    </div>

                    {{-- CTA --}}
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-5 rounded-2xl transition-all active:scale-95 shadow-xl shadow-blue-200 text-sm flex items-center justify-center gap-3">
                        <i class="fas fa-arrow-right lg:text-lg"></i>
                        LANJUTKAN PESANAN
                    </button>
                </form>
                @else
                    {{-- Date Picker (Static for Guests) --}}
                    <div class="space-y-4 mb-8">
                        <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100 space-y-4">
                            <div>
                                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest block mb-2">Tanggal Mulai</label>
                                <input type="date" id="book-start" class="w-full bg-transparent text-slate-900 font-bold focus:outline-none text-sm p-0">
                            </div>
                            <hr class="border-slate-200">
                            <div>
                                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest block mb-2">Tanggal Selesai</label>
                                <input type="date" id="book-end" class="w-full bg-transparent text-slate-900 font-bold focus:outline-none text-sm p-0">
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('login') }}" class="block w-full text-center bg-slate-900 hover:bg-slate-800 text-white font-black py-5 rounded-2xl transition-all active:scale-95 shadow-xl shadow-slate-200 text-sm">
                        <i class="fas fa-sign-in-alt mr-2"></i> LOGIN UNTUK MEMESAN
                    </a>
                @endauth
                
                <p class="text-center text-[10px] font-bold text-slate-400 mt-5 uppercase tracking-widest">Proses cepat & tanpa biaya admin</p>

                <hr class="my-8 border-slate-100">

                {{-- Chat CS --}}
                <a href="https://wa.me/6281234567890" target="_blank"
                    class="flex items-center justify-center gap-3 w-full bg-green-50 hover:bg-green-100 text-green-600 font-bold py-4 rounded-2xl transition-all text-sm border border-green-100">
                    <i class="fab fa-whatsapp text-xl"></i> Konsultasi via WhatsApp
                </a>
            </div>
        </div>
    </div>

    {{-- Related Vehicles --}}
    <div class="mt-24">
        @php
            $related = \App\Models\Vehicle::where('id', '!=', $vehicle->id)->where('type', $vehicle->type)->take(3)->get();
            if($related->count() < 3) {
                $related = \App\Models\Vehicle::where('id', '!=', $vehicle->id)->latest()->take(3)->get();
            }
        @endphp
        <div class="flex items-center justify-between mb-10">
            <div>
                <h2 class="text-3xl font-black text-slate-900">Kendaraan <span class="text-blue-600">Serupa</span></h2>
                <p class="text-slate-400 text-sm mt-1">Mungkin Anda juga tertarik dengan armada ini</p>
            </div>
            <a href="{{ route('browse') }}" class="text-blue-600 font-bold text-sm hover:underline">Lihat Semua</a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($related as $r)
            <div class="group bg-white rounded-3xl border border-slate-100 p-4 hover:shadow-2xl transition-all duration-500">
                <div class="h-44 rounded-2xl overflow-hidden mb-5">
                    <img src="{{ $r->image ? (strpos($r->image, 'http') === 0 ? $r->image : asset('storage/' . $r->image)) : 'https://placehold.co/600x400?text=No+Image' }}" class="w-full h-full object-cover group-hover:scale-110 transition-all duration-700" alt="{{ $r->name }}">
                </div>
                <div class="px-2 pb-2">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-slate-900 font-bold text-lg leading-none mb-1">{{ $r->name }}</p>
                            <div class="flex items-center gap-2">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $r->type }}</p>
                                <span class="text-slate-300 text-xs">•</span>
                                <p class="text-[10px] font-bold text-red-500 uppercase tracking-widest"><i class="fas fa-map-marker-alt"></i> {{ $r->domicile ?? 'Jakarta' }}</p>
                            </div>
                        </div>
                        <a href="{{ route('vehicle.detail', $r->id) }}" class="w-10 h-10 bg-slate-50 text-slate-400 hover:bg-blue-600 hover:text-white rounded-xl flex items-center justify-center transition-all">
                            <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                    <div class="flex items-center justify-between pt-4 border-t border-slate-50">
                        <div class="flex items-center gap-3 text-slate-400">
                             <span class="flex items-center gap-1 text-[10px] font-bold"><i class="fas fa-users text-blue-400"></i> {{ $r->seats }}</span>
                             <span class="flex items-center gap-1 text-[10px] font-bold"><i class="fas fa-cog text-blue-400"></i> {{ $r->transmission }}</span>
                        </div>
                        <p class="font-black text-blue-600">Rp {{ number_format($r->price_per_day, 0, ',', '.') }}<small class="text-slate-400 text-[10px] font-normal uppercase ml-1">/hari</small></p>
                    </div>
                </div>
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
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active', 'text-blue-600', 'font-black'));
            document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
            this.classList.add('active', 'text-blue-600', 'font-black');
            document.getElementById(this.dataset.tab).classList.remove('hidden');
        });
    });

    // Booking date & price calculator
    const startInput = document.getElementById('book-start');
    const endInput   = document.getElementById('book-end');
    const priceBreakdown = document.getElementById('price-breakdown');
    const pricePerDay = {{ $vehicle->price_per_day }};
    const serviceFee  = 50000;

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

    // Review Carousel Script
    const slider = document.getElementById('review-slider');
    if (slider) {
        const prevBtn = document.getElementById('prev-review');
        const nextBtn = document.getElementById('next-review');
        const dots = document.querySelectorAll('.dot-btn');
        const slideCount = slider.children.length;
        let currentIndex = 0;
        let slideInterval;

        function updateSlider() {
            slider.style.transform = `translateX(-${currentIndex * 100}%)`;
            dots.forEach((dot, i) => {
                if(i === currentIndex) {
                    dot.classList.add('bg-white');
                    dot.classList.remove('bg-white/40');
                } else {
                    dot.classList.remove('bg-white');
                    dot.classList.add('bg-white/40');
                }
            });
        }
        function nextSlide() {
            currentIndex = (currentIndex + 1) % slideCount;
            updateSlider();
        }
        function prevSlide() {
            currentIndex = (currentIndex - 1 + slideCount) % slideCount;
            updateSlider();
        }

        if (slideCount > 1) {
            updateSlider(); // init
            nextBtn?.addEventListener('click', () => { nextSlide(); resetInterval(); });
            prevBtn?.addEventListener('click', () => { prevSlide(); resetInterval(); });
            dots.forEach(dot => {
                dot.addEventListener('click', (e) => {
                    currentIndex = parseInt(e.target.dataset.index);
                    updateSlider();
                    resetInterval();
                });
            });
            
            function startInterval() {
                slideInterval = setInterval(nextSlide, 7000); // 7s auto slide
            }
            function resetInterval() {
                clearInterval(slideInterval);
                startInterval();
            }
            startInterval();
        }
    }

</script>
@endpush
