@extends('layouts.app')

@section('title', 'Selesaikan Pesanan Anda')

@php
    $checkoutPool = $vehicle->mitra->pool ?? null;
@endphp

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-8 text-center md:text-left">
        <h1 class="text-3xl font-black text-slate-900 mb-2">Selesaikan <span class="text-blue-600">Pesanan</span></h1>
        <p class="text-slate-500">Lengkapi data verifikasi untuk melanjutkan pemesanan</p>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 shadow-sm border border-red-100">
            <ul class="list-disc pl-5 text-sm font-medium">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="flex flex-col lg:flex-row gap-8">
        {{-- ==== BAGIAN KIRI: FORM VERIFIKASI ==== --}}
        <div class="lg:w-2/3 space-y-8">
            <div class="bg-white rounded-[2.5rem] p-8 md:p-10 border border-slate-100 shadow-2xl shadow-slate-200/50 relative overflow-hidden">
                {{-- Decorative Element --}}
                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50/50 rounded-full -mr-16 -mt-16 blur-2xl"></div>
                
                <form action="{{ route('booking.store') }}" method="POST" enctype="multipart/form-data" id="checkout-form">
                    @csrf
                    <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
                    <input type="hidden" name="start_date" value="{{ $bookingData['start_date'] }}">
                    <input type="hidden" name="end_date" value="{{ $bookingData['end_date'] }}">
                    <input type="hidden" name="delivery_type" value="self-pickup">

                    {{-- Section 1: Identitas --}}
                    <div id="identity_section" class="relative transition-all duration-300">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-blue-500/20">
                                <i class="fas fa-id-card text-lg"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-black text-slate-900 leading-tight">Berkas Verifikasi</h2>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Identitas Penyewa Terdaftar</p>
                            </div>
                        </div>
                        
                        <div class="bg-slate-50/50 rounded-[2rem] p-8 border border-slate-100/80 mb-10">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="group">
                                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] block mb-4 ml-1">Unggah Foto KTP <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <input type="file" name="ktp_photo" id="ktp_photo" accept="image/*" required class="w-full text-slate-900 text-xs file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-xs file:font-black file:uppercase file:tracking-widest file:bg-slate-900 file:text-white hover:file:bg-slate-800 transition-all cursor-pointer">
                                    </div>
                                </div>
                                <div id="sim_upload_wrapper" class="group transition-all duration-300">
                                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] block mb-4 ml-1">Unggah Foto SIM (A/C) <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <input type="file" name="sim_photo" id="sim_photo" accept="image/*" required class="w-full text-slate-900 text-xs file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-xs file:font-black file:uppercase file:tracking-widest file:bg-slate-900 file:text-white hover:file:bg-slate-800 transition-all cursor-pointer">
                                    </div>
                                </div>
                            </div>
                            <p class="mt-6 text-[10px] text-slate-400 font-bold leading-relaxed flex items-center gap-2">
                                <i class="fas fa-info-circle text-blue-500"></i>
                                Pastikan berkas terlihat jelas dan tidak terpotong (Format: JPG, PNG, maks 2MB).
                            </p>
                        </div>
                    </div>

                    {{-- Section 2: Lokasi Pool --}}
                    <div class="relative">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-12 h-12 bg-blue-900 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-blue-900/20">
                                <i class="fas fa-map-marked-alt text-lg"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-black text-slate-900 leading-tight">Lokasi Pool</h2>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Titik Pengambilan Armada</p>
                            </div>
                        </div>

                        <div id="pool_map_section" class="mt-0 mb-10">
                            <div class="bg-white rounded-[2.5rem] p-8 border-2 border-slate-100 shadow-2xl shadow-slate-200/50 overflow-hidden relative group">
                                <div class="flex items-center gap-4 mb-6">
                                    <div class="w-10 h-10 bg-red-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-red-500/20">
                                        <i class="fas fa-map-marker-alt text-sm"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-black text-slate-900 text-lg leading-none">Lokasi Pool Utama</h3>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Titik Pengambilan Armada Mandiri</p>
                                    </div>
                                </div>

                                @if($checkoutPool && $checkoutPool->latitude && $checkoutPool->longitude)
                                <div class="mb-4 flex items-start gap-3 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                    <i class="fas fa-map-pin text-slate-500 mt-0.5"></i>
                                    <div>
                                        <p class="text-xs font-black text-slate-700">{{ $checkoutPool->name }}</p>
                                        <p class="text-[10px] text-slate-400 font-medium mt-0.5">{{ $checkoutPool->address }}</p>
                                    </div>
                                    <a href="https://www.google.com/maps/search/?api=1&query={{ $checkoutPool->latitude }},{{ $checkoutPool->longitude }}" target="_blank" class="ml-auto flex-shrink-0 text-[10px] font-black text-blue-600 uppercase tracking-widest bg-blue-50 px-3 py-1.5 rounded-lg hover:bg-blue-100 transition-colors flex items-center gap-1">
                                        <i class="fas fa-directions"></i> Rute
                                    </a>
                                </div>
                                <div id="checkout-pool-map" class="w-full rounded-2xl overflow-hidden shadow-inner border border-slate-100 relative" style="height: 300px;"></div>
                                @else
                                <div class="aspect-video w-full rounded-2xl overflow-hidden bg-slate-50 border border-slate-100 flex flex-col items-center justify-center text-slate-400">
                                    <i class="fas fa-map-marked-alt text-4xl mb-3 opacity-30"></i>
                                    <p class="text-xs font-bold uppercase tracking-widest">{{ $vehicle->domicile ?? 'Lokasi Pool' }}</p>
                                    <p class="text-[10px] mt-1 opacity-70">Koordinat belum diatur oleh mitra</p>
                                </div>
                                @endif

                                <div class="mt-4 flex items-start gap-3 bg-red-50 p-4 rounded-xl border border-red-100">
                                    <i class="fas fa-info-circle text-red-500 mt-0.5"></i>
                                    <p class="text-[10px] font-bold text-red-700 leading-relaxed uppercase tracking-tighter">
                                        Harap tunjukkan kode booking ini saat pengambilan di pool {{ $checkoutPool->name ?? $vehicle->domicile ?? 'Jakarta' }}. Jam operasional Pool: 08.00 - 20.00 WIB.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-8 text-center md:text-right">
                        <button type="submit" class="w-full md:w-auto bg-slate-900 hover:bg-slate-800 text-white font-black py-6 px-14 rounded-3xl transition-all shadow-2xl shadow-slate-200 active:scale-95 group flex items-center justify-center gap-4 text-lg">
                            BUAT PESANAN SEKARANG
                            <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center group-hover:translate-x-2 transition-transform">
                                <i class="fas fa-arrow-right text-xs"></i>
                            </div>
                        </button>
                        <div class="flex flex-col md:flex-row items-center justify-center md:justify-end gap-6 mt-8">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-lock text-green-500 text-xs"></i>
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Enskripsi SSL 256-bit</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-shield-check text-blue-500 text-xs"></i>
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Garansi Layanan 24/7</span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- ==== BAGIAN KANAN: RINGKASAN PESANAN ==== --}}
        <div class="lg:w-1/3">
            <div class="bg-white border border-slate-100 rounded-[2rem] shadow-xl p-6 md:p-8 top-24">
                <h3 class="font-black text-slate-800 text-lg mb-6">Ringkasan Pesanan</h3>

                {{-- Kendaraan Info --}}
                <div class="flex gap-4 items-center mb-6 border-b border-slate-100 pb-6">
                    <div class="w-24 h-16 rounded-lg overflow-hidden bg-slate-50">
                        <img src="{{ $vehicle->image ? asset('storage/' . $vehicle->image) : 'https://placehold.co/600x400?text=No+Image' }}" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900">{{ $vehicle->name }}</h4>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest"><i class="fas fa-map-marker-alt text-red-500"></i> {{ $vehicle->domicile ?? 'Jakarta' }}</p>
                    </div>
                </div>

                {{-- Waktu Sewa --}}
                <div class="space-y-4 mb-6 border-b border-slate-100 pb-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Mulai</p>
                            <p class="font-semibold text-slate-800 text-sm">{{ \Carbon\Carbon::parse($bookingData['start_date'])->format('d M Y') }}</p>
                        </div>
                        <div class="w-10 border-b-2 border-dashed border-slate-200"></div>
                        <div class="text-right">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Selesai</p>
                            <p class="font-semibold text-slate-800 text-sm">{{ \Carbon\Carbon::parse($bookingData['end_date'])->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>

                {{-- Rincian Biaya --}}
                <div class="space-y-3 mb-6">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">Rincian Biaya</p>
                    <div class="flex justify-between text-sm text-slate-600">
                        <span>Biaya Sewa × {{ $bookingData['days'] }} Hari</span>
                        <span class="font-bold text-slate-800">Rp {{ number_format($bookingData['subtotal'], 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-between items-center">
                    <span class="font-bold text-slate-800">Total Bayar</span>
                    <span class="text-2xl font-black text-blue-600">Rp {{ number_format($bookingData['subtotal'], 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // No extra scripts needed
</script>
<style>
    .animate-fade-in {
        animation: fadeIn 0.3s ease-in-out forwards;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    #checkout-pool-map {
        height: 300px !important;
        width: 100% !important;
        display: block !important;
        z-index: 1;
        border-radius: 1rem;
    }
    #checkout-pool-map .leaflet-container {
        border-radius: 1rem;
    }
</style>
@endpush

@if($checkoutPool && $checkoutPool->latitude && $checkoutPool->longitude)
@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    let checkoutMapInstance = null;

    function initCheckoutMap() {
        const poolSection = document.getElementById('pool_map_section');
        if (!poolSection || poolSection.classList.contains('hidden')) return;

        if (checkoutMapInstance) {
            checkoutMapInstance.invalidateSize();
            return;
        }

        const container = document.getElementById('checkout-pool-map');
        if (!container) return;

        // Fix Leaflet default marker icons
        delete L.Icon.Default.prototype._getIconUrl;
        L.Icon.Default.mergeOptions({
            iconRetinaUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon-2x.png',
            iconUrl:       'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
            shadowUrl:     'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
        });

        const lat = {{ number_format($checkoutPool->latitude, 8, '.', '') }};
        const lng = {{ number_format($checkoutPool->longitude, 8, '.', '') }};

        checkoutMapInstance = L.map('checkout-pool-map', {
            scrollWheelZoom: false,
            zoomControl: true,
        }).setView([lat, lng], 16);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            maxZoom: 19
        }).addTo(checkoutMapInstance);

        const marker = L.marker([lat, lng]).addTo(checkoutMapInstance);
        marker.bindPopup(`
            <div style="font-family:'Inter',sans-serif; min-width:150px; padding:2px 0;">
                <p style="font-weight:800;color:#121212;margin-bottom:4px;font-size:13px;">{{ $checkoutPool->name }}</p>
                <p style="font-size:11px;color:#5e5e5e;line-height:1.4;margin:0;">{{ $checkoutPool->address }}</p>
            </div>
        `).openPopup();

        setTimeout(() => { checkoutMapInstance.invalidateSize(); }, 400);
    }

    // Override toggleOptionDetails tidak diperlukan lagi
    // Render saat halaman sepenuhnya dimuat (termasuk Leaflet JS)
    window.addEventListener('load', function() {
        setTimeout(initCheckoutMap, 200);
    });
</script>
@endpush
@endif
