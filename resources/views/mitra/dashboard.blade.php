@extends('layouts.admin')

@section('title', 'Dashboard Ringkasan')

@section('content')

{{-- Header Area --}}
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-xl font-bold text-gray-800 dark:text-white tracking-tight leading-tight">
            Dashboard Mitra
        </h2>
        <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5 font-medium">Pantau performa penyewaan armada Anda secara real-time.</p>
    </div>
    <div class="flex items-center gap-3">
        <button type="button" onclick="openExportModal()" class="bg-white dark:bg-white/[0.03] border border-gray-200 dark:border-gray-800 px-4 py-2.5 rounded-2xl flex items-center gap-2 shadow-sm hover:bg-gray-50 transition-colors text-[10px] font-bold uppercase tracking-widest text-gray-700 dark:text-gray-300">
            <i class="fas fa-file-export text-brand-500"></i> Ekspor laporan
        </button>
       
    </div>
</div>

{{-- Stats Grid --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5 mb-8">
    {{-- Total Armada --}}
    <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-white/[0.03] transition-all hover:shadow-md group">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-brand-500/10 text-brand-600 dark:text-brand-400 flex items-center justify-center transition-transform group-hover:scale-110">
                <i class="fas fa-car text-lg"></i>
            </div>
            <span class="text-[9px] font-bold text-success-500 bg-success-50 dark:bg-success-500/10 px-2 py-0.5 rounded-md uppercase">Aktif</span>
        </div>
        <div>
            <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Armada</p>
            <h4 class="text-lg font-bold text-gray-800 dark:text-white">{{ $stats['total_mobil'] }} <span class="text-[10px] font-medium text-gray-400">Unit</span></h4>
        </div>
    </div>

    {{-- Total Transaksi --}}
    <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-white/[0.03] transition-all hover:shadow-md group">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-warning-500/10 text-warning-600 dark:text-warning-400 flex items-center justify-center transition-transform group-hover:scale-110">
                <i class="fas fa-shopping-cart text-lg"></i>
            </div>
        </div>
        <div>
            <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-1">Transaksi</p>
            <h4 class="text-lg font-bold text-gray-800 dark:text-white">{{ $stats['total_booking'] }} <span class="text-[10px] font-medium text-gray-400">Order</span></h4>
        </div>
    </div>

    {{-- Pending --}}
    <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-white/[0.03] transition-all hover:shadow-md group">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-error-500/10 text-error-600 dark:text-error-400 flex items-center justify-center transition-transform group-hover:scale-110">
                <i class="fas fa-clock text-lg"></i>
            </div>
        </div>
        <div>
            <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-1">Pending</p>
            <h4 class="text-lg font-bold text-gray-800 dark:text-white">{{ $stats['pending'] }} <span class="text-[10px] font-medium text-gray-400">Unit</span></h4>
        </div>
    </div>

    {{-- Sedang Disewa --}}
    <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-white/[0.03] transition-all hover:shadow-md group">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-success-500/10 text-success-600 dark:text-success-400 flex items-center justify-center transition-transform group-hover:scale-110">
                <i class="fas fa-car-side text-lg"></i>
            </div>
        </div>
        <div>
            <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-1">Sedang Disewa</p>
            <h4 class="text-lg font-bold text-gray-800 dark:text-white">{{ $stats['active'] }} <span class="text-[10px] font-medium text-gray-400">Unit</span></h4>
        </div>
    </div>

    {{-- Total Pendapatan --}}
    <div class="rounded-2xl border border-brand-500 bg-brand-500 p-5 shadow-lg shadow-brand-500/20 transition-all hover:scale-[1.02] group">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-white/20 text-white flex items-center justify-center transition-transform group-hover:rotate-12">
                <i class="fas fa-wallet text-lg"></i>
            </div>
        </div>
        <div>
            <p class="text-[9px] font-bold text-white/70 uppercase tracking-widest mb-1">Pendapatan</p>
            <h4 class="text-lg font-bold text-white truncate tracking-tight">Rp{{ number_format($stats['revenue'], 0, ',', '.') }}</h4>
        </div>
    </div>
</div>

{{-- Chart Section --}}
<div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <div class="w-1.5 h-6 bg-brand-500 rounded-full"></div>
                <h3 class="text-lg font-bold text-gray-800 dark:text-white tracking-tight">Analitik Penyewaan</h3>
            </div>
            <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Tren pemesanan armada dalam 6 bulan terakhir.</p>
        </div>
        <div class="flex items-center gap-2 bg-gray-50 dark:bg-white/5 p-1.5 rounded-xl border border-gray-100 dark:border-gray-800">
            <button id="btn-chart-monthly" class="px-3 py-1.5 rounded-lg bg-white dark:bg-white/10 text-[10px] font-bold text-brand-600 dark:text-brand-400 shadow-sm transition-all uppercase tracking-widest">Bulanan</button>
            <button id="btn-chart-weekly" class="px-3 py-1.5 rounded-lg text-[10px] font-bold text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-all uppercase tracking-widest">Mingguan</button>
        </div>
    </div>
    
    <div class="h-[350px] w-full">
        <canvas id="rentalChart"></canvas>
    </div>
</div>

{{-- Modal Export Laporan Mitra --}}
<div id="modal-export" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" onclick="closeExportModal()"></div>
    <div class="bg-white dark:bg-[#121212] rounded-[2.5rem] shadow-2xl w-full max-w-md z-10 overflow-hidden p-8 border border-white/10 animate-in zoom-in duration-300">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-gray-800 dark:text-white tracking-tight">Ekspor Laporan</h3>
            <button onclick="closeExportModal()" class="w-8 h-8 rounded-full bg-gray-100 dark:bg-white/10 hover:bg-gray-200 flex items-center justify-center text-gray-600 dark:text-gray-300 transition-colors"><i class="fas fa-times"></i></button>
        </div>
        <form action="{{ route('mitra.laporan.export') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-600 dark:text-gray-400 mb-1">Bulan</label>
                    <select name="month" class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-gray-800 rounded-xl px-4 py-2 text-sm outline-none dark:text-white">
                        <option value="">Semua</option>
                        @for($i=1; $i<=12; $i++)
                            <option value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 dark:text-gray-400 mb-1">Tahun</label>
                    <select name="year" class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-gray-800 rounded-xl px-4 py-2 text-sm outline-none dark:text-white">
                        <option value="">Semua</option>
                        @for($i=date('Y'); $i>=date('Y')-5; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-600 dark:text-gray-400 mb-1">Kategori Kendaraan</label>
                <select name="category_id" class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-gray-800 rounded-xl px-4 py-2 text-sm outline-none dark:text-white">
                    <option value="">Semua Kategori</option>
                    @foreach(\App\Models\VehicleCategory::all() as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-600 dark:text-gray-400 mb-1">Jenis Pesanan</label>
                <select name="type" class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-gray-800 rounded-xl px-4 py-2 text-sm outline-none dark:text-white">
                    <option value="">Semua Jenis</option>
                    <option value="with_driver">Dengan Sopir</option>
                    <option value="lepas_kunci">Lepas Kunci</option>
                </select>
            </div>
            <div class="mt-6">
                <button type="submit" class="w-full bg-brand-500 hover:bg-brand-600 text-white font-bold py-3 rounded-xl transition-all shadow-lg shadow-brand-500/20"><i class="fas fa-download mr-2"></i> Unduh CSV</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('rentalChart').getContext('2d');
        
        // Gradient for the chart
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(70, 128, 255, 0.25)');
        gradient.addColorStop(1, 'rgba(70, 128, 255, 0)');

        const monthlyLabels = @json($chartLabels);
        const monthlyData = @json($chartData);
        
        const weeklyLabels = @json($weeklyChartLabels ?? []);
        const weeklyData = @json($weeklyChartData ?? []);

        let rentalChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: monthlyLabels,
                datasets: [{
                    label: 'Jumlah Pesanan',
                    data: monthlyData,
                    borderColor: '#4680FF',
                    borderWidth: 4,
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.45,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#4680FF',
                    pointBorderWidth: 4,
                    pointRadius: 6,
                    pointHoverRadius: 9,
                    pointHoverBorderWidth: 4,
                    pointHoverBackgroundColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleFont: { size: 12, weight: 'bold' },
                        bodyFont: { size: 12 },
                        padding: 12,
                        cornerRadius: 12,
                        displayColors: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            font: { size: 11, weight: '600' },
                            color: '#94a3b8',
                            padding: 10
                        },
                        grid: { 
                            color: 'rgba(241, 245, 249, 0.5)',
                            drawBorder: false 
                        }
                    },
                    x: {
                        ticks: {
                            font: { size: 11, weight: '600' },
                            color: '#94a3b8',
                            padding: 10
                        },
                        grid: { display: false }
                    }
                }
            }
        });

        document.getElementById('btn-chart-monthly').addEventListener('click', function() {
            this.classList.add('bg-white', 'dark:bg-white/10', 'text-brand-600', 'dark:text-brand-400', 'shadow-sm');
            this.classList.remove('text-gray-400', 'hover:text-gray-600', 'dark:hover:text-gray-200');
            
            let weeklyBtn = document.getElementById('btn-chart-weekly');
            weeklyBtn.classList.remove('bg-white', 'dark:bg-white/10', 'text-brand-600', 'dark:text-brand-400', 'shadow-sm');
            weeklyBtn.classList.add('text-gray-400', 'hover:text-gray-600', 'dark:hover:text-gray-200');

            rentalChart.data.labels = monthlyLabels;
            rentalChart.data.datasets[0].data = monthlyData;
            rentalChart.update();
        });

        document.getElementById('btn-chart-weekly').addEventListener('click', function() {
            this.classList.add('bg-white', 'dark:bg-white/10', 'text-brand-600', 'dark:text-brand-400', 'shadow-sm');
            this.classList.remove('text-gray-400', 'hover:text-gray-600', 'dark:hover:text-gray-200');
            
            let monthlyBtn = document.getElementById('btn-chart-monthly');
            monthlyBtn.classList.remove('bg-white', 'dark:bg-white/10', 'text-brand-600', 'dark:text-brand-400', 'shadow-sm');
            monthlyBtn.classList.add('text-gray-400', 'hover:text-gray-600', 'dark:hover:text-gray-200');

            rentalChart.data.labels = weeklyLabels;
            rentalChart.data.datasets[0].data = weeklyData;
            rentalChart.update();
        });
    });

    function openExportModal() {
        document.getElementById('modal-export').classList.remove('hidden');
    }
    function closeExportModal() {
        document.getElementById('modal-export').classList.add('hidden');
    }
</script>
@endpush
@endsection
