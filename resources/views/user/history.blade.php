@extends('layouts.app')

@section('title', 'Riwayat Sewa')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    {{-- Header --}}
    <div class="mb-10">
        <h1 class="text-4xl font-black text-slate-900 mb-2">Riwayat <span class="text-blue-600">Sewa</span></h1>
        <p class="text-slate-500 font-medium">Pantau status pesanan dan perjalanan Anda di sini.</p>
    </div>

    @if(session('success'))
    <div class="mb-8 bg-green-50 border border-green-100 text-green-700 px-6 py-4 rounded-2xl flex items-center gap-3 shadow-sm">
        <i class="fas fa-check-circle text-xl"></i>
        <p class="font-bold text-sm">{{ session('success') }}</p>
    </div>
    @endif

    @if($bookings->isEmpty())
    <div class="bg-white rounded-[2.5rem] p-12 text-center border border-slate-100 shadow-sm">
        <div class="w-24 h-24 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-calendar-xmark text-4xl"></i>
        </div>
        <h3 class="text-2xl font-black text-slate-900 mb-2">Belum ada pesanan</h3>
        <p class="text-slate-400 mb-8 max-w-sm mx-auto">Sepertinya Anda belum pernah melakukan pemesanan kendaraan. Yuk, cari armada impian Anda sekarang!</p>
        <a href="{{ route('browse') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-black px-8 py-4 rounded-2xl transition-all shadow-lg shadow-blue-100">
            Jelajahi Armada <i class="fas fa-arrow-right"></i>
        </a>
    </div>
    @else
    <div class="grid grid-cols-1 gap-6">
        @foreach($bookings as $booking)
        <div class="bg-white rounded-[2rem] border border-slate-100 p-6 md:p-8 flex flex-col md:flex-row gap-8 items-center hover:shadow-xl transition-all duration-500 group">
            {{-- Image --}}
            <div class="w-full md:w-64 h-44 rounded-2xl overflow-hidden flex-shrink-0">
                <img src="{{ $booking->vehicle->image ? (strpos($booking->vehicle->image, 'http') === 0 ? $booking->vehicle->image : asset('storage/' . $booking->vehicle->image)) : 'https://placehold.co/600x400?text=No+Image' }}" 
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="{{ $booking->vehicle->name }}">
            </div>

            {{-- Info --}}
            <div class="flex-1 min-w-0 w-full text-center md:text-left">
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 mb-3">
                    <span class="text-[10px] font-black px-3 py-1.5 rounded-lg bg-slate-900 text-white uppercase tracking-widest shadow-sm">#TRX-{{ $booking->id }}</span>
                    @php
                        $statusColors = [
                            'Pending' => 'bg-orange-100 text-orange-600 border-orange-200',
                            'Confirmed' => 'bg-blue-100 text-blue-600 border-blue-200',
                            'On_Delivery' => 'bg-sky-100 text-sky-600 border-sky-200',
                            'Picked_Up' => 'bg-indigo-100 text-indigo-600 border-indigo-200',
                            'Active' => 'bg-indigo-100 text-indigo-600 border-indigo-200',
                            'Waiting_Pickup' => 'bg-yellow-100 text-yellow-600 border-yellow-200',
                            'Completed' => 'bg-green-100 text-green-600 border-green-200',
                            'Cancelled' => 'bg-red-100 text-red-600 border-red-200',
                            'Rejected' => 'bg-slate-100 text-slate-600 border-slate-200',
                        ];
                        $statusLabels = [
                            'On_Delivery' => 'Sedang Diantar',
                            'Picked_Up' => 'Sudah Diambil',
                            'Waiting_Pickup' => 'Menunggu Penjemputan/Penyelesaian',
                        ];
                    @endphp
                    <span class="text-[10px] font-black px-3 py-1.5 rounded-lg border {{ $statusColors[$booking->status] }} uppercase tracking-widest">
                         {{ $statusLabels[$booking->status] ?? $booking->status }}
                    </span>
                </div>
                <h3 class="text-2xl font-black text-slate-900 mb-1 truncate">{{ $booking->vehicle->name }}</h3>
                <p class="text-slate-400 font-bold text-xs uppercase tracking-widest mb-6">{{ $booking->vehicle->type }} • {{ $booking->vehicle->transmission }}</p>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Mulai</p>
                        <p class="font-bold text-slate-900 text-sm italic">{{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Selesai</p>
                        <p class="font-bold text-slate-900 text-sm italic">{{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Durasi</p>
                        <p class="font-bold text-slate-900 text-sm">{{ $booking->days }} Hari</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total Biaya</p>
                        <p class="font-black text-blue-600 text-sm">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            {{-- Action & Payment Status --}}
            <div class="w-full md:w-1/3 flex flex-col gap-2 relative">
                @if($booking->payment_status === 'unpaid' && $booking->status === 'Confirmed')
                    <div class="bg-blue-50 border border-blue-200 p-4 rounded-xl mb-2 text-center text-sm">
                        <p class="font-bold text-blue-800 mb-2">Data Terverifikasi!</p>
                        <p class="text-blue-600 mb-3">Silakan bayar DP 30%: <strong>Rp {{ number_format($booking->total_price * 0.3, 0, ',', '.') }}</strong></p>
                        <form action="{{ route('booking.pay', $booking->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="payment_type" value="dp">
                            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg text-xs transition">Bayar DP 30%</button>
                        </form>
                    </div>
                @elseif($booking->payment_status === 'dp_paid' && $booking->status === 'Confirmed')
                    <div class="bg-orange-50 border border-orange-200 p-4 rounded-xl mb-2 text-center text-sm">
                        <p class="font-bold text-orange-800 mb-2">DP Terbayar</p>
                        <p class="text-orange-600 mb-3">Sisa pelunasan: <strong>Rp {{ number_format($booking->total_price * 0.7, 0, ',', '.') }}</strong></p>
                        <form action="{{ route('booking.pay', $booking->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="payment_type" value="full">
                            <button class="w-full bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded-lg text-xs transition">Lunasi Sekarang</button>
                        </form>
                    </div>
                @elseif($booking->status === 'Confirmed' && $booking->payment_status === 'fully_paid')
                    <div class="bg-green-50 border border-green-200 p-4 rounded-xl mb-2 text-center text-sm">
                        <p class="font-bold text-green-800">Lunas</p>
                        <p class="text-green-600 text-xs">Menunggu serah terima mobil</p>
                    </div>
                @elseif($booking->status === 'On_Delivery')
                    <div class="bg-sky-50 border border-sky-200 p-4 rounded-xl mb-2 text-center text-sm">
                        <p class="font-bold text-sky-800">Mobil Diantar</p>
                        <p class="text-sky-600 text-xs mb-3">Sopir kami sedang menuju lokasi Anda</p>
                        <form action="{{ route('booking.status.update', $booking->id) }}" method="POST">
                            @csrf @method('PUT')
                            <input type="hidden" name="status" value="Active">
                            <button class="w-full bg-sky-600 hover:bg-sky-700 text-white font-bold py-2 px-4 rounded-lg text-xs transition">Konfirmasi Mobil Sampai</button>
                        </form>
                    </div>
                @elseif($booking->status === 'Picked_Up')
                    <div class="bg-indigo-50 border border-indigo-200 p-4 rounded-xl mb-2 text-center text-sm">
                        <p class="font-bold text-indigo-800">Mobil Siap</p>
                        <p class="text-indigo-600 text-xs mb-3">Admin menyatakan mobil sudah diambil</p>
                        <form action="{{ route('booking.status.update', $booking->id) }}" method="POST">
                            @csrf @method('PUT')
                            <input type="hidden" name="status" value="Active">
                            <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg text-xs transition">Saya Setuju (Pakai Mobil)</button>
                        </form>
                    </div>
                @elseif($booking->status === 'Active')
                    <div class="bg-indigo-50 border border-indigo-200 p-4 rounded-xl mb-2 text-center text-sm">
                        <p class="font-bold text-indigo-800">Masa Sewa</p>
                        <p class="text-indigo-600 text-xs mb-3">Mobil sedang Anda gunakan</p>
                        @if($booking->delivery_type === 'delivery')
                            <form action="{{ route('booking.status.update', $booking->id) }}" method="POST">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="Waiting_Pickup">
                                <button class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg text-xs transition">Minta Penjemputan Mobil</button>
                            </form>
                        @else
                            <form action="{{ route('booking.status.update', $booking->id) }}" method="POST">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="Waiting_Pickup">
                                <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg text-xs transition">Konfirmasi Mobil Dikembalikan</button>
                            </form>
                        @endif
                    </div>
                @elseif($booking->status === 'Waiting_Pickup')
                    <div class="bg-yellow-50 border border-yellow-200 p-4 rounded-xl mb-2 text-center text-sm">
                        <p class="font-bold text-yellow-800">Proses Akhir</p>
                        <p class="text-yellow-600 text-xs">Menunggu konfirmasi admin untuk menyelesaikan sewa</p>
                    </div>
                @elseif($booking->status === 'Completed')
                    <div class="bg-slate-50 border border-slate-200 p-4 rounded-xl mb-2 text-center text-sm">
                        <p class="font-bold text-slate-800">Selesai</p>
                        <p class="text-slate-600 text-xs mb-3">Mobil telah dikembalikan</p>
                        
                        @if(!$booking->rating)
                            <button type="button" onclick="openReviewModal({{ $booking->id }})" class="w-full bg-yellow-400 hover:bg-yellow-500 text-yellow-900 font-bold py-2 px-4 rounded-lg text-xs transition mb-2">Beri Ulasan</button>
                        @else
                            <div class="flex gap-1 justify-center text-yellow-400 mb-3 text-xs">
                                @for($i=1; $i<=5; $i++)
                                    <i class="fas fa-star {{ $i <= $booking->rating ? '' : 'text-slate-300' }}"></i>
                                @endfor
                            </div>
                        @endif
                        
                        <a href="{{ route('vehicle.detail', $booking->vehicle_id) }}" class="block w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-2 px-4 rounded-lg text-xs transition">Sewa Kembali</a>
                    </div>
                @elseif($booking->status === 'Rejected')
                    <div class="bg-red-50 border border-red-200 p-4 rounded-xl mb-2 text-center text-sm">
                        <p class="font-bold text-red-800">Ditolak</p>
                        @if($booking->rejection_reason)
                            <p class="text-red-600 text-xs mt-1 mb-3">Alasan: <strong>{{ $booking->rejection_reason }}</strong></p>
                        @else
                            <p class="text-red-600 text-xs mb-3">Pesanan ditolak oleh admin</p>
                        @endif
                        <a href="{{ route('vehicle.detail', $booking->vehicle_id) }}" class="block w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-2 px-4 rounded-lg text-xs transition">Sewa Kembali</a>
                    </div>
                @endif
                
                @if($booking->status === 'Pending')
                <p class="text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2">Menunggu Admin Verifikasi KTP & SIM...</p>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

{{-- Modal Ulasan --}}
<div id="modal-review" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeReviewModal()"></div>
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md z-10 overflow-hidden text-center p-8">
        <h3 class="text-xl font-black text-slate-900 mb-2">Beri Ulasan</h3>
        <p class="text-slate-500 text-sm mb-6">Bagaimana pengalaman Anda menyewa mobil ini?</p>
        
        <form id="form-review" action="" method="POST">
            @csrf
            
            <div class="flex justify-center gap-2 mb-4">
                <input type="hidden" name="rating" id="rating-val" value="5" required>
                @for($i=1; $i<=5; $i++)
                <button type="button" onclick="setRating({{ $i }})" class="star-btn text-2xl text-yellow-400 focus:outline-none transition-transform hover:scale-110" data-val="{{ $i }}">
                    <i class="fas fa-star"></i>
                </button>
                @endfor
            </div>
            
            <textarea name="review" rows="3" class="w-full bg-slate-50 text-slate-900 border border-slate-200 rounded-xl p-4 text-sm focus:outline-none focus:border-yellow-500 mb-6" placeholder="Ketik pengalaman Anda di sini (opsional)..."></textarea>
            
            <div class="flex gap-3">
                <button type="button" onclick="closeReviewModal()" class="flex-1 font-semibold py-3 rounded-xl transition-all text-sm border border-slate-200 text-slate-600 hover:bg-slate-50">Batal</button>
                <button type="submit" class="flex-1 bg-yellow-400 hover:bg-yellow-500 text-yellow-900 font-bold py-3 rounded-xl transition-all active:scale-95 text-sm">Kirim Ulasan</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openReviewModal(id) {
        document.getElementById('form-review').action = `/pesan/${id}/review`;
        document.getElementById('modal-review').classList.remove('hidden');
        setRating(5);
    }
    function closeReviewModal() {
        document.getElementById('modal-review').classList.add('hidden');
    }
    function setRating(val) {
        document.getElementById('rating-val').value = val;
        document.querySelectorAll('.star-btn').forEach(btn => {
            if (parseInt(btn.dataset.val) <= val) {
                btn.classList.add('text-yellow-400');
                btn.classList.remove('text-slate-200');
            } else {
                btn.classList.remove('text-yellow-400');
                btn.classList.add('text-slate-200');
            }
        });
    }
</script>
@endpush
