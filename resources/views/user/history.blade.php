@extends('layouts.app')
@section('title', 'Riwayat Sewa')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-28 pb-16 lg:pt-36 lg:pb-24">
    {{-- Header --}}
    <div class="mb-10">
        <h1 class="text-3xl md:text-4xl font-extrabold text-[#0A174E] tracking-tight mb-3">Pesanan Saya</h1>
        <p class="text-[#8F8F7E] text-base md:text-lg font-medium">Pantau status pemesanan dan riwayat sewa kendaraan Anda.</p>
    </div>

    @if(session('success'))
    <div class="mb-8 bg-[#F9F9F5] border border-[#EBEBDF] border-l-4 border-l-[#F5D042] text-[#0A174E] px-6 py-4 rounded-2xl flex items-center gap-4 shadow-[0_2px_15px_rgb(0,0,0,0.02)]">
        <div class="w-8 h-8 rounded-full bg-[#F5D042]/20 flex items-center justify-center flex-shrink-0 text-[#F5D042]">
            <i class="fas fa-check-circle"></i>
        </div>
        <p class="font-bold text-sm">{{ session('success') }}</p>
    </div>
    @endif

    @if($bookings->isEmpty())
    <div class="bg-white border border-[#EBEBDF] rounded-[2rem] p-12 lg:p-16 text-center shadow-[0_2px_20px_rgb(0,0,0,0.02)]">
        <div class="w-20 h-20 bg-[#F9F9F5] text-[#8F8F7E] border border-[#EBEBDF] rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-receipt text-3xl"></i>
        </div>
        <h3 class="text-2xl font-bold text-[#0A174E] mb-3">Belum ada pesanan terdaftar</h3>
        <p class="text-[#8F8F7E] text-sm mb-8 max-w-md mx-auto leading-relaxed">Anda belum pernah melakukan pemesanan kendaraan sebelumnya. Mari mulai langkah pertama Anda bersama Jatara.</p>
        <a href="{{ route('browse') }}" class="inline-flex items-center gap-2 bg-[#0A174E] hover:bg-[#F5D042] text-white hover:text-[#0A174E] font-bold px-8 py-3.5 rounded-xl transition-colors">
            Cari Kendaraan
        </a>
    </div>
    @else
    <div class="flex flex-col gap-6">
        @foreach($bookings as $booking)
        <div class="bg-white border border-[#EBEBDF] rounded-[2rem] p-6 lg:p-8 flex flex-col md:flex-row gap-8 items-start shadow-[0_2px_20px_rgb(0,0,0,0.02)] hover:border-[#F5D042]/50 hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-all duration-300 group">
            
            {{-- Image --}}
            <div class="w-full md:w-56 h-40 bg-[#F9F9F5] rounded-2xl overflow-hidden flex-shrink-0 border border-[#EBEBDF]">
                <img src="{{ $booking->vehicle->image ? (strpos($booking->vehicle->image, 'http') === 0 ? $booking->vehicle->image : asset('storage/' . $booking->vehicle->image)) : 'https://placehold.co/600x400?text=No+Image' }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="{{ $booking->vehicle->name }}">
            </div>

            {{-- Info Content --}}
            <div class="flex-1 min-w-0 w-full">
                <div class="flex flex-wrap items-center gap-3 mb-4">
                    <span class="text-[10px] font-bold px-3 py-1.5 rounded-lg bg-[#F9F9F5] border border-[#EBEBDF] text-[#8F8F7E] uppercase tracking-widest font-mono">TRX-{{ $booking->id }}</span>
                    @php
                        $statusStyles = [
                            'Pending'    => 'bg-[#F9F9F5] text-[#8F8F7E] border-[#EBEBDF]',
                            'Confirmed'  => 'bg-[#F5D042]/10 text-[#0A174E] border-[#F5D042]',
                            'Active'     => 'bg-[#0A174E] text-[#F5D042] border-[#0A174E]',
                            'Picked_Up'  => 'bg-[#0A174E] text-[#F5D042] border-[#0A174E]',
                            'Returning'  => 'bg-[#0A174E]/5 text-[#0A174E] border-[#0A174E]/20',
                            'Completed'  => 'bg-green-50 text-green-700 border-green-200',
                            'Cancelled'  => 'bg-red-50 text-red-600 border-red-200',
                            'Rejected'   => 'bg-red-50 text-red-600 border-red-200',
                        ];
                        $statusLabels = [
                            'Pending'    => 'Menunggu Verifikasi',
                            'Confirmed'  => 'Dikonfirmasi',
                            'Active'     => 'Masa Sewa Aktif',
                            'Picked_Up'  => 'Kendaraan Diambil',
                            'Returning'  => 'Menunggu Pengembalian',
                            'Completed'  => 'Selesai',
                            'Cancelled'  => 'Dibatalkan',
                            'Rejected'   => 'Ditolak',
                        ];
                    @endphp
                    <span class="text-[10px] font-bold px-3 py-1.5 rounded-lg border {{ $statusStyles[$booking->status] ?? 'bg-[#F9F9F5] text-[#8F8F7E] border-[#EBEBDF]' }} uppercase tracking-widest">
                         {{ $statusLabels[$booking->status] ?? $booking->status }}
                    </span>
                </div>
                
                <h3 class="text-xl lg:text-2xl font-bold text-[#0A174E] mb-1 truncate">{{ $booking->vehicle->name }}</h3>
                <p class="text-[#8F8F7E] font-semibold text-xs uppercase tracking-widest mb-6">{{ $booking->vehicle->type }} <span class="mx-1">•</span> {{ $booking->vehicle->transmission }}</p>

                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 bg-[#F9F9F5] p-5 rounded-2xl border border-[#EBEBDF]">
                    <div>
                        <p class="text-[10px] font-bold text-[#8F8F7E] uppercase tracking-widest mb-1">Mulai</p>
                        <p class="font-bold text-[#0A174E] text-sm">{{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-[#8F8F7E] uppercase tracking-widest mb-1">Selesai</p>
                        <p class="font-bold text-[#0A174E] text-sm">{{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-[#8F8F7E] uppercase tracking-widest mb-1">Durasi</p>
                        <p class="font-bold text-[#0A174E] text-sm">{{ $booking->days }} Hari</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-[#8F8F7E] uppercase tracking-widest mb-1">Total Biaya</p>
                        <p class="font-bold text-[#0A174E] text-sm">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            {{-- Layout Divider on Mobile --}}
            <div class="w-full h-px bg-[#EBEBDF] md:hidden"></div>

            {{-- Actions sidebar --}}
            <div class="w-full md:w-48 xl:w-56 flex flex-col gap-3 justify-center h-full pt-2 md:pt-0">
                
                {{-- Pending Status (Waiting KTP verification) --}}
                @if($booking->status === 'Pending')
                    <div class="bg-[#F9F9F5] border border-[#EBEBDF] p-4 rounded-xl text-center">
                        <i class="fas fa-clock text-[#8F8F7E] text-xl mb-2"></i>
                        <p class="text-[10px] font-bold text-[#8F8F7E] uppercase tracking-widest leading-relaxed">Menunggu Tim Verifikasi</p>
                    </div>

                {{-- Confirmed + unpaid DP --}}
                @elseif($booking->status === 'Confirmed' && $booking->payment_status === 'unpaid')
                    <div class="bg-[#F9F9F5] border border-[#EBEBDF] p-4 rounded-xl text-center shadow-sm">
                        <p class="text-[10px] font-bold text-[#8F8F7E] uppercase tracking-widest mb-2">DP 30% Dibuka</p>
                        <p class="font-bold text-[#0A174E] text-sm mb-3">Rp {{ number_format($booking->total_price * 0.3, 0, ',', '.') }}</p>
                        
                        <button type="button" onclick="payWithMidtrans('{{ $booking->id }}', 'dp')" class="w-full bg-[#0A174E] hover:bg-[#F5D042] hover:text-[#0A174E] text-white font-bold py-2.5 px-4 rounded-xl text-xs transition-colors relative flex items-center justify-center gap-2">
                            Bayar DP
                            <i class="fas fa-arrow-right"></i>
                            <div id="loader-{{ $booking->id }}-dp" class="hidden absolute right-3 w-4 h-4 border-2 border-current border-t-transparent rounded-full animate-spin"></div>
                        </button>
                        <form id="payment-form-{{ $booking->id }}-dp" action="{{ route('booking.pay', $booking->id) }}" method="POST" class="hidden">
                            @csrf <input type="hidden" name="payment_type" value="dp">
                        </form>
                    </div>

                {{-- Confirmed + DP_Paid (Needs Pelunasan) --}}
                @elseif($booking->status === 'Confirmed' && $booking->payment_status === 'dp_paid')
                    <div class="bg-[#F9F9F5] border border-[#EBEBDF] p-4 rounded-xl text-center shadow-sm">
                        <p class="text-[10px] font-bold text-[#8F8F7E] uppercase tracking-widest mb-2">Pelunasan</p>
                        <p class="font-bold text-[#0A174E] text-sm mb-3">Rp {{ number_format($booking->total_price * 0.7, 0, ',', '.') }}</p>
                        
                        <button type="button" onclick="payWithMidtrans('{{ $booking->id }}', 'full')" class="w-full bg-[#0A174E] hover:bg-[#F5D042] hover:text-[#0A174E] text-white font-bold py-2.5 px-4 rounded-xl text-xs transition-colors relative flex items-center justify-center gap-2">
                            Bayar Lunas
                            <i class="fas fa-check"></i>
                            <div id="loader-{{ $booking->id }}-full" class="hidden absolute right-3 w-4 h-4 border-2 border-current border-t-transparent rounded-full animate-spin"></div>
                        </button>
                        <form id="payment-form-{{ $booking->id }}-full" action="{{ route('booking.pay', $booking->id) }}" method="POST" class="hidden">
                            @csrf <input type="hidden" name="payment_type" value="full">
                        </form>
                    </div>

                {{-- Fully Paid --}}
                @elseif($booking->status === 'Confirmed' && $booking->payment_status === 'fully_paid')
                    <div class="bg-[#F9F9F5] border border-[#EBEBDF] p-4 rounded-xl text-center h-full flex flex-col justify-center items-center shadow-sm">
                        <div class="text-[#F5D042] mb-2 bg-white rounded-full w-8 h-8 flex items-center justify-center border border-[#EBEBDF]">
                            <i class="fas fa-check"></i>
                        </div>
                        <p class="text-[10px] font-bold text-[#0A174E] uppercase tracking-widest mb-3">Telah Lunas</p>
                        <a href="{{ route('booking.receipt', $booking->id) }}" class="inline-block w-full bg-white border border-[#EBEBDF] hover:border-[#F5D042] text-[#0A174E] font-bold py-2 rounded-lg text-xs transition-colors">
                            Lihat Tiket
                        </a>
                    </div>
                
                {{-- Active / In Use / Returning --}}
                @elseif(in_array($booking->status, ['Active', 'Picked_Up', 'Returning']))
                    <div class="bg-[#0A174E] border border-[#0A174E] p-4 rounded-xl text-center text-white h-full flex flex-col justify-center shadow-sm">
                        <i class="fas fa-key text-[#F5D042] text-xl mb-2"></i>
                        <p class="text-[10px] font-bold text-[#F9F9F5] uppercase tracking-widest leading-relaxed">
                            {{ $booking->status === 'Returning' ? 'Konfirmasi Pengembalian' : 'Sewa Aktif' }}
                        </p>
                    </div>

                {{-- Completed --}}
                @elseif($booking->status === 'Completed')
                    <div class="bg-[#F9F9F5] border border-[#EBEBDF] p-4 rounded-xl text-center flex flex-col h-full justify-center gap-2 shadow-sm">
                        @if(!$booking->rating)
                            <button type="button" onclick="openReviewModal({{ $booking->id }})" class="w-full bg-white border border-[#EBEBDF] hover:border-[#F5D042] text-[#0A174E] font-bold py-2 px-2 rounded-lg text-xs transition-colors flex items-center justify-center gap-1.5">
                                <i class="fas fa-star text-[#F5D042]"></i> Beri Ulasan
                            </button>
                        @else
                            <div class="w-full bg-white border border-[#EBEBDF] text-[#8F8F7E] font-bold py-2 px-2 rounded-lg text-[10px] uppercase flex items-center justify-center gap-1">
                                <i class="fas fa-check text-green-500"></i> Direview
                            </div>
                        @endif
                        <a href="{{ route('vehicle.detail', $booking->vehicle_id) }}" class="block w-full bg-[#0A174E] hover:bg-[#F5D042] hover:text-[#0A174E] text-white font-bold py-2 px-2 rounded-lg text-xs transition-colors">
                            Sewa Lagi
                        </a>
                    </div>

                {{-- Rejected / Cancelled --}}
                @elseif(in_array($booking->status, ['Rejected', 'Cancelled']))
                    <div class="bg-[#F9F9F5] border border-[#EBEBDF] p-4 rounded-xl text-center h-full flex flex-col justify-center shadow-sm">
                        <i class="fas fa-times-circle text-[#8F8F7E] text-xl mb-2"></i>
                        <p class="text-[10px] font-bold text-[#8F8F7E] uppercase tracking-widest">Dibatalkan</p>
                        @if($booking->rejection_reason)
                            <p class="text-[9px] mt-2 text-[#8F8F7E] font-medium border-t border-[#EBEBDF] pt-2 line-clamp-2" title="{{ $booking->rejection_reason }}">{{ $booking->rejection_reason }}</p>
                        @endif
                    </div>
                @endif
                
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

{{-- Modal Ulasan --}}
<div id="modal-review" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
    <div class="absolute inset-0 bg-[#0A174E]/40 backdrop-blur-sm transition-opacity" onclick="closeReviewModal()"></div>
    <div class="bg-white rounded-[2rem] border border-[#EBEBDF] shadow-[0_20px_60px_rgba(10,23,78,0.1)] w-full max-w-md z-10 overflow-hidden text-center p-8 relative">
        <button onclick="closeReviewModal()" class="absolute top-6 right-6 w-8 h-8 rounded-full bg-[#F9F9F5] text-[#8F8F7E] hover:text-[#0A174E] flex items-center justify-center transition-colors">
            <i class="fas fa-times"></i>
        </button>
        <div class="w-14 h-14 bg-[#F9F9F5] text-[#F5D042] rounded-full flex items-center justify-center mx-auto mb-4 border border-[#EBEBDF]">
            <i class="fas fa-star text-2xl"></i>
        </div>
        <h3 class="text-2xl font-bold text-[#0A174E] mb-2">Beri Ulasan</h3>
        <p class="text-[#8F8F7E] text-sm mb-6 font-medium">Bagaimana pengalaman Anda dengan kendaraan ini?</p>
        <form id="form-review" action="" method="POST">
            @csrf
            <div class="mb-6">
                <input type="hidden" name="rating" id="rating-val" value="5" required>
                <div class="flex justify-center gap-2">
                    @for($i=1; $i<=5; $i++)
                    <button type="button" onclick="setRating({{ $i }})" class="star-btn text-3xl text-[#F5D042] focus:outline-none transition-transform hover:scale-110" data-val="{{ $i }}">
                        <i class="fas fa-star drop-shadow-sm"></i>
                    </button>
                    @endfor
                </div>
            </div>
            <textarea name="review" rows="3" class="w-full bg-[#F9F9F5] text-[#0A174E] border border-[#EBEBDF] rounded-2xl p-4 text-sm focus:outline-none focus:border-[#F5D042] focus:ring-1 focus:ring-[#F5D042] mb-6 resize-none transition-all" placeholder="Tuliskan pengalaman Anda secara singkat..."></textarea>
            <button type="submit" class="w-full bg-[#0A174E] text-white hover:bg-[#F5D042] hover:text-[#0A174E] font-bold py-3.5 rounded-xl transition-all shadow-[0_4px_15px_rgba(10,23,78,0.2)] hover:shadow-[0_4px_15px_rgba(245,208,66,0.3)] text-sm">
                Kirim Penilaian
            </button>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openReviewModal(id) {
        document.getElementById('form-review').action = `/pesan/${id}/review`;
        const modal = document.getElementById('modal-review');
        modal.classList.remove('hidden');
        setRating(5);
    }
    function closeReviewModal() {
        document.getElementById('modal-review').classList.add('hidden');
    }
    function setRating(val) {
        document.getElementById('rating-val').value = val;
        document.querySelectorAll('.star-btn').forEach(btn => {
            if (parseInt(btn.dataset.val) <= val) {
                btn.classList.add('text-[#F5D042]'); btn.classList.remove('text-[#EBEBDF]');
            } else {
                btn.classList.remove('text-[#F5D042]'); btn.classList.add('text-[#EBEBDF]');
            }
        });
    }

    function payWithMidtrans(bookingId, paymentType) {
        const loader = document.getElementById(`loader-${bookingId}-${paymentType}`);
        if(loader) loader.classList.remove('hidden');
        fetch(`/pesan/${bookingId}/snap-token`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ payment_type: paymentType })
        })
        .then(r => r.json())
        .then(data => {
            if(loader) loader.classList.add('hidden');
            if(data.snap_token) {
                snap.pay(data.snap_token, {
                    onSuccess: () => document.getElementById(`payment-form-${bookingId}-${paymentType}`).submit(),
                    onPending: () => alert('Menunggu pembayaran Anda!'),
                    onError:   () => alert('Pembayaran gagal!'),
                    onClose:   () => alert('Pembayaran dibatalkan.'),
                });
            } else {
                alert(data.error || 'Terjadi kesalahan saat membuat kode pembayaran.');
            }
        })
        .catch(err => { if(loader) loader.classList.add('hidden'); alert('Kesalahan jaringan koneksi.'); });
    }
</script>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key', 'SB-Mid-client-0Ew4k_C4bI8NlCjV') }}"></script>
@endpush