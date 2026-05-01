@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan performa & aktivitas hari ini')

@section('content')

{{-- ===== STAT CARDS ===== --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-6 mb-10">
    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-7 flex items-start gap-5 hover:shadow-xl transition-all duration-500 group">
        <div class="w-14 h-14 bg-teal-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-teal-100 group-hover:scale-110 transition-transform">
            <i class="fas fa-handshake text-xl"></i>
        </div>
        <div class="min-w-0">
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-[0.2em] mb-1">Total Mitra</p>
            <p class="text-2xl font-black text-slate-900 leading-none">{{ $stats['total_mitra'] }} <span class="text-xs text-slate-400 font-bold">Mitra</span></p>
            <p class="text-[10px] text-teal-600 font-bold mt-2 uppercase tracking-wider">Terdaftar</p>
        </div>
    </div>

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

    {{-- Chart Statistik Mitra --}}
    <div class="xl:col-span-2 bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden p-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-xl font-black text-slate-900 leading-none">Statistik Transaksi Mitra</h2>
                <p class="text-xs text-slate-400 mt-2 font-medium">Performa transaksi 5 mitra teratas</p>
            </div>
            <a href="{{ route('admin.mitra.index') }}" class="flex items-center gap-2 text-[10px] font-black text-blue-600 uppercase tracking-widest hover:translate-x-1 transition-transform">Kelola Mitra <i class="fas fa-arrow-right"></i></a>
        </div>
        
        <div class="relative w-full h-[350px]">
            <canvas id="mitraChart"></canvas>
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

        {{-- Top Mitra --}}
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8">
            <h2 class="text-xl font-black text-slate-900 mb-6">Top Mitra</h2>
            <div class="space-y-4">
                @forelse($topMitras as $mitra)
                <div class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 border border-slate-100 hover:bg-slate-100 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center font-black uppercase text-xs">
                            {{ substr($mitra->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-900">{{ $mitra->name }}</p>
                            <p class="text-[10px] text-slate-400 font-bold uppercase">{{ $mitra->vehicles_count }} Armada</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-black text-blue-600">{{ $mitra->bookings_count }}</p>
                        <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">Transaksi Selesai</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-6 text-slate-400">
                    <p class="text-sm font-bold">Belum ada mitra.</p>
                </div>
                @endforelse
            </div>
            <a href="{{ route('admin.mitra.index') }}" class="mt-6 block text-center text-[10px] font-black text-blue-600 uppercase tracking-widest hover:underline">Kelola Mitra</a>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('mitraChart').getContext('2d');
        
        // Data from server
        const mitraData = @json($topMitras);
        
        const labels = mitraData.map(m => m.name);
        const data = mitraData.map(m => m.bookings_count);
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Transaksi',
                    data: data,
                    backgroundColor: 'rgba(37, 99, 235, 0.8)', // blue-600
                    borderColor: 'rgb(37, 99, 235)',
                    borderWidth: 1,
                    borderRadius: 8,
                    barPercentage: 0.6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            font: {
                                family: "'Inter', sans-serif",
                                size: 11
                            }
                        },
                        grid: {
                            color: '#f1f5f9', // slate-100
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                family: "'Inter', sans-serif",
                                size: 12,
                                weight: 'bold'
                            },
                            color: '#64748b' // slate-500
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleFont: {
                            family: "'Inter', sans-serif",
                            size: 13
                        },
                        bodyFont: {
                            family: "'Inter', sans-serif",
                            size: 14,
                            weight: 'bold'
                        },
                        padding: 12,
                        cornerRadius: 12,
                        displayColors: false
                    }
                }
            }
        });
    });
</script>
@endpush