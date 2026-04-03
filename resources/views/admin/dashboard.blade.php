@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan performa & aktivitas hari ini')

@section('content')

{{-- ===== STAT CARDS ===== --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-10">
    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-7 flex items-start gap-5 hover:shadow-xl transition-all duration-500 group">
        <div class="w-14 h-14 bg-blue-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-100 group-hover:scale-110 transition-transform">
            <i class="fas fa-wallet text-xl"></i>
        </div>
        <div class="min-w-0">
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-[0.2em] mb-1">Total Omzet</p>
            <p class="text-2xl font-black text-slate-900 leading-none">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
            <p class="text-[10px] text-green-600 font-bold mt-2 uppercase tracking-wider">Transaksi Selesai</p>
        </div>
    </div>

    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-7 flex items-start gap-5 hover:shadow-xl transition-all duration-500 group">
        <div class="w-14 h-14 bg-orange-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-orange-100 group-hover:scale-110 transition-transform">
            <i class="fas fa-clock text-xl"></i>
        </div>
        <div class="min-w-0">
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-[0.2em] mb-1">Butuh Konfirmasi</p>
            <p class="text-2xl font-black text-slate-900 leading-none">{{ $stats['pending_bookings'] }} <span class="text-xs text-slate-400 font-bold">Booking</span></p>
            <p class="text-[10px] text-orange-400 font-bold mt-2 uppercase tracking-wider">Menunggu Persetujuan</p>
        </div>
    </div>

    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-7 flex items-start gap-5 hover:shadow-xl transition-all duration-500 group">
        <div class="w-14 h-14 bg-purple-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-purple-100 group-hover:scale-110 transition-transform">
            <i class="fas fa-car text-xl"></i>
        </div>
        <div class="min-w-0">
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-[0.2em] mb-1">Sedang Jalan</p>
            <p class="text-2xl font-black text-slate-900 leading-none">{{ $stats['rented_vehicles'] }} <span class="text-xs text-slate-400 font-bold">Unit</span></p>
            <p class="text-[10px] text-purple-400 font-bold mt-2 uppercase tracking-wider">Status: Disewa</p>
        </div>
    </div>

    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-7 flex items-start gap-5 hover:shadow-xl transition-all duration-500 group">
        <div class="w-14 h-14 bg-slate-900 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-slate-100 group-hover:scale-110 transition-transform">
            <i class="fas fa-boxes-stacked text-xl"></i>
        </div>
        <div class="min-w-0">
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-[0.2em] mb-1">Total Armada</p>
            <p class="text-2xl font-black text-slate-900 leading-none">{{ $stats['total_vehicles'] }} <span class="text-xs text-slate-400 font-bold">Unit</span></p>
            <p class="text-[10px] text-slate-400 font-bold mt-2 uppercase tracking-wider">Semua Kategori</p>
        </div>
    </div>
</div>

{{-- ===== CONTENT GRID ===== --}}
<div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

    {{-- Recent Bookings --}}
    <div class="xl:col-span-2 bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="flex justify-between items-center px-8 py-7 border-b border-slate-50">
            <div>
                <h2 class="text-xl font-black text-slate-900 leading-none">Aktivitas Terkini</h2>
                <p class="text-xs text-slate-400 mt-2 font-medium">5 pesanan terbaru yang masuk ke sistem</p>
            </div>
            <a href="{{ route('admin.pemesanan') }}" class="flex items-center gap-2 text-[10px] font-black text-blue-600 uppercase tracking-widest hover:translate-x-1 transition-transform">Lihat Semua <i class="fas fa-arrow-right"></i></a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50/50">
                    <tr>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Pelanggan</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Unit</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Durasi</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Total</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($recentBookings as $b)
                    <tr class="hover:bg-slate-50/30 transition-colors">
                        <td class="px-8 py-5 flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-[10px] font-black uppercase">
                                {{ substr($b->user->name, 0, 1) }}
                            </div>
                            <p class="text-sm font-bold text-slate-800">{{ $b->user->name }}</p>
                        </td>
                        <td class="px-8 py-5 text-sm font-bold text-slate-600">{{ $b->vehicle->name }}</td>
                        <td class="px-8 py-5 text-xs text-slate-400 font-bold italic">{{ $b->days }} Hari</td>
                        <td class="px-8 py-5 text-sm font-black text-blue-600">Rp {{ number_format($b->total_price, 0, ',', '.') }}</td>
                        <td class="px-8 py-5">
                            @php
                                $colors = [
                                    'Pending' => 'bg-orange-100 text-orange-600',
                                    'Confirmed' => 'bg-blue-100 text-blue-600',
                                    'Completed' => 'bg-green-100 text-green-700',
                                    'Cancelled' => 'bg-red-100 text-red-600',
                                ];
                            @endphp
                            <span class="text-[10px] font-black px-3 py-1.5 rounded-lg {{ $colors[$b->status] ?? 'bg-slate-100 text-slate-600' }} uppercase tracking-widest">
                                {{ $b->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <i class="fas fa-mug-hot text-3xl text-slate-200 mb-3"></i>
                            <p class="text-sm font-bold text-slate-400">Belum ada aktivitas pesanan hari ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Ketersediaan Armada --}}
    <div class="space-y-8">
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8">
            <h2 class="text-xl font-black text-slate-900 mb-6">Status Armada</h2>
            <div class="space-y-6">
                @php
                    $availablePct = $stats['total_vehicles'] > 0 ? round(($stats['total_vehicles'] - $stats['rented_vehicles']) / $stats['total_vehicles'] * 100) : 0;
                    $rentedPct = $stats['total_vehicles'] > 0 ? round($stats['rented_vehicles'] / $stats['total_vehicles'] * 100) : 0;
                @endphp
                <div>
                    <div class="flex justify-between items-center mb-3">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tersedia untuk Sewa</p>
                        <p class="font-black text-slate-900">{{ $stats['total_vehicles'] - $stats['rented_vehicles'] }} <span class="text-[10px] text-slate-400">Unit</span></p>
                    </div>
                    <div class="h-3 bg-slate-100 rounded-full overflow-hidden">
                        <div class="bg-green-500 h-full rounded-full transition-all duration-1000" style="width: {{ $availablePct }}%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-3">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Sedang Beroperasi</p>
                        <p class="font-black text-slate-900">{{ $stats['rented_vehicles'] }} <span class="text-[10px] text-slate-400">Unit</span></p>
                    </div>
                    <div class="h-3 bg-slate-100 rounded-full overflow-hidden">
                        <div class="bg-blue-600 h-full rounded-full transition-all duration-1000" style="width: {{ $rentedPct }}%"></div>
                    </div>
                </div>
            </div>

            <div class="mt-10 pt-8 border-t border-slate-50 flex flex-wrap gap-4">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Ready</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-blue-600"></div>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Disewa</span>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection