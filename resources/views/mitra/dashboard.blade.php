@extends('layouts.admin')

@section('page-title', 'Dashboard Ringkasan')
@section('page-subtitle', 'Statistik penyewaan armada Anda')

@section('content')
<div class="px-4 py-6">
    {{-- Grid Statistik --}}
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-title-md2 font-bold text-black dark:text-white text-2xl">Dashboard Ringkasan</h2>
        <p class="text-sm text-body dark:text-bodydark mt-1">Statistik penyewaan armada Anda</p>
    </div>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
    {{-- Total Armada --}}
    <div class="rounded-2xl border border-stroke bg-white py-6 px-7 shadow-sm dark:border-white/10 dark:bg-boxdark flex items-center justify-between gap-4">
        <div>
            <p class="text-sm font-medium text-body dark:text-bodydark mt-1">Armada</p>
            <h4 class="text-title-md font-bold text-black dark:text-white mt-2">{{ $stats['total_mobil'] }}</h4>
        </div>
        <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4">
            <i class="fas fa-car text-lg"></i>
        </div>
    </div>

    {{-- Total Pesanan --}}
    <div class="rounded-2xl border border-stroke bg-white py-6 px-7 shadow-sm dark:border-white/10 dark:bg-boxdark flex items-center justify-between gap-4">
        <div>
            <p class="text-sm font-medium text-body dark:text-bodydark mt-1">Transaksi</p>
            <h4 class="text-title-md font-bold text-black dark:text-white mt-2">{{ $stats['total_booking'] }}</h4>
        </div>
        <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4">
            <i class="fas fa-list text-lg"></i>
        </div>
    </div>

    {{-- Pending --}}
    <div class="rounded-2xl border border-stroke bg-white py-6 px-7 shadow-sm dark:border-white/10 dark:bg-boxdark flex items-center justify-between gap-4">
        <div>
            <p class="text-sm font-medium text-body dark:text-bodydark mt-1">Pending</p>
            <h4 class="text-title-md font-bold text-black dark:text-white mt-2">{{ $stats['pending'] }}</h4>
        </div>
        <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4">
            <i class="fas fa-clock text-lg"></i>
        </div>
    </div>

    {{-- Sedang Disewa --}}
    <div class="rounded-2xl border border-stroke bg-white py-6 px-7 shadow-sm dark:border-white/10 dark:bg-boxdark flex items-center justify-between gap-4">
        <div>
            <p class="text-sm font-medium text-body dark:text-bodydark mt-1">Disewa</p>
            <h4 class="text-title-md font-bold text-black dark:text-white mt-2">{{ $stats['active'] }}</h4>
        </div>
        <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4">
            <i class="fas fa-car-side text-lg"></i>
        </div>
    </div>

    {{-- Total Pendapatan --}}
    <div class="rounded-2xl border border-primary bg-primary py-6 px-7 shadow-sm dark:border-white/10 dark:bg-primary flex items-center justify-between gap-4">
        <div class="min-w-0">
            <p class="text-sm font-medium text-blue-100 mt-1">Pendapatan</p>
            <h4 class="text-title-md font-bold text-white mt-2 truncate">Rp{{ number_format($stats['revenue'], 0, ',', '.') }}</h4>
        </div>
        <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-white/20 text-white">
            <i class="fas fa-wallet text-lg"></i>
        </div>
    </div>
</div>

    {{-- Grafik Statistik --}}
    <div class="rounded-2xl border border-stroke bg-white p-7.5 shadow-sm dark:border-white/10 dark:bg-boxdark mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <div>
                <h3 class="text-xl font-bold text-black dark:text-white">Tren Penyewaan</h3>
                <p class="text-sm font-medium text-body dark:text-bodydark mt-1">Laporan Pesanan 6 Bulan Terakhir</p>
            </div>
            <div class="flex items-center gap-2 bg-slate-50 dark:bg-white/5 px-4 py-2 rounded border border-stroke dark:border-white/10">
                <div class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></div>
                <span class="text-xs font-bold text-body dark:text-bodydark uppercase tracking-widest">Live Report</span>
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
