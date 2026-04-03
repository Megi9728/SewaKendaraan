@extends('layouts.app')

@section('title', 'Pilih Kendaraan Anda')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Page Header (Uber style: Minimalist) --}}
    <div class="mb-10 text-center md:text-left">
        <h1 class="text-4xl font-bold text-uber-black tracking-tight">Katalog Armada</h1>
        <p class="text-uber-text font-medium mt-2">Pilih kendaraan terbaik untuk perjalanan Anda hari ini.</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-12">

        {{-- ===== SIDEBAR FILTER (Uber Style: Flat & Functional) ===== --}}
        <aside class="lg:w-72 flex-shrink-0">
            <div class="bg-uber-white border-0 lg:border-r border-gray-100 lg:pr-8" id="filter-panel">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-xl font-bold text-uber-black">Filter</h2>
                    <button id="reset-filter" class="text-xs font-bold text-uber-black hover:underline">Hapus Semua</button>
                </div>

                {{-- Jenis Kendaraan --}}
                <div class="mb-8">
                    <label class="text-xs font-bold text-uber-muted uppercase tracking-widest block mb-3">Jenis Kendaraan</label>
                    <select name="jenis" class="w-full bg-uber-chip border-0 text-sm font-bold text-uber-black px-4 py-3.5 rounded-lg focus:ring-2 focus:ring-uber-black transition-all appearance-none cursor-pointer">
                        @php
                        $types = ['Semua' => '', 'Mobil Sedan' => 'sedan', 'MPV / SUV' => 'mpv', 'Motor' => 'motor', 'Minibus' => 'minibus'];
                        @endphp
                        @foreach($types as $label => $val)
                            <option value="{{ $val }}" {{ (request('type') && strtolower(request('type')) == strtolower($val)) ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Wilayah --}}
                <div class="mb-8 border-t border-gray-100 pt-8">
                    <label class="text-xs font-bold text-uber-muted uppercase tracking-widest block mb-3">Wilayah</label>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach(['Semua', 'Jakarta', 'Bogor', 'Tangerang', 'Bekasi'] as $wilayah)
                            <button class="region-chip border border-gray-200 text-xs font-bold py-2.5 rounded-full hover:bg-uber-chip transition-all {{ ($loop->first && !request('domicile')) || (request('domicile') == strtolower($wilayah)) ? 'bg-uber-black text-uber-white border-uber-black' : 'text-uber-black bg-uber-white' }}" data-value="{{ $wilayah == 'Semua' ? '' : strtolower($wilayah) }}">
                                {{ $wilayah }}
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Harga --}}
                <div class="mb-8 border-t border-gray-100 pt-8">
                    <label class="text-xs font-bold text-uber-muted uppercase tracking-widest block mb-3">Harga Maksimum</label>
                    <input type="range" id="price-range" min="50000" max="2000000" step="50000" value="2000000"
                            class="w-full h-1.5 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-uber-black">
                    <div class="flex justify-between mt-3">
                        <span class="text-[10px] font-bold text-uber-muted">Rp 50K</span>
                        <span id="price-display" class="text-sm font-bold text-uber-black">Rp 2.000.000</span>
                    </div>
                </div>

                <button id="apply-filter" class="w-full btn-primary py-4 text-sm font-bold mt-4 shadow-uber">
                    Terapkan
                </button>
            </div>
        </aside>

        {{-- ===== GRID KENDARAAN (Uber Style: Efficient) ===== --}}
        <div class="flex-1">

            {{-- Toolbar --}}
            <div class="flex flex-col sm:flex-row justify-between items-center gap-6 mb-10 w-full">
                <div class="flex-1 w-full max-w-md relative">
                    <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input type="text" id="search-input" placeholder="Cari merk atau model..." class="w-full bg-uber-chip border-0 text-sm font-bold text-uber-black pl-12 pr-6 py-3.5 rounded-full focus:ring-2 focus:ring-uber-black transition-all">
                </div>

                <div class="flex items-center gap-4 w-full sm:w-auto">
                    <span class="text-sm font-bold text-uber-muted whitespace-nowrap"><span id="vehicle-count-text">{{ $vehicles->count() }}</span> Armada Tersedia</span>
                    <select id="sort-select" class="bg-uber-white border border-gray-200 text-xs font-bold text-uber-black px-4 py-2.5 rounded-full focus:ring-2 focus:ring-uber-black transition-all cursor-pointer">
                        <option value="latest" {{ request('sort') == 'latest' || !request('sort') ? 'selected' : '' }}>Terbaru</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga Rendah</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga Tinggi</option>
                    </select>
                </div>
            </div>

            <div id="vehicle-grid" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8">
                @foreach($vehicles as $v)
                <a href="{{ route('vehicle.detail', $v->id) }}" class="vehicle-card flex flex-col group bg-uber-white border border-transparent hover:border-gray-200 rounded-xl p-0 transition-all duration-300"
                    data-name="{{ strtolower($v->name) }}"
                    data-type="{{ strtolower($v->type) }}"
                    data-price="{{ $v->price_per_day }}"
                    data-transmisi="{{ strtolower($v->transmission) }}"
                    data-seat="{{ $v->seats }}"
                    data-domicile="{{ strtolower($v->domicile) }}">
                    
                    {{-- Image Aspect 16/10 --}}
                    <div class="relative aspect-[16/10] mb-5 overflow-hidden rounded-lg bg-uber-chip">
                        <img src="{{ $v->image ? (strpos($v->image, 'http') === 0 ? $v->image : asset('storage/' . $v->image)) : 'https://placehold.co/600x400?text=' . urlencode($v->name) }}" 
                             alt="{{ $v->name }}" 
                             class="w-full h-full object-cover">
                        
                        {{-- Status Badge (Minimalist) --}}
                        <div class="absolute top-3 left-3">
                            @if($v->status === 'Tersedia')
                                <span class="bg-uber-white text-uber-black text-[10px] font-bold px-2.5 py-1 rounded shadow-sm border border-gray-100 uppercase tracking-widest">Tersedia</span>
                            @else
                                <span class="bg-uber-black text-uber-white text-[10px] font-bold px-2.5 py-1 rounded shadow-sm uppercase tracking-widest">Disewa</span>
                            @endif
                        </div>
                    </div>

                    {{-- Info --}}
                    <div class="flex flex-col flex-1 px-1">
                        <div class="flex justify-between items-start mb-1">
                            <h3 class="text-xl font-bold text-uber-black leading-tight">{{ $v->name }}</h3>
                            <div class="flex items-center gap-1 text-uber-black">
                                <i class="fas fa-star text-xs"></i>
                                <span class="text-sm font-bold">{{ $v->rating }}</span>
                            </div>
                        </div>

                        <p class="text-uber-text font-medium text-sm mb-4">{{ $v->seats }} Kursi • {{ $v->transmission }}</p>

                        <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-bold text-uber-muted uppercase tracking-widest">Tarif</span>
                                <span class="text-lg font-bold text-uber-black">Rp {{ number_format($v->price_per_day, 0, ',', '.') }}</span>
                            </div>
                            <span class="btn-primary px-7 py-3 text-xs font-bold shadow-none group-active:scale-95 transition-transform">
                                Pesan
                            </span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            {{-- Empty State (Uber font style) --}}
            <div id="empty-state" class="hidden py-20 text-center">
                <i class="fas fa-car-side text-5xl text-gray-200 mb-4 scale-x-[-1]"></i>
                <h3 class="text-xl font-bold text-uber-black">Unit tidak ditemukan</h3>
                <p class="text-uber-muted mt-2">Coba sesuaikan filter atau cari merk lain.</p>
            </div>

            {{-- Pagination (Uber style: Minimalist) --}}
            <div class="flex justify-center mt-20 gap-2">
                <button class="w-10 h-10 flex items-center justify-center rounded-full border border-gray-200 text-uber-black hover:bg-uber-chip transition-all mr-2">
                    <i class="fas fa-chevron-left text-xs"></i>
                </button>
                <button class="px-5 h-10 flex items-center justify-center rounded-full bg-uber-black text-uber-white text-sm font-bold shadow-uber">
                    1
                </button>
                <button class="w-10 h-10 flex items-center justify-center rounded-full border border-gray-200 text-uber-black hover:bg-uber-chip transition-all ml-2">
                    <i class="fas fa-chevron-right text-xs"></i>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const priceRange = document.getElementById('price-range');
    const priceDisplay = document.getElementById('price-display');
    const searchInput = document.getElementById('search-input');
    const applyBtn = document.getElementById('apply-filter');
    const regionButtons = document.querySelectorAll('.region-chip');
    const typeSelect = document.querySelector('select[name="jenis"]');
    const vehicleCards = document.querySelectorAll('.vehicle-card');
    const emptyState = document.getElementById('empty-state');
    const vehicleGrid = document.getElementById('vehicle-grid');
    const countText = document.getElementById('vehicle-count-text');

    let currentRegion = '';

    // Region Chip listener
    regionButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            regionButtons.forEach(b => b.className = 'region-chip border border-gray-200 text-xs font-bold py-2.5 rounded-full hover:bg-uber-chip transition-all text-uber-black bg-uber-white text-uber-black bg-uber-white');
            this.className = 'region-chip border border-uber-black text-xs font-bold py-2.5 rounded-full hover:bg-uber-chip transition-all bg-uber-black text-uber-white';
            currentRegion = this.dataset.value;
            filterVehicles();
        });
    });

    // Price range listener
    if (priceRange) {
        priceRange.addEventListener('input', function() {
            priceDisplay.textContent = 'Rp ' + parseInt(this.value).toLocaleString('id-ID');
            filterVehicles();
        });
    }

    // Search input listener
    if (searchInput) {
        searchInput.addEventListener('input', filterVehicles);
    }

    // Type select listener
    if (typeSelect) {
        typeSelect.addEventListener('change', filterVehicles);
    }

    function filterVehicles() {
        const searchVal = searchInput.value.toLowerCase();
        const typeVal = typeSelect.value.toLowerCase();
        const maxPrice = parseInt(priceRange.value);
        
        let visibleCount = 0;

        vehicleCards.forEach(card => {
            const name = card.dataset.name;
            const type = card.dataset.type;
            const price = parseInt(card.dataset.price);
            const domicile = card.dataset.domicile;

            let show = true;
            if (searchVal && !name.includes(searchVal)) show = false;
            if (typeVal && !type.includes(typeVal)) show = false;
            if (currentRegion && !domicile.includes(currentRegion)) show = false;
            if (price > maxPrice) show = false;

            card.style.display = show ? 'flex' : 'none';
            if (show) visibleCount++;
        });

        countText.textContent = visibleCount;
        if (visibleCount === 0) {
            vehicleGrid.classList.add('hidden');
            emptyState.classList.remove('hidden');
        } else {
            vehicleGrid.classList.remove('hidden');
            emptyState.classList.add('hidden');
        }
    }

    // Initial check
    filterVehicles();

    // Reset logic
    document.getElementById('reset-filter').addEventListener('click', () => {
        searchInput.value = '';
        typeSelect.value = '';
        priceRange.value = 2000000;
        priceDisplay.textContent = 'Rp 2.000.000';
        regionButtons[0].click(); // Reset region to 'Semua'
        filterVehicles();
    });

    // Sort redirect
    const sortSelect = document.getElementById('sort-select');
    if(sortSelect) {
        sortSelect.addEventListener('change', function() {
            const url = new URL(window.location.href);
            url.searchParams.set('sort', this.value);
            window.location.href = url.toString();
        });
    }
</script>
@endpush
