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

            <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">

                {{-- ==== BAGIAN KIRI: FORM VERIFIKASI ==== --}}
                <div class="lg:w-2/3 space-y-8">

                    {{-- Section 1: Identitas --}}
                    <div id="security_docs_section"
                        class="bg-white border border-[#EBEBDF] rounded-[2rem] p-6 sm:p-8 lg:p-10 shadow-[0_2px_20px_rgb(0,0,0,0.02)]">
                        <h2 class="text-2xl font-bold text-[#0A174E] mb-2">Berkas Keamanan</h2>
                        <p class="text-[#8F8F7E] text-sm mb-8 font-medium">Syarat wajib pendaftaran lepas kunci. Data Anda
                            dienkripsi dan aman.</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- KTP --}}
                            <div>
                                <label class="block text-sm font-semibold text-[#0A174E] mb-3">Foto KTP Asli <span
                                        class="text-red-500">*</span></label>
                                <div class="relative group cursor-pointer min-h-[180px] w-full">
                                    <div id="bg_ktp_photo"
                                        class="absolute inset-0 bg-[#F9F9F5] border-2 border-dashed border-[#D4D4C3] rounded-2xl group-hover:border-[#F5D042] group-hover:bg-[#F5D042]/5 transition-all duration-300">
                                    </div>
                                    <img id="preview_img_ktp_photo" class="absolute inset-0 w-full h-full object-cover rounded-2xl hidden pointer-events-none" style="z-index: 5;">
                                    <div id="placeholder_ktp_photo"
                                        class="relative p-8 flex flex-col items-center justify-center text-center pointer-events-none h-full min-h-[180px]" style="z-index: 6;">
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
                                <div class="relative group cursor-pointer min-h-[180px] w-full">
                                    <div id="bg_sim_photo"
                                        class="absolute inset-0 bg-[#F9F9F5] border-2 border-dashed border-[#D4D4C3] rounded-2xl group-hover:border-[#F5D042] group-hover:bg-[#F5D042]/5 transition-all duration-300">
                                    </div>
                                    <img id="preview_img_sim_photo" class="absolute inset-0 w-full h-full object-cover rounded-2xl hidden pointer-events-none" style="z-index: 5;">
                                    <div id="placeholder_sim_photo"
                                        class="relative p-8 flex flex-col items-center justify-center text-center pointer-events-none h-full min-h-[180px]" style="z-index: 6;">
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

                    {{-- Section 3: Layanan Sopir --}}
                    <div class="bg-white border border-[#EBEBDF] rounded-[2rem] p-6 sm:p-8 lg:p-10 shadow-[0_2px_20px_rgb(0,0,0,0.02)]">
                        <h2 class="text-2xl font-bold text-[#0A174E] mb-2">Layanan Sopir</h2>
                        <p class="text-[#8F8F7E] text-sm mb-6 font-medium">Opsional: Sewa kendaraan sekaligus layanan sopir berpengalaman.</p>

                        <div class="space-y-4">
                            <label class="flex items-center gap-4 p-4 border border-[#EBEBDF] rounded-2xl cursor-pointer hover:border-[#F5D042] transition-all bg-[#F9F9F5]">
                                <input type="radio" name="with_driver" value="0" class="w-5 h-5 text-[#0A174E] focus:ring-[#0A174E] border-gray-300" checked onchange="toggleDriver(false)">
                                <div class="flex-1">
                                    <span class="block font-bold text-[#0A174E]">Lepas Kunci (Tanpa Sopir)</span>
                                    <span class="block text-xs text-[#8F8F7E] mt-0.5">Berkendara secara mandiri. Penjemputan di lokasi pool.</span>
                                </div>
                            </label>

                            <label class="flex items-center gap-4 p-4 border border-[#EBEBDF] rounded-2xl cursor-pointer hover:border-[#F5D042] transition-all">
                                <input type="radio" name="with_driver" value="1" class="w-5 h-5 text-[#0A174E] focus:ring-[#0A174E] border-gray-300" onchange="toggleDriver(true)">
                                <div class="flex-1">
                                    <span class="block font-bold text-[#0A174E]">Gunakan Sopir</span>
                                    <span class="block text-xs text-[#8F8F7E] mt-0.5">+ Rp 150.000 / hari. Biaya bensin & tol ditanggung penyewa.</span>
                                </div>
                            </label>
                        </div>

                        <div id="driver_form" class="hidden mt-6 pt-6 border-t border-[#EBEBDF]">
                            @if(isset($availableDrivers) && $availableDrivers->count() > 0)
                                <div class="mb-5">
                                    <label class="block text-sm font-semibold text-[#0A174E] mb-3">Pilih Sopir (Opsional)</label>
                                    <select name="driver_id" id="driver_id" disabled class="w-full bg-[#F9F9F5] border border-[#D4D4C3] rounded-xl px-4 py-3 text-sm font-bold text-[#0A174E] focus:border-[#0A174E] focus:ring-1 focus:ring-[#0A174E] outline-none transition-all">
                                        <option value="">Kami yang akan pilihkan untuk Anda</option>
                                        @foreach($availableDrivers as $driver)
                                            <option value="{{ $driver->id }}">{{ $driver->name }} - {{ $driver->phone }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <div class="mb-5 p-4 bg-yellow-50 text-yellow-700 rounded-xl text-sm font-medium border border-yellow-200">
                                    <i class="fas fa-exclamation-triangle mr-2"></i> Saat ini tidak ada sopir yang tersedia. Silakan pilih opsi lepas kunci.
                                </div>
                            @endif

                            <div class="space-y-5">
                                <div class="hidden" id="pickup_map_container">
                                    <label class="block text-sm font-semibold text-[#0A174E] mb-2">Tentukan Titik Penjemputan di Peta</label>
                                    <div id="driver-pickup-map" class="w-full h-[250px] rounded-2xl border border-[#D4D4C3] bg-[#F9F9F5] relative z-10"></div>
                                    <p class="text-[10px] text-[#8F8F7E] mt-2 font-medium"><i class="fas fa-info-circle"></i> Geser pin merah atau ketuk peta untuk menentukan titik jemput Anda. Alamat di bawah akan terisi otomatis.</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-[#0A174E] mb-2">Alamat Penjemputan</label>
                                    <input type="text" name="pickup_location" id="pickup_location" disabled placeholder="Cth: Bandara Soekarno Hatta / Alamat rumah" class="w-full bg-white border border-[#D4D4C3] rounded-xl px-4 py-3 text-sm font-medium text-[#0A174E] focus:border-[#0A174E] focus:ring-1 focus:ring-[#0A174E] outline-none transition-all">
                                </div>
                            </div>
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
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between items-center text-sm font-semibold text-[#8F8F7E]">
                                <span>Biaya Sewa Kendaraan</span>
                                <span>Rp {{ number_format($bookingData['subtotal'], 0, ',', '.') }}</span>
                            </div>
                            <div id="driver_fee_row" class="hidden flex justify-between items-center text-sm font-semibold text-[#8F8F7E]">
                                <span>Layanan Sopir ({{ $bookingData['days'] }} Hari)</span>
                                <span>Rp {{ number_format(150000 * $bookingData['days'], 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-end mb-8">
                            <div>
                                <p class="text-sm font-semibold text-[#8F8F7E] mb-1">Total Pembayaran</p>
                                <p class="text-[10px] font-medium text-[#8F8F7E]">Termasuk PPN & Asuransi Dasar</p>
                            </div>
                            <div class="text-right">
                                <span id="grand_total" class="block text-2xl font-extrabold text-[#0A174E] tracking-tight" data-subtotal="{{ $bookingData['subtotal'] }}" data-driver-fee="{{ 150000 * $bookingData['days'] }}">Rp {{ number_format($bookingData['subtotal'], 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="mt-8 mb-8 border-t border-[#EBEBDF] pt-6 text-left">
                            <h4 class="font-bold text-[#111827] text-sm mb-1">Wajib Dibaca Sebelum Lanjut</h4>
                            <p class="text-xs text-gray-500 mb-4 leading-relaxed">Sebelum kamu booking, yuk baca info penting berikut agar proses sewa lancar!</p>
                            
                            <div class="space-y-0">
                                <!-- Item 1 -->
                                <details class="group cursor-pointer border-b border-[#EBEBDF]">
                                    <summary class="flex justify-between items-center font-semibold text-[13px] text-blue-600 py-4 select-none outline-none pr-2 list-none [&::-webkit-details-marker]:hidden">
                                        <span class="pr-4 leading-snug">Peraturan Sebelum Melakukan Pemesanan Sewa Kendaraan</span>
                                        <i class="fas fa-chevron-down text-gray-600 transition-transform duration-300 group-open:rotate-180"></i>
                                    </summary>
                                    <div class="pb-4 text-xs text-gray-600 leading-relaxed">
                                        1. Penyewa wajib memiliki identitas diri yang sah (KTP/SIM).<br>
                                        2. Melakukan pembayaran penuh sesuai dengan durasi sewa.<br>
                                        3. Dilarang menggunakan kendaraan untuk tindak kejahatan.
                                    </div>
                                </details>

                                <!-- Item 2 -->
                                <details class="group cursor-pointer border-b border-[#EBEBDF]">
                                    <summary class="flex justify-between items-center font-semibold text-[13px] text-blue-600 py-4 select-none outline-none pr-2 list-none [&::-webkit-details-marker]:hidden">
                                        <span class="pr-4 leading-snug">Biaya Overtime</span>
                                        <i class="fas fa-chevron-down text-gray-600 transition-transform duration-300 group-open:rotate-180"></i>
                                    </summary>
                                    <div class="pb-4 text-xs text-gray-600 leading-relaxed">
                                        Keterlambatan pengembalian kendaraan akan dikenakan denda sesuai dengan ketentuan biaya overtime per jam yang berlaku di tiap armada.
                                    </div>
                                </details>

                                <!-- Item 3 -->
                                <details class="group cursor-pointer border-b border-[#EBEBDF]">
                                    <summary class="flex justify-between items-center font-semibold text-[13px] text-blue-600 py-4 select-none outline-none pr-2 list-none [&::-webkit-details-marker]:hidden">
                                        <span class="pr-4 leading-snug">Biaya Kerugian</span>
                                        <i class="fas fa-chevron-down text-gray-600 transition-transform duration-300 group-open:rotate-180"></i>
                                    </summary>
                                    <div class="pb-4 text-xs text-gray-600 leading-relaxed">
                                        Segala bentuk kerusakan kendaraan (lecet, penyok, kecelakaan) selama masa sewa menjadi tanggung jawab penyewa sepenuhnya.
                                    </div>
                                </details>

                                <!-- Item 4 -->
                                <details class="group cursor-pointer border-b border-[#EBEBDF]">
                                    <summary class="flex justify-between items-center font-semibold text-[13px] text-blue-600 py-4 select-none outline-none pr-2 list-none [&::-webkit-details-marker]:hidden">
                                        <span class="pr-4 leading-snug">Pasal 378 KUHP</span>
                                        <i class="fas fa-chevron-down text-gray-600 transition-transform duration-300 group-open:rotate-180"></i>
                                    </summary>
                                    <div class="pb-4 text-xs text-gray-600 leading-relaxed">
                                        Tindak pidana penipuan. Segala bentuk pemalsuan data diri dan penipuan akan dilaporkan ke pihak berwajib dan diproses hukum sesuai Pasal 378 KUHP.
                                    </div>
                                </details>
                                
                                <!-- Item 5 -->
                                <details class="group cursor-pointer border-b border-[#EBEBDF]">
                                    <summary class="flex justify-between items-center font-semibold text-[13px] text-blue-600 py-4 select-none outline-none pr-2 list-none [&::-webkit-details-marker]:hidden">
                                        <span class="pr-4 leading-snug">Pasal 378 KUHP (Wanprestasi)</span>
                                        <i class="fas fa-chevron-down text-gray-600 transition-transform duration-300 group-open:rotate-180"></i>
                                    </summary>
                                    <div class="pb-4 text-xs text-gray-600 leading-relaxed">
                                        Pelanggaran terhadap perjanjian sewa, termasuk kegagalan pembayaran atau penggelapan kendaraan akan ditindaklanjuti secara hukum perdata maupun pidana.
                                    </div>
                                </details>
                            </div>
                        </div>

                        <button type="submit" id="submit_booking_btn"
                            class="w-full bg-[#0A174E] text-white py-4 rounded-xl font-bold text-lg hover:bg-[#F5D042] hover:text-[#0A174E] hover:shadow-[0_8px_20px_rgba(245,208,66,0.3)] transition-all duration-300 active:scale-[0.98] flex items-center justify-center gap-2 group">
                            Konfirmasi Pesanan
                            <i class="fas fa-chevron-right text-sm group-hover:translate-x-1 transition-transform"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        // Driver toggle logic
        function toggleDriver(isWithDriver) {
            const driverForm = document.getElementById('driver_form');
            const driverId = document.getElementById('driver_id');
            const pickupLocation = document.getElementById('pickup_location');
            const poolSection = document.getElementById('pool_map_section');
            const driverFeeRow = document.getElementById('driver_fee_row');
            const grandTotal = document.getElementById('grand_total');

            const securitySection = document.getElementById('security_docs_section');
            const ktpInput = document.getElementById('ktp_photo');
            const simInput = document.getElementById('sim_photo');
            const submitBtn = document.getElementById('submit_booking_btn');
            const driversAvailable = {{ (isset($availableDrivers) && $availableDrivers->count() > 0) ? 'true' : 'false' }};

            const subtotal = parseInt(grandTotal.dataset.subtotal);
            const driverFee = parseInt(grandTotal.dataset.driverFee);

            if (isWithDriver) {
                driverForm.classList.remove('hidden');
                
                if (!driversAvailable) {
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed', 'pointer-events-none');
                } else {
                    if(driverId) driverId.disabled = false;
                }
                
                if(pickupLocation) pickupLocation.disabled = false;
                
                // Hide pool & security section fully
                if(poolSection) poolSection.classList.add('hidden');
                if(securitySection) securitySection.classList.add('hidden');

                // Remove required when using driver
                if(ktpInput) ktpInput.required = false;
                if(simInput) simInput.required = false;

                // Show pickup map container
                const mapContainer = document.getElementById('pickup_map_container');
                if(mapContainer) {
                    mapContainer.classList.remove('hidden');
                    setTimeout(() => {
                        if(typeof initPickupMap === 'function') initPickupMap();
                    }, 300);
                }

                // Update pricing
                driverFeeRow.classList.remove('hidden');
                grandTotal.textContent = 'Rp ' + (subtotal + driverFee).toLocaleString('id-ID');
            } else {
                driverForm.classList.add('hidden');
                if(driverId) { driverId.disabled = true; driverId.value = ""; }
                if(pickupLocation) { pickupLocation.disabled = true; pickupLocation.value = ""; }
                
                // Re-enable submit button for self-pickup
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed', 'pointer-events-none');
                
                // Restore sections
                if(poolSection) poolSection.classList.remove('hidden');
                if(securitySection) securitySection.classList.remove('hidden');

                // Restore required for self-pickup
                if(ktpInput) ktpInput.required = true;
                if(simInput) simInput.required = true;

                // Hide pickup map container
                const mapContainer = document.getElementById('pickup_map_container');
                if(mapContainer) mapContainer.classList.add('hidden');

                // Update pricing
                driverFeeRow.classList.add('hidden');
                grandTotal.textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
            }
        }

        // JS for showing selected file name cleanly
        function previewText(id, input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const label = document.getElementById('label_' + id);
                label.textContent = "File: " + file.name;
                label.classList.remove('hidden');

                if (file.type && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.getElementById('preview_img_' + id);
                        const placeholder = document.getElementById('placeholder_' + id);
                        const bg = document.getElementById('bg_' + id);
                        
                        if(img) {
                            img.src = e.target.result;
                            img.classList.remove('hidden');
                        }
                        if(placeholder) {
                            placeholder.classList.add('hidden');
                        }
                        if(bg) {
                            bg.classList.add('border-solid', 'border-[#0A174E]');
                            bg.classList.remove('border-dashed', 'border-[#D4D4C3]');
                        }
                    }
                    reader.readAsDataURL(file);
                }
            }
        }
    </script>
    <style>
        /* Prevent z-index overlap on maps */
        #checkout-pool-map, #driver-pickup-map {
            display: block !important;
            z-index: 10;
            border-radius: 1rem;
        }

        #checkout-pool-map .leaflet-container, #driver-pickup-map .leaflet-container {
            border-radius: 1rem;
        }
    </style>
@endpush

@push('scripts')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Leaflet Global Setup
        delete L.Icon.Default.prototype._getIconUrl;
        L.Icon.Default.mergeOptions({
            iconRetinaUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon-2x.png',
            iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
            shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
        });

        // 1. Checkout Pool Map Logic (Lepas Kunci)
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

            @if ($checkoutPool && $checkoutPool->latitude && $checkoutPool->longitude)
                const lat = {{ number_format($checkoutPool->latitude, 8, '.', '') }};
                const lng = {{ number_format($checkoutPool->longitude, 8, '.', '') }};

                checkoutMapInstance = L.map('checkout-pool-map', {
                    scrollWheelZoom: false,
                    zoomControl: true,
                }).setView([lat, lng], 16);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap',
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
            @endif
        }

        // 2. Pickup Location Map Logic (Dengan Sopir)
        let pickupMapInstance = null;
        let pickupMarker = null;

        function initPickupMap() {
            const container = document.getElementById('driver-pickup-map');
            if (!container) return;

            if (pickupMapInstance) {
                pickupMapInstance.invalidateSize();
                return;
            }

            const defaultLat = {{ $checkoutPool->latitude ?? -6.200000 }};
            const defaultLng = {{ $checkoutPool->longitude ?? 106.816666 }};

            pickupMapInstance = L.map('driver-pickup-map').setView([defaultLat, defaultLng], 14);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19
            }).addTo(pickupMapInstance);

            pickupMarker = L.marker([defaultLat, defaultLng], {draggable: true}).addTo(pickupMapInstance);

            pickupMarker.on('dragend', function() {
                const position = pickupMarker.getLatLng();
                reverseGeocode(position.lat, position.lng);
            });

            pickupMapInstance.on('click', function(event) {
                pickupMarker.setLatLng(event.latlng);
                reverseGeocode(event.latlng.lat, event.latlng.lng);
            });
            
            // Only initialize the input once when the map is first shown
            reverseGeocode(defaultLat, defaultLng);
        }

        function reverseGeocode(lat, lng) {
            const input = document.getElementById('pickup_location');
            if(!input) return;
            
            input.value = "Mengambil alamat...";
            
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                .then(response => response.json())
                .then(data => {
                    input.value = data.display_name || (lat + ', ' + lng);
                })
                .catch(() => {
                    input.value = lat + ', ' + lng;
                });
        }

        window.addEventListener('load', function() {
            setTimeout(initCheckoutMap, 200);
        });
    </script>
@endpush
