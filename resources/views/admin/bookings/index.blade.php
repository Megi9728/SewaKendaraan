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
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Detail & Berkas</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Waktu & Harga</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status & Bayar</th>
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
                        <td class="px-6 py-5">
                            <p class="font-bold text-slate-700 text-sm mb-2">{{ $booking->vehicle->name }}</p>
                            <div class="flex gap-2 mb-2">
                                @if($booking->ktp_photo)
                                <button type="button" onclick="openPreviewModal('{{ asset('storage/' . $booking->ktp_photo) }}', 'KTP - {{ $booking->user->name }}')" class="text-[10px] bg-blue-50 text-blue-600 px-2 py-1 rounded font-bold hover:bg-blue-100">KTP</button>
                                @endif
                                @if($booking->sim_photo)
                                <button type="button" onclick="openPreviewModal('{{ asset('storage/' . $booking->sim_photo) }}', 'SIM - {{ $booking->user->name }}')" class="text-[10px] bg-blue-50 text-blue-600 px-2 py-1 rounded font-bold hover:bg-blue-100">SIM</button>
                                @endif
                            </div>
                            <p class="text-[10px] font-bold text-slate-500">Opsi: <span class="capitalize text-slate-800">{{ str_replace('-', ' ', $booking->delivery_type) }}</span></p>
                            @if($booking->delivery_type === 'delivery')
                            <p class="text-[10px] text-slate-500 italic max-w-[150px] truncate" title="{{ $booking->delivery_location }}">{{ $booking->delivery_location }}</p>
                            @endif
                            @if($booking->with_driver)
                            <span class="text-[10px] font-bold bg-teal-50 text-teal-600 px-2 py-1 rounded border border-teal-100 mt-1 inline-block">
                                <i class="fas fa-user-tie mr-1"></i> {{ $booking->driver->name ?? 'Pakai Sopir' }}
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-5">
                            <p class="text-xs text-slate-600 mb-1">
                                {{ \Carbon\Carbon::parse($booking->start_date)->format('d/m') }} - {{ \Carbon\Carbon::parse($booking->end_date)->format('d/m/Y') }}
                                <span class="font-bold text-slate-400">({{ $booking->days }}x)</span>
                            </p>
                            <p class="text-sm font-black text-blue-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                        </td>
                        <td class="px-6 py-5">
                            @php
                                $colors = [
                                    'Pending' => 'bg-orange-100 text-orange-600',
                                    'Confirmed' => 'bg-blue-100 text-blue-600',
                                    'Active' => 'bg-indigo-100 text-indigo-600',
                                    'Completed' => 'bg-green-100 text-green-600',
                                    'Cancelled' => 'bg-red-100 text-red-600',
                                    'Rejected' => 'bg-slate-100 text-slate-600',
                                    'On_Delivery' => 'bg-sky-100 text-sky-600',
                                    'Picked_Up' => 'bg-indigo-100 text-indigo-600',
                                    'Active' => 'bg-indigo-100 text-indigo-600',
                                    'Waiting_Pickup' => 'bg-yellow-100 text-yellow-600',
                                    'Returning' => 'bg-indigo-100 text-indigo-600',
                                    'On_Pickup' => 'bg-blue-900 text-white',
                                ];
                                $statusLabels = [
                                    'On_Delivery' => 'Sedang Diantar',
                                    'Picked_Up' => 'Sudah Diambil',
                                    'Waiting_Pickup' => 'Menunggu Penjemputan',
                                    'Returning' => 'Menunggu Pengembalian',
                                    'On_Pickup' => 'Sopir Menuju Lokasi',
                                ];
                                $payColors = [
                                    'unpaid' => 'bg-red-50 text-red-600',
                                    'dp_paid' => 'bg-orange-50 text-orange-600',
                                    'fully_paid' => 'bg-green-50 text-green-600',
                                ];
                                $payLabels = [
                                    'unpaid' => 'Belum Bayar',
                                    'dp_paid' => 'DP Terbayar',
                                    'fully_paid' => 'Lunas',
                                ];
                            @endphp
                            <div class="flex flex-col gap-2 items-start">
                                <span class="text-[10px] font-bold px-2 py-1 rounded {{ $colors[$booking->status] ?? 'bg-slate-100' }} uppercase tracking-wider">
                                    {{ $statusLabels[$booking->status] ?? $booking->status }}
                                </span>
                                <span class="text-[10px] font-bold px-2 py-1 rounded {{ $payColors[$booking->payment_status] ?? 'bg-slate-100' }} uppercase tracking-wider">
                                    {{ $payLabels[$booking->payment_status] ?? 'Unknown' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-2">
                                {{-- Dropdown or direct buttons for speed --}}
                                @if($booking->status === 'Pending')
                                    <form action="{{ route('admin.pemesanan.update', $booking->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="status" value="Confirmed">
                                        <button type="submit" class="text-[10px] font-bold px-3 py-1.5 rounded bg-green-50 text-green-600 hover:bg-green-100 transition shadow-sm border border-green-200" title="Verifikasi Data">
                                            VERIFIKASI
                                        </button>
                                    </form>
                                    <button type="button" onclick="openRejectModal({{ $booking->id }})" class="text-[10px] font-bold px-3 py-1.5 rounded bg-red-50 text-red-600 hover:bg-red-100 transition shadow-sm border border-red-200" title="Tolak">
                                        TOLAK
                                    </button>
                                @endif

                                @if($booking->status === 'Confirmed' && ($booking->payment_status === 'fully_paid' || $booking->with_driver))
                                    @if($booking->with_driver)
                                        <form action="{{ route('admin.pemesanan.update', $booking->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="status" value="On_Pickup">
                                            <button type="submit" class="bg-blue-900 hover:bg-slate-800 text-white text-[10px] font-bold px-3 py-1.5 rounded-lg flex items-center gap-1.5 shadow-sm transition">
                                                <i class="fas fa-user-tie"></i> KIRIM SOPIR
                                            </button>
                                        </form>
                                    @elseif($booking->delivery_type === 'delivery')
                                        <form action="{{ route('admin.pemesanan.update', $booking->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="status" value="On_Delivery">
                                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-[10px] font-bold px-3 py-1.5 rounded-lg flex items-center gap-1.5 shadow-sm transition">
                                                <i class="fas fa-truck"></i> KONFIRMASI PENGANTARAN
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.pemesanan.update', $booking->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="status" value="Picked_Up">
                                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-[10px] font-bold px-3 py-1.5 rounded-lg flex items-center gap-1.5 shadow-sm transition">
                                                <i class="fas fa-key"></i> KONFIRMASI DIAMBIL
                                            </button>
                                        </form>
                                    @endif
                                @endif

                                @if($booking->status === 'On_Pickup')
                                    <span class="text-[10px] font-bold text-slate-400 italic">Menunggu User Konfirmasi Sampai...</span>
                                @endif

                                @if($booking->status === 'Picked_Up' && $booking->with_driver)
                                     <form action="{{ route('admin.pemesanan.update', $booking->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="status" value="Completed">
                                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white text-[10px] font-bold px-3 py-1.5 rounded-lg flex items-center gap-1.5 shadow-sm transition">
                                            <i class="fas fa-flag-checkered"></i> SELESAI (DRIVER KEMBALI)
                                        </button>
                                    </form>
                                @endif

                                @if($booking->status === 'Waiting_Pickup' || $booking->status === 'Returning')
                                    <form action="{{ route('admin.pemesanan.update', $booking->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="status" value="Completed">
                                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white text-[10px] font-bold px-3 py-1.5 rounded-lg flex items-center gap-1.5 shadow-sm transition">
                                            <i class="fas fa-flag-checkered"></i> KONFIRMASI SEWA SELESAI
                                        </button>
                                    </form>
                                @endif

                                @if($booking->status === 'Active' && $booking->delivery_type === 'self-pickup')
                                     <p class="text-[10px] font-bold text-slate-400 italic">User harus mengembalikan mobil</p>
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

{{-- Modal Tolak --}}
<div id="modal-reject" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeRejectModal()"></div>
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md z-10 overflow-hidden text-center p-8">
        <h3 class="text-xl font-black text-slate-900 mb-2">Tolak Pesanan</h3>
        <p class="text-slate-500 text-sm mb-6">Berikan alasan mengapa pesanan ini ditolak. Alasan ini akan mempermudah pelanggan untuk memperbaiki pesanannya.</p>
        
        <form id="form-reject" action="" method="POST">
            @csrf @method('PUT')
            <input type="hidden" name="status" value="Rejected">
            <textarea name="rejection_reason" required rows="3" class="w-full bg-slate-50 text-slate-900 border border-slate-200 rounded-xl p-4 text-sm focus:outline-none focus:border-red-500 mb-6" placeholder="Contoh: Foto KTP buram, tidak dapat dibaca..."></textarea>
            
            <div class="flex gap-3">
                <button type="button" onclick="closeRejectModal()" class="flex-1 font-semibold py-3 rounded-xl transition-all text-sm border border-slate-200 text-slate-600 hover:bg-slate-50">Batal</button>
                <button type="submit" class="flex-1 bg-red-600 border border-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-xl transition-all active:scale-95 text-sm">Ya, Tolak Permohonan</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Preview Dokumen --}}
