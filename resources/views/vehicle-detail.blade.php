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
        <a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors">Beranda</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <a href="{{ route('browse') }}" class="hover:text-blue-600 transition-colors">Jelajahi</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-slate-700 font-medium">Toyota Innova Zenix</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

        {{-- ===== LEFT: GALLERY & DETAILS ===== --}}
        <div class="lg:col-span-2">

            {{-- Main Image --}}
            <div class="bg-slate-100 rounded-3xl overflow-hidden h-80 sm:h-96 relative">
                <img id="main-image" src="https://images.unsplash.com/photo-1570733577524-3a047079e80d?auto=format&fit=crop&q=80&w=900"
                    class="w-full h-full object-cover" alt="Toyota Innova Zenix">

                {{-- Badge --}}
                <div class="absolute top-4 left-4 flex gap-2">
                    <span class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1.5 rounded-full">✅ Tersedia</span>
                    <span class="bg-blue-600 text-white text-xs font-bold px-3 py-1.5 rounded-full">🔥 Terlaris</span>
                </div>

                {{-- Wishlist --}}
                <button id="wishlist-detail-btn" class="absolute top-4 right-4 w-10 h-10 bg-white rounded-full flex items-center justify-center text-slate-400 hover:text-red-500 transition-colors shadow-lg">
                    <i class="far fa-heart"></i>
                </button>
            </div>

            {{-- Thumbnail Gallery --}}
            <div class="flex gap-3 mt-4 overflow-x-auto pb-2">
                @php
                $thumbs = [
                    'https://images.unsplash.com/photo-1570733577524-3a047079e80d?auto=format&fit=crop&q=80&w=300',
                    'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&q=80&w=300',
                    'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&q=80&w=300',
                    'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&q=80&w=300',
                ];
                @endphp
                @foreach($thumbs as $i => $thumb)
                <div class="thumb-img flex-shrink-0 w-20 h-16 rounded-xl overflow-hidden border-2 {{ $i === 0 ? 'border-blue-600 active' : 'border-transparent' }}"
                    data-src="{{ $thumb }}" onclick="switchImage(this)">
                    <img src="{{ $thumb }}" class="w-full h-full object-cover">
                </div>
                @endforeach
            </div>

            {{-- Tabs --}}
            <div class="mt-8 border-b border-slate-200">
                <div class="flex gap-0">
                    @foreach(['Spesifikasi' => 'tab-spek', 'Fasilitas' => 'tab-fasilitas', 'Syarat Sewa' => 'tab-syarat', 'Ulasan' => 'tab-ulasan'] as $label => $tabId)
                    <button class="tab-btn px-5 py-3 text-sm font-semibold text-slate-500 hover:text-blue-600 transition-colors {{ $loop->first ? 'active' : '' }}"
                        data-tab="{{ $tabId }}">{{ $label }}</button>
                    @endforeach
                </div>
            </div>

            {{-- Tab Content: Spesifikasi --}}
            <div id="tab-spek" class="tab-content py-6">
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    @php
                    $specs = [
                        ['icon' => 'fas fa-users', 'label' => 'Kapasitas', 'value' => '7 Penumpang'],
                        ['icon' => 'fas fa-cog', 'label' => 'Transmisi', 'value' => 'Matic CVT'],
                        ['icon' => 'fas fa-gas-pump', 'label' => 'Bahan Bakar', 'value' => 'Bensin'],
                        ['icon' => 'fas fa-tachometer-alt', 'label' => 'Mesin', 'value' => '2.0L Hybrid'],
                        ['icon' => 'fas fa-palette', 'label' => 'Warna', 'value' => 'Putih Pearl'],
                        ['icon' => 'fas fa-calendar', 'label' => 'Tahun', 'value' => '2024'],
                    ];
                    @endphp
                    @foreach($specs as $spec)
                    <div class="bg-slate-50 rounded-2xl p-4 flex items-center gap-3">
                        <div class="w-9 h-9 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="{{ $spec['icon'] }} text-sm"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-medium">{{ $spec['label'] }}</p>
                            <p class="font-bold text-slate-800 text-sm">{{ $spec['value'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Tab Content: Fasilitas --}}
            <div id="tab-fasilitas" class="tab-content py-6 hidden">
                <div class="grid grid-cols-2 gap-3">
                    @php
                    $fasilitas = ['AC Double Blower', 'Kursi Captain', 'Sunroof', 'Kamera Mundur', 'Apple CarPlay', 'Wireless Charging', 'USB Port x4', 'Sensor Parkir', 'Keyless Entry', 'Head Unit Touchscreen'];
                    @endphp
                    @foreach($fasilitas as $f)
                    <div class="flex items-center gap-3 text-sm text-slate-700">
                        <i class="fas fa-check-circle text-green-500 flex-shrink-0"></i>
                        <span>{{ $f }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Tab Content: Syarat Sewa --}}
            <div id="tab-syarat" class="tab-content py-6 hidden">
                <ul class="space-y-3 text-sm text-slate-700">
                    @php
                    $syarat = [
                        'KTP asli yang masih berlaku (wajib)',
                        'SIM A yang masih berlaku',
                        'Jaminan: KTP/KK/Paspor atau uang tunai Rp 500.000',
                        'Usia minimal penyewa: 21 tahun',
                        'Tidak diperkenankan untuk antar-kota tanpa izin',
                        'Pengisian bensin menjadi tanggung jawab penyewa',
                        'Kendaraan dikembalikan dalam kondisi bersih',
                        'Keterlambatan pengembalian dikenakan denda Rp 50.000/jam',
                    ];
                    @endphp
                    @foreach($syarat as $s)
                    <li class="flex items-start gap-3">
                        <i class="fas fa-info-circle text-blue-500 mt-0.5 flex-shrink-0"></i>
                        <span>{{ $s }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Tab Content: Ulasan --}}
            <div id="tab-ulasan" class="tab-content py-6 hidden">
                <div class="flex items-center gap-6 mb-6 p-5 bg-blue-50 rounded-2xl">
                    <div class="text-center">
                        <p class="text-5xl font-black text-blue-600">4.9</p>
                        <div class="flex gap-1 mt-1 justify-center">
                            @for($i = 0; $i < 5; $i++)<i class="fas fa-star text-yellow-400 text-sm"></i>@endfor
                        </div>
                        <p class="text-xs text-slate-500 mt-1">128 Ulasan</p>
                    </div>
                    <div class="flex-1 space-y-1.5">
                        @foreach([['5',92],['4',28],['3',6],['2',2],['1',0]] as [$star,$count])
                        <div class="flex items-center gap-2 text-xs">
                            <span class="w-2 text-slate-500">{{ $star }}</span>
                            <i class="fas fa-star text-yellow-400 text-xs"></i>
                            <div class="flex-1 h-2 bg-slate-200 rounded-full overflow-hidden">
                                <div class="h-full bg-yellow-400 rounded-full" style="width: {{ ($count/128)*100 }}%"></div>
                            </div>
                            <span class="text-slate-400 w-6">{{ $count }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Sample reviews --}}
                @php
                $ulasan = [
                    ['name'=>'Budi S.','date'=>'25 Mar 2025','text'=>'Mobilnya sangat terawat dan bersih. Proses booking mudah, rekomen!','avatar'=>'B','rating'=>5],
                    ['name'=>'Sari D.','date'=>'18 Mar 2025','text'=>'Pelayanan cepat dan responsif. Pasti sewa lagi di sini.','avatar'=>'S','rating'=>5],
                ];
                @endphp
                <div class="space-y-4">
                    @foreach($ulasan as $u)
                    <div class="border border-slate-100 rounded-2xl p-5">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-9 h-9 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-sm">{{ $u['avatar'] }}</div>
                            <div>
                                <p class="font-bold text-slate-800 text-sm">{{ $u['name'] }}</p>
                                <p class="text-xs text-slate-400">{{ $u['date'] }}</p>
                            </div>
                            <div class="ml-auto flex gap-0.5">
                                @for($i=0;$i<$u['rating'];$i++)<i class="fas fa-star text-yellow-400 text-xs"></i>@endfor
                            </div>
                        </div>
                        <p class="text-sm text-slate-600">"{{ $u['text'] }}"</p>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>

        {{-- ===== RIGHT: BOOKING CARD ===== --}}
        <div class="lg:col-span-1">
            <div class="bg-white border border-slate-100 rounded-3xl shadow-xl p-6 sticky top-22">

                {{-- Price --}}
                <div class="mb-5">
                    <p class="text-slate-400 text-sm">Harga per hari</p>
                    <p class="text-4xl font-black text-slate-900 mt-1">Rp 650.000</p>
                    <p class="text-xs text-slate-400 mt-1">Sudah termasuk asuransi dasar</p>
                </div>

                <div class="flex gap-1 mb-5">
                    @for($i=0;$i<5;$i++)<i class="fas fa-star text-yellow-400 text-sm"></i>@endfor
                    <span class="text-sm text-slate-500 ml-2">4.9 (128 ulasan)</span>
                </div>

                {{-- Date Picker --}}
                <div class="space-y-3 mb-5">
                    <div class="border border-slate-200 rounded-2xl overflow-hidden divide-y divide-slate-200">
                        <div class="p-4">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wide block mb-1">Tanggal Mulai</label>
                            <input type="date" id="book-start" class="w-full text-slate-800 font-semibold bg-transparent focus:outline-none text-sm">
                        </div>
                        <div class="p-4">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wide block mb-1">Tanggal Selesai</label>
                            <input type="date" id="book-end" class="w-full text-slate-800 font-semibold bg-transparent focus:outline-none text-sm">
                        </div>
                    </div>
                </div>

                {{-- Price Breakdown --}}
                <div id="price-breakdown" class="bg-slate-50 rounded-2xl p-4 mb-5 space-y-2 text-sm hidden">
                    <div class="flex justify-between text-slate-600">
                        <span>Rp 650.000 × <span id="days-count">0</span> hari</span>
                        <span id="subtotal">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-slate-600">
                        <span>Biaya layanan</span>
                        <span>Rp 25.000</span>
                    </div>
                    <div class="flex justify-between font-bold text-slate-900 pt-2 border-t border-slate-200">
                        <span>Total</span>
                        <span id="grand-total" class="text-blue-600">Rp 0</span>
                    </div>
                </div>

                {{-- CTA --}}
                <a href="{{ route('login') }}" class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-2xl transition-all active:scale-95 shadow-lg shadow-blue-200 text-sm">
                    <i class="fas fa-calendar-check mr-2"></i>Pesan Sekarang
                </a>
                <p class="text-center text-xs text-slate-400 mt-3">Tidak akan dikenakan biaya sekarang</p>

                {{-- Contact --}}
                <a href="https://wa.me/6281234567890" target="_blank"
                    class="flex items-center justify-center gap-2 w-full border border-green-200 hover:bg-green-50 text-green-600 font-semibold py-3 rounded-2xl mt-3 transition-all text-sm">
                    <i class="fab fa-whatsapp text-lg"></i> Tanya via WhatsApp
                </a>
            </div>
        </div>
    </div>

    {{-- Related Vehicles --}}
    <div class="mt-16">
        <h2 class="text-2xl font-black text-slate-900 mb-6">Kendaraan <span class="text-blue-600">Serupa</span></h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @php
            $related = [
                ['name'=>'Mitsubishi Xpander','type'=>'MPV','price'=>'Rp 500.000','img'=>'https://images.unsplash.com/photo-1583267746897-2cf415887172?auto=format&fit=crop&q=80&w=600'],
                ['name'=>'Honda CR-V Turbo','type'=>'SUV','price'=>'Rp 750.000','img'=>'https://images.unsplash.com/photo-1519641471654-76ce0107ad1b?auto=format&fit=crop&q=80&w=600'],
                ['name'=>'Daihatsu Xenia','type'=>'MPV','price'=>'Rp 380.000','img'=>'https://images.unsplash.com/photo-1603553329474-99f95f35394f?auto=format&fit=crop&q=80&w=600'],
            ];
            @endphp
            @foreach($related as $r)
            <a href="{{ route('vehicle.detail', 1) }}" class="group bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                <div class="h-44 overflow-hidden">
                    <img src="{{ $r['img'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $r['name'] }}">
                </div>
                <div class="p-4 flex justify-between items-center">
                    <div>
                        <p class="font-bold text-slate-900 text-sm">{{ $r['name'] }}</p>
                        <p class="text-slate-400 text-xs">{{ $r['type'] }}</p>
                    </div>
                    <p class="font-black text-blue-600 text-sm">{{ $r['price'] }}<small class="text-slate-400 font-normal">/hr</small></p>
                </div>
            </a>
            @endforeach
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // Image gallery switcher
    function switchImage(el) {
        document.getElementById('main-image').src = el.getAttribute('data-src');
        document.querySelectorAll('.thumb-img').forEach(t => t.classList.remove('active', 'border-blue-600'));
        el.classList.add('active', 'border-blue-600');
    }

    // Tab system
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
            this.classList.add('active');
            document.getElementById(this.dataset.tab).classList.remove('hidden');
        });
    });

    // Booking date & price calculator
    const startInput = document.getElementById('book-start');
    const endInput   = document.getElementById('book-end');
    const priceBreakdown = document.getElementById('price-breakdown');
    const pricePerDay = 650000;
    const serviceFee  = 25000;

    const fmt = d => d.toISOString().split('T')[0];
    const today = new Date();
    const tomorrow = new Date(today); tomorrow.setDate(today.getDate() + 1);
    startInput.value = fmt(today);
    endInput.value   = fmt(tomorrow);
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

    // Wishlist
    document.getElementById('wishlist-detail-btn').addEventListener('click', function() {
        const icon = this.querySelector('i');
        icon.classList.toggle('far');
        icon.classList.toggle('fas');
        icon.classList.toggle('text-red-500');
    });
</script>
@endpush
