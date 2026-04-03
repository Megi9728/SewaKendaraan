@extends('layouts.admin')

@section('page-title', 'Manajemen Pemesanan')
@section('page-subtitle', 'Daftar semua transaksi penyewaan kendaraan')

@section('content')
<div class="px-4 py-6">
    {{-- Stats Mini --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        @php
            $stats = [
                ['label' => 'Total Pesanan', 'value' => $bookings->count(), 'icon' => 'fas fa-list', 'color' => 'blue'],
                ['label' => 'Pending', 'value' => $bookings->where('status', 'Pending')->count(), 'icon' => 'fas fa-clock', 'color' => 'orange'],
                ['label' => 'Aktif/Sewa', 'value' => $bookings->where('status', 'Confirmed')->count(), 'icon' => 'fas fa-car', 'color' => 'green'],
                ['label' => 'Selesai', 'value' => $bookings->where('status', 'Completed')->count(), 'icon' => 'fas fa-check-double', 'color' => 'slate'],
            ];
        @endphp
        @foreach($stats as $s)
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-{{ $s['color'] }}-50 text-{{ $s['color'] }}-600 flex items-center justify-center">
                    <i class="{{ $s['icon'] }}"></i>
                </div>
                <div>
                    <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $s['label'] }}</h4>
                    <p class="text-xl font-black text-slate-900">{{ $s['value'] }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if(session('success'))
    <div class="mb-6 bg-green-50 border border-green-100 text-green-700 px-6 py-4 rounded-xl flex items-center gap-3">
        <i class="fas fa-check-circle"></i>
        <p class="font-bold text-sm">{{ session('success') }}</p>
    </div>
    @endif

    {{-- Table --}}
    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-50">
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Transaksi</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Pelanggan</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Armada</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Durasi</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Total</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($bookings as $booking)
                    <tr class="hover:bg-slate-50/30 transition-colors">
                        <td class="px-6 py-5">
                            <span class="text-xs font-bold text-slate-900">#TRX-{{ $booking->id }}</span>
                            <p class="text-[10px] text-slate-400 mt-0.5">{{ $booking->created_at->format('d/m/Y H:i') }}</p>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center text-[10px] font-black uppercase">
                                    {{ substr($booking->user->name, 0, 1) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-bold text-slate-800 truncate">{{ $booking->user->name }}</p>
                                    <p class="text-[10px] text-slate-400 truncate">{{ $booking->user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 font-bold text-slate-700 text-sm">
                            {{ $booking->vehicle->name }}
                        </td>
                        <td class="px-6 py-5 text-xs text-slate-500 italic">
                            {{ $booking->start_date }} sd {{ $booking->end_date }}
                            <p class="text-[10px] font-bold text-slate-400 non-italic mt-1">({{ $booking->days }} Hari)</p>
                        </td>
                        <td class="px-6 py-5 text-sm font-black text-blue-600">
                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-5">
                            @php
                                $colors = [
                                    'Pending' => 'bg-orange-100 text-orange-600',
                                    'Confirmed' => 'bg-blue-100 text-blue-600',
                                    'Completed' => 'bg-green-100 text-green-600',
                                    'Cancelled' => 'bg-red-100 text-red-600',
                                    'Rejected' => 'bg-slate-100 text-slate-600',
                                ];
                            @endphp
                            <span class="text-[10px] font-bold px-3 py-1.5 rounded-lg {{ $colors[$booking->status] }} uppercase tracking-wider">
                                {{ $booking->status }}
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-2">
                                {{-- Dropdown or direct buttons for speed --}}
                                @if($booking->status === 'Pending')
                                    <form action="{{ route('admin.pemesanan.update', $booking->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="status" value="Confirmed">
                                        <button type="submit" class="w-8 h-8 rounded-lg bg-green-50 text-green-600 flex items-center justify-center hover:bg-green-100 transition shadow-sm" title="Setujui">
                                            <i class="fas fa-check text-xs"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.pemesanan.update', $booking->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="status" value="Rejected">
                                        <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-100 transition shadow-sm" title="Tolak">
                                            <i class="fas fa-times text-xs"></i>
                                        </button>
                                    </form>
                                @endif

                                @if($booking->status === 'Confirmed')
                                    <form action="{{ route('admin.pemesanan.update', $booking->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="status" value="Completed">
                                        <button type="submit" class="bg-blue-600 text-white text-[10px] font-bold px-3 py-1.5 rounded-lg flex items-center gap-1.5 shadow-sm shadow-blue-100">
                                            <i class="fas fa-flag-checkered"></i> SELESAI
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-calendar-minus text-2xl"></i>
                            </div>
                            <p class="text-sm font-bold text-slate-400">Tidak ada pemesanan masuk.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
