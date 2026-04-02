@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan performa & aktivitas hari ini')

@section('content')

{{-- ===== STAT CARDS ===== --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">
    @php
    $stats = [
        ['label'=>'Total Pendapatan','value'=>'Rp 48,5 Jt','sub'=>'+12% dari bulan lalu','icon'=>'fas fa-wallet','color'=>'bg-blue-100 text-blue-600','trend'=>'up'],
        ['label'=>'Pemesanan Aktif','value'=>'28','sub'=>'3 menunggu konfirmasi','icon'=>'fas fa-calendar-check','color'=>'bg-purple-100 text-purple-600','trend'=>'up'],
        ['label'=>'Total Armada','value'=>'215','sub'=>'187 unit siap disewa','icon'=>'fas fa-car','color'=>'bg-green-100 text-green-600','trend'=>'stable'],
        ['label'=>'Pelanggan Baru','value'=>'142','sub'=>'+8 hari ini','icon'=>'fas fa-users','color'=>'bg-orange-100 text-orange-600','trend'=>'up'],
    ];
    @endphp
    @foreach($stats as $s)
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 flex items-start gap-4 hover:shadow-md transition-shadow">
        <div class="w-12 h-12 {{ $s['color'] }} rounded-2xl flex items-center justify-center flex-shrink-0">
            <i class="{{ $s['icon'] }} text-lg"></i>
        </div>
        <div class="min-w-0">
            <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider">{{ $s['label'] }}</p>
            <p class="text-2xl font-white text-slate-900 mt-1">{{ $s['value'] }}</p>
            <p class="text-xs mt-1 {{ $s['trend'] === 'up' ? 'text-green-600' : 'text-slate-400' }}">
                @if($s['trend'] === 'up')<i class="fas fa-arrow-up mr-1"></i>@endif
                {{ $s['sub'] }}
            </p>
        </div>
    </div>
    @endforeach
</div>

{{-- ===== CONTENT GRID ===== --}}
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

    {{-- Recent Bookings (col-span-2) --}}
    <div class="xl:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="flex justify-between items-center px-6 py-5 border-b border-slate-100">
            <h2 class="font-bold text-slate-900">Pemesanan Terbaru</h2>
            <a href="{{ route('admin.pemesanan') }}" class="text-xs text-blue-600 hover:underline font-semibold">Lihat Semua →</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="text-left px-6 py-3.5 text-xs font-bold text-slate-400 uppercase tracking-wider">Pelanggan</th>
                        <th class="text-left px-6 py-3.5 text-xs font-bold text-slate-400 uppercase tracking-wider">Kendaraan</th>
                        <th class="text-left px-6 py-3.5 text-xs font-bold text-slate-400 uppercase tracking-wider">Durasi</th>
                        <th class="text-left px-6 py-3.5 text-xs font-bold text-slate-400 uppercase tracking-wider">Total</th>
                        <th class="text-left px-6 py-3.5 text-xs font-bold text-slate-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3.5"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @php
                    $bookings = [
                        ['name'=>'Budi Santoso','vehicle'=>'Innova Zenix','dur'=>'3 hari','total'=>'Rp 1.975.000','status'=>'Aktif','sc'=>'bg-green-100 text-green-700'],
                        ['name'=>'Sari Dewi','vehicle'=>'Honda PCX','dur'=>'1 hari','total'=>'Rp 145.000','status'=>'Selesai','sc'=>'bg-slate-100 text-slate-500'],
                        ['name'=>'Riko Pratama','vehicle'=>'Toyota Alphard','dur'=>'2 hari','total'=>'Rp 2.425.000','status'=>'Menunggu','sc'=>'bg-yellow-100 text-yellow-700'],
                        ['name'=>'Dina Rahayu','vehicle'=>'Honda CR-V','dur'=>'5 hari','total'=>'Rp 3.775.000','status'=>'Aktif','sc'=>'bg-green-100 text-green-700'],
                        ['name'=>'Andi Wijaya','vehicle'=>'Yamaha NMAX','dur'=>'2 hari','total'=>'Rp 225.000','status'=>'Dibatalkan','sc'=>'bg-red-100 text-red-600'],
                    ];
                    @endphp
                    @foreach($bookings as $b)
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <td class="px-6 py-4 font-semibold text-slate-800">{{ $b['name'] }}</td>
                        <td class="px-6 py-4 text-slate-500">{{ $b['vehicle'] }}</td>
                        <td class="px-6 py-4 text-slate-500">{{ $b['dur'] }}</td>
                        <td class="px-6 py-4 font-bold text-blue-600">{{ $b['total'] }}</td>
                        <td class="px-6 py-4">
                            <span class="text-xs font-bold px-3 py-1 rounded-full {{ $b['sc'] }}">{{ $b['status'] }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <button class="text-slate-400 hover:text-blue-600 transition-colors">
                                <i class="fas fa-eye text-sm"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Right column --}}
    <div class="space-y-6">

        {{-- Ketersediaan Armada --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <h2 class="font-bold text-slate-900 mb-5">Status Armada</h2>
            @php
            $fleet = [
                ['type'=>'Tersedia','count'=>187,'total'=>215,'color'=>'bg-green-500','pct'=>87],
                ['type'=>'Sedang Disewa','count'=>21,'total'=>215,'color'=>'bg-blue-500','pct'=>10],
                ['type'=>'Perawatan','count'=>7,'total'=>215,'color'=>'bg-orange-400','pct'=>3],
            ];
            @endphp
            <div class="space-y-4">
                @foreach($fleet as $f)
                <div>
                    <div class="flex justify-between text-sm font-medium mb-1.5">
                        <span class="text-slate-600">{{ $f['type'] }}</span>
                        <span class="text-slate-900 font-bold">{{ $f['count'] }}</span>
                    </div>
                    <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                        <div class="{{ $f['color'] }} h-full rounded-full transition-all duration-700" style="width: {{ $f['pct'] }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Donut summary --}}
            <div class="mt-5 pt-5 border-t border-slate-100 flex gap-3 flex-wrap">
                <span class="flex items-center gap-1.5 text-xs text-slate-500"><span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>Tersedia</span>
                <span class="flex items-center gap-1.5 text-xs text-slate-500"><span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>Disewa</span>
                <span class="flex items-center gap-1.5 text-xs text-slate-500"><span class="w-2.5 h-2.5 rounded-full bg-orange-400"></span>Perawatan</span>
            </div>
        </div>

        {{-- Aksi Cepat --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <h2 class="font-bold text-slate-900 mb-4">Aksi Cepat</h2>
            <div class="space-y-2">
                <a href="{{ route('admin.kendaraan') }}" class="flex items-center gap-3 p-3 hover:bg-blue-50 rounded-xl group transition-colors">
                    <div class="w-9 h-9 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-all">
                        <i class="fas fa-plus text-sm"></i>
                    </div>
                    <span class="text-sm font-semibold text-slate-700 group-hover:text-blue-700">Tambah Kendaraan Baru</span>
                </a>
                <a href="{{ route('admin.pemesanan') }}" class="flex items-center gap-3 p-3 hover:bg-purple-50 rounded-xl group transition-colors">
                    <div class="w-9 h-9 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center group-hover:bg-purple-600 group-hover:text-white transition-all">
                        <i class="fas fa-list-check text-sm"></i>
                    </div>
                    <span class="text-sm font-semibold text-slate-700 group-hover:text-purple-700">Kelola Pemesanan</span>
                </a>
                <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 p-3 hover:bg-green-50 rounded-xl group transition-colors">
                    <div class="w-9 h-9 bg-green-100 text-green-600 rounded-xl flex items-center justify-center group-hover:bg-green-600 group-hover:text-white transition-all">
                        <i class="fas fa-globe text-sm"></i>
                    </div>
                    <span class="text-sm font-semibold text-slate-700 group-hover:text-green-700">Lihat Website Publik</span>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection