@extends('layouts.app')

@section('title', 'Cara Kerja RentDrive')

@section('content')

{{-- Hero --}}
<section class="bg-gradient-to-br from-blue-900 to-blue-700 text-white py-20 text-center">
    <div class="max-w-3xl mx-auto px-6">
        <span class="inline-block bg-white/15 border border-white/20 text-blue-100 text-xs font-semibold px-4 py-2 rounded-full mb-5">Mudah & Cepat</span>
        <h1 class="text-4xl font-black">Cara Sewa Kendaraan<br><span class="text-blue-200">di RentDrive</span></h1>
        <p class="text-blue-100 mt-4 text-lg">Proses pemesanan yang simpel, transparan, dan dapat dilakukan dari mana saja.</p>
    </div>
</section>

{{-- Steps --}}
<section class="max-w-5xl mx-auto px-4 sm:px-6 py-20">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @php
        $steps = [
            ['num'=>'01','icon'=>'fas fa-search','title'=>'Pilih Kendaraan','color'=>'bg-blue-100 text-blue-600','desc'=>'Jelajahi ratusan pilihan kendaraan. Filter sesuai kebutuhan — jenis, kapasitas, harga, dan tanggal ketersediaan.'],
            ['num'=>'02','icon'=>'fas fa-calendar-alt','title'=>'Tentukan Jadwal','color'=>'bg-purple-100 text-purple-600','desc'=>'Pilih tanggal mulai dan selesai penyewaan. Sistem kami akan otomatis menghitung total biaya secara transparan.'],
            ['num'=>'03','icon'=>'fas fa-id-card','title'=>'Isi Data & Verifikasi','color'=>'bg-orange-100 text-orange-600','desc'=>'Unggah KTP dan SIM Anda. Proses verifikasi kami cepat — biasanya hanya butuh 15 menit.'],
            ['num'=>'04','icon'=>'fas fa-credit-card','title'=>'Pembayaran Aman','color'=>'bg-green-100 text-green-600','desc'=>'Bayar via Transfer Bank, QRIS, atau dompet digital (GoPay, OVO, Dana). Bukti pembayaran langsung dikirim ke email.'],
            ['num'=>'05','icon'=>'fas fa-car','title'=>'Terima Kendaraan','color'=>'bg-red-100 text-red-600','desc'=>'Kendaraan siap diambil di lokasi kami atau kami antar ke lokasi Anda (layanan antar tersedia di kota tertentu).'],
            ['num'=>'06','icon'=>'fas fa-undo','title'=>'Pengembalian','color'=>'bg-slate-100 text-slate-600','desc'=>'Kembalikan kendaraan sesuai jadwal. Jika ada perpanjangan, hubungi kami minimal 2 jam sebelum waktu habis.'],
        ];
        @endphp
        @foreach($steps as $step)
        <div class="flex gap-5 p-6 bg-white border border-slate-100 rounded-2xl shadow-sm hover:shadow-md transition-shadow group">
            <div class="flex-shrink-0">
                <div class="w-14 h-14 {{ $step['color'] }} rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="{{ $step['icon'] }} text-xl"></i>
                </div>
            </div>
            <div>
                <span class="text-xs font-black text-slate-300 uppercase tracking-widest">Langkah {{ $step['num'] }}</span>
                <h3 class="font-bold text-slate-900 mt-1 mb-2">{{ $step['title'] }}</h3>
                <p class="text-slate-500 text-sm leading-relaxed">{{ $step['desc'] }}</p>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- FAQ --}}
<section class="bg-slate-50 py-20">
    <div class="max-w-3xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-black text-slate-900">Pertanyaan <span class="text-blue-600">Umum</span></h2>
        </div>
        @php
        $faqs = [
            ['q'=>'Apakah saya butuh kartu kredit untuk menyewa?','a'=>'Tidak. Kami menerima berbagai metode pembayaran termasuk transfer bank dan dompet digital. Tidak ada keharusan menggunakan kartu kredit.'],
            ['q'=>'Berapa batas minimal penyewaan?','a'=>'Minimal penyewaan adalah 1x24 jam. Untuk motor, kami juga menyediakan opsi sewa harian (6-12 jam) dengan tarif khusus.'],
            ['q'=>'Apakah harga sudah termasuk BBM?','a'=>'Harga yang tertera belum termasuk BBM. Pengisian bahan bakar menjadi tanggung jawab penyewa. Kendaraan diserahkan dengan posisi bensin penuh.'],
            ['q'=>'Apa yang terjadi jika kendaraan bermasalah di jalan?','a'=>'Hubungi nomor darurat kami yang beroperasi 24/7. Tim kami akan segera membantu, baik dengan perbaikan di tempat maupun penggantian unit.'],
            ['q'=>'Bisakah saya membatalkan pemesanan?','a'=>'Pembatalan lebih dari 24 jam sebelum jadwal sewa mendapat pengembalian dana 100%. Pembatalan kurang dari 24 jam dikenakan biaya 50% dari total sewa.'],
        ];
        @endphp
        <div class="space-y-3" id="faq-container">
            @foreach($faqs as $i => $faq)
            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
                <button class="faq-toggle w-full flex justify-between items-center p-5 text-left hover:bg-slate-50 transition-colors" data-index="{{ $i }}">
                    <span class="font-semibold text-slate-800 pr-4">{{ $faq['q'] }}</span>
                    <i class="fas fa-plus text-blue-500 flex-shrink-0 transition-transform"></i>
                </button>
                <div class="faq-answer hidden px-5 pb-5">
                    <p class="text-slate-500 text-sm leading-relaxed">{{ $faq['a'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="max-w-4xl mx-auto px-4 sm:px-6 py-20 text-center">
    <h2 class="text-3xl font-black text-slate-900 mb-4">Siap Mulai?</h2>
    <p class="text-slate-500 mb-8">Temukan kendaraan impian Anda dan mulai perjalanan sekarang.</p>
    <a href="{{ route('browse') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold px-10 py-4 rounded-2xl transition-all active:scale-95 shadow-lg shadow-blue-200 text-lg">
        <i class="fas fa-car mr-2"></i>Lihat Armada Sekarang
    </a>
</section>

@endsection

@push('scripts')
<script>
    // FAQ accordion
    document.querySelectorAll('.faq-toggle').forEach(btn => {
        btn.addEventListener('click', function() {
            const answer = this.nextElementSibling;
            const icon = this.querySelector('i');
            const isOpen = !answer.classList.contains('hidden');

            // Close all
            document.querySelectorAll('.faq-answer').forEach(a => a.classList.add('hidden'));
            document.querySelectorAll('.faq-toggle i').forEach(i => {
                i.classList.remove('fa-minus', 'rotate-45');
                i.classList.add('fa-plus');
            });

            if (!isOpen) {
                answer.classList.remove('hidden');
                icon.classList.remove('fa-plus');
                icon.classList.add('fa-minus');
            }
        });
    });
</script>
@endpush
