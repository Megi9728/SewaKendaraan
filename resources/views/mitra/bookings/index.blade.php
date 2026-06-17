@extends('layouts.admin')

@section('title', 'Manajemen Pemesanan')

@section('content')

{{-- Header Area --}}
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-xl font-bold text-gray-800 dark:text-white tracking-tight">
            Pemesanan Armada
        </h2>
        <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5 font-medium">Kelola transaksi penyewaan armada mitra Anda.</p>
    </div>
    <div class="flex items-center gap-3">
        <div class="bg-white dark:bg-white/[0.03] border border-gray-200 dark:border-gray-800 px-4 py-2 rounded-xl flex items-center gap-3 shadow-sm">
            <div class="w-2 h-2 rounded-full bg-brand-500 animate-pulse"></div>
            <span class="text-[9px] font-bold uppercase tracking-widest text-gray-500 dark:text-gray-400">Status: Mitra Aktif</span>
        </div>
    </div>
</div>

{{-- Stats Grid --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
    @php
        $stats = [
            ['label' => 'Total', 'value' => $bookings->count(), 'icon' => 'fas fa-list', 'color' => 'brand'],
            ['label' => 'Pending', 'value' => $bookings->where('status', 'Pending')->count(), 'icon' => 'fas fa-clock', 'color' => 'warning'],
            ['label' => 'Terjadwal', 'value' => $bookings->where('status', 'Confirmed')->count(), 'icon' => 'fas fa-calendar-check', 'color' => 'indigo'],
            ['label' => 'Disewa', 'value' => $bookings->whereIn('status', ['Active','Picked_Up', 'On_the_Way'])->count(), 'icon' => 'fas fa-car', 'color' => 'success'],
            ['label' => 'Selesai', 'value' => $bookings->where('status', 'Completed')->count(), 'icon' => 'fas fa-check-double', 'color' => 'gray'],
        ];
    @endphp
    @foreach($stats as $s)
    <div class="bg-white dark:bg-white/[0.03] p-4 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm transition-all hover:shadow-md group">
        <div class="flex items-center justify-between mb-2">
            <div class="w-9 h-9 rounded-lg bg-{{ $s['color'] === 'brand' ? 'brand-500/10 text-brand-600' : ($s['color'] === 'warning' ? 'warning-500/10 text-warning-600' : ($s['color'] === 'success' ? 'success-500/10 text-success-600' : ($s['color'] === 'indigo' ? 'indigo-500/10 text-indigo-600' : 'gray-100 text-gray-500'))) }} dark:text-{{ $s['color'] === 'brand' ? 'brand-400' : ($s['color'] === 'warning' ? 'warning-400' : ($s['color'] === 'success' ? 'success-400' : ($s['color'] === 'indigo' ? 'indigo-400' : 'gray-400'))) }} flex items-center justify-center transition-transform group-hover:scale-110">
                <i class="{{ $s['icon'] }} text-base"></i>
            </div>
        </div>
        <div>
            <h4 class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">{{ $s['label'] }}</h4>
            <p class="text-xl font-bold text-gray-800 dark:text-white">{{ $s['value'] }}</p>
        </div>
    </div>
    @endforeach
</div>

@if(session('success'))
<div class="mb-8 bg-success-50 dark:bg-success-500/10 border border-success-500/10 text-success-600 dark:text-success-400 px-6 py-4 rounded-2xl flex items-center gap-3 animate-in fade-in slide-in-from-top-4 duration-300">
    <i class="fas fa-check-circle"></i>
    <p class="font-bold text-sm">{{ session('success') }}</p>
</div>
@endif

{{-- ===== TABLE ===== --}}
<div class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="overflow-x-auto custom-scrollbar">
        <table class="w-full text-left whitespace-nowrap">
            <thead class="bg-gray-50 dark:bg-white/[0.02] border-b border-gray-100 dark:border-gray-800">
                <tr>
                    <th class="py-3.5 px-6 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Transaksi</th>
                    <th class="py-3.5 px-6 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Pelanggan</th>
                    <th class="py-3.5 px-6 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Unit & Berkas</th>
                    <th class="py-3.5 px-6 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Durasi & Biaya</th>
                    <th class="py-3.5 px-6 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider text-center">Status</th>
                    <th class="py-3.5 px-6 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse($bookings as $booking)
                <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.01] transition-colors">
                    <td class="py-4 px-6">
                        <div class="flex flex-col gap-0.5">
                            <span class="text-xs font-bold text-gray-800 dark:text-white tracking-tight leading-none">#TRX-{{ $booking->id }}</span>
                            <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">{{ $booking->created_at->format('d/m/y, H:i') }}</p>
                        </div>
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-brand-500/10 text-brand-600 dark:text-brand-400 flex items-center justify-center text-[10px] font-bold uppercase border border-brand-500/20">
                                {{ substr($booking->customer->name, 0, 1) }}
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-bold text-gray-800 dark:text-white truncate tracking-tight leading-none mb-0.5">{{ $booking->customer->name }}</p>
                                <p class="text-[9px] font-medium text-gray-400 truncate leading-none">{{ $booking->customer->email }}</p>
                                @if($booking->customer->phone)
                                    <p class="text-[9px] text-gray-500 font-bold mt-1 tracking-tight leading-none"><i class="fas fa-phone-alt text-[8px] mr-1"></i> {{ $booking->customer->phone }}</p>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex flex-col gap-1.5">
                            <div class="flex items-center gap-2">
                                <p class="text-xs font-bold text-gray-800 dark:text-white tracking-tight leading-tight truncate max-w-[120px]">{{ $booking->vehicle->name }}</p>
                                @if($booking->vehicleUnit && $booking->vehicleUnit->plate_number)
                                    <span class="text-[8px] font-bold px-1.5 py-0.5 rounded bg-gray-100 dark:bg-white/10 text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-gray-800">{{ $booking->vehicleUnit->plate_number }}</span>
                                @endif
                            </div>
                            @if($booking->driver_fee > 0 || !is_null($booking->driver_id))
                                @php
                                    $driverText = $booking->driver->name ?? (in_array($booking->status, ['Pending', 'Confirmed']) ? 'Menunggu Sopir' : 'Sopir Ditugaskan');
                                @endphp
                                <p class="text-[9px] text-purple-600 font-bold uppercase tracking-widest leading-none"><i class="fas fa-user-tie mr-1 text-[8px]"></i> {{ $driverText }}</p>
                            @else
                                <p class="text-[9px] text-orange-600 font-bold uppercase tracking-widest leading-none"><i class="fas fa-key mr-1 text-[8px]"></i> Lepas Kunci</p>
                            @endif
                            <div class="flex gap-1.5">
                                @if($booking->status !== 'Completed')
                                    @if($booking->ktp_photo)
                                    <button type="button" onclick="openPreviewModal('{{ asset('storage/' . $booking->ktp_photo) }}', 'KTP')" 
                                            class="text-[8px] font-bold uppercase tracking-widest bg-gray-50 dark:bg-white/5 text-gray-500 dark:text-gray-400 px-1.5 py-0.5 rounded-md hover:bg-brand-500 hover:text-white transition-all border border-gray-100 dark:border-gray-800">KTP</button>
                                    @endif
                                    @if($booking->sim_photo)
                                    <button type="button" onclick="openPreviewModal('{{ asset('storage/' . $booking->sim_photo) }}', 'SIM')" 
                                            class="text-[8px] font-bold uppercase tracking-widest bg-gray-50 dark:bg-white/5 text-gray-500 dark:text-gray-400 px-1.5 py-0.5 rounded-md hover:bg-brand-500 hover:text-white transition-all border border-gray-100 dark:border-gray-800">SIM</button>
                                    @endif
                                @else
                                    <span class="text-[8px] font-bold text-gray-400 uppercase tracking-widest italic flex items-center gap-1 leading-none"><i class="fas fa-lock text-[7px]"></i> Terarsip</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex flex-col gap-0.5">
                            <div class="text-[9px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest leading-none">
                                {{ \Carbon\Carbon::parse($booking->start_date)->format('d/m/y H:i') }} - {{ \Carbon\Carbon::parse($booking->end_date)->format('d/m/y H:i') }}
                                <span class="text-brand-500 ml-0.5">({{ $booking->days }}x)</span>
                            </div>
                            <div class="text-xs font-bold text-gray-800 dark:text-white leading-none mt-1">
                                <span class="text-[9px] font-normal opacity-60">Rp</span> {{ number_format($booking->total_price, 0, ',', '.') }}
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-6 text-center">
                        @php
                            $statusClasses = [
                                'Pending'   => 'bg-warning-50 text-warning-600 border-warning-500/20 dark:bg-warning-500/10 dark:text-warning-400',
                                'Confirmed' => 'bg-indigo-50 text-indigo-600 border-indigo-500/20 dark:bg-indigo-500/10 dark:text-indigo-400',
                                'Active'    => 'bg-success-50 text-success-600 border-success-500/20 dark:bg-success-500/10 dark:text-success-400',
                                'Picked_Up' => 'bg-success-50 text-success-600 border-success-500/20 dark:bg-success-500/10 dark:text-success-400',
                                'On_the_Way' => 'bg-blue-50 text-blue-600 border-blue-500/20 dark:bg-blue-500/10 dark:text-blue-400',
                                'Returning' => 'bg-brand-50 text-brand-600 border-brand-500/20 dark:bg-brand-500/10 dark:text-brand-400',
                                'Completed' => 'bg-gray-50 text-gray-500 border-gray-200 dark:bg-white/10 dark:text-gray-400',
                                'Cancelled' => 'bg-error-50 text-error-600 border-error-500/20 dark:bg-error-500/10 dark:text-error-400',
                                'Rejected'  => 'bg-gray-100 text-gray-400 border-gray-200 dark:bg-white/5 dark:text-gray-600',
                            ];
                            $payColors = [
                                'unpaid'     => 'bg-error-50 text-error-600 dark:bg-error-500/10 dark:text-error-400',
                                'dp_paid'    => 'bg-warning-50 text-warning-600 dark:bg-warning-500/10 dark:text-warning-400',
                                'fully_paid' => 'bg-success-50 text-success-600 dark:bg-success-500/10 dark:text-success-400',
                            ];
                            $payLabels = [
                                'unpaid'     => 'Belum Bayar',
                                'dp_paid'    => 'DP Terbayar',
                                'fully_paid' => 'Lunas',
                            ];
                        @endphp
                        <div class="flex flex-col gap-1 items-center">
                            <span class="inline-flex rounded-md px-2 py-0.5 text-[8px] font-bold uppercase tracking-widest border {{ $statusClasses[$booking->status] ?? 'bg-gray-100' }}">
                                {{ $booking->status }}
                            </span>
                            <span class="inline-flex rounded-md px-1.5 py-0.5 text-[7px] font-bold uppercase tracking-tighter border {{ $payColors[$booking->payment_status] ?? 'bg-gray-100' }}">
                                {{ $payLabels[$booking->payment_status] ?? '-' }}
                            </span>
                        </div>
                    </td>
                    <td class="py-4 px-6 text-right">
                        <div class="flex items-center justify-end gap-1.5">
                            @if($booking->status === 'Pending')
                                <form action="{{ route('mitra.booking.update', $booking->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="Confirmed">
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-success-50 dark:bg-success-500/10 text-success-600 dark:text-success-400 hover:bg-success-500 hover:text-white transition-all border border-success-500/20" title="Verifikasi">
                                        <i class="fas fa-check text-[10px]"></i>
                                    </button>
                                </form>
                                <button type="button" onclick="openRejectModal({{ $booking->id }})" class="w-8 h-8 rounded-lg bg-error-50 dark:bg-error-500/10 text-error-600 dark:text-error-400 hover:bg-error-500 hover:text-white transition-all border border-error-500/20" title="Tolak">
                                    <i class="fas fa-times text-[10px]"></i>
                                </button>
                            @endif

                            @if($booking->status === 'Confirmed')
                                @if($booking->payment_status === 'fully_paid')
                                    <form action="{{ route('mitra.booking.update', $booking->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        @if($booking->driver_fee > 0)
                                            <input type="hidden" name="status" value="On_the_Way">
                                            <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white text-[8px] font-bold px-3 py-1.5 rounded-lg transition-all active:scale-95 uppercase tracking-widest flex items-center gap-1">
                                                <i class="fas fa-paper-plane"></i> KIRIM
                                            </button>
                                        @else
                                            <input type="hidden" name="status" value="Picked_Up">
                                            <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white text-[8px] font-bold px-3 py-1.5 rounded-lg transition-all active:scale-95 uppercase tracking-widest flex items-center gap-1">
                                                <i class="fas fa-key"></i> AMBIL
                                            </button>
                                        @endif
                                    </form>
                                @else
                                    <span class="text-[8px] font-bold text-warning-500 uppercase italic animate-pulse">Menunggu Pembayaran...</span>
                                @endif
                            @endif

                            @if(in_array($booking->status, ['Active', 'Picked_Up', 'Returning', 'On_the_Way']))
                                <form action="{{ route('mitra.booking.update', $booking->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="Completed">
                                    <button type="submit" class="bg-success-500 hover:bg-success-600 text-white text-[8px] font-bold px-3 py-1.5 rounded-lg transition-all active:scale-95 uppercase tracking-widest flex items-center gap-1">
                                        <i class="fas fa-check-double"></i> SELESAI
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-20 text-center bg-gray-50/20 dark:bg-white/[0.01]">
                        <div class="w-20 h-20 bg-gray-100 dark:bg-white/5 rounded-[2rem] flex items-center justify-center mx-auto mb-6 border-2 border-dashed border-gray-200 dark:border-gray-800">
                            <i class="fas fa-calendar-minus text-gray-300 dark:text-gray-700 text-3xl"></i>
                        </div>
                        <p class="text-gray-400 dark:text-gray-500 font-bold uppercase tracking-widest text-[10px]">Belum ada pemesanan masuk</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Reject --}}
<div id="modal-reject" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" onclick="closeRejectModal()"></div>
    <div class="bg-white dark:bg-[#121212] rounded-[2.5rem] shadow-2xl w-full max-w-md z-10 overflow-hidden text-center p-10 border border-white/10 animate-in zoom-in duration-300">
        <div class="w-20 h-20 bg-error-50 dark:bg-error-500/10 rounded-[2rem] flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-times-circle text-error-500 text-3xl"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-2 tracking-tight">Tolak Pesanan</h3>
        <p class="text-gray-500 dark:text-gray-400 text-sm mb-8 leading-relaxed">Berikan alasan logis mengapa pesanan ini harus ditolak.</p>
        
        <form id="form-reject" action="" method="POST" class="space-y-6">
            @csrf @method('PUT')
            <input type="hidden" name="status" value="Rejected">
            <textarea name="rejection_reason" required rows="3" 
                      class="w-full bg-gray-50 dark:bg-white/[0.03] border border-gray-200 dark:border-gray-800 rounded-2xl px-5 py-4 text-sm font-medium text-gray-800 dark:text-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 outline-none transition-all resize-none" 
                      placeholder="Contoh: Unit sedang kendala teknis, dokumen tidak valid..."></textarea>
            
            <div class="flex gap-3">
                <button type="button" onclick="closeRejectModal()" class="flex-1 font-bold py-4 rounded-2xl transition-all text-sm bg-gray-100 dark:bg-white/5 text-gray-600 dark:text-gray-400 active:scale-95">Batal</button>
                <button type="submit" class="flex-[2] bg-error-500 hover:bg-error-600 text-white font-bold py-4 rounded-2xl transition-all active:scale-95 text-sm shadow-lg shadow-error-500/20">Ya, Tolak Sekarang</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Preview Dokumen --}}
<div id="modal-preview" class="fixed inset-0 z-[60] flex items-center justify-center p-4 hidden">
    <div class="absolute inset-0 bg-gray-900/80 backdrop-blur-md transition-opacity" onclick="closePreviewModal()"></div>
    <div class="bg-white dark:bg-[#121212] rounded-[3rem] shadow-2xl w-full max-w-4xl z-10 overflow-hidden relative border border-white/10 animate-in zoom-in duration-300">
        <button onclick="closePreviewModal()" class="absolute top-8 right-8 w-12 h-12 bg-white/10 hover:bg-white/20 text-white rounded-2xl flex items-center justify-center backdrop-blur-md transition-all z-20 border border-white/10">
            <i class="fas fa-times text-xl"></i>
        </button>
        <div class="p-4 bg-gray-900 flex items-center justify-center min-h-[400px]">
            <img id="preview-img" src="" class="w-full h-auto max-h-[70vh] object-contain rounded-2xl shadow-2xl">
        </div>
        <div class="px-12 py-10 flex flex-col sm:flex-row justify-between items-center bg-white dark:bg-[#121212] gap-6">
            <div>
                <h3 id="preview-title" class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">Preview Dokumen</h3>
                <p class="text-xs font-bold text-brand-500 uppercase tracking-widest mt-1">Verifikasi Identitas Pelanggan</p>
            </div>
            <a id="preview-download" href="" download class="bg-gray-900 dark:bg-brand-500 hover:scale-105 text-white text-xs font-bold py-4 px-10 rounded-2xl transition-all shadow-2xl flex items-center gap-3 uppercase tracking-widest">
                <i class="fas fa-download"></i> Unduh Berkas
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openRejectModal(id) {
        document.getElementById('form-reject').action = `/mitra/booking/${id}`;
        document.getElementById('modal-reject').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function closeRejectModal() {
        document.getElementById('modal-reject').classList.add('hidden');
        document.body.style.overflow = '';
    }

    function openPreviewModal(url, title) {
        document.getElementById('preview-img').src = url;
        document.getElementById('preview-title').textContent = title;
        document.getElementById('preview-download').href = url;
        document.getElementById('modal-preview').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function closePreviewModal() {
        document.getElementById('modal-preview').classList.add('hidden');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') { closePreviewModal(); closeRejectModal(); }
    });
</script>
@endpush

@endsection
