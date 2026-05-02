@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

{{-- Header Area --}}
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-xl font-bold text-gray-800 dark:text-white tracking-tight leading-tight">
            Dashboard Overview
        </h2>
        <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5 font-medium">Ringkasan performa dan aktivitas platform hari ini</p>
    </div>
    <div class="flex items-center gap-3">
        <div class="bg-white dark:bg-white/[0.03] border border-gray-200 dark:border-gray-800 px-4 py-2 rounded-xl flex items-center gap-3 shadow-sm">
            <div class="w-2 h-2 rounded-full bg-success-500 animate-pulse"></div>
            <span class="text-[10px] font-bold uppercase tracking-widest text-gray-500 dark:text-gray-400">Sistem Online</span>
        </div>
    </div>
</div>

{{-- ===== STAT CARDS ===== --}}
<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4 mb-8">
    <!-- Revenue -->
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-white/[0.03] hover:shadow-lg transition-all duration-300 group relative overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 bg-brand-500/5 rounded-full -mr-8 -mt-8 group-hover:scale-110 transition-transform duration-500"></div>
        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-brand-500/10 text-brand-600 dark:text-brand-400 mb-4 group-hover:scale-110 transition-transform">
            <i class="fas fa-wallet text-lg"></i>
        </div>
        <div>
            <span class="text-[9px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Total Omzet</span>
            <h4 class="text-lg font-bold text-gray-800 dark:text-white mt-1">
                <span class="text-xs font-normal opacity-50">Rp</span> {{ number_format($stats['total_revenue'], 0, ',', '.') }}
            </h4>
        </div>
        <div class="mt-3 flex items-center gap-2 text-[9px] font-bold text-success-500 bg-success-500/10 px-2 py-0.5 rounded-md w-fit">
            <i class="fas fa-arrow-up"></i> REAL-TIME
        </div>
    </div>

    <!-- Pending -->
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-white/[0.03] hover:shadow-lg transition-all duration-300 group relative overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 bg-warning-500/5 rounded-full -mr-8 -mt-8 group-hover:scale-110 transition-transform duration-500"></div>
        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-warning-500/10 text-warning-600 dark:text-warning-400 mb-4 group-hover:scale-110 transition-transform">
            <i class="fas fa-clock text-lg"></i>
        </div>
        <div>
            <span class="text-[9px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Konfirmasi</span>
            <h4 class="text-lg font-bold text-gray-800 dark:text-white mt-1">
                {{ $stats['pending_bookings'] }} <span class="text-[10px] font-medium opacity-50 ml-1">Order</span>
            </h4>
        </div>
        <div class="mt-3 flex items-center gap-2 text-[9px] font-bold text-warning-500 bg-warning-500/10 px-2 py-0.5 rounded-md w-fit">
            MENUNGGU KONFIRMASI
        </div>
    </div>

    <!-- Rented -->
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-white/[0.03] hover:shadow-lg transition-all duration-300 group relative overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 bg-success-500/5 rounded-full -mr-8 -mt-8 group-hover:scale-110 transition-transform duration-500"></div>
        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-success-500/10 text-success-600 dark:text-success-400 mb-4 group-hover:scale-110 transition-transform">
            <i class="fas fa-car text-lg"></i>
        </div>
        <div>
            <span class="text-[9px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Sedang Disewa</span>
            <h4 class="text-lg font-bold text-gray-800 dark:text-white mt-1">
                {{ $stats['rented_vehicles'] }} <span class="text-[10px] font-medium opacity-50 ml-1">Unit</span>
            </h4>
        </div>
        <div class="mt-3 flex items-center gap-2 text-[9px] font-bold text-success-500 bg-success-500/10 px-2 py-0.5 rounded-md w-fit">
            ARMADA AKTIF
        </div>
    </div>

    <!-- Total Booking -->
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-white/[0.03] hover:shadow-lg transition-all duration-300 group relative overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 bg-indigo-500/5 rounded-full -mr-8 -mt-8 group-hover:scale-110 transition-transform duration-500"></div>
        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 mb-4 group-hover:scale-110 transition-transform">
            <i class="fas fa-receipt text-lg"></i>
        </div>
        <div>
            <span class="text-[9px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Total Booking</span>
            <h4 class="text-lg font-bold text-gray-800 dark:text-white mt-1">
                {{ $stats['total_bookings'] }} <span class="text-[10px] font-medium opacity-50 ml-1">Order</span>
            </h4>
        </div>
        <div class="mt-3 flex items-center gap-2 text-[9px] font-bold text-indigo-500 bg-indigo-500/10 px-2 py-0.5 rounded-md w-fit">
            KESELURUHAN DATA
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    {{-- ===== TRANSAKSI TERBARU (TABLE) ===== --}}
    <div class="lg:col-span-2">
        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
            <div class="border-b border-gray-100 py-4 px-6 dark:border-gray-800 flex justify-between items-center bg-gray-50/50 dark:bg-white/[0.01]">
                <div class="flex items-center gap-3">
                    <div class="w-1.5 h-6 bg-brand-500 rounded-full"></div>
                    <h3 class="text-sm font-bold text-gray-800 dark:text-white uppercase tracking-wider">
                        Transaksi Terbaru
                    </h3>
                </div>
                <a href="{{ route('admin.booking.monitor') }}" class="text-xs text-brand-600 dark:text-brand-400 hover:underline font-bold uppercase tracking-widest">
                    Lihat Semua <i class="fas fa-arrow-right ml-1 text-[10px]"></i>
                </a>
            </div>
            <div class="p-0">
                @if($recentBookings->count() > 0)
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full text-left whitespace-nowrap">
                        <thead class="bg-gray-50 dark:bg-white/[0.02]">
                            <tr>
                                <th class="py-3 px-6 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">ID / Tanggal</th>
                                <th class="py-3 px-6 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Pelanggan</th>
                                <th class="py-3 px-6 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider text-center">Unit</th>
                                <th class="py-3 px-6 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider text-center">Status</th>
                                <th class="py-3 px-6 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @foreach($recentBookings as $booking)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.01] transition-colors">
                                <td class="py-3 px-6">
                                    <span class="text-xs font-bold text-gray-800 dark:text-white">#TRX-{{ $booking->id }}</span>
                                    <div class="text-[10px] text-gray-400 dark:text-gray-500 mt-0.5 font-medium">{{ $booking->created_at->format('d/m/y, H:i') }}</div>
                                </td>
                                <td class="py-3 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-brand-500/10 text-brand-600 dark:text-brand-400 flex items-center justify-center text-[10px] font-bold uppercase border border-brand-500/20">
                                            {{ substr($booking->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-xs font-bold text-gray-800 dark:text-white/90">{{ $booking->user->name }}</div>
                                            <div class="text-[9px] text-gray-400 dark:text-gray-500 font-medium tracking-tight">{{ substr($booking->user->phone ?? '-', 0, 13) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-sm font-medium text-gray-600 dark:text-gray-400">
                                    {{ $booking->vehicle->name }}
                                </td>
                                <td class="py-3 px-6">
                                    @php
                                        $statusClasses = [
                                            'Pending'   => 'bg-warning-50 text-warning-600 dark:bg-warning-500/10 dark:text-warning-500',
                                            'Active'    => 'bg-success-50 text-success-600 dark:bg-success-500/10 dark:text-success-400',
                                            'Completed' => 'bg-gray-100 text-gray-600 dark:bg-white/10 dark:text-gray-400',
                                        ];
                                    @endphp
                                    <span class="inline-flex rounded-lg px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider {{ $statusClasses[$booking->status] ?? 'bg-error-50 text-error-600 dark:bg-error-500/10 dark:text-error-400' }}">
                                        {{ $booking->status === 'Pending' ? 'Menunggu' : $booking->status }}
                                    </span>
                                </td>
                                <td class="py-3 px-6 font-bold text-gray-800 dark:text-white text-right">
                                    <span class="text-[10px] font-normal opacity-50">Rp</span> {{ number_format($booking->total_price, 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-20 bg-gray-50/20 dark:bg-white/[0.01]">
                    <div class="w-16 h-16 bg-gray-100 dark:bg-white/5 rounded-2xl flex items-center justify-center mx-auto mb-4 border-2 border-dashed border-gray-200 dark:border-gray-800">
                        <i class="fas fa-receipt text-gray-300 dark:text-gray-700 text-2xl"></i>
                    </div>
                    <p class="text-gray-400 dark:text-gray-500 font-bold uppercase tracking-widest text-[10px]">Belum ada transaksi hari ini</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ===== UNIT TERPOPULER (LIST) ===== --}}
    <div class="lg:col-span-1 space-y-8">
        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
            <div class="border-b border-gray-100 py-4 px-6 dark:border-gray-800 flex items-center gap-3 bg-gray-50/50 dark:bg-white/[0.01]">
                <div class="w-1.5 h-6 bg-success-500 rounded-full"></div>
                <h3 class="text-sm font-bold text-gray-800 dark:text-white uppercase tracking-wider">
                    Armada Terpopuler
                </h3>
            </div>
            <div class="p-6">
                <div class="flex flex-col gap-6">
                    @forelse($popularVehicles ?? [] as $vehicle)
                    <div class="flex items-center gap-4 group cursor-default">
                        <div class="relative h-14 w-14 rounded-xl overflow-hidden shadow-sm border border-gray-100 dark:border-gray-800 group-hover:scale-105 transition-transform">
                            @if($vehicle->images->count() > 0)
                                <img src="{{ asset('storage/' . $vehicle->images->first()->image_path) }}" alt="Vehicle" class="h-full w-full object-cover">
                            @else
                                <div class="h-full w-full bg-gray-100 dark:bg-white/5 flex items-center justify-center text-gray-300">
                                    <i class="fas fa-car"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-1 items-center justify-between min-w-0">
                            <div class="min-w-0">
                                <h5 class="font-bold text-gray-800 dark:text-white/90 truncate text-sm">{{ $vehicle->name }}</h5>
                                <p class="text-[10px] text-gray-400 dark:text-gray-500 font-bold uppercase tracking-widest mt-0.5"><span class="text-brand-500">{{ $vehicle->bookings_count }}x</span> Penyewaan</p>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="text-[9px] font-bold px-2 py-0.5 rounded bg-success-50 dark:bg-success-500/10 text-success-600 dark:text-success-400 uppercase tracking-tighter">HOT</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-6">
                        <p class="text-gray-400 dark:text-gray-500 text-xs font-medium">Belum ada data popularitas armada.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- ===== MITRA BARU ===== --}}
        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden group">
            <div class="p-6">
                 <div class="flex items-center gap-4 mb-6">
                    <div class="h-12 w-12 rounded-xl bg-brand-500 text-white flex items-center justify-center shadow-lg shadow-brand-500/20 group-hover:scale-110 transition-transform">
                        <i class="fas fa-handshake text-lg"></i>
                    </div>
                    <div>
                        <h4 class="text-base font-bold text-gray-800 dark:text-white tracking-tight">{{ \App\Models\User::where('role', 'mitra')->count() }} Mitra</h4>
                        <p class="text-[10px] text-gray-400 dark:text-gray-500 font-medium uppercase tracking-widest">Mitra Aktif</p>
                    </div>
                 </div>
                 <a href="{{ route('admin.mitra.index') }}" class="block w-full rounded-xl bg-gray-50 dark:bg-white/5 py-3 text-center text-[10px] font-bold text-gray-800 dark:text-white hover:bg-brand-500 hover:text-white transition-all active:scale-95 border border-gray-100 dark:border-gray-800 uppercase tracking-widest">
                    Kelola Semua Mitra
                 </a>
            </div>
        </div>
    </div>

</div>

@endsection