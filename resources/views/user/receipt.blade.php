@extends('layouts.app')

@section('title', 'Bukti Pesanan #' . $booking->id)

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">
    <div class="bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-slate-100">
        {{-- Header Bukti --}}
        <div class="bg-slate-900 p-8 text-white flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h1 class="text-3xl font-black mb-1 italic tracking-tight">Jatara<span class="text-blue-500">Rent</span></h1>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">Bukti Pembayaran & Pesanan Resmi</p>
            </div>
            <div class="text-right">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">ID Transaksi</p>
                <p class="text-xl font-black italic">#TRX-{{ $booking->id }}</p>
            </div>
        </div>

        <div class="p-8 md:p-12">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-12">
                {{-- User Info --}}
                <div>
                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 border-b border-slate-100 pb-2">Informasi Penyewa</h4>
                    <p class="text-xl font-black text-slate-900 mb-1">{{ $booking->customer->name }}</p>
                    <p class="text-slate-500 font-medium text-sm mb-1">{{ $booking->customer->email }}</p>
                    <p class="text-slate-500 font-medium text-sm">{{ $booking->customer->phone ?? '-' }}</p>
                </div>

                {{-- Booking Stats --}}
                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                    <div class="flex flex-col gap-4">
                        <div class="flex justify-between items-center">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Status Pesanan</span>
                            <span class="px-3 py-1 bg-blue-100 text-blue-600 rounded-lg text-[10px] font-black uppercase tracking-widest border border-blue-200">{{ $booking->status }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pembayaran</span>
                            <span class="px-3 py-1 bg-green-100 text-green-600 rounded-lg text-[10px] font-black uppercase tracking-widest border border-green-200">LUNAS</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Vehicle Info --}}
            <div class="mb-12">
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6 border-b border-slate-100 pb-2">Detail Armada</h4>
                <div class="flex flex-col md:flex-row gap-6 items-center bg-white border border-slate-100 p-6 rounded-2xl">
                    <img src="{{ $booking->vehicle->image ? (strpos($booking->vehicle->image, 'http') === 0 ? $booking->vehicle->image : asset('storage/' . $booking->vehicle->image)) : 'https://placehold.co/600x400?text=No+Image' }}" 
                         class="w-32 h-24 object-cover rounded-xl" alt="{{ $booking->vehicle->name }}">
                    <div class="flex-1 text-center md:text-left">
                        <h3 class="text-xl font-black text-slate-900 mb-1">{{ $booking->vehicle->name }}</h3>
                        <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">{{ $booking->vehicle->type }} • {{ $booking->vehicle->transmission }}</p>
                    </div>
                    <div class="text-right hidden md:block">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Durasi Sewa</p>
                        <p class="text-lg font-black text-slate-900">{{ $booking->days }} Hari</p>
                    </div>
                </div>
            </div>

            {{-- Schedule --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
                <div class="p-6 bg-blue-50/50 rounded-2xl border border-blue-100">
                    <p class="text-[10px] font-black text-blue-400 uppercase tracking-widest mb-2">
                        {{ $booking->driver_fee > 0 ? 'Jadwal Penjemputan' : 'Jadwal Pengambilan' }}
                    </p>
                    <p class="text-lg font-black text-slate-900 italic">{{ \Carbon\Carbon::parse($booking->start_date)->format('d F Y, H:i') }} WIB</p>
                    <p class="text-slate-500 text-xs mt-1 font-bold">
                        @ {{ $booking->driver_fee > 0 ? 'Lokasi Penjemputan' : ($booking->vehicle->mitra->pool->name ?? 'Pool Utama') }}
                    </p>
                    <p class="text-slate-400 text-[10px] font-medium leading-relaxed mt-1">
                        {{ $booking->driver_fee > 0 ? $booking->pickup_location : ($booking->vehicle->mitra->pool->address ?? $booking->vehicle->mitra->address ?? '-') }}
                    </p>
                </div>
                <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Jadwal Pengembalian</p>
                    <p class="text-lg font-black text-slate-900 italic">{{ \Carbon\Carbon::parse($booking->end_date)->format('d F Y, H:i') }} WIB</p>
                    <p class="text-slate-500 text-xs mt-1 font-bold">@ {{ $booking->vehicle->mitra->pool->name ?? $booking->vehicleUnit->pool->name ?? 'Pool Utama' }}</p>
                    <p class="text-slate-400 text-[10px] font-medium leading-relaxed mt-1">
                        {{ $booking->vehicle->mitra->pool->address ?? $booking->vehicleUnit->pool->address ?? $booking->vehicle->mitra->address ?? '-' }}
                    </p>
                </div>
            </div>

            {{-- Financial Summary --}}
            <div class="border-t-2 border-dashed border-slate-100 pt-8">
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Ringkasan Biaya</h4>
                <div class="space-y-4">
                    <div class="flex justify-between items-center text-sm font-bold text-slate-600">
                        <span>Sewa Kendaraan ({{ $booking->days }} Hari)</span>
                        <span>Rp {{ number_format($booking->vehicle->price_per_day * $booking->days, 0, ',', '.') }}</span>
                    </div>

                    @if($booking->driver_fee > 0)
                    <div class="flex justify-between items-center text-sm font-bold text-slate-600">
                        <span>Layanan Sopir ({{ $booking->days }} Hari)</span>
                        <span>Rp {{ number_format($booking->driver_fee, 0, ',', '.') }}</span>
                    </div>
                    @endif

                    <div class="flex justify-between items-center pt-4 border-t border-slate-100">
                        <span class="text-lg font-black text-slate-900 uppercase italic">Total Dibayar</span>
                        <span class="text-2xl font-black text-blue-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- QR Code Placeholder & Signature --}}
            <div class="mt-16 flex flex-col md:flex-row justify-between items-end gap-12">
                <div class="text-center md:text-left">
                    {{-- QR Code placeholder removed --}}
                </div>
                <div class="text-right">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-12">Authorized by Jatara Administration</p>
                    <div class="font-black text-slate-900 text-xl italic border-b-2 border-slate-900 pb-1 mb-1">Rental Administrator</div>
                    <p class="text-[10px] font-bold text-slate-400">Dicetak pada: {{ now()->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>

        {{-- Footer Buttons --}}
        <div class="p-8 bg-slate-50 border-t border-slate-100 flex flex-wrap gap-4 justify-center">
            <button onclick="window.print()" class="bg-white hover:bg-slate-50 text-slate-900 border border-slate-200 font-black px-8 py-3 rounded-2xl transition-all flex items-center gap-2 text-sm">
                <i class="fas fa-print"></i> Cetak Bukti
            </button>
            <a href="{{ route('booking.history') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-black px-8 py-3 rounded-2xl transition-all shadow-lg shadow-blue-100 text-sm">
                Kembali ke Riwayat
            </a>
        </div>
    </div>
</div>

<style>
    @media print {
        header, footer, .bg-slate-50.border-t {
            display: none !important;
        }
        body {
            background: white !important;
        }
        .max-w-4xl {
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        .bg-white {
            border: none !important;
            box-shadow: none !important;
        }
    }
</style>
@endsection
