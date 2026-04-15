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
                            'Pending'    => 'bg-orange-100 text-orange-600 border-orange-200',
                            'Confirmed'  => 'bg-blue-100 text-blue-600 border-blue-200',
                            'Active'     => 'bg-indigo-100 text-indigo-600 border-indigo-200',
                            'Picked_Up'  => 'bg-indigo-100 text-indigo-600 border-indigo-200',
                            'Returning'  => 'bg-indigo-100 text-indigo-600 border-indigo-200',
                            'Completed'  => 'bg-green-100 text-green-600 border-green-200',
                            'Cancelled'  => 'bg-red-100 text-red-600 border-red-200',
                            'Rejected'   => 'bg-slate-100 text-slate-600 border-slate-200',
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
                    <span class="text-[10px] font-black px-3 py-1.5 rounded-lg border {{ $statusColors[$booking->status] ?? 'bg-slate-100 text-slate-600 border-slate-200' }} uppercase tracking-widest">
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

                {{-- Pending: Menunggu Verifikasi --}}
                @if($booking->status === 'Pending')
                    <p class="text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2">Menunggu Admin Verifikasi KTP & SIM...</p>

                {{-- Confirmed + unpaid: bayar DP --}}
                @elseif($booking->status === 'Confirmed' && $booking->payment_status === 'unpaid')
                    <div class="bg-blue-50 border border-blue-200 p-4 rounded-xl text-center text-sm">
                        <p class="font-bold text-blue-800 mb-2">Data Terverifikasi!</p>
                        <p class="text-blue-600 mb-3">Silakan bayar DP 30%: <strong>Rp {{ number_format($booking->total_price * 0.3, 0, ',', '.') }}</strong></p>
                        <button type="button" onclick="payWithMidtrans('{{ $booking->id }}', 'dp')" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg text-xs transition relative">
                            Bayar DP 30%
                            <div id="loader-{{ $booking->id }}-dp" class="hidden absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                        </button>
                        <form id="payment-form-{{ $booking->id }}-dp" action="{{ route('booking.pay', $booking->id) }}" method="POST" class="hidden">
                            @csrf <input type="hidden" name="payment_type" value="dp">
                        </form>
                    </div>

                {{-- Confirmed + dp_paid: bayar pelunasan --}}
                @elseif($booking->status === 'Confirmed' && $booking->payment_status === 'dp_paid')
                    <div class="bg-blue-50 border border-blue-200 p-4 rounded-xl text-center text-sm">
                        <p class="font-bold text-blue-800 mb-2">DP Terverifikasi!</p>
                        <p class="text-blue-600 mb-3">Silakan lunasi sisa (70%): <strong>Rp {{ number_format($booking->total_price * 0.7, 0, ',', '.') }}</strong></p>
                        <button type="button" onclick="payWithMidtrans('{{ $booking->id }}', 'full')" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg text-xs transition relative">
                            Bayar Pelunasan
                            <div id="loader-{{ $booking->id }}-full" class="hidden absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                        </button>
                        <form id="payment-form-{{ $booking->id }}-full" action="{{ route('booking.pay', $booking->id) }}" method="POST" class="hidden">
                            @csrf <input type="hidden" name="payment_type" value="full">
                        </form>
                    </div>

                {{-- Confirmed + fully_paid: siap diambil --}}
                @elseif($booking->status === 'Confirmed' && $booking->payment_status === 'fully_paid')
                    <div class="bg-green-50 border border-green-200 p-4 rounded-xl text-center text-sm">
                        <p class="font-bold text-green-800 mb-1">Pembayaran Lunas!</p>
                        <p class="text-green-600 text-[10px] uppercase font-black tracking-widest mb-3">Silakan ambil kendaraan di pool</p>
                        <a href="{{ route('booking.receipt', $booking->id) }}" class="inline-block w-full bg-green-600 hover:bg-green-700 text-white font-black py-2.5 rounded-xl text-[10px] transition uppercase tracking-widest">
                            <i class="fas fa-file-invoice mr-1"></i> Lihat Bukti Pesanan
                        </a>
                    </div>

                {{-- Active/Picked_Up: masa sewa berjalan --}}
                @elseif(in_array($booking->status, ['Active', 'Picked_Up']))
                    @php $isExpired = \Carbon\Carbon::today()->gte(\Carbon\Carbon::parse($booking->end_date)); @endphp
                    <div class="{{ $isExpired ? 'bg-red-50 border-red-200' : 'bg-indigo-50 border-indigo-200' }} border p-4 rounded-xl text-center text-sm">
                        <p class="font-bold {{ $isExpired ? 'text-red-800' : 'text-indigo-800' }} uppercase tracking-tight text-xs mb-1">
                            {{ $isExpired ? 'Waktu Sewa Habis' : 'Masa Sewa Aktif' }}
                        </p>
                        <p class="{{ $isExpired ? 'text-red-600' : 'text-indigo-600' }} text-[10px] font-black uppercase tracking-widest italic">
                            {{ $isExpired ? 'Harap kembalikan kendaraan' : 'Mobil sedang dalam pemakaian' }}
                        </p>
                    </div>

                {{-- Returning --}}
                @elseif($booking->status === 'Returning')
                    <div class="bg-yellow-50 border border-yellow-200 p-4 rounded-xl text-center text-sm">
                        <p class="font-bold text-yellow-800 uppercase tracking-tight text-xs">Menunggu Verifikasi Admin</p>
                        <p class="text-yellow-600 text-[10px] font-black tracking-widest mt-1">Proses Pengembalian Kendaraan</p>
                    </div>

                {{-- Completed --}}
                @elseif($booking->status === 'Completed')
                    <div class="bg-slate-50 border border-slate-200 p-4 rounded-xl text-center text-sm">
                        <p class="font-bold text-slate-800 mb-2">Transaksi Selesai</p>
                        @if(!$booking->rating)
                            <button type="button" onclick="openReviewModal({{ $booking->id }})" class="w-full bg-yellow-400 hover:bg-yellow-500 text-yellow-900 font-bold py-2 px-4 rounded-lg text-xs transition mb-2">Beri Ulasan</button>
                        @endif
                        <a href="{{ route('vehicle.detail', $booking->vehicle_id) }}" class="block w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-2 px-4 rounded-lg text-xs transition">Sewa Lagi</a>
                    </div>

                {{-- Rejected --}}
                @elseif($booking->status === 'Rejected')
                    <div class="bg-red-50 border border-red-200 p-4 rounded-xl text-center text-sm">
                        <p class="font-bold text-red-800 uppercase tracking-tight text-xs">Pesanan Ditolak</p>
                        @if($booking->rejection_reason)
                            <p class="text-[10px] text-red-600 font-bold mt-1">Alasan: {{ $booking->rejection_reason }}</p>
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
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeReviewModal()"></div>
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md z-10 overflow-hidden text-center p-8">
        <h3 class="text-xl font-black text-slate-900 mb-2">Beri Ulasan</h3>
        <p class="text-slate-500 text-sm mb-6">Bagaimana pengalaman Anda menyewa mobil ini?</p>
        <form id="form-review" action="" method="POST">
            @csrf
            <div class="mb-4">
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Rating Mobil</h4>
                <div class="flex justify-center gap-2">
                    <input type="hidden" name="rating" id="rating-val" value="5" required>
                    @for($i=1; $i<=5; $i++)
                    <button type="button" onclick="setRating({{ $i }})" class="star-btn text-2xl text-yellow-400 focus:outline-none transition-transform hover:scale-110" data-val="{{ $i }}">
                        <i class="fas fa-star"></i>
                    </button>
                    @endfor
                </div>
            </div>
            <textarea name="review" rows="2" class="w-full bg-slate-50 text-slate-900 border border-slate-200 rounded-xl p-4 text-sm focus:outline-none focus:border-yellow-500 mb-4" placeholder="Ketik pengalaman Anda di sini (opsional)..."></textarea>
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
                btn.classList.add('text-yellow-400'); btn.classList.remove('text-slate-200');
            } else {
                btn.classList.remove('text-yellow-400'); btn.classList.add('text-slate-200');
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
                    onClose:   () => alert('Anda menutup popup sebelum menyelesaikan transaksi.'),
                });
            } else {
                alert(data.error || 'Terjadi kesalahan mengambil token transaksi.');
            }
        })
        .catch(err => { if(loader) loader.classList.add('hidden'); alert('Kesalahan jaringan: ' + err.message); });
    }
</script>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key', 'SB-Mid-client-0Ew4k_C4bI8NlCjV') }}"></script>
@endpush
