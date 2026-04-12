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
                            'On_Pickup' => 'bg-blue-900 text-white border-slate-800',
                            'Picked_Up' => 'bg-indigo-100 text-indigo-600 border-indigo-200',
                            'Active' => 'bg-indigo-100 text-indigo-600 border-indigo-200',
                            'Waiting_Pickup' => 'bg-yellow-100 text-yellow-600 border-yellow-200',
                            'Returning' => 'bg-indigo-100 text-indigo-600 border-indigo-200',
                            'Completed' => 'bg-green-100 text-green-600 border-green-200',
                            'Cancelled' => 'bg-red-100 text-red-600 border-red-200',
                            'Rejected' => 'bg-slate-100 text-slate-600 border-slate-200',
                        ];
                        $statusLabels = [
                            'On_Delivery' => 'Sedang Diantar',
                            'On_Pickup' => 'Sopir Menuju Lokasi',
                            'Picked_Up' => 'Sudah Diambil',
                            'Waiting_Pickup' => 'Menunggu Penjemputan',
                            'Returning' => 'Menunggu Pengembalian',
                        ];
                    @endphp
                    <span class="text-[10px] font-black px-3 py-1.5 rounded-lg border {{ $statusColors[$booking->status] }} uppercase tracking-widest">
                         {{ $statusLabels[$booking->status] ?? $booking->status }}
                    </span>
                    @if($booking->with_driver)
                        <span class="text-[10px] font-black px-3 py-1.5 rounded-lg bg-teal-100 text-teal-700 border border-teal-200 uppercase tracking-widest" title="Driver: {{ $booking->driver->name ?? 'Ditempatkan Otomatis' }}">
                            <i class="fas fa-user-tie mr-1"></i> {{ $booking->driver->name ?? 'Dengan Sopir' }}
                        </span>
                    @endif
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
            {{-- Action & Payment Status --}}
            <div class="w-full md:w-1/3 flex flex-col gap-2 relative">
                {{-- 1. PEMBAYARAN (Pending/Confirmed but not paid) --}}
                @if($booking->status === 'Pending' && $booking->with_driver && $booking->payment_status === 'unpaid')
                     <div class="mt-0 p-5 bg-slate-50 border border-slate-200 rounded-2xl">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Sopir Disediakan - Lanjut Bayar DP (30%)</p>
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-xs font-bold text-slate-600">Total DP:</span>
                            <span class="text-lg font-black text-blue-600">Rp {{ number_format($booking->total_price * 0.3, 0, ',', '.') }}</span>
                        </div>
                        <button type="button" onclick="payWithMidtrans('{{ $booking->id }}', 'dp')" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-black py-2.5 rounded-xl text-xs transition relative">
                            BAYAR DP
                            <div id="loader-{{ $booking->id }}-dp-alt" class="hidden absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                        </button>
                        <form id="payment-form-{{ $booking->id }}-dp" action="{{ route('booking.pay', $booking->id) }}" method="POST" class="hidden">
                            @csrf
                            <input type="hidden" name="payment_type" value="dp">
                        </form>
                    </div>
                @elseif($booking->payment_status === 'unpaid' && $booking->status === 'Confirmed')
                    <div class="bg-blue-50 border border-blue-200 p-4 rounded-xl mb-2 text-center text-sm">
                        <p class="font-bold text-blue-800 mb-2">Data Terverifikasi!</p>
                        <p class="text-blue-600 mb-3">Silakan bayar DP 30%: <strong>Rp {{ number_format($booking->total_price * 0.3, 0, ',', '.') }}</strong></p>
                        <button type="button" onclick="payWithMidtrans('{{ $booking->id }}', 'dp')" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg text-xs transition relative">
                            Bayar DP 30%
                            <div id="loader-{{ $booking->id }}-dp" class="hidden absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                        </button>
                        <form id="payment-form-{{ $booking->id }}-dp" action="{{ route('booking.pay', $booking->id) }}" method="POST" class="hidden">
                            @csrf
                            <input type="hidden" name="payment_type" value="dp">
                        </form>
                    </div>

                {{-- 2. STATUS TRANSITIONS --}}
                @elseif($booking->status === 'Confirmed')
                    @if($booking->payment_status === 'dp_paid')
                        <div class="bg-blue-50 border border-blue-200 p-4 rounded-xl mb-2 text-center text-sm">
                            <p class="font-bold text-blue-800 mb-2">DP Terverifikasi!</p>
                            <p class="text-blue-600 mb-3">Silakan lunasi sisa pembayaran (70%): <strong>Rp {{ number_format($booking->total_price * 0.7, 0, ',', '.') }}</strong></p>
                            <button type="button" onclick="payWithMidtrans('{{ $booking->id }}', 'full')" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg text-xs transition relative">
                                BAYAR PELUNASAN
                                <div id="loader-{{ $booking->id }}-full" class="hidden absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                            </button>
                            <form id="payment-form-{{ $booking->id }}-full" action="{{ route('booking.pay', $booking->id) }}" method="POST" class="hidden">
                                @csrf
                                <input type="hidden" name="payment_type" value="full">
                            </form>
                        </div>
                    @else
                        <div class="bg-blue-50 border border-blue-200 p-4 rounded-xl mb-2 text-center text-sm">
                            <p class="font-bold text-blue-800">Pesanan Dikonfirmasi</p>
                            <p class="text-blue-600 text-[10px] uppercase font-black tracking-widest mt-1">Admin sedang menyiapkan armada {{ $booking->with_driver ? '& sopir' : '' }}</p>
                        </div>
                    @endif


                @elseif($booking->status === 'On_Pickup')
                    <div class="bg-yellow-50 border border-yellow-200 p-4 rounded-xl mb-2 text-center text-sm">
                        <p class="font-bold text-yellow-800">Sopir Menuju Lokasi</p>
                        <p class="text-yellow-600 text-xs mb-3">Driver sedang dalam perjalanan menjemput Anda.</p>
                        <form action="{{ route('booking.status.update', $booking->id) }}" method="POST">
                            @csrf @method('PUT')
                            <input type="hidden" name="status" value="Picked_Up">
                            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg text-xs transition">Sopir Sampai / Mulai Perjalanan</button>
                        </form>
                    </div>

                @elseif($booking->status === 'On_Delivery')
                    <div class="bg-sky-50 border border-sky-200 p-4 rounded-xl mb-2 text-center text-sm">
                        <p class="font-bold text-sky-800 text-xs mb-1 uppercase tracking-tight">Mobil Sedang Diantar</p>
                        <form action="{{ route('booking.status.update', $booking->id) }}" method="POST">
                            @csrf @method('PUT')
                            <input type="hidden" name="status" value="Active">
                            <button class="w-full bg-sky-600 hover:bg-sky-700 text-white font-bold py-2 px-4 rounded-lg text-xs transition">Konfirmasi Mobil Sampai</button>
                        </form>
                    </div>

                @elseif($booking->status === 'Picked_Up')
                    <div class="bg-green-50 border border-green-200 p-4 rounded-xl mb-2 text-center text-sm">
                        <p class="font-bold text-green-800 uppercase tracking-tight text-xs mb-1">Sudah Diambil / Perjalanan</p>
                        @if($booking->with_driver)
                            <p class="text-green-600 text-[10px] font-black uppercase tracking-widest">Semoga Perjalanan Menyenangkan</p>
                        @else
                            <form action="{{ route('booking.status.update', $booking->id) }}" method="POST">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="Active">
                                <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg text-xs transition">Saya Setuju (Pakai Mobil)</button>
                            </form>
                        @endif
                    </div>

                @elseif($booking->status === 'Active')
                    <div class="bg-indigo-50 border border-indigo-200 p-4 rounded-xl mb-2 text-center text-sm">
                        <p class="font-bold text-indigo-800">Masa Sewa Aktif</p>
                        <p class="text-indigo-600 text-[10px] font-black uppercase tracking-widest mb-3 italic">Mobil sedang dalam pemakaian</p>
                        @if($booking->delivery_type === 'delivery')
                            <form action="{{ route('booking.status.update', $booking->id) }}" method="POST">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="Waiting_Pickup">
                                <button class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg text-xs transition">Minta Penjemputan Mobil</button>
                            </form>
                        @else
                            <form action="{{ route('booking.status.update', $booking->id) }}" method="POST">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="Returning">
                                <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg text-xs transition">Konfirmasi Pengembalian</button>
                            </form>
                        @endif
                    </div>

                @elseif($booking->status === 'Waiting_Pickup' || $booking->status === 'Returning')
                    <div class="bg-yellow-50 border border-yellow-200 p-4 rounded-xl mb-2 text-center text-sm">
                        <p class="font-bold text-yellow-800 uppercase tracking-tight text-xs">Menunggu Verifikasi Admin</p>
                        <p class="text-yellow-600 text-[10px] font-black tracking-widest mt-1">Proses Pengembalian / Penjemputan</p>
                    </div>

                @elseif($booking->status === 'Completed')
                    <div class="bg-slate-50 border border-slate-200 p-4 rounded-xl mb-2 text-center text-sm">
                        <p class="font-bold text-slate-800">Transaksi Selesai</p>
                        @if(!$booking->rating)
                            <button type="button" onclick="openReviewModal({{ $booking->id }}, {{ $booking->with_driver ? 'true' : 'false' }})" class="w-full bg-yellow-400 hover:bg-yellow-500 text-yellow-900 font-bold py-2 px-4 rounded-lg text-xs transition mb-2">Beri Ulasan</button>
                        @endif
                        <a href="{{ route('vehicle.detail', $booking->vehicle_id) }}" class="block w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-2 px-4 rounded-lg text-xs transition">Sewa Lagi</a>
                    </div>
                @elseif($booking->status === 'Rejected')
                    <div class="bg-red-50 border border-red-200 p-4 rounded-xl mb-2 text-center text-sm">
                        <p class="font-bold text-red-800 uppercase tracking-tight text-xs">Pesanan Ditolak</p>
                        @if($booking->rejection_reason)
                            <p class="text-[10px] text-red-600 font-bold mt-1 max-w-[150px] mx-auto">Alasan: {{ $booking->rejection_reason }}</p>
                        @endif
                    </div>
                @endif
                
                @if($booking->status === 'Pending' && !$booking->with_driver)
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

            <div id="driver_review_section" class="hidden border-t border-slate-100 pt-6 mt-4 mb-6">
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Ulasan Driver</h4>
                <div class="flex justify-center gap-2 mb-4">
                    <input type="hidden" name="driver_rating" id="driver-rating-val" value="5">
                    @for($i=1; $i<=5; $i++)
                    <button type="button" onclick="setDriverRating({{ $i }})" class="driver-star-btn text-2xl text-yellow-400 focus:outline-none transition-transform hover:scale-110" data-val="{{ $i }}">
                        <i class="fas fa-star"></i>
                    </button>
                    @endfor
                </div>
                <textarea name="driver_review" rows="2" class="w-full bg-slate-50 text-slate-900 border border-slate-200 rounded-xl p-4 text-sm focus:outline-none focus:border-yellow-500" placeholder="Bagaimana layanan driver kami?"></textarea>
            </div>
            
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
    function openReviewModal(id, withDriver) {
        document.getElementById('form-review').action = `/pesan/${id}/review`;
        const driverSection = document.getElementById('driver_review_section');
        if (withDriver) {
            driverSection.classList.remove('hidden');
        } else {
            driverSection.classList.add('hidden');
        }
        document.getElementById('modal-review').classList.remove('hidden');
        setRating(5);
        setDriverRating(5);
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

    function setDriverRating(val) {
        document.getElementById('driver-rating-val').value = val;
        document.querySelectorAll('.driver-star-btn').forEach(btn => {
            if (parseInt(btn.dataset.val) <= val) {
                btn.classList.add('text-yellow-400');
                btn.classList.remove('text-slate-200');
            } else {
                btn.classList.remove('text-yellow-400');
                btn.classList.add('text-slate-200');
            }
        });
    }

    // Midtrans Payment Logic
    function payWithMidtrans(bookingId, paymentType) {
        const loader = document.getElementById(`loader-${bookingId}-${paymentType}`);
        if(loader) loader.classList.remove('hidden');

        fetch(`/pesan/${bookingId}/snap-token`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ payment_type: paymentType })
        })
        .then(response => response.json())
        .then(data => {
            if(loader) loader.classList.add('hidden');
            if(data.snap_token) {
                snap.pay(data.snap_token, {
                    onSuccess: function(result){
                        // Payment success, submit the hidden form logic
                        document.getElementById(`payment-form-${bookingId}-${paymentType}`).submit();
                    },
                    onPending: function(result){
                        alert("Menunggu pembayaran Anda!");
                    },
                    onError: function(result){
                        alert("Pembayaran gagal!");
                    },
                    onClose: function(){
                        alert('Anda menutup popup pembayaran sebelum menyelesaikan transaksi.');
                    }
                });
            } else {
                alert(data.error || 'Terjadi kesalahan mengambil token transaksi.');
            }
        })
        .catch(err => {
            if(loader) loader.classList.add('hidden');
            alert('Kesalahan jaringan: ' + err.message);
        });
    }
</script>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key', 'SB-Mid-client-0Ew4k_C4bI8NlCjV') }}"></script>
@endpush