<div id="modal-preview" class="fixed inset-0 z-[60] flex items-center justify-center p-4 hidden animate-fade-in">
    <div class="absolute inset-0 bg-slate-900/80 backdrop-blur-sm" onclick="closePreviewModal()"></div>
    <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-4xl z-10 overflow-hidden relative border border-white/20">
        <button onclick="closePreviewModal()" class="absolute top-6 right-6 w-12 h-12 bg-slate-900/10 hover:bg-slate-900/20 text-slate-900 rounded-full flex items-center justify-center backdrop-blur-md transition-all z-20">
            <i class="fas fa-times text-xl"></i>
        </button>
        <div class="p-3 bg-slate-100">
            <div class="bg-white rounded-2xl overflow-hidden shadow-inner flex items-center justify-center min-h-[300px]">
                <img id="preview-img" src="" class="w-full h-auto max-h-[75vh] object-contain">
            </div>
        </div>
        <div class="px-10 py-6 flex justify-between items-center bg-white">
            <div>
                <h3 id="preview-title" class="font-black text-slate-900 text-lg">Preview Dokumen</h3>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Verifikasi Identitas Pelanggan</p>
            </div>
            <a id="preview-download" href="" download class="bg-slate-900 hover:bg-slate-800 text-white text-xs font-black py-4 px-8 rounded-2xl transition-all shadow-xl shadow-slate-200 flex items-center gap-3">
                <i class="fas fa-download"></i> UNDUH BERKAS
            </a>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openRejectModal(id) {
        document.getElementById('form-reject').action = `/admin/pemesanan/${id}`;
        document.getElementById('modal-reject').classList.remove('hidden');
    }
    function closeRejectModal() {
        document.getElementById('modal-reject').classList.add('hidden');
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

    // Escape to close
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closePreviewModal();
            closeRejectModal();
        }
    });
</script>
<style>
    .animate-fade-in {
        animation: fadeIn 0.2s ease-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }
</style>
@endpush
