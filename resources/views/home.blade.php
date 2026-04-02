@extends('layouts.app')

@section('title', 'Sewa Mobil & Motor Terbaik di Indonesia')

@push('styles')
<style>
    .hero-bg {
        background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 50%, #2563eb 100%);
    }
    .floating-card {
        animation: float 3s ease-in-out infinite;
    }
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-8px); }
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
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

            {{-- Left: Text --}}
            <div>
                <span class="inline-flex items-center gap-2 bg-white/15 backdrop-blur-sm border border-white/20 text-blue-100 text-xs font-semibold px-4 py-2 rounded-full mb-6">
                    <i class="fas fa-star text-yellow-400"></i>
                    #1 Platform Sewa Kendaraan Indonesia
                </span>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight">
                    Perjalanan Nyaman<br>
                    <span class="text-blue-200">Mulai dari Sini</span>
                </h1>
                <p class="mt-5 text-blue-100 text-lg leading-relaxed max-w-lg">
                    Ribuan armada mobil & motor berkualitas tersedia 24 jam. Harga transparan, proses cepat, tanpa biaya tersembunyi.
                </p>

                {{-- Stats --}}
                <div class="flex gap-8 mt-8">
                    <div>
                        <p class="text-3xl font-black">500+</p>
                        <p class="text-blue-200 text-sm">Armada Unit</p>
                    </div>
                    <div class="w-px bg-white/20"></div>
                    <div>
                        <p class="text-3xl font-black">50K+</p>
                        <p class="text-blue-200 text-sm">Pelanggan Puas</p>
                    </div>
                    <div class="w-px bg-white/20"></div>
                    <div>
                        <p class="text-3xl font-black">4.9⭐</p>
                        <p class="text-blue-200 text-sm">Rating Rata-rata</p>
                    </div>
                </div>

                <div class="flex gap-4 mt-10">
                    <a href="{{ route('browse') }}" class="bg-white text-blue-700 font-bold px-7 py-3.5 rounded-xl hover:bg-blue-50 transition-all active:scale-95 shadow-xl">
                        <i class="fas fa-search mr-2"></i>Cari Kendaraan
                    </a>
                    <a href="{{ route('how.it.works') }}" class="border border-white/40 hover:bg-white/10 font-semibold px-7 py-3.5 rounded-xl transition-all">
                        <i class="fas fa-play mr-2"></i>Cara Kerja
                    </a>
                </div>
            </div>

            {{-- Right: Floating Card --}}
            <div class="hidden lg:flex justify-center">
                <div class="relative">
                    <div class="floating-card bg-white/15 backdrop-blur-md border border-white/20 rounded-3xl p-6 w-72 shadow-2xl">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-blue-500 rounded-xl flex items-center justify-center">
                                <i class="fas fa-car text-white"></i>
                            </div>
                            <div>
                                <p class="font-bold text-sm">Toyota Alphard</p>
                                <p class="text-blue-200 text-xs">MPV Premium</p>
                            </div>
                        </div>
                        <img src="https://images.unsplash.com/photo-1550355291-bbee04a92027?auto=format&fit=crop&q=80&w=400" class="w-full h-36 object-cover rounded-2xl mb-4" alt="Alphard">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-blue-200 text-xs">Harga per hari</p>
                                <p class="text-2xl font-black">Rp 1,2 Jt</p>
                            </div>
                            <span class="bg-green-400 text-green-900 text-xs font-bold px-3 py-1.5 rounded-full">Tersedia</span>
                        </div>
                    </div>
                    {{-- Badge floating --}}
                    <div class="absolute -bottom-4 -right-4 bg-yellow-400 text-yellow-900 font-black text-sm px-4 py-2 rounded-full shadow-lg">
                        🔥 Promo Hari Ini!
                    </div>
                </div>
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
<section class="max-w-4xl mx-auto px-4 -mt-2 relative z-10">
    <div class="bg-white rounded-2xl shadow-xl border border-slate-100 p-6">
        <h2 class="text-lg font-bold text-slate-800 mb-5">Cari Kendaraan Tersedia</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label class="text-xs font-semibold text-slate-500 uppercase tracking-wide block mb-2">Jenis Kendaraan</label>
                <select id="filter-type" class="search-input w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium text-slate-700 cursor-pointer">
                    <option value="">Semua Jenis</option>
                    <option value="mobil">🚗 Mobil</option>
                    <option value="motor">🏍️ Motor</option>
                    <option value="minibus">🚐 Minibus</option>
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
                <a href="{{ route('browse') }}" id="btn-search" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition-all active:scale-95 text-center text-sm shadow-md">
                    <i class="fas fa-search mr-2"></i>Cari Sekarang
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
            ['icon' => 'fas fa-shuttle-van', 'label' => 'MPV / SUV', 'count' => '32 Unit', 'color' => 'bg-purple-50 text-purple-600', 'border' => 'border-purple-100'],
            ['icon' => 'fas fa-motorcycle', 'label' => 'Motor', 'count' => '120 Unit', 'color' => 'bg-orange-50 text-orange-600', 'border' => 'border-orange-100'],
            ['icon' => 'fas fa-bus', 'label' => 'Minibus / ELF', 'count' => '18 Unit', 'color' => 'bg-green-50 text-green-600', 'border' => 'border-green-100'],
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

    @php
    $vehicles = [
        ['name' => 'Toyota Innova Zenix', 'type' => 'MPV', 'seats' => 7, 'transmission' => 'Matic', 'price' => 'Rp 650.000', 'status' => 'Tersedia', 'status_color' => 'bg-green-100 text-green-700', 'img' => 'https://images.unsplash.com/photo-1570733577524-3a047079e80d?auto=format&fit=crop&q=80&w=600', 'rating' => '4.9', 'reviews' => 128],
        ['name' => 'Honda CR-V Turbo', 'type' => 'SUV', 'seats' => 5, 'transmission' => 'Matic', 'price' => 'Rp 750.000', 'status' => 'Tersedia', 'status_color' => 'bg-green-100 text-green-700', 'img' => 'https://images.unsplash.com/photo-1519641471654-76ce0107ad1b?auto=format&fit=crop&q=80&w=600', 'rating' => '4.8', 'reviews' => 95],
        ['name' => 'Honda PCX 160', 'type' => 'Motor Sport', 'seats' => 2, 'transmission' => 'Matic', 'price' => 'Rp 120.000', 'status' => 'Disewa', 'status_color' => 'bg-orange-100 text-orange-700', 'img' => 'https://images.unsplash.com/photo-1558981359-219d6364c9c8?auto=format&fit=crop&q=80&w=600', 'rating' => '4.7', 'reviews' => 210],
    ];
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($vehicles as $v)
        <div class="card-hover bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm group">
            {{-- Image --}}
            <div class="relative overflow-hidden h-52">
                <img src="{{ $v['img'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $v['name'] }}">
                <div class="absolute top-3 left-3">
                    <span class="text-xs font-bold px-3 py-1.5 rounded-full {{ $v['status_color'] }}">
                        {{ $v['status'] }}
                    </span>
                </div>
                <div class="absolute top-3 right-3">
                    <button class="w-8 h-8 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center text-slate-400 hover:text-red-500 transition-colors wishlist-btn shadow-sm">
                        <i class="far fa-heart text-sm"></i>
                    </button>
                </div>
            </div>

            {{-- Content --}}
            <div class="p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-bold text-slate-900">{{ $v['name'] }}</h3>
                        <p class="text-slate-400 text-sm mt-0.5">{{ $v['type'] }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-black text-blue-600">{{ $v['price'] }}</p>
                        <p class="text-slate-400 text-xs">/hari</p>
                    </div>
                </div>

                {{-- Specs --}}
                <div class="flex gap-4 mt-4 text-xs text-slate-500 border-t border-slate-50 pt-4">
                    <span class="flex items-center gap-1"><i class="fas fa-users"></i> {{ $v['seats'] }} Kursi</span>
                    <span class="flex items-center gap-1"><i class="fas fa-cog"></i> {{ $v['transmission'] }}</span>
                    <span class="flex items-center gap-1 ml-auto"><i class="fas fa-star text-yellow-400"></i> {{ $v['rating'] }} ({{ $v['reviews'] }})</span>
                </div>

                {{-- Action --}}
                <div class="mt-4 flex gap-2">
                    <a href="{{ route('vehicle.detail', 1) }}" class="flex-1 text-center border border-slate-200 hover:border-blue-300 hover:text-blue-600 text-slate-600 font-semibold py-2.5 rounded-xl text-sm transition-all">
                        Detail
                    </a>
                    <a href="{{ route('vehicle.detail', 1) }}" class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-xl text-sm transition-all">
                        <i class="fas fa-calendar-check mr-1"></i> Sewa
                    </a>
                </div>
            </div>
        </div>
        @endforeach
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