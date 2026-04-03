@extends('layouts.app')

@section('title', 'Jelajahi Semua Armada Kendaraan')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Page Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-black text-slate-900">Jelajahi <span class="text-blue-600">Semua Armada</span></h1>
        <p class="text-slate-500 mt-1">Temukan kendaraan yang sempurna untuk perjalanan Anda</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">

        {{-- ===== SIDEBAR FILTER ===== --}}
        <aside class="lg:w-72 flex-shrink-0">
            <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm top-20" id="filter-panel">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="font-bold text-slate-900">Filter</h2>
                    <button id="reset-filter" class="text-xs text-blue-600 hover:underline font-semibold">Reset Semua</button>
                </div>

                {{-- Jenis Kendaraan --}}
                <div class="mb-6">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Jenis Kendaraan</p>
                    <select name="jenis" class="w-full bg-slate-50 border border-slate-200 text-sm font-medium text-slate-700 px-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300">
                        @php
                        $types = ['Semua' => '', 'Mobil Sedan' => 'sedan', 'MPV / SUV' => 'mpv', 'Motor' => 'motor', 'Minibus' => 'minibus'];
                        @endphp
                        @foreach($types as $label => $val)
                            <option value="{{ $val }}" {{ (request('type') && strtolower(request('type')) == strtolower($val)) ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Wilayah --}}
                <div class="mb-6 border-t border-slate-100 pt-6">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Wilayah Domisili</p>
                    <select name="wilayah" class="w-full bg-slate-50 border border-slate-200 text-sm font-medium text-slate-700 px-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300">
                        @foreach(['Semua', 'Jakarta', 'Bogor', 'Depok', 'Tangerang', 'Bekasi'] as $wilayah)
                            <option value="{{ $wilayah == 'Semua' ? '' : strtolower($wilayah) }}" {{ (request('domicile') && strtolower(request('domicile')) == strtolower($wilayah)) ? 'selected' : '' }}>{{ $wilayah }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Transmisi --}}
                <div class="mb-6 border-t border-slate-100 pt-6">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Transmisi</p>
                    <select name="transmisi" class="w-full bg-slate-50 border border-slate-200 text-sm font-medium text-slate-700 px-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300">
                        @foreach(['Semua', 'Matic', 'Manual'] as $tx)
                            <option value="{{ $tx == 'Semua' ? '' : strtolower($tx) }}">{{ $tx }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Range Harga --}}
                <div class="mb-6 border-t border-slate-100 pt-6">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Harga / Hari</p>
                    <div class="flex gap-2 items-center">
                        <span class="text-xs text-slate-400">Rp 50K</span>
                        <input type="range" id="price-range" min="50000" max="2000000" step="50000" value="2000000"
                            class="flex-1 h-2 accent-blue-600 cursor-pointer">
                        <span class="text-xs text-slate-400">Rp 2Jt</span>
                    </div>
                    <p class="text-center text-sm font-bold text-blue-600 mt-2">Maks: <span id="price-display">Rp 2.000.000</span></p>
                </div>

                {{-- Kapasitas --}}
                <div class="border-t border-slate-100 pt-6">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Kapasitas</p>
                    <div class="grid grid-cols-3 gap-2" id="seat-filters">
                        @foreach(['1-2', '4-5', '6-7', '8+'] as $s)
                        <button data-seat="{{ $s }}" class="seat-btn border border-slate-200 hover:border-blue-400 hover:text-blue-600 hover:bg-blue-50 text-slate-600 text-xs font-semibold py-2 rounded-xl transition-all">
                            {{ $s }}
                        </button>
                        @endforeach
                    </div>
                </div>

                <button id="apply-filter" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl mt-6 transition-all active:scale-95">
                    <i class="fas fa-filter mr-2"></i>Terapkan Filter
                </button>
            </div>
        </aside>

        {{-- ===== GRID KENDARAAN ===== --}}
        <div class="flex-1">

            {{-- Search, Sort & Count Bar --}}
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 w-full">
                <p class="text-slate-500 text-sm flex-shrink-0"><span id="vehicle-count-text" class="font-bold text-slate-900">{{ $vehicles->count() }} kendaraan</span> ditemukan</p>
                
                <div class="flex-1 w-full max-w-sm relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                    <input type="text" id="search-input" placeholder="Cari nama atau merk kendaraan..." class="w-full bg-white border border-slate-200 text-sm font-medium text-slate-600 pl-10 pr-4 py-2.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 transition-shadow">
                </div>

                <div class="flex items-center gap-3 flex-shrink-0">
                    {{-- View Toggle --}}
                    <div class="flex gap-1 bg-slate-100 p-1 rounded-xl">
                        <button id="view-grid" class="w-8 h-8 rounded-lg bg-white shadow-sm flex items-center justify-center text-blue-600 transition-all">
                            <i class="fas fa-th text-sm"></i>
                        </button>
                        <button id="view-list" class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-600 transition-all">
                            <i class="fas fa-list text-sm"></i>
                        </button>
                    </div>
                    <select id="sort-select" class="bg-white border border-slate-200 text-sm font-medium text-slate-600 px-4 py-2 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300">
                        <option value="latest" {{ request('sort') == 'latest' || !request('sort') ? 'selected' : '' }}>Paling Baru / Populer</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating Terbaik</option>
                    </select>
                </div>
            </div>

            <div id="vehicle-grid" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8 mt-12">
                @foreach($vehicles as $v)
                <div class="vehicle-card group bg-white rounded-3xl p-5 border border-slate-100 hover:border-blue-200 transition-all duration-500 hover:shadow-2xl hover:shadow-blue-100/50"
                    data-name="{{ strtolower($v->name) }}"
                    data-type="{{ strtolower($v->type) }}"
                    data-price="{{ $v->price_per_day }}"
                    data-transmisi="{{ strtolower($v->transmission) }}"
                    data-seat="{{ $v->seats }}"
                    data-domicile="{{ strtolower($v->domicile) }}">
                    
                    {{-- Image --}}
                    <div class="relative h-48 mb-6 overflow-hidden rounded-2xl bg-slate-50">
                        <img src="{{ $v->image ? (strpos($v->image, 'http') === 0 ? $v->image : asset('storage/' . $v->image)) : 'https://placehold.co/600x400?text=No+Image' }}" 
                             alt="{{ $v->name }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-all duration-700">
                        <div class="absolute top-4 left-4">
                            @php
                                $statusClass = $v->status == 'Tersedia' ? 'bg-green-500' : ($v->status == 'Perawatan' ? 'bg-orange-500' : 'bg-blue-600');
                            @endphp
                            <span class="{{ $statusClass }} text-white text-[10px] font-bold px-3 py-1 rounded-lg uppercase tracking-wider shadow-lg">
                                {{ $v->status }}
                            </span>
                        </div>
                    </div>

                    {{-- Info --}}
                    <div class="p-2 space-y-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors">{{ $v->name }}</h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $v->type }}</p>
                                    <span class="text-slate-300">•</span>
                                    <p class="text-[10px] font-bold text-red-500 uppercase tracking-widest"><i class="fas fa-map-marker-alt"></i> {{ $v->domicile ?? 'Jakarta' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-1 text-orange-400 bg-orange-50 px-2 py-1 rounded-lg border border-orange-100">
                                <i class="fas fa-star text-[10px]"></i>
                                <span class="text-xs font-bold text-slate-900">{{ $v->rating }}</span>
                            </div>
                        </div>

                        {{-- Specs Grid --}}
                        <div class="grid grid-cols-2 gap-3 py-4 border-y border-slate-50">
                            <div class="flex items-center gap-2 text-slate-500">
                                <div class="w-7 h-7 rounded-lg bg-slate-50 flex items-center justify-center text-xs text-blue-600">
                                    <i class="fas fa-users"></i>
                                </div>
                                <span class="text-xs font-medium">{{ $v->seats }} Kursi</span>
                            </div>
                            <div class="flex items-center gap-2 text-slate-500">
                                <div class="w-7 h-7 rounded-lg bg-slate-50 flex items-center justify-center text-xs text-blue-600">
                                    <i class="fas fa-cog"></i>
                                </div>
                                <span class="text-xs font-medium">{{ $v->transmission }}</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-2">
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Mulai Dari</p>
                                <div class="flex items-baseline gap-1">
                                    <span class="text-lg font-black text-blue-600">Rp {{ number_format($v->price_per_day, 0, ',', '.') }}</span>
                                    <span class="text-xs text-slate-400 font-medium">/hari</span>
                                </div>
                            </div>
                            <a href="{{ route('vehicle.detail', $v->id) }}" class="w-11 h-11 bg-slate-900 group-hover:bg-blue-600 text-white rounded-xl flex items-center justify-center transition-all duration-300 shadow-lg shadow-slate-200">
                                <i class="fas fa-arrow-right text-sm"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="flex justify-center items-center gap-2 mt-10">
                <button class="w-10 h-10 rounded-xl border border-slate-200 text-slate-400 hover:border-blue-400 hover:text-blue-600 transition-all flex items-center justify-center">
                    <i class="fas fa-chevron-left text-sm"></i>
                </button>
                @foreach([1,2,3,'...',8] as $page)
                <button class="w-10 h-10 rounded-xl text-sm font-semibold transition-all {{ $page == 1 ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'border border-slate-200 text-slate-600 hover:border-blue-400 hover:text-blue-600' }}">
                    {{ $page }}
                </button>
                @endforeach
                <button class="w-10 h-10 rounded-xl border border-slate-200 text-slate-400 hover:border-blue-400 hover:text-blue-600 transition-all flex items-center justify-center">
                    <i class="fas fa-chevron-right text-sm"></i>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Wishlist toggle
    document.querySelectorAll('.wishlist-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const icon = this.querySelector('i');
            icon.classList.toggle('far');
            icon.classList.toggle('fas');
            icon.classList.toggle('text-red-500');
            icon.classList.toggle('text-slate-400');
        });
    });

    // Price range display
    const priceRange = document.getElementById('price-range');
    const priceDisplay = document.getElementById('price-display');
    if (priceRange) {
        priceRange.addEventListener('input', function() {
            const val = parseInt(this.value);
            priceDisplay.textContent = 'Rp ' + val.toLocaleString('id-ID');
        });
    }

    // Seat filter toggle
    document.querySelectorAll('.seat-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.seat-btn').forEach(b => {
                b.classList.remove('bg-blue-600', 'text-white', 'border-blue-600');
                b.classList.add('border-slate-200', 'text-slate-600');
            });
            this.classList.add('bg-blue-600', 'text-white', 'border-blue-600');
            this.classList.remove('border-slate-200', 'text-slate-600');
        });
    });

    // Grid / List view toggle
    const gridView = document.getElementById('vehicle-grid');
    document.getElementById('view-grid').addEventListener('click', function() {
        gridView.className = 'grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5';
        this.classList.add('bg-white', 'shadow-sm', 'text-blue-600');
        document.getElementById('view-list').classList.remove('bg-white', 'shadow-sm', 'text-blue-600');
    });
    document.getElementById('view-list').addEventListener('click', function() {
        gridView.className = 'grid grid-cols-1 gap-4';
        this.classList.add('bg-white', 'shadow-sm', 'text-blue-600');
        document.getElementById('view-grid').classList.remove('bg-white', 'shadow-sm', 'text-blue-600');
    });

    // Client-side Sort redirect
    const sortSelect = document.getElementById('sort-select');
    if(sortSelect) {
        sortSelect.addEventListener('change', function() {
            const url = new URL(window.location.href);
            url.searchParams.set('sort', this.value);
            window.location.href = url.toString();
        });
    }

    // Reset filter
    document.getElementById('reset-filter').addEventListener('click', function() {
        if(document.querySelector('select[name="jenis"]')) document.querySelector('select[name="jenis"]').value = '';
        if(document.querySelector('select[name="wilayah"]')) document.querySelector('select[name="wilayah"]').value = '';
        if(document.querySelector('select[name="transmisi"]')) document.querySelector('select[name="transmisi"]').value = '';
        if (priceRange) { priceRange.value = 2000000; priceDisplay.textContent = 'Rp 2.000.000'; }
        document.querySelectorAll('.seat-btn').forEach(b => {
            b.classList.remove('bg-blue-600','text-white','border-blue-600');
            b.classList.add('border-slate-200','text-slate-600');
        });
        document.getElementById('apply-filter').click();
    });

    // Client-side Search listener
    const searchInput = document.getElementById('search-input');
    if(searchInput) {
        searchInput.addEventListener('input', function() {
            document.getElementById('apply-filter').click();
        });
    }

    // Apply Filter Logic (Client Side)
    document.getElementById('apply-filter').addEventListener('click', function() {
        const searchFilter = searchInput ? searchInput.value.toLowerCase() : '';
        
        const typeEl = document.querySelector('select[name="jenis"]');
        const typeFilter = typeEl ? typeEl.value.toLowerCase() : '';

        const wilayahEl = document.querySelector('select[name="wilayah"]');
        const wilayahFilter = wilayahEl ? wilayahEl.value.toLowerCase() : '';
        
        const transEl = document.querySelector('select[name="transmisi"]');
        const transFilter = transEl ? transEl.value.toLowerCase() : '';
        
        const priceFilter = parseInt(document.getElementById('price-range').value);
        
        const activeSeatBtn = document.querySelector('.seat-btn.bg-blue-600');
        const seatFilter = activeSeatBtn ? activeSeatBtn.dataset.seat : '';

        let count = 0;
        document.querySelectorAll('.vehicle-card').forEach(card => {
            const cName = card.dataset.name;
            const cType = card.dataset.type;
            const cDom = card.dataset.domicile;
            const cTrans = card.dataset.transmisi;
            const cPrice = parseInt(card.dataset.price);
            const cSeat = parseInt(card.dataset.seat);

            let show = true;
            if(searchFilter && !cName.includes(searchFilter)) show = false;
            if(typeFilter && typeFilter !== 'semua' && !cType.includes(typeFilter)) show = false;
            if(wilayahFilter && !cDom.includes(wilayahFilter)) show = false;
            if(transFilter && transFilter !== 'semua' && cTrans !== transFilter && !cTrans.includes(transFilter)) show = false;
            if(cPrice > priceFilter) show = false;
            
            if(seatFilter) {
                if(seatFilter === '1-2' && (cSeat < 1 || cSeat > 2)) show = false;
                if(seatFilter === '4-5' && (cSeat < 3 || cSeat > 5)) show = false;
                if(seatFilter === '6-7' && (cSeat < 6 || cSeat > 7)) show = false;
                if(seatFilter === '8+' && cSeat < 8) show = false;
            }

            if(show) {
                card.style.display = 'block';
                count++;
            } else {
                card.style.display = 'none';
            }
        });

        const countText = document.getElementById('vehicle-count-text');
        if(countText) countText.textContent = count + ' kendaraan';
    });
</script>
@endpush
