@extends('layouts.app')

@section('title', 'Selesaikan Pesanan Anda')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-8 text-center md:text-left">
        <h1 class="text-3xl font-black text-slate-900 mb-2">Selesaikan <span class="text-blue-600">Pesanan</span></h1>
        <p class="text-slate-500">Lengkapi data verifikasi dan opsi pengambilan untuk melanjutkan</p>
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

                    {{-- Section 2: Layanan Tambahan --}}
                    <div class="relative">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-12 h-12 bg-teal-500 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-teal-500/20">
                                <i class="fas fa-user-plus text-lg"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-black text-slate-900 leading-tight">Layanan Ekstra</h2>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Personalisasi Kenyamanan Anda</p>
                            </div>
                        </div>

                        <div class="bg-slate-50/50 rounded-[2rem] p-8 border border-slate-100/80 mb-10">
                            <label class="flex items-center gap-5 cursor-pointer p-6 bg-white rounded-3xl border-2 border-slate-100 hover:border-blue-400 hover:shadow-xl hover:shadow-blue-500/5 transition-all group active:scale-[0.99] has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50/20">
                                <div class="relative flex items-center h-5">
                                    <input type="checkbox" name="with_driver" id="with_driver" value="1" class="w-7 h-7 rounded-lg text-blue-600 border-slate-300 focus:ring-blue-500 transition-all cursor-pointer accent-blue-600" onchange="toggleOptionDetails()">
                                </div>
                                <div class="ml-1 flex-1">
                                    <div class="flex items-center justify-between">
                                        <span class="block font-black text-slate-900 text-lg leading-none">Pesan Jasa Sopir</span>
                                        <span class="bg-blue-100 text-blue-700 text-[9px] font-black px-2.5 py-1 rounded-full uppercase tracking-tighter">Paling Direkomendasi</span>
                                    </div>
                                    <span class="text-slate-500 font-bold text-sm mt-1 block">Nikmati perjalanan tanpa lelah. <span class="text-blue-600">+Rp {{ number_format($bookingData['driver_price'], 0, ',', '.') }}/Hari</span></span>
                                </div>
                            </label>

                            <div id="driver_selection_wrapper" class="mt-8 hidden animate-fade-in space-y-5">
                                <div class="flex items-center justify-between px-2">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Pilih Pengemudi Berpengalaman</p>
                                    <span class="text-[10px] font-black text-green-600 bg-green-50 px-2.5 py-1 rounded-lg">TERSEDIA</span>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    @forelse($drivers as $driver)
                                    <label class="driver-card relative flex items-center gap-5 p-5 bg-white border border-slate-200 rounded-[1.5rem] cursor-pointer hover:border-blue-400 hover:shadow-lg transition-all group has-[:checked]:border-blue-600 has-[:checked]:bg-blue-600 has-[:checked]:text-white">
                                        <input type="radio" name="driver_id" value="{{ $driver->id }}" class="absolute opacity-0" id="driver-{{ $driver->id }}" disabled>
                                        <div class="w-16 h-16 rounded-2xl overflow-hidden bg-slate-100 flex-shrink-0 border-2 border-white shadow-md">
                                            <img src="{{ $driver->photo ? asset('storage/' . $driver->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($driver->name) . '&background=random' }}" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="font-black text-slate-900 text-sm group-has-[:checked]:text-white transition-colors truncate">{{ $driver->name }}</p>
                                            <div class="flex items-center gap-2 mt-1.5">
                                                <div class="flex text-yellow-400 text-[9px]">
                                                    @for($i=1; $i<=5; $i++)
                                                        <i class="fas fa-star {{ $i <= $driver->rating ? '' : 'text-slate-200 group-has-[:checked]:text-blue-400' }}"></i>
                                                    @endfor
                                                </div>
                                                <span class="text-[9px] font-black text-slate-400 uppercase group-has-[:checked]:text-blue-100">{{ number_format($driver->rating, 1) }}</span>
                                            </div>
                                        </div>
                                        <div class="w-7 h-7 border-2 border-slate-200 rounded-full flex items-center justify-center transition-all bg-white group-hover:border-blue-300 group-has-[:checked]:border-white group-has-[:checked]:bg-white">
                                            <i class="fas fa-check text-[10px] text-blue-600 scale-0 group-has-[:checked]:scale-100 transition-transform"></i>
                                        </div>
                                    </label>
                                    @empty
                                    <div class="col-span-2 p-6 bg-orange-50 border border-orange-100 rounded-3xl text-center">
                                        <p class="text-sm font-bold text-orange-600">Mohon maaf, saat ini sedang tidak ada driver yang tersedia untuk dipilih.</p>
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section 3: Destination Section (Merged) --}}
                    <div id="destination_section" class="relative">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-12 h-12 bg-blue-900 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-blue-900/20">
                                <i class="fas fa-map-marked-alt text-lg"></i>
                            </div>
                            <div>
                                <h2 id="destination_main_title" class="text-2xl font-black text-slate-900 leading-tight">Titik Penjemputan</h2>
                                <p id="destination_main_subtitle" class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Tentukan Lokasi Serah Terima Armada</p>
                            </div>
                        </div>

                        {{-- Radio Choices - Hidden when with driver --}}
                        <div id="delivery_options_section" class="bg-slate-50/50 rounded-[2rem] p-8 border border-slate-100/80 mb-10 transition-all duration-300">
                            <div class="flex flex-col sm:flex-row gap-5">
                                <label class="flex-1 border-2 border-slate-100 bg-white rounded-3xl p-6 cursor-pointer hover:border-blue-400 hover:shadow-lg transition-all flex items-start gap-4 has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50/20 active:scale-[0.98]">
                                    <input type="radio" name="delivery_type" id="delivery_type_self" value="self-pickup" checked class="mt-1.5 w-5 h-5 accent-blue-600" onchange="toggleOptionDetails()">
                                    <div class="flex-1">
                                        <span class="block font-black text-slate-900 text-lg">Ambil Mandiri</span>
                                        <span class="text-xs font-bold text-slate-500 leading-relaxed block mt-1">Pool Armada di {{ $vehicle->domicile ?? 'Jakarta' }}.</span>
                                    </div>
                                </label>

                                <label class="flex-1 border-2 border-slate-100 bg-white rounded-3xl p-6 cursor-pointer hover:border-blue-400 hover:shadow-lg transition-all flex items-start gap-4 has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50/20 active:scale-[0.98]">
                                    <input type="radio" name="delivery_type" id="delivery_type_delivery" value="delivery" class="mt-1.5 w-5 h-5 accent-blue-600" onchange="toggleOptionDetails()">
                                    <div class="flex-1">
                                        <span class="block font-black text-slate-900 text-lg">Antar Jemput</span>
                                        <span class="text-xs font-bold text-slate-500 leading-relaxed block mt-1">Mobil diantar ke alamat Anda (+Biaya Operasional).</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- Section 3.1: Pool Map (Shown when self-pickup and no driver) --}}
                        <div id="pool_map_section" class="hidden mt-0 mb-10 animate-fade-in">
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
                                <div class="aspect-video w-full rounded-2xl overflow-hidden grayscale hover:grayscale-0 transition-all duration-700 shadow-inner border border-slate-100 relative">
                                    <iframe 
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126935.5347225134!2d106.759478!3d-6.175392!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e945e3fa73%3A0x761c32ffc907f10!2sJakarta!5e0!3m2!1sen!2sid!4v1712123456789!5m2!1sen!2sid" 
                                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
                                <div class="mt-4 flex items-start gap-3 bg-red-50 p-4 rounded-xl border border-red-100">
                                    <i class="fas fa-info-circle text-red-500 mt-0.5"></i>
                                    <p class="text-[10px] font-bold text-red-700 leading-relaxed uppercase tracking-tighter">
                                        Harap tunjukkan kode booking ini saat pengambilan di pool {{ $vehicle->domicile ?? 'Jakarta' }}. Jam operasional Pool: 08.00 - 20.00 WIB.
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Address Card --}}
                        <div id="address_card_container" class="bg-slate-900 rounded-[2.5rem] p-8 md:p-10 border border-slate-800 shadow-2xl relative overflow-hidden mb-10 group transition-all duration-500">
                             {{-- Background Pattern --}}
                             <div class="absolute inset-0 opacity-10 pointer-events-none">
                                 <div class="absolute top-0 left-0 w-full h-full" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 10px 10px;"></div>
                             </div>

                             <div class="relative">
                                 <div class="flex items-center gap-4 mb-6">
                                     <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center text-white backdrop-blur-md">
                                         <i class="fas fa-search-location"></i>
                                     </div>
                                     <h3 id="location_title" class="font-black text-white text-lg uppercase tracking-tight">Lokasi Pengantaran</h3>
                                 </div>
                                 
                                 <div id="delivery_location_wrapper" class="hidden animate-fade-in">
                                     <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Detail Lokasi Lengkap</p>
                                     <textarea name="delivery_location" id="delivery_location" rows="3" class="w-full bg-white/10 border border-white/10 rounded-2xl p-6 text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-4 focus:ring-blue-500/20 focus:bg-white/20 transition-all resize-none shadow-inner" placeholder="Contoh: Jl. Sudirman No. 123..."></textarea>
                                 </div>

                                 <div id="no_location_selected" class="py-10 text-center border-2 border-dashed border-white/10 rounded-3xl group-hover:border-white/20 transition-colors">
                                     <i class="fas fa-location-arrow text-3xl text-white/20 mb-4 block"></i>
                                     <p class="text-xs font-black text-white/50 uppercase tracking-widest">Silakan pilih opsi Antar Jemput untuk mengisi alamat</p>
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
                    <div class="flex justify-between text-sm text-slate-600" id="service-fee-row" style="display: none;">
                        <span>Biaya Antar Jemput</span>
                        <span class="font-bold text-slate-800">Rp {{ number_format($bookingData['delivery_fee_amount'], 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm text-slate-600" id="driver-fee-row" style="display: none;">
                        <span>Biaya Sopir ({{ $bookingData['days'] }} Hari)</span>
                        <span class="font-bold text-slate-800" id="driver-fee-display">Rp 0</span>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-between items-center">
                    <span class="font-bold text-slate-800">Total Bayar</span>
                    <span class="text-2xl font-black text-blue-600" id="total-price-display" 
                        data-subtotal="{{ $bookingData['subtotal'] }}" 
                        data-delivery-fee="{{ $bookingData['delivery_fee_amount'] }}"
                        data-driver-price="{{ $bookingData['driver_price'] }}"
                        data-days="{{ $bookingData['days'] }}">Rp {{ number_format($bookingData['subtotal'], 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleOptionDetails() {
        const wrapper = document.getElementById('delivery_location_wrapper');
        const input = document.getElementById('delivery_location');
        const deliveryTypeSection = document.getElementById('delivery_options_section');
        const withDriver = document.getElementById('with_driver').checked;
        const deliveryRadios = document.getElementsByName('delivery_type');
        let selectedDelivery = 'self-pickup';
        deliveryRadios.forEach(r => { if(r.checked) selectedDelivery = r.value; });

        const simSection = document.getElementById('sim_upload_wrapper');
        const simInput = document.getElementById('sim_photo');

        const poolMapSection = document.getElementById('pool_map_section');

        const driverWrapper = document.getElementById('driver_selection_wrapper');
        const driverRadios = document.querySelectorAll('input[name="driver_id"]');
        
        const totalDisplay = document.getElementById('total-price-display');
        const subtotal = parseInt(totalDisplay.dataset.subtotal);
        const deliveryFee = parseInt(totalDisplay.dataset.deliveryFee);
        const driverPrice = parseInt(totalDisplay.dataset.driverPrice);
        const days = parseInt(totalDisplay.dataset.days);
        
        const addressCard = document.getElementById('address_card_container');
        
        let total = subtotal;

        // Logic SIM & Opsi Pengambilan
        const identitySection = document.getElementById('identity_section');
        const ktpInput = document.getElementById('ktp_photo');

        if (withDriver) {
            // Sembunyikan SIM & Radio Opsi & KTP
            identitySection.classList.add('hidden');
            ktpInput.required = false;
            simSection.classList.add('hidden');
            simInput.required = false;
            deliveryTypeSection.classList.add('hidden');

            // Update Header
            document.getElementById('destination_main_title').innerText = "Titik Pertemuan";
            document.getElementById('destination_main_subtitle').innerText = "Lokasi Penjemputan Driver & Armada";

            // Paksa lokasi tampil (driver butuh tujuan)
            wrapper.classList.remove('hidden');
            input.required = true;
            document.getElementById('location_title').innerText = "Alamat Lengkap Penjemputan";
            
            // Driver Fee
            const totalDriverFee = driverPrice * days;
            document.getElementById('driver-fee-row').style.display = 'flex';
            document.getElementById('driver-fee-display').innerText = 'Rp ' + totalDriverFee.toLocaleString('id-ID');
            total += totalDriverFee;
            
            driverWrapper.classList.remove('hidden');
            driverRadios.forEach(radio => {
                radio.disabled = false;
                radio.required = true;
            });

            // Biaya antar jemput 0 jika pakai driver (asumsi sudah include)
            document.getElementById('service-fee-row').style.display = 'none';

            // Show Address Card for driver destination
            addressCard.classList.remove('hidden');
            poolMapSection.classList.add('hidden');

        } else {
            identitySection.classList.remove('hidden');
            ktpInput.required = true;
            simSection.classList.remove('hidden');
            simInput.required = true;
            deliveryTypeSection.classList.remove('hidden');
            document.getElementById('location_title').innerText = "Alamat Pengantaran";

            // Normal Delivery Logic
            if (selectedDelivery === 'delivery') {
                wrapper.classList.remove('hidden');
                addressCard.classList.remove('hidden');
                input.required = true;
                document.getElementById('service-fee-row').style.display = 'flex';
                total += deliveryFee;
                poolMapSection.classList.add('hidden');
            } else {
                wrapper.classList.add('hidden');
                addressCard.classList.add('hidden');
                input.required = false;
                document.getElementById('service-fee-row').style.display = 'none';
                poolMapSection.classList.remove('hidden'); // Show fleet pool map
            }

            document.getElementById('driver-fee-row').style.display = 'none';
            driverWrapper.classList.add('hidden');
            driverRadios.forEach(radio => {
                radio.disabled = true;
                radio.required = false;
                radio.checked = false;
            });
        }

        totalDisplay.innerText = 'Rp ' + total.toLocaleString('id-ID');

        // Handle placeholder
        const noLocationPlaceholder = document.getElementById('no_location_selected');
        if (wrapper.classList.contains('hidden')) {
            noLocationPlaceholder.classList.remove('hidden');
        } else {
            noLocationPlaceholder.classList.add('hidden');
        }
    }
    
    // Inisialisasi awal saat render
    toggleOptionDetails();
</script>
<style>
    .animate-fade-in {
        animation: fadeIn 0.3s ease-in-out forwards;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush
