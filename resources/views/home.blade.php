@extends('layouts.app')

@section('title', 'Sewa Mobil & Motor Terbaik di Indonesia')

@push('styles')
<style>
    .hero-bg {
        background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 50%, #2563eb 100%);
    }
    .card-hover {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .card-hover:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(37, 99, 235, 0.12);
    }
    .search-input:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
    }
</style>
@endpush

@section('content')

{{-- ===== HERO SECTION ===== --}}
<section class="hero-bg text-white relative overflow-hidden">
    {{-- Background decoration --}}
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-10 right-20 w-64 h-64 bg-white rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-10 w-96 h-96 bg-blue-300 rounded-full blur-3xl"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative z-10">
        <div class="max-w-4xl mx-auto text-center flex flex-col items-center">
            {{-- Text Content --}}
            <span class="inline-flex items-center gap-2 bg-white/15 backdrop-blur-sm border border-white/20 text-blue-100 text-xs font-semibold px-4 py-2 rounded-full mb-8">
                <i class="fas fa-location-dot text-red-400"></i>
                Jangkauan Wilayah Jabodetabek
            </span>
            
            <h1 class="text-4xl sm:text-6xl lg:text-7xl font-black leading-tight">
                Sewa Kendaraan<br>
                <span class="text-blue-200 text-5xl sm:text-7xl">Se-Jabodetabek</span>
            </h1>
            
            <p class="mt-6 text-blue-100 text-lg sm:text-xl leading-relaxed max-w-2xl">
                Mobil & motor berkualitas siap antar jemput ke lokasi Anda. Temukan armada terbaik untuk perjalanan Anda di Jakarta, Bogor, Depok, Tangerang, dan Bekasi.
            </p>

            {{-- Stats --}}
            <div class="flex flex-wrap justify-center gap-8 md:gap-12 mt-10">
                <div class="text-center">
                    <p class="text-3xl sm:text-4xl font-black">500+</p>
                    <p class="text-blue-200 text-sm">Armada Unit</p>
                </div>
                <div class="hidden sm:block w-px h-10 bg-white/20 my-auto"></div>
                <div class="text-center">
                    <p class="text-3xl sm:text-4xl font-black">50K+</p>
                    <p class="text-blue-200 text-sm">Pelanggan Puas</p>
                </div>
                <div class="hidden sm:block w-px h-10 bg-white/20 my-auto"></div>
                <div class="text-center">
                    <p class="text-2xl sm:text-4xl font-black flex items-center justify-center gap-2">
                        4.9<i class="fas fa-star text-yellow-400 text-xl sm:text-2xl"></i>
                    </p>
                    <p class="text-blue-200 text-sm">Rating Rata-rata</p>
                </div>
            </div>

            {{-- CTA Buttons --}}
            <div class="flex flex-col sm:flex-row gap-4 mt-12 w-full sm:w-auto">
                <a href="{{ route('browse') }}" class="bg-white text-blue-700 font-bold px-10 py-4 rounded-xl hover:bg-blue-50 transition-all active:scale-95 shadow-xl text-lg">
                    <i class="fas fa-search mr-2"></i>Cari Kendaraan
                </a>
                <a href="{{ route('how.it.works') }}" class="border border-white/40 hover:bg-white/10 font-semibold px-10 py-4 rounded-xl transition-all text-lg">
                    <i class="fas fa-play mr-2"></i>Cara Kerja
                </a>
            </div>
        </div>
    </div>

    {{-- Wave --}}
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 80L1440 80L1440 30C1200 70 720 0 0 50L0 80Z" fill="#f8fafc"/>
        </svg>
    </div>
</section>

{{-- ===== SEARCH BAR SECTION ===== --}}
<section class="max-w-6xl mx-auto px-4 -mt-2 relative z-10">
    <div class="bg-white rounded-2xl shadow-xl border border-slate-100 p-6">
        <h2 class="text-lg font-bold text-slate-800 mb-5 flex items-center gap-2">
            <i class="fas fa-sliders text-blue-500"></i>
            Tentukan Perjalanan Anda
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <div>
                <label class="text-xs font-semibold text-slate-500 uppercase tracking-wide block mb-2 font-black">Lokasi Penjemputan</label>
                <select id="filter-location" class="search-input w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium text-slate-700 cursor-pointer">
                    <option value="">Semua Lokasi</option>
                    <option value="jakarta">Jakarta</option>
                    <option value="bogor">Bogor</option>
                    <option value="depok">Depok</option>
                    <option value="tangerang">Tangerang</option>
                    <option value="bekasi">Bekasi</option>
                </select>
            </div>
            <div>
                <label class="text-xs font-semibold text-slate-500 uppercase tracking-wide block mb-2">Jenis Kendaraan</label>
                <select id="filter-type" class="search-input w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium text-slate-700 cursor-pointer">
                    <option value="">Semua Jenis</option>
                    <option value="mobil">Mobil</option>
                    <option value="motor">Motor</option>
                    <option value="minibus">Minibus</option>
                </select>
            </div>
            <div>
                <label class="text-xs font-semibold text-slate-500 uppercase tracking-wide block mb-2">Tanggal Mulai</label>
                <input type="date" id="filter-start" class="search-input w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium text-slate-700">
            </div>
            <div>
                <label class="text-xs font-semibold text-slate-500 uppercase tracking-wide block mb-2">Tanggal Selesai</label>
                <input type="date" id="filter-end" class="search-input w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium text-slate-700">
            </div>
            <div class="flex items-end">
                <a href="{{ route('browse') }}" id="btn-search" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl transition-all active:scale-95 text-center text-sm shadow-md">
                    Cari Sekarang
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ===== KATEGORI SECTION ===== --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-20">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-black text-slate-900">Pilih Kategori<br><span class="text-blue-600">Kendaraan Anda</span></h2>
        <p class="text-slate-500 mt-3">Temukan kendaraan yang sesuai dengan kebutuhan perjalanan Anda</p>
    </div>
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @php
        $categories = [
            ['icon' => 'fas fa-car', 'label' => 'Mobil Sedan', 'count' => '45 Unit', 'color' => 'bg-blue-50 text-blue-600', 'border' => 'border-blue-100'],
            ['icon' => 'fas fa-shuttle-van', 'label' => 'MPV / SUV', 'count' => '32 Unit', 'color' => 'bg-blue-50 text-blue-600', 'border' => 'border-blue-100'],
            ['icon' => 'fas fa-motorcycle', 'label' => 'Motor', 'count' => '120 Unit', 'color' => 'bg-blue-50 text-blue-600', 'border' => 'border-blue-100'],
            ['icon' => 'fas fa-bus', 'label' => 'Minibus / ELF', 'count' => '18 Unit', 'color' => 'bg-blue-50 text-blue-600', 'border' => 'border-blue-100'],
        ];
        @endphp
        @foreach($categories as $cat)
        <a href="{{ route('browse') }}" class="card-hover group bg-white border {{ $cat['border'] }} rounded-2xl p-6 text-center cursor-pointer">
            <div class="w-14 h-14 {{ $cat['color'] }} rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                <i class="{{ $cat['icon'] }} text-2xl"></i>
            </div>
            <p class="font-bold text-slate-800">{{ $cat['label'] }}</p>
            <p class="text-slate-400 text-sm mt-1">{{ $cat['count'] }}</p>
        </a>
        @endforeach
    </div>
</section>

