@extends('layouts.admin')

@section('page-title', 'Dashboard Ringkasan')
@section('page-subtitle', 'Statistik penyewaan armada Anda')

@section('content')
<div class="px-4 py-6">
    {{-- Grid Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
        {{-- Total Armada --}}
        <div class="bg-white p-5 rounded-[2rem] shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center">
                <i class="fas fa-car text-lg"></i>
            </div>
            <div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1.5">Armada</p>
                <p class="text-xl font-black text-slate-900">{{ $stats['total_mobil'] }}</p>
            </div>
        </div>

        {{-- Total Pesanan --}}
        <div class="bg-white p-5 rounded-[2rem] shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="w-12 h-12 bg-slate-50 text-slate-900 rounded-2xl flex items-center justify-center">
                <i class="fas fa-list text-lg"></i>
            </div>
            <div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1.5">Transaksi</p>
                <p class="text-xl font-black text-slate-900">{{ $stats['total_booking'] }}</p>
            </div>
        </div>

        {{-- Pending --}}
        <div class="bg-white p-5 rounded-[2rem] shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center">
                <i class="fas fa-clock text-lg"></i>
            </div>
            <div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1.5">Pending</p>
                <p class="text-xl font-black text-slate-900">{{ $stats['pending'] }}</p>
            </div>
        </div>

        {{-- Sedang Disewa --}}
        <div class="bg-white p-5 rounded-[2rem] shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="w-12 h-12 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center">
                <i class="fas fa-car-side text-lg"></i>
            </div>
            <div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1.5">Disewa</p>
                <p class="text-xl font-black text-slate-900">{{ $stats['active'] }}</p>
            </div>
        </div>

        {{-- Total Pendapatan --}}
        <div class="bg-blue-600 p-5 rounded-[2rem] shadow-xl border border-blue-500 flex items-center gap-4">
            <div class="w-12 h-12 bg-white/20 text-white rounded-2xl flex items-center justify-center shadow-inner">
                <i class="fas fa-wallet text-lg"></i>
            </div>
            <div class="min-w-0">
                <p class="text-[9px] font-black text-blue-100 uppercase tracking-widest leading-none mb-1.5">Pendapatan</p>
                <p class="text-lg font-black text-white truncate">Rp{{ number_format($stats['revenue'], 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    {{-- Grafik Statistik --}}
    <div class="bg-white p-8 rounded-[3rem] shadow-sm border border-slate-100 mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <div>
                <h3 class="text-xl font-black text-slate-900 italic">Tren Penyewaan</h3>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Laporan Pesanan 6 Bulan Terakhir</p>
            </div>
            <div class="flex items-center gap-2 bg-slate-50 px-4 py-2 rounded-xl border border-slate-100">
                <div class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></div>
                <span class="text-[10px] font-black text-slate-600 uppercase tracking-widest">Live Report</span>
            </div>
        </div>
        <div class="h-[350px]">
            <canvas id="rentalChart"></canvas>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('rentalChart').getContext('2d');
    
    // Gradien Warna
    const blueGradient = ctx.createLinearGradient(0, 0, 0, 400);
    blueGradient.addColorStop(0, 'rgba(37, 99, 235, 0.2)');
    blueGradient.addColorStop(1, 'rgba(37, 99, 235, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Jumlah Pesanan',
                data: @json($chartData),
                borderColor: '#2563eb',
                borderWidth: 4,
                backgroundColor: blueGradient,
                fill: true,
                tension: 0.4, // Membuat garis melengkung halus
                pointBackgroundColor: '#fff',
                pointBorderColor: '#2563eb',
                pointBorderWidth: 3,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: { size: 10, weight: 'bold' },
                        color: '#94a3b8'
                    },
                    grid: { color: '#f1f5f9' }
                },
                x: {
                    ticks: {
                        font: { size: 10, weight: 'bold' },
                        color: '#94a3b8'
                    },
                    grid: { display: false }
                }
            }
        }
    });
</script>
@endpush
@endsection
