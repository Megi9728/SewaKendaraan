@extends('layouts.app')

@section('title', 'Selesaikan Pesanan Anda')

@php
    $checkoutPool = $vehicle->mitra->pool ?? null;
@endphp

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-28 pb-10 lg:pt-36 lg:pb-16">

        {{-- Header --}}
        <div class="mb-10">
            <a href="javascript:history.back()"
                class="inline-flex items-center text-sm font-semibold text-[#8F8F7E] hover:text-[#0A174E] transition-colors mb-6">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
            <h1 class="text-3xl md:text-4xl font-extrabold text-[#0A174E] tracking-tight mb-3">Selesaikan pesanan.</h1>
            <p class="text-[#8F8F7E] text-base md:text-lg font-medium">Lengkapi verifikasi data untuk segera memulai
                perjalanan Anda.</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 text-red-600 p-5 rounded-2xl mb-8 border border-red-100">
                <div class="flex items-center gap-3 mb-2">
                    <i class="fas fa-exclamation-circle"></i>
                    <span class="font-bold">Terdapat kesalahan:</span>
                </div>
                <ul class="list-disc pl-8 text-sm font-medium">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('booking.store') }}" method="POST" enctype="multipart/form-data" id="checkout-form">
            @csrf
            <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
            <input type="hidden" name="start_date" value="{{ $bookingData['start_date'] }}">
            <input type="hidden" name="end_date" value="{{ $bookingData['end_date'] }}">
            <input type="hidden" name="delivery_type" value="self-pickup">

            <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">

                {{-- ==== BAGIAN KIRI: FORM VERIFIKASI ==== --}}
                <div class="lg:w-2/3 space-y-8">

                    {{-- Section 1: Identitas --}}
                    <div
                        class="bg-white border border-[#EBEBDF] rounded-[2rem] p-6 sm:p-8 lg:p-10 shadow-[0_2px_20px_rgb(0,0,0,0.02)]">
                        <h2 class="text-2xl font-bold text-[#0A174E] mb-2">Berkas Keamanan</h2>
                        <p class="text-[#8F8F7E] text-sm mb-8 font-medium">Syarat wajib pendaftaran lepas kunci. Data Anda
                            dienkripsi dan aman.</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- KTP --}}
                            <div>
                                <label class="block text-sm font-semibold text-[#0A174E] mb-3">Foto KTP Asli <span
                                        class="text-red-500">*</span></label>
                                <div class="relative group cursor-pointer">
                                    <div
                                        class="absolute inset-0 bg-[#F9F9F5] border-2 border-dashed border-[#D4D4C3] rounded-2xl group-hover:border-[#F5D042] group-hover:bg-[#F5D042]/5 transition-all duration-300">
                                    </div>
                                    <div
                                        class="relative p-8 flex flex-col items-center justify-center text-center pointer-events-none">
                                        <div
                                            class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-[#8F8F7E] group-hover:text-[#F5D042] mb-4 transition-colors shadow-sm">
                                            <i class="fas fa-id-card text-xl"></i>
                                        </div>
                                        <span class="text-sm font-bold text-[#0A174E]">Pilih Dokumen KTP</span>
                                        <span class="text-xs text-[#8F8F7E] mt-1">Maks. 2MB (JPG/PNG)</span>
                                    </div>
                                    <input type="file" name="ktp_photo" id="ktp_photo" accept="image/*" required
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                        onchange="previewText('ktp_photo', this)">
                                </div>
                                <p id="label_ktp_photo"
                                    class="text-xs font-semibold text-[#0A174E] mt-2 hidden text-center truncate px-2"></p>
                            </div>

                            {{-- SIM --}}
                            <div>
                                <label class="block text-sm font-semibold text-[#0A174E] mb-3">Foto SIM A/C <span
                                        class="text-red-500">*</span></label>
                                <div class="relative group cursor-pointer">
                                    <div
                                        class="absolute inset-0 bg-[#F9F9F5] border-2 border-dashed border-[#D4D4C3] rounded-2xl group-hover:border-[#F5D042] group-hover:bg-[#F5D042]/5 transition-all duration-300">
                                    </div>
                                    <div
                                        class="relative p-8 flex flex-col items-center justify-center text-center pointer-events-none">
                                        <div
                                            class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-[#8F8F7E] group-hover:text-[#F5D042] mb-4 transition-colors shadow-sm">
                                            <i class="fas fa-car-side text-xl"></i>
                                        </div>
                                        <span class="text-sm font-bold text-[#0A174E]">Pilih Dokumen SIM</span>
                                        <span class="text-xs text-[#8F8F7E] mt-1">Maks. 2MB (JPG/PNG)</span>
                                    </div>
                                    <input type="file" name="sim_photo" id="sim_photo" accept="image/*" required
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                        onchange="previewText('sim_photo', this)">
                                </div>
                                <p id="label_sim_photo"
                                    class="text-xs font-semibold text-[#0A174E] mt-2 hidden text-center truncate px-2"></p>
                            </div>
                        </div>
                    </div>

                    {{-- Section 2: Lokasi Pool --}}
                    <div class="bg-white border border-[#EBEBDF] rounded-[2rem] p-6 sm:p-8 lg:p-10 shadow-[0_2px_20px_rgb(0,0,0,0.02)]"
                        id="pool_map_section">
                        <h2 class="text-2xl font-bold text-[#0A174E] mb-2">Lokasi Penjemputan</h2>
                        <p class="text-[#8F8F7E] text-sm mb-8 font-medium">Titik pengambilan armada mandiri secara langsung.
                        </p>

                        @if ($checkoutPool && $checkoutPool->latitude && $checkoutPool->longitude)
                            <div
                                class="mb-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-[#F9F9F5] p-5 rounded-2xl border border-[#EBEBDF]">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="w-10 h-10 bg-white rounded-xl flex items-center justify-center border border-[#EBEBDF] text-[#0A174E] flex-shrink-0">
                                        <i class="fas fa-map-pin"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-[#0A174E] mb-1">{{ $checkoutPool->name }}</p>
                                        <p class="text-xs text-[#8F8F7E] font-medium leading-relaxed">
                                            {{ $checkoutPool->address }}</p>
                                    </div>
                                </div>
                                <a href="https://www.google.com/maps/search/?api=1&query={{ $checkoutPool->latitude }},{{ $checkoutPool->longitude }}"
                                    target="_blank"
                                    class="flex-shrink-0 text-xs font-bold text-[#0A174E] hover:text-[#F5D042] bg-white border border-[#EBEBDF] px-4 py-2.5 rounded-xl hover:border-[#F5D042] transition-colors text-center w-full sm:w-auto">
                                    Tampilkan Rute
                                </a>
                            </div>
                            <div id="checkout-pool-map"
                                class="w-full rounded-2xl overflow-hidden bg-[#F9F9F5] border border-[#EBEBDF] relative z-0"
                                style="height: 250px;"></div>
                        @else
                            <div
                                class="aspect-video w-full rounded-2xl overflow-hidden bg-[#F9F9F5] border border-[#EBEBDF] flex flex-col items-center justify-center text-[#8F8F7E]">
                                <i class="fas fa-map-marked-alt text-3xl mb-3 opacity-40"></i>
                                <p class="text-sm font-bold text-[#0A174E]">{{ $vehicle->domicile ?? 'Lokasi Pool' }}</p>
                                <p class="text-xs mt-1">Titik penjemputan spesifik akan diinformasikan oleh mitra.</p>
                            </div>
                        @endif

                        <div class="mt-6 flex items-start gap-3 bg-[#0A174E]/5 p-4 rounded-xl border border-[#0A174E]/10">
                            <i class="fas fa-info-circle text-[#0A174E] mt-0.5"></i>
                            <p class="text-xs font-medium text-[#0A174E] leading-relaxed">
                                Pastikan Anda tiba sesuai jadwal. Tunjukkan bukti pemesanan aktif yang tampil di dasbor akun
                                Anda saat pengambilan armada.
                            </p>
                        </div>
                    </div>

                </div>

                {{-- ==== BAGIAN KANAN: RINGKASAN PESANAN ==== --}}
                <div class="lg:w-1/3 relative">
                    <div
                        class="bg-white border border-[#EBEBDF] rounded-[2rem] p-6 lg:p-8 sticky top-28 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
                        <h3 class="text-xl font-bold text-[#0A174E] mb-6">Ringkasan Sewa</h3>

                        {{-- Kendaraan Info --}}
                        <div class="flex gap-4 items-center">
                            <div
                                class="w-20 h-20 rounded-xl overflow-hidden bg-[#F9F9F5] flex-shrink-0 border border-[#EBEBDF]">
                                <img src="{{ $vehicle->image ? asset('storage/' . $vehicle->image) : 'https://placehold.co/600x400?text=No+Image' }}"
                                    class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h4 class="font-bold text-[#0A174E] mb-1 line-clamp-1">{{ $vehicle->name }}</h4>
                                <p
                                    class="text-xs font-semibold text-[#8F8F7E] bg-[#F9F9F5] px-2 py-1 rounded inline-flex items-center gap-1">
                                    <i class="fas fa-map-marker-alt text-[#F5D042]"></i>
                                    {{ $vehicle->domicile ?? 'Jakarta' }}
                                </p>
                            </div>
                        </div>

                        <hr class="border-[#EBEBDF] my-6">

                        {{-- Waktu Sewa --}}
                        <div
                            class="flex justify-between items-center bg-[#F9F9F5] p-4 rounded-2xl border border-[#EBEBDF]">
                            <div class="text-left w-1/2">
                                <p class="text-[10px] font-bold text-[#8F8F7E] uppercase mb-1">Pengambilan</p>
                                <p class="font-bold text-[#0A174E] text-sm">
                                    {{ \Carbon\Carbon::parse($bookingData['start_date'])->format('d M Y') }}</p>
                            </div>
                            <div class="text-center px-2">
                                <p
                                    class="text-xs font-bold text-[#0A174E] bg-white border border-[#EBEBDF] rounded-full w-8 h-8 flex items-center justify-center shadow-sm">
                                    {{ $bookingData['days'] }}
                                </p>
                                <p class="text-[9px] font-bold text-[#8F8F7E] uppercase mt-1">Hari</p>
                            </div>
                            <div class="text-right w-1/2">
                                <p class="text-[10px] font-bold text-[#8F8F7E] uppercase mb-1">Pengembalian</p>
                                <p class="font-bold text-[#0A174E] text-sm">
                                    {{ \Carbon\Carbon::parse($bookingData['end_date'])->format('d M Y') }}</p>
                            </div>
                        </div>

                        <hr class="border-[#EBEBDF] my-6">

                        {{-- Harga Total --}}
                        <div class="flex justify-between items-end mb-8">
                            <div>
                                <p class="text-sm font-semibold text-[#8F8F7E] mb-1">Total Pembayaran</p>
                                <p class="text-[10px] font-medium text-[#8F8F7E]">Termasuk PPN & Asuransi Dasar</p>
                            </div>
                            <div class="text-right">
                                <span class="block text-2xl font-extrabold text-[#0A174E] tracking-tight">Rp
                                    {{ number_format($bookingData['subtotal'], 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full bg-[#0A174E] text-white py-4 rounded-xl font-bold text-lg hover:bg-[#F5D042] hover:text-[#0A174E] hover:shadow-[0_8px_20px_rgba(245,208,66,0.3)] transition-all duration-300 active:scale-[0.98] flex items-center justify-center gap-2 group">
                            Konfirmasi Pesanan
                            <i class="fas fa-chevron-right text-sm group-hover:translate-x-1 transition-transform"></i>
                        </button>

                        <div class="mt-4 flex justify-center text-[10px] font-semibold text-[#8F8F7E] gap-4">
                            <span class="flex items-center gap-1.5"><i class="fas fa-lock text-[#0A174E]/30"></i> Enkripsi
                                Aman</span>
                            <span class="flex items-center gap-1.5"><i class="fas fa-shield-alt text-[#0A174E]/30"></i>
                                Transaksi Terlindungi</span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        // JS for showing selected file name cleanly
        function previewText(id, input) {
            if (input.files && input.files[0]) {
                const label = document.getElementById('label_' + id);
                label.textContent = "File: " + input.files[0].name;
                label.classList.remove('hidden');
            }
        }
    </script>
    <style>
        /* Prevent z-index overlap on maps */
        #checkout-pool-map {
            display: block !important;
            z-index: 10;
            border-radius: 1rem;
        }

        #checkout-pool-map .leaflet-container {
            border-radius: 1rem;
        }
    </style>
@endpush

@if ($checkoutPool && $checkoutPool->latitude && $checkoutPool->longitude)
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
                    iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
                    shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
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

                setTimeout(() => {
                    checkoutMapInstance.invalidateSize();
                }, 400);
            }

            window.addEventListener('load', function() {
                setTimeout(initCheckoutMap, 200);
            });
        </script>
    @endpush
@endif