{{-- ===== ARMADA TERLARIS ===== --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-20">
    <div class="flex justify-between items-end mb-10">
        <div>
            <h2 class="text-3xl font-black text-slate-900">Armada <span class="text-blue-600">Terlaris</span></h2>
            <p class="text-slate-500 mt-2">Kendaraan paling banyak dipesan minggu ini</p>
        </div>
        <a href="{{ route('browse') }}" class="text-blue-600 hover:text-blue-700 font-semibold text-sm flex items-center gap-1.5 group">
            Lihat Semua <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-12">
        @foreach($vehicles as $v)
        <div class="card-hover bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm group">
            {{-- Image --}}
            <div class="relative overflow-hidden h-52">
                <img src="{{ $v->image ? (strpos($v->image, 'http') === 0 ? $v->image : asset('storage/' . $v->image)) : 'https://placehold.co/600x400?text=No+Image' }}" 
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $v->name }}">
                <div class="absolute top-3 left-3">
                    @php
                        $statusColor = $v->status == 'Tersedia' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700';
                    @endphp
                    <span class="text-[10px] font-bold px-3 py-1.5 rounded-full {{ $statusColor }} uppercase tracking-wider">
                        {{ $v->status }}
                    </span>
                </div>
            </div>

            {{-- Content --}}
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="font-bold text-slate-900 group-hover:text-blue-600 transition-colors">{{ $v->name }}</h3>
                        <p class="text-slate-400 text-xs mt-1 uppercase tracking-widest font-bold">{{ $v->type }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-black text-blue-600 text-lg">Rp {{ number_format($v->price_per_day, 0, ',', '.') }}</p>
                        <p class="text-slate-400 text-[10px] uppercase font-bold tracking-widest">/ hari</p>
                    </div>
                </div>

                {{-- Specs --}}
                <div class="flex gap-4 mb-6 text-xs text-slate-500 border-t border-slate-50 pt-4">
                    <span class="flex items-center gap-1.5"><i class="fas fa-users text-blue-400"></i> {{ $v->seats }} Kursi</span>
                    <span class="flex items-center gap-1.5"><i class="fas fa-cog text-blue-400"></i> {{ $v->transmission }}</span>
                    <span class="flex items-center gap-1.5 ml-auto"><i class="fas fa-star text-yellow-500"></i> {{ $v->rating }}</span>
                </div>

                {{-- Action --}}
                <div class="flex gap-2">
                    <a href="{{ route('vehicle.detail', $v->id) }}" class="flex-1 text-center border border-slate-200 hover:border-blue-300 hover:text-blue-600 text-slate-600 font-bold py-3 rounded-xl text-xs transition-all uppercase tracking-widest">
                        Detail
                    </a>
                    <a href="{{ route('vehicle.detail', $v->id) }}" class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl text-xs transition-all uppercase tracking-widest shadow-lg shadow-blue-100">
                        Sewa
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    </div>
</section>

{{-- ===== AREA LAYANAN SECTION ===== --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-24">
    <div class="bg-white border border-slate-100 rounded-[2.5rem] p-8 md:p-14 shadow-sm relative overflow-hidden">
        <div class="absolute -top-10 -right-10 opacity-[0.03]">
            <i class="fas fa-map-location-dot text-[20rem] text-blue-600 -rotate-12"></i>
        </div>
        <div class="relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
                <div>
                    <h2 class="text-4xl font-black text-slate-900">Area Jangkauan <span class="text-blue-600">Layanan</span></h2>
                    <p class="text-slate-500 mt-4 text-lg max-w-xl">Kami melayani layanan antar-jemput kendaraan langsung ke lokasi Anda di seluruh wilayah Jabodetabek tanpa biaya tambahan.</p>
                </div>
                <div class="flex items-center gap-3 bg-blue-50 px-5 py-3 rounded-2xl border border-blue-100">
                    <i class="fas fa-circle-check text-blue-600 text-xl"></i>
                    <span class="text-blue-800 font-bold text-sm">Gratis Antar Jemput</span>
                </div>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
                @php
                $cities = [
                    ['name' => 'Jakarta', 'icon' => 'fas fa-city'],
                    ['name' => 'Bogor', 'icon' => 'fas fa-mountain-city'],
                    ['name' => 'Depok', 'icon' => 'fas fa-building-user'],
                    ['name' => 'Tangerang', 'icon' => 'fas fa-plane-up'],
                    ['name' => 'Bekasi', 'icon' => 'fas fa-industry'],
                ];
                @endphp
                @foreach($cities as $city)
                <div class="flex flex-col items-center p-8 bg-slate-50 rounded-3xl border border-slate-100 hover:border-blue-200 hover:bg-blue-50 hover:shadow-lg hover:shadow-blue-900/5 transition-all group cursor-default">
                    <div class="w-16 h-16 bg-white rounded-2xl shadow-sm flex items-center justify-center mb-5 group-hover:bg-blue-600 group-hover:text-white transition-all transform group-hover:-translate-y-1">
                        <i class="{{ $city['icon'] }} text-2xl"></i>
                    </div>
                    <span class="font-extrabold text-slate-800 tracking-tight text-lg">{{ $city['name'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ===== WHY CHOOSE US ===== --}}
<section class="mt-24 bg-gradient-to-br from-blue-900 to-blue-700 text-white py-20 relative overflow-hidden">
    <div class="absolute inset-0 opacity-5">
        <div class="absolute top-0 right-0 w-96 h-96 bg-white rounded-full blur-3xl"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-14">
            <h2 class="text-3xl font-black">Kenapa Pilih <span class="text-blue-200">RentDrive?</span></h2>
            <p class="text-blue-200 mt-2">Kami hadir untuk memastikan perjalanan Anda lebih mudah dan menyenangkan</p>
        </div>
        @php
        $features = [
            ['icon' => 'fas fa-shield-alt', 'title' => 'Armada Terverifikasi', 'desc' => 'Setiap kendaraan melewati inspeksi ketat sebelum tersedia untuk disewa.'],
            ['icon' => 'fas fa-tags', 'title' => 'Harga Transparan', 'desc' => 'Tidak ada biaya tersembunyi. Apa yang Anda lihat adalah yang Anda bayar.'],
            ['icon' => 'fas fa-headset', 'title' => 'Dukungan 24/7', 'desc' => 'Tim kami siap membantu Anda kapanpun dibutuhkan selama 24 jam.'],
            ['icon' => 'fas fa-map-marker-alt', 'title' => 'Antar Jemput', 'desc' => 'Layanan antar jemput tersedia untuk kenyamanan perjalanan Anda.'],
        ];
        @endphp
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($features as $f)
            <div class="bg-white/10 backdrop-blur-sm border border-white/15 rounded-2xl p-6 hover:bg-white/20 transition-all">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mb-4">
                    <i class="{{ $f['icon'] }} text-xl"></i>
                </div>
                <h3 class="font-bold mb-2">{{ $f['title'] }}</h3>
                <p class="text-blue-200 text-sm leading-relaxed">{{ $f['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== TESTIMONIAL ===== --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-24">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-black text-slate-900">Apa Kata <span class="text-blue-600">Mereka?</span></h2>
        <p class="text-slate-500 mt-2">Ribuan pelanggan sudah mempercayai RentDrive</p>
    </div>
    @php
    $testimonials = [
        ['name' => 'Budi Santoso', 'role' => 'Pebisnis, Jakarta', 'text' => 'Prosesnya sangat mudah dan cepat. Mobil datang tepat waktu dan dalam kondisi sangat baik. Pasti sewa lagi!', 'rating' => 5, 'avatar' => 'B'],
        ['name' => 'Sari Dewi', 'role' => 'Wisatawan, Surabaya', 'text' => 'Harganya bersaing dan tidak ada biaya tersembunyi. Customer service sangat ramah dan responsif. Recommended!', 'rating' => 5, 'avatar' => 'S'],
        ['name' => 'Riko Pratama', 'role' => 'Mahasiswa, Bandung', 'text' => 'Sewa motor PCX untuk keliling kota, super nyaman! Proses booking online mudah banget, langsung dapat konfirmasi.', 'rating' => 5, 'avatar' => 'R'],
    ];
    @endphp
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($testimonials as $t)
        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex gap-1 mb-4">
                @for($i = 0; $i < $t['rating']; $i++)
                <i class="fas fa-star text-yellow-400 text-sm"></i>
                @endfor
            </div>
            <p class="text-slate-600 text-sm leading-relaxed">"{{ $t['text'] }}"</p>
            <div class="flex items-center gap-3 mt-5 pt-5 border-t border-slate-50">
                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">{{ $t['avatar'] }}</div>
                <div>
                    <p class="font-bold text-slate-900 text-sm">{{ $t['name'] }}</p>
                    <p class="text-slate-400 text-xs">{{ $t['role'] }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- ===== CTA SECTION ===== --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-24">
    <div class="bg-blue-600 rounded-3xl p-10 md:p-16 text-center text-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <i class="fas fa-car-side absolute right-10 top-5 text-[12rem]"></i>
        </div>
        <div class="relative z-10">
            <h2 class="text-3xl md:text-4xl font-black mb-4">Siap Memulai<br>Perjalanan Anda?</h2>
            <p class="text-blue-100 mb-8 max-w-md mx-auto">Daftar sekarang dan dapatkan diskon 20% untuk pemesanan pertama Anda.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="bg-white text-blue-600 font-bold px-8 py-4 rounded-xl hover:bg-blue-50 transition-all active:scale-95 shadow-xl">
                    Daftar Gratis Sekarang
                </a>
                <a href="{{ route('browse') }}" class="border border-white/40 hover:bg-white/10 font-semibold px-8 py-4 rounded-xl transition-all">
                    Lihat Armada
                </a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    // Wishlist toggle (pure Vanilla JS)
    document.querySelectorAll('.wishlist-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const icon = this.querySelector('i');
            icon.classList.toggle('far');
            icon.classList.toggle('fas');
            icon.classList.toggle('text-red-500');
            icon.classList.toggle('text-slate-400');
        });
    });

    // Set default date for search bar (today & tomorrow)
    const today = new Date();
    const tomorrow = new Date(today);
    tomorrow.setDate(tomorrow.getDate() + 1);

    const fmt = (d) => d.toISOString().split('T')[0];
    const startInput = document.getElementById('filter-start');
    const endInput = document.getElementById('filter-end');
    if (startInput) startInput.value = fmt(today);
    if (endInput) endInput.value = fmt(tomorrow);

    // Prevent end date from being before start date
    if (startInput && endInput) {
        startInput.addEventListener('change', function() {
            if (endInput.value && endInput.value <= this.value) {
                const next = new Date(this.value);
                next.setDate(next.getDate() + 1);
                endInput.value = fmt(next);
            }
            endInput.min = this.value;
        });
    }
</script>
@endpush