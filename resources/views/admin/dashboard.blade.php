@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

{{-- Breadcrumb / Header area --}}
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-title-md2 font-bold text-black dark:text-white text-2xl">
            Dashboard
        </h2>
        <p class="text-sm text-body dark:text-bodydark mt-1">Ringkasan performa & aktivitas hari ini</p>
    </div>
</div>

{{-- ===== STAT CARDS ===== --}}
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:gap-6 xl:grid-cols-4 2xl:gap-7.5 mb-10">
    <!-- Card Item 1 -->
    <div class="rounded-2xl border border-stroke bg-white p-6 shadow-sm dark:border-white/10 dark:bg-[#24303F] hover:shadow-lg transition-all duration-300 group">
        <div class="flex h-14 w-14 items-center justify-center rounded-full bg-blue-50 dark:bg-blue-500/20 text-blue-600 group-hover:scale-110 transition-transform">
            <i class="fas fa-wallet text-xl"></i>
        </div>
        <div class="mt-4 flex items-end justify-between">
            <div>
                <h4 class="text-title-md font-bold text-black dark:text-white mb-1 text-2xl">
                    Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}
                </h4>
                <span class="text-sm font-medium text-body dark:text-bodydark">Total Omzet</span>
            </div>
            <span class="flex items-center gap-1 text-sm font-medium text-emerald-500">
                Sukses
            </span>
        </div>
    </div>

    <!-- Card Item 2 -->
    <div class="rounded-2xl border border-stroke bg-white p-6 shadow-sm dark:border-white/10 dark:bg-[#24303F] hover:shadow-lg transition-all duration-300 group">
        <div class="flex h-14 w-14 items-center justify-center rounded-full bg-orange-50 dark:bg-orange-500/20 text-orange-500 group-hover:scale-110 transition-transform">
            <i class="fas fa-clock text-xl"></i>
        </div>
        <div class="mt-4 flex items-end justify-between">
            <div>
                <h4 class="text-title-md font-bold text-black dark:text-white mb-1 text-2xl">
                    {{ $stats['pending_bookings'] }}
                </h4>
                <span class="text-sm font-medium text-body dark:text-bodydark">Butuh Konfirmasi</span>
            </div>
            <span class="flex items-center gap-1 text-sm font-medium text-orange-500">
                Menunggu
            </span>
        </div>
    </div>

    <!-- Card Item 3 -->
    <div class="rounded-2xl border border-stroke bg-white p-6 shadow-sm dark:border-white/10 dark:bg-[#24303F] hover:shadow-lg transition-all duration-300 group">
        <div class="flex h-14 w-14 items-center justify-center rounded-full bg-indigo-50 dark:bg-emerald-500/20 text-emerald-500 group-hover:scale-110 transition-transform">
            <i class="fas fa-car text-xl"></i>
        </div>
        <div class="mt-4 flex items-end justify-between">
            <div>
                <h4 class="text-title-md font-bold text-black dark:text-white mb-1 text-2xl">
                    {{ $stats['rented_vehicles'] }}
                </h4>
                <span class="text-sm font-medium text-body dark:text-bodydark">Sedang Disewa</span>
            </div>
            <span class="flex items-center gap-1 text-sm font-medium text-emerald-500">
                Aktif
            </span>
        </div>
    </div>

    <!-- Card Item 4 -->
    <div class="rounded-2xl border border-stroke bg-white p-6 shadow-sm dark:border-white/10 dark:bg-[#24303F] hover:shadow-lg transition-all duration-300 group">
        <div class="flex h-14 w-14 items-center justify-center rounded-full bg-purple-50 dark:bg-indigo-500/20 text-indigo-500 group-hover:scale-110 transition-transform">
            <i class="fas fa-users text-xl"></i>
        </div>
        <div class="mt-4 flex items-end justify-between">
            <div>
                <h4 class="text-title-md font-bold text-black dark:text-white mb-1 text-2xl">
                    {{ $stats['total_bookings'] }}
                </h4>
                <span class="text-sm font-medium text-body dark:text-bodydark">Total Booking</span>
            </div>
            <span class="flex items-center gap-1 text-sm font-medium text-indigo-500">
                Semua Transaksi
            </span>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ===== TRANSAKSI TERBARU (TABLE) ===== --}}
    <div class="lg:col-span-2">
        <div class="rounded-2xl border border-stroke bg-white shadow-sm dark:border-white/10 dark:bg-[#24303F]">
            <div class="border-b border-stroke py-4 px-6 dark:border-white/10 flex justify-between items-center">
                <h3 class="font-semibold text-black dark:text-white text-lg">
                    Transaksi Terbaru
                </h3>
                <a href="{{ route('admin.booking.monitor') }}" class="text-sm text-primary hover:underline font-medium">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="p-6">
                @if($recentBookings->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm whitespace-nowrap">
                        <thead class="uppercase tracking-wider text-body dark:text-bodydark font-bold text-[10px] bg-slate-50 dark:bg-white/5 rounded-xl">
                            <tr>
                                <th class="py-3 px-4 rounded-l-lg">ID / Tanggal</th>
                                <th class="py-3 px-4">Pelanggan</th>
                                <th class="py-3 px-4">Kendaraan</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 px-4 rounded-r-lg">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stroke dark:divide-white/10 text-black dark:text-white">
                            @foreach($recentBookings as $booking)
                            <tr class="hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                                <td class="py-3 px-4">
                                    <span class="font-bold">#{{ $booking->id }}</span>
                                    <div class="text-[10px] text-body dark:text-bodydark">{{ $booking->created_at->format('d M Y') }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="font-bold">{{ $booking->user->name }}</div>
                                    <div class="text-[10px] text-body dark:text-bodydark">{{ substr($booking->user->phone ?? '-', 0, 12) }}...</div>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="font-bold">{{ $booking->vehicle->name }}</div>
                                    <div class="text-[10px] text-body dark:text-bodydark">{{ $booking->vehicle->brand }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    @if($booking->status == 'Pending')
                                        <span class="inline-flex rounded-full bg-warning/10 py-1 px-3 text-xs font-semibold text-warning dark:text-orange-400">
                                            Menunggu
                                        </span>
                                    @elseif($booking->status == 'Active')
                                        <span class="inline-flex rounded-full bg-success/10 py-1 px-3 text-xs font-semibold text-success dark:text-emerald-400">
                                            Disewa
                                        </span>
                                    @elseif($booking->status == 'Completed')
                                        <span class="inline-flex rounded-full bg-success/10 py-1 px-3 text-xs font-semibold text-success dark:text-emerald-400">
                                            Selesai
                                        </span>
                                    @else
                                        <span class="inline-flex rounded-full bg-danger/10 py-1 px-3 text-xs font-semibold text-danger dark:text-red-400">
                                            {{ $booking->status }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 font-bold">
                                    Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-10">
                    <div class="w-16 h-16 bg-slate-100 dark:bg-white/5 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-receipt text-body dark:text-bodydark text-2xl"></i>
                    </div>
                    <p class="text-black dark:text-white font-semibold">Belum ada transaksi</p>
                    <p class="text-sm text-body dark:text-bodydark">Transaksi terbaru akan ditampilkan di sini.</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ===== UNIT TERPOPULER (LIST) ===== --}}
    <div class="lg:col-span-1">
        <div class="rounded-2xl border border-stroke bg-white shadow-sm dark:border-white/10 dark:bg-[#24303F]">
            <div class="border-b border-stroke py-4 px-6 dark:border-white/10">
                <h3 class="font-semibold text-black dark:text-white text-lg">
                    Armada Terpopuler
                </h3>
            </div>
            <div class="p-6">
                <div class="flex flex-col gap-5">
                    @forelse($popularVehicles ?? [] as $vehicle)
                    <div class="flex items-center gap-4">
                        <div class="relative h-16 w-16 rounded-xl overflow-hidden shadow-sm">
                            @if($vehicle->images->count() > 0)
                                <img src="{{ asset('storage/' . $vehicle->images->first()->image_path) }}" alt="Vehicle" class="h-full w-full object-cover">
                            @else
                                <div class="h-full w-full bg-slate-200 dark:bg-white/10 flex items-center justify-center">
                                    <i class="fas fa-car text-body dark:text-bodydark"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-1 items-center justify-between">
                            <div>
                                <h5 class="font-bold text-black dark:text-white">{{ $vehicle->name }}</h5>
                                <p class="text-xs text-body dark:text-bodydark"><span class="text-primary font-bold">{{ $vehicle->bookings_count }}x</span> Disewa</p>
                            </div>
                            <div class="text-right">
                                <span class="block text-sm font-bold text-success dark:text-emerald-400">Tersedia</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-6">
                        <p class="text-body dark:text-bodydark text-sm">Belum ada data popularitas armada.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- ===== MITRA BARU ===== --}}
        <div class="mt-6 rounded-2xl border border-stroke bg-white shadow-sm dark:border-white/10 dark:bg-[#24303F]">
            <div class="border-b border-stroke py-4 px-6 dark:border-white/10 flex justify-between items-center">
                <h3 class="font-semibold text-black dark:text-white text-lg">
                    Mitra Terdaftar
                </h3>
            </div>
            <div class="p-6">
                <!-- Example of displaying total mitra or newest ones -->
                 <div class="flex items-center gap-4 mb-4">
                    <div class="h-12 w-12 rounded-full bg-primary/10 text-primary flex items-center justify-center">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-black dark:text-white">Total {{ \App\Models\User::where('role', 'mitra')->count() }} Mitra</h4>
                        <p class="text-xs text-body dark:text-bodydark">Berkontribusi pada platform</p>
                    </div>
                 </div>
                 <a href="{{ route('admin.mitra.index') }}" class="block w-full rounded-lg border border-stroke dark:border-white/10 bg-transparent py-2.5 text-center font-medium text-black dark:text-white hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                    Kelola Mitra
                 </a>
            </div>
        </div>
    </div>

</div>

@endsection