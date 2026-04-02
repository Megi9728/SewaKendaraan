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
            <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm sticky top-20" id="filter-panel">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="font-bold text-slate-900">Filter</h2>
                    <button id="reset-filter" class="text-xs text-blue-600 hover:underline font-semibold">Reset Semua</button>
                </div>

                {{-- Jenis Kendaraan --}}
                <div class="mb-6">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Jenis Kendaraan</p>
                    <div class="space-y-2" id="type-filters">
                        @php
                        $types = ['Semua' => '', 'Mobil Sedan' => 'sedan', 'MPV / SUV' => 'mpv', 'Motor' => 'motor', 'Minibus' => 'minibus'];
                        @endphp
                        @foreach($types as $label => $val)
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="radio" name="jenis" value="{{ $val }}" class="w-4 h-4 text-blue-600 accent-blue-600" {{ $loop->first ? 'checked' : '' }}>
                            <span class="text-sm text-slate-700 group-hover:text-blue-600 transition-colors font-medium">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Transmisi --}}
                <div class="mb-6 border-t border-slate-100 pt-6">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Transmisi</p>
                    <div class="space-y-2">
                        @foreach(['Semua', 'Matic', 'Manual'] as $tx)
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="radio" name="transmisi" value="{{ strtolower($tx) }}" class="w-4 h-4 accent-blue-600" {{ $loop->first ? 'checked' : '' }}>
                            <span class="text-sm text-slate-700 group-hover:text-blue-600 transition-colors font-medium">{{ $tx }}</span>
                        </label>
                        @endforeach
                    </div>
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

                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl mt-6 transition-all active:scale-95">
                    <i class="fas fa-filter mr-2"></i>Terapkan Filter
                </button>
            </div>
        </aside>

        {{-- ===== GRID KENDARAAN ===== --}}
        <div class="flex-1">

            {{-- Sort & Count Bar --}}
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
                <p class="text-slate-500 text-sm"><span class="font-bold text-slate-900">215 kendaraan</span> ditemukan</p>
                <div class="flex items-center gap-3">
                    {{-- View Toggle --}}
                    <div class="flex gap-1 bg-slate-100 p-1 rounded-xl">
                        <button id="view-grid" class="w-8 h-8 rounded-lg bg-white shadow-sm flex items-center justify-center text-blue-600 transition-all">
                            <i class="fas fa-th text-sm"></i>
                        </button>
                        <button id="view-list" class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-600 transition-all">
                            <i class="fas fa-list text-sm"></i>
                        </button>
                    </div>
                    <select class="bg-white border border-slate-200 text-sm font-medium text-slate-600 px-4 py-2 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300">
                        <option>Paling Populer</option>
                        <option>Harga Terendah</option>
                        <option>Harga Tertinggi</option>
                        <option>Rating Terbaik</option>
                    </select>
                </div>
            </div>

            {{-- Vehicle Cards Grid --}}
            @php
            $allVehicles = [
                ['id'=>1,'name'=>'Toyota Innova Zenix','type'=>'MPV','seats'=>7,'tx'=>'Matic','price'=>'Rp 650.000','status'=>'Tersedia','sc'=>'bg-green-100 text-green-700','img'=>'https://images.unsplash.com/photo-1570733577524-3a047079e80d?auto=format&fit=crop&q=80&w=600','rating'=>'4.9','rev'=>128,'badge'=>'Terlaris'],
                ['id'=>2,'name'=>'Honda CR-V Turbo','type'=>'SUV','seats'=>5,'tx'=>'Matic','price'=>'Rp 750.000','status'=>'Tersedia','sc'=>'bg-green-100 text-green-700','img'=>'https://images.unsplash.com/photo-1519641471654-76ce0107ad1b?auto=format&fit=crop&q=80&w=600','rating'=>'4.8','rev'=>95,'badge'=>null],
                ['id'=>3,'name'=>'Honda PCX 160','type'=>'Motor','seats'=>2,'tx'=>'Matic','price'=>'Rp 120.000','status'=>'Disewa','sc'=>'bg-orange-100 text-orange-700','img'=>'https://images.unsplash.com/photo-1558981359-219d6364c9c8?auto=format&fit=crop&q=80&w=600','rating'=>'4.7','rev'=>210,'badge'=>null],
                ['id'=>4,'name'=>'Toyota Alphard','type'=>'MPV Mewah','seats'=>7,'tx'=>'Matic','price'=>'Rp 1.200.000','status'=>'Tersedia','sc'=>'bg-green-100 text-green-700','img'=>'https://images.unsplash.com/photo-1550355291-bbee04a92027?auto=format&fit=crop&q=80&w=600','rating'=>'5.0','rev'=>64,'badge'=>'Premium'],
                ['id'=>5,'name'=>'Yamaha NMAX 155','type'=>'Motor','seats'=>2,'tx'=>'Matic','price'=>'Rp 100.000','status'=>'Tersedia','sc'=>'bg-green-100 text-green-700','img'=>'https://images.unsplash.com/photo-1558981806-ec527fa84c39?auto=format&fit=crop&q=80&w=600','rating'=>'4.6','rev'=>175,'badge'=>null],
                ['id'=>6,'name'=>'Mitsubishi Xpander','type'=>'MPV','seats'=>7,'tx'=>'Manual','price'=>'Rp 500.000','status'=>'Tersedia','sc'=>'bg-green-100 text-green-700','img'=>'https://images.unsplash.com/photo-1583267746897-2cf415887172?auto=format&fit=crop&q=80&w=600','rating'=>'4.7','rev'=>88,'badge'=>null],
                ['id'=>7,'name'=>'Daihatsu Xenia','type'=>'MPV','seats'=>7,'tx'=>'Manual','price'=>'Rp 380.000','status'=>'Tersedia','sc'=>'bg-green-100 text-green-700','img'=>'https://images.unsplash.com/photo-1603553329474-99f95f35394f?auto=format&fit=crop&q=80&w=600','rating'=>'4.5','rev'=>55,'badge'=>null],
                ['id'=>8,'name'=>'Toyota Calya','type'=>'LCGC','seats'=>7,'tx'=>'Manual','price'=>'Rp 300.000','status'=>'Disewa','sc'=>'bg-orange-100 text-orange-700','img'=>'https://images.unsplash.com/photo-1609521263047-f8f205293f24?auto=format&fit=crop&q=80&w=600','rating'=>'4.4','rev'=>42,'badge'=>null],
                ['id'=>9,'name'=>'Honda Beat Street','type'=>'Motor','seats'=>2,'tx'=>'Matic','price'=>'Rp 75.000','status'=>'Tersedia','sc'=>'bg-green-100 text-green-700','img'=>'https://images.unsplash.com/photo-1558981285-6f0c94958bb6?auto=format&fit=crop&q=80&w=600','rating'=>'4.5','rev'=>320,'badge'=>null],
            ];
            @endphp

            <div id="vehicle-grid" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
                @foreach($allVehicles as $v)
                <div class="vehicle-card bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
                    <div class="relative overflow-hidden h-48">
                        <img src="{{ $v['img'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $v['name'] }}">
                        <div class="absolute top-3 left-3 flex gap-2">
                            <span class="text-xs font-bold px-3 py-1 rounded-full {{ $v['sc'] }}">{{ $v['status'] }}</span>
                            @if($v['badge'])
                            <span class="text-xs font-bold px-3 py-1 rounded-full bg-blue-600 text-white">{{ $v['badge'] }}</span>
                            @endif
                        </div>
                        <button class="wishlist-btn absolute top-3 right-3 w-8 h-8 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center text-slate-400 hover:text-red-500 transition-colors shadow-sm">
                            <i class="far fa-heart text-sm"></i>
                        </button>
                    </div>
                    <div class="p-5">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-bold text-slate-900 text-sm">{{ $v['name'] }}</h3>
                                <p class="text-slate-400 text-xs mt-0.5">{{ $v['type'] }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-black text-blue-600 text-sm">{{ $v['price'] }}</p>
                                <p class="text-slate-400 text-xs">/hari</p>
                            </div>
                        </div>
                        <div class="flex gap-3 mt-3 text-xs text-slate-500 border-t border-slate-50 pt-3">
                            <span><i class="fas fa-users mr-1"></i>{{ $v['seats'] }} Kursi</span>
                            <span><i class="fas fa-cog mr-1"></i>{{ $v['tx'] }}</span>
                            <span class="ml-auto"><i class="fas fa-star text-yellow-400 mr-1"></i>{{ $v['rating'] }} ({{ $v['rev'] }})</span>
                        </div>
                        <div class="mt-4 flex gap-2">
                            <a href="{{ route('vehicle.detail', $v['id']) }}" class="flex-1 text-center border border-slate-200 hover:border-blue-300 hover:text-blue-600 text-slate-600 font-semibold py-2 rounded-xl text-xs transition-all">Detail</a>
                            <a href="{{ route('vehicle.detail', $v['id']) }}" class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-xl text-xs transition-all">
                                <i class="fas fa-calendar-check mr-1"></i>Sewa
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

    // Reset filter
    document.getElementById('reset-filter').addEventListener('click', function() {
        document.querySelectorAll('input[type="radio"]').forEach(r => r.checked = r.value === '' || r.name === 'transmisi' && r.value === 'semua');
        document.querySelectorAll('input[name="jenis"]')[0].checked = true;
        document.querySelectorAll('input[name="transmisi"]')[0].checked = true;
        if (priceRange) { priceRange.value = 2000000; priceDisplay.textContent = 'Rp 2.000.000'; }
        document.querySelectorAll('.seat-btn').forEach(b => {
            b.classList.remove('bg-blue-600','text-white','border-blue-600');
            b.classList.add('border-slate-200','text-slate-600');
        });
    });
</script>
@endpush
