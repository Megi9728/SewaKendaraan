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
        <div class="lg:w-2/3">
            <div class="bg-white rounded-3xl p-6 md:p-8 border border-slate-100 shadow-sm">
                <form action="{{ route('booking.store') }}" method="POST" enctype="multipart/form-data" id="checkout-form">
                    @csrf
                    <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
                    <input type="hidden" name="start_date" value="{{ $bookingData['start_date'] }}">
                    <input type="hidden" name="end_date" value="{{ $bookingData['end_date'] }}">

                    <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <i class="fas fa-id-card text-blue-600"></i> Dokumen Verifikasi
                    </h2>
                    
                    <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100 mb-8">
                        <p class="text-sm text-slate-500 mb-6">Sesuai kebijakan kami, mohon unggah foto KTP dan SIM asli Anda yang masih berlaku untuk keperluan verifikasi keamanan.</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest block mb-2">Foto KTP <span class="text-red-500">*</span></label>
                                <input type="file" name="ktp_photo" accept="image/*" required class="w-full text-slate-900 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest block mb-2">Foto SIM (A/C) <span class="text-red-500">*</span></label>
                                <input type="file" name="sim_photo" accept="image/*" required class="w-full text-slate-900 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>
                        </div>
                    </div>

                    <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2 mt-10">
                        <i class="fas fa-map-marked-alt text-blue-600"></i> Opsi Pengambilan
                    </h2>
                    
                    <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                        <div class="flex flex-col sm:flex-row gap-4 mb-6">
                            <label class="flex-1 border border-slate-200 bg-white rounded-xl p-4 cursor-pointer hover:border-blue-400 transition-all flex items-start gap-3">
                                <input type="radio" name="delivery_type" value="self-pickup" checked class="mt-1 accent-blue-600" onchange="toggleDeliveryLocation()">
                                <div>
                                    <span class="block font-bold text-slate-900">Ambil Sendiri</span>
                                    <span class="text-xs text-slate-500">Ambil mobil di titik lokasi pool armada ({{ $vehicle->domicile ?? 'Jakarta' }}).</span>
                                </div>
                            </label>

                            <label class="flex-1 border border-slate-200 bg-white rounded-xl p-4 cursor-pointer hover:border-blue-400 transition-all flex items-start gap-3">
                                <input type="radio" name="delivery_type" value="delivery" class="mt-1 accent-blue-600" onchange="toggleDeliveryLocation()">
                                <div>
                                    <span class="block font-bold text-slate-900">Layanan Antar Jemput</span>
                                    <span class="text-xs text-slate-500">Mobil diantar ke rumah, kantor atau stasiun Anda.</span>
                                </div>
                            </label>
                        </div>
                        
                        <div id="delivery_location_wrapper" class="hidden animate-fade-in">
                            <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest block mb-2">Alamat Pengantaran / Penjemputan Lengkap</label>
                            <textarea name="delivery_location" id="delivery_location" rows="3" class="w-full bg-white border border-slate-200 rounded-xl p-4 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-colors shadow-sm" placeholder="Contoh: Jl. Sudirman No. 123, RT 01/RW 02, Patokan di depan gerbang warna biru..."></textarea>
                        </div>
                    </div>

                    <div class="mt-10 pt-8 border-t border-slate-100 text-right">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-black py-4 px-10 rounded-2xl transition-all shadow-xl shadow-blue-200 active:scale-95 group">
                            KONFIRMASI & PESAN SEKARANG
                            <i class="fas fa-check-circle ml-2 group-hover:scale-110 transition-transform"></i>
                        </button>
                        <p class="text-[10px] uppercase font-bold text-slate-400 mt-4 tracking-widest text-center md:text-right">Aman • Cepat • Transparan</p>
                    </div>
                </form>
            </div>
        </div>

        {{-- ==== BAGIAN KANAN: RINGKASAN PESANAN ==== --}}
        <div class="lg:w-1/3">
            <div class="bg-white border border-slate-100 rounded-[2rem] shadow-xl p-6 md:p-8 sticky top-24">
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
                    <div class="flex justify-between text-sm text-slate-600">
                        <span>Biaya Layanan & Pajak</span>
                        <span class="font-bold text-slate-800">Rp {{ number_format($bookingData['service_fee'], 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-between items-center">
                    <span class="font-bold text-slate-800">Total Bayar</span>
                    <span class="text-2xl font-black text-blue-600">Rp {{ number_format($bookingData['total_price'], 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleDeliveryLocation() {
        const wrapper = document.getElementById('delivery_location_wrapper');
        const input = document.getElementById('delivery_location');
        const val = document.querySelector('input[name="delivery_type"]:checked').value;
        if (val === 'delivery') {
            wrapper.classList.remove('hidden');
            input.required = true;
        } else {
            wrapper.classList.add('hidden');
            input.required = false;
        }
    }
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
