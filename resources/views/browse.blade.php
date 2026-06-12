@extends('layouts.app')

@section('title', 'Pilih Kendaraan Anda')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-36 pb-20">

        <div class="flex flex-col lg:flex-row gap-12">

            {{-- ===== SIDEBAR FILTER (Uber Style: Flat & Functional) ===== --}}
            <aside class="lg:w-[300px] flex-shrink-0">
                <div class="bg-white rounded-3xl lg:border border-[#EBEBDF] lg:p-6 lg:shadow-[0_8px_30px_rgb(0,0,0,0.04)] sticky top-32"
                    id="filter-panel">
                    <div class="flex justify-between items-center mb-8">
                        <h2 class="text-xl font-bold text-[#0A174E]">Filter</h2>
                        <button id="reset-filter"
                            class="text-[11px] px-3 py-1.5 bg-[#EBEBDF] hover:bg-[#D4D4C3] rounded-lg font-bold text-[#0A174E] transition-colors hover:underline">Hapus
                            Semua</button>
                    </div>

                    {{-- Jenis Kendaraan --}}
                    <div class="mb-8">
                        <label class="text-xs font-bold text-[#8F8F7E] uppercase tracking-widest block mb-3">Jenis
                            Kendaraan</label>
                        <select name="jenis"
                            class="w-full bg-[#EBEBDF] border-0 text-sm font-bold text-[#0A174E] px-4 py-3.5 rounded-lg focus:ring-2 focus:ring-[#0A174E] transition-all appearance-none cursor-pointer">
                            @php
                                $types = [
                                    'Semua' => '',
                                    'Mobil Sedan' => 'sedan',
                                    'MPV / SUV' => 'mpv',
                                    'Motor' => 'motor',
                                    'Minibus' => 'minibus',
                                ];
                            @endphp
                            @foreach ($types as $label => $val)
                                <option value="{{ $val }}"
                                    {{ request('type') && strtolower(request('type')) == strtolower($val) ? 'selected' : '' }}>
                                    {{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Wilayah --}}
                    <div class="mb-8 border-t border-[#EBEBDF] pt-8">
                        <label class="text-xs font-bold text-[#8F8F7E] uppercase tracking-widest block mb-3">Wilayah</label>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach (['Semua', 'Jakarta', 'Bogor', 'Tangerang', 'Bekasi'] as $wilayah)
                                <button
                                    class="region-chip border border-[#D4D4C3] text-xs font-bold py-2.5 rounded-full hover:bg-[#EBEBDF] transition-all {{ ($loop->first && !request('domicile')) || request('domicile') == strtolower($wilayah) ? 'bg-[#F5D042] text-[#0A174E] border-[#F5D042] shadow-sm' : 'text-[#0A174E] bg-white' }}"
                                    data-value="{{ $wilayah == 'Semua' ? '' : strtolower($wilayah) }}">
                                    {{ $wilayah }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    @php
                        $maxVehiclePrice = $vehicles->max('price_per_day') ?? 3000000;
                        // Pastikan step-nya masuk akal jika harga maksimalnya aneh, namun kita biarkan default step 50000
                    @endphp
                    {{-- Harga --}}
                    <div class="mb-8 border-t border-[#EBEBDF] pt-8">
                        <label class="text-xs font-bold text-[#8F8F7E] uppercase tracking-widest block mb-3">Harga
                            Maksimum</label>
                        <input type="range" id="price-range" min="50000" max="{{ $maxVehiclePrice }}" step="50000" value="{{ $maxVehiclePrice }}"
                            class="w-full h-1.5 bg-[#D4D4C3] rounded-lg appearance-none cursor-pointer accent-#0A174E">
                        <div class="flex justify-between mt-3">
                            <span class="text-[10px] font-bold text-[#8F8F7E]">Rp 50K</span>
                            <span id="price-display" class="text-sm font-bold text-[#0A174E]">Rp {{ number_format($maxVehiclePrice, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <button id="apply-filter"
                        class="w-full bg-[#0A174E] hover:bg-[#0A174E]/90 text-white w-full py-4 rounded-xl text-sm font-bold mt-4 shadow-[0_4px_12px_rgba(10,23,78,0.15)] transition-all active:scale-95">
                        Terapkan
                    </button>
                </div>
            </aside>

            {{-- ===== GRID KENDARAAN (Uber Style: Efficient) ===== --}}
            <div class="flex-1">

                {{-- Toolbar --}}
                <div class="flex flex-col sm:flex-row justify-between items-center gap-6 mb-10 w-full">
                    <div class="flex-1 w-full max-w-md relative">
                        <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-[#BDBDAC] text-sm"></i>
                        <input type="text" id="search-input" placeholder="Cari merk atau model..."
                            class="w-full bg-white border border-[#EBEBDF] shadow-[0_2px_12px_rgba(0,0,0,0.03)] text-sm font-bold text-[#0A174E] pl-12 pr-6 py-4 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#F5D042] focus:border-transparent transition-all placeholder:text-[#8F8F7E]">
                    </div>

                    <div class="flex items-center gap-4 w-full sm:w-auto">
                        <span class="text-sm font-bold text-[#8F8F7E] whitespace-nowrap"><span
                                id="vehicle-count-text">{{ $vehicles->count() }}</span> Armada Tersedia</span>
                        <select id="sort-select"
                            class="appearance-none bg-white border border-[#EBEBDF] shadow-[0_2px_12px_rgba(0,0,0,0.03)] text-xs font-bold text-[#0A174E] px-5 py-3 pr-10 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#F5D042] transition-all cursor-pointer bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cpath%20d%3D%22M6%209L12%2015L18%209%22%20stroke%3D%22%230A174E%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%2F%3E%3C%2Fsvg%3E')] bg-[length:16px_16px] bg-[right_12px_center] bg-no-repeat">
                            <option value="latest" {{ request('sort') == 'latest' || !request('sort') ? 'selected' : '' }}>
                                Terbaru</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga Rendah
                            </option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga Tinggi
                            </option>
                        </select>
                    </div>
                </div>

                <div id="vehicle-grid" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8">
                    @foreach ($vehicles as $v)
                        <a href="{{ route('vehicle.detail', $v->id) }}"
                            class="vehicle-card flex flex-col group bg-white border border-[#EBEBDF] hover:border-[#F5D042] rounded-[24px] p-2.5 transition-all duration-500 hover:shadow-[0_12px_32px_rgba(10,23,78,0.08)]"
                            data-name="{{ strtolower($v->name) }}" data-type="{{ strtolower($v->type) }}"
                            data-price="{{ $v->price_per_day }}" data-transmisi="{{ strtolower($v->transmission) }}"
                            data-seat="{{ $v->seats }}" data-domicile="{{ strtolower($v->domicile) }}">

                            {{-- Image Aspect 16/10 --}}
                            <div class="relative aspect-[16/10] mb-5 overflow-hidden rounded-[18px] bg-[#EBEBDF]">
                                <img src="{{ $v->image ? (strpos($v->image, 'http') === 0 ? $v->image : asset('storage/' . $v->image)) : 'https://placehold.co/600x400?text=' . urlencode($v->name) }}"
                                    alt="{{ $v->name }}"
                                    class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700 ease-[cubic-bezier(0.22,1,0.36,1)]">

                                {{-- Status Badge (Minimalist) --}}
                                <div class="absolute top-3 left-3">
                                    @if ($v->available_units_count >= 1)
                                        <span
                                            class="bg-[#F5D042] text-[#0A174E] text-[10px] font-extrabold px-3 py-1.5 rounded-lg shadow-sm border border-[#F5D042]/50 uppercase tracking-widest">Tersedia</span>
                                    @else
                                        <span
                                            class="bg-red-50 text-red-600 text-[10px] font-extrabold px-3 py-1.5 rounded-lg shadow-sm border border-red-100 uppercase tracking-widest relative z-10">Tidak
                                            Tersedia</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Info --}}
                            <div class="flex flex-col flex-1 px-1">
                                <div class="flex justify-between items-start mb-1">
                                    <h3 class="text-xl font-bold text-[#0A174E] leading-tight">{{ $v->name }}</h3>
                                    <div class="flex items-center gap-1.5 text-[#0A174E]">
                                        <i class="fas fa-star text-xs"></i>
                                        <span class="text-sm font-bold">{{ $v->rating }}</span>
                                        <span class="text-[10px] font-bold text-[#8F8F7E]">({{ $v->reviews_count }})</span>
                                    </div>
                                </div>

                                <p class="text-[#0A174E]/70 font-medium text-xs mb-4">
                                    {{ $v->seats }} Kursi • {{ $v->transmission }} • {{ $v->fuel_type ?? 'Bensin' }}
                                    • {{ $v->engine_capacity ?? '1500' }} CC
                                </p>

                                <div class="mt-auto pt-4 border-t border-[#EBEBDF] flex items-center justify-between">
                                    <div class="flex flex-col">
                                        <span
                                            class="text-[10px] font-bold text-[#8F8F7E] uppercase tracking-widest">Tarif</span>
                                        <span class="text-lg font-bold text-[#0A174E]">Rp
                                            {{ number_format($v->price_per_day, 0, ',', '.') }}</span>
                                    </div>
                                    <span
                                        class="bg-[#F9F9F5] group-hover:bg-[#F5D042] text-[#0A174E] px-6 py-2.5 rounded-xl text-xs font-bold transition-all duration-300 shadow-sm flex items-center justify-center gap-2 group-active:scale-95">
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
                    <h3 class="text-xl font-bold text-[#0A174E]">Unit tidak ditemukan</h3>
                    <p class="text-[#8F8F7E] mt-2">Coba sesuaikan filter atau cari merk lain.</p>
                </div>

                {{-- Pagination (Uber style: Minimalist) --}}
                <div class="flex justify-center mt-20 gap-2">
                    <button
                        class="w-10 h-10 flex items-center justify-center rounded-full border border-[#D4D4C3] text-[#0A174E] hover:bg-[#EBEBDF] transition-all mr-2">
                        <i class="fas fa-chevron-left text-xs"></i>
                    </button>
                    <button
                        class="px-5 h-10 flex items-center justify-center rounded-full bg-[#0A174E] text-white text-sm font-bold shadow-uber">
                        1
                    </button>
                    <button
                        class="w-10 h-10 flex items-center justify-center rounded-full border border-[#D4D4C3] text-[#0A174E] hover:bg-[#EBEBDF] transition-all ml-2">
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

        // Region Chip listener (Update UI only, don't filter yet)
        regionButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                regionButtons.forEach(b => {
                    b.className =
                        'region-chip border border-[#D4D4C3] text-xs font-bold py-2.5 rounded-full hover:bg-[#EBEBDF] transition-all text-[#0A174E] bg-white';
                });
                this.className =
                    'region-chip border border-[#0A174E] text-xs font-bold py-2.5 rounded-full hover:bg-[#EBEBDF] transition-all bg-[#0A174E] text-white';
                currentRegion = this.dataset.value;
                // Removed immediate filterVehicles()
            });
        });

        // Price range listener (Update display only)
        if (priceRange) {
            priceRange.addEventListener('input', function() {
                priceDisplay.textContent = 'Rp ' + parseInt(this.value).toLocaleString('id-ID');
                // Removed immediate filterVehicles()
            });
        }

        // Apply button - Only filter here
        if (applyBtn) {
            applyBtn.addEventListener('click', filterVehicles);
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
            priceRange.value = {{ $maxVehiclePrice }};
            priceDisplay.textContent = 'Rp ' + ({{ $maxVehiclePrice }}).toLocaleString('id-ID');
            regionButtons[0].click(); // Reset region to 'Semua'
            filterVehicles();
        });

        // Sort redirect
        const sortSelect = document.getElementById('sort-select');
        if (sortSelect) {
            sortSelect.addEventListener('change', function() {
                const url = new URL(window.location.href);
                url.searchParams.set('sort', this.value);
                window.location.href = url.toString();
            });
        }
    </script>
@endpush
