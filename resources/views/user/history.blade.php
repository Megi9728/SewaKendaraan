@extends('layouts.app')

@section('title', 'Riwayat Sewa')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    {{-- Header --}}
    <div class="mb-10">
        <h1 class="text-4xl font-black text-slate-900 mb-2">Riwayat <span class="text-blue-600">Sewa</span></h1>
        <p class="text-slate-500 font-medium">Pantau status pesanan dan perjalanan Anda di sini.</p>
    </div>

    @if(session('success'))
    <div class="mb-8 bg-green-50 border border-green-100 text-green-700 px-6 py-4 rounded-2xl flex items-center gap-3 shadow-sm">
        <i class="fas fa-check-circle text-xl"></i>
        <p class="font-bold text-sm">{{ session('success') }}</p>
    </div>
    @endif

    @if($bookings->isEmpty())
    <div class="bg-white rounded-[2.5rem] p-12 text-center border border-slate-100 shadow-sm">
        <div class="w-24 h-24 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-calendar-xmark text-4xl"></i>
        </div>
        <h3 class="text-2xl font-black text-slate-900 mb-2">Belum ada pesanan</h3>
        <p class="text-slate-400 mb-8 max-w-sm mx-auto">Sepertinya Anda belum pernah melakukan pemesanan kendaraan. Yuk, cari armada impian Anda sekarang!</p>
        <a href="{{ route('browse') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-black px-8 py-4 rounded-2xl transition-all shadow-lg shadow-blue-100">
            Jelajahi Armada <i class="fas fa-arrow-right"></i>
        </a>
    </div>
    @else
    <div class="grid grid-cols-1 gap-6">
        @foreach($bookings as $booking)
        <div class="bg-white rounded-[2rem] border border-slate-100 p-6 md:p-8 flex flex-col md:flex-row gap-8 items-center hover:shadow-xl transition-all duration-500 group">
            {{-- Image --}}
            <div class="w-full md:w-64 h-44 rounded-2xl overflow-hidden flex-shrink-0">
                <img src="{{ $booking->vehicle->image ? (strpos($booking->vehicle->image, 'http') === 0 ? $booking->vehicle->image : asset('storage/' . $booking->vehicle->image)) : 'https://placehold.co/600x400?text=No+Image' }}" 
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="{{ $booking->vehicle->name }}">
            </div>

            {{-- Info --}}
            <div class="flex-1 min-w-0 w-full text-center md:text-left">
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 mb-3">
                    <span class="text-[10px] font-black px-3 py-1.5 rounded-lg bg-slate-900 text-white uppercase tracking-widest shadow-sm">#TRX-{{ $booking->id }}</span>
                    @php
                        $statusColors = [
                            'Pending' => 'bg-orange-100 text-orange-600 border-orange-200',
                            'Confirmed' => 'bg-blue-100 text-blue-600 border-blue-200',
                            'Completed' => 'bg-green-100 text-green-600 border-green-200',
                            'Cancelled' => 'bg-red-100 text-red-600 border-red-200',
                            'Rejected' => 'bg-slate-100 text-slate-600 border-slate-200',
                        ];
                    @endphp
                    <span class="text-[10px] font-black px-3 py-1.5 rounded-lg border {{ $statusColors[$booking->status] }} uppercase tracking-widest">
                         {{ $booking->status }}
                    </span>
                </div>
                <h3 class="text-2xl font-black text-slate-900 mb-1 truncate">{{ $booking->vehicle->name }}</h3>
                <p class="text-slate-400 font-bold text-xs uppercase tracking-widest mb-6">{{ $booking->vehicle->type }} • {{ $booking->vehicle->transmission }}</p>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Mulai</p>
                        <p class="font-bold text-slate-900 text-sm italic">{{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Selesai</p>
                        <p class="font-bold text-slate-900 text-sm italic">{{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Durasi</p>
                        <p class="font-bold text-slate-900 text-sm">{{ $booking->days }} Hari</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total Biaya</p>
                        <p class="font-black text-blue-600 text-sm">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            {{-- Action --}}
            <div class="w-full md:w-auto flex flex-col gap-2">
                <a href="{{ route('vehicle.detail', $booking->vehicle_id) }}" class="w-full text-center border border-slate-200 hover:border-blue-600 hover:text-blue-600 text-slate-600 font-bold py-4 px-6 rounded-2xl transition-all text-sm">
                    Detail Mobil
                </a>
                @if($booking->status === 'Pending')
                <p class="text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2">Menunggu Admin...</p>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
