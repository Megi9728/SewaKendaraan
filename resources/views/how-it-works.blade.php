@extends('layouts.app')

@section('title', 'Tentang RentDrive')

@section('content')

{{-- Uber-style Hero --}}
<section class="bg-uber-white py-20 border-b border-gray-100">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <h1 class="text-5xl md:text-7xl font-bold text-uber-black tracking-tighter mb-6">
            Cara Sewa di RentDrive.
        </h1>
        <p class="text-xl text-uber-text font-medium leading-relaxed max-w-2xl mx-auto">
            Proses simpel yang didesain untuk kenyamanan perjalanan Anda. Mulai dari layar ponsel hingga unit di depan pintu.
        </p>
    </div>
</section>

{{-- Steps Section (Uber list style) --}}
<section class="max-w-4xl mx-auto px-6 py-24">
    <div class="space-y-20">
        @php
        $steps = [
            ['num'=>'1','title'=>'Pilih Unit Anda','desc'=>'Jelajahi beragam pilihan mobil dan motor. Gunakan filter wilayah untuk menemukan unit terdekat dengan lokasi penjemputan Anda.'],
            ['num'=>'2','title'=>'Atur Waktu Perjalanan','desc'=>'Pilih tanggal pengambilan dan pengembalian. Sistem kami akan langsung menghitung estimasi biaya secara transparan tanpa biaya tersembunyi.'],
            ['num'=>'3','title'=>'Lengkapi Data Diri','desc'=>'Unggah identitas Anda (KTP/SIM) untuk proses verifikasi kilat. Keamanan identitas Anda adalah prioritas utama kami.'],
            ['num'=>'4','title'=>'Lakukan Pembayaran','desc'=>'Pilih metode favorit Anda: Transfer, QRIS, atau E-wallet. Konfirmasi instan akan dikirimkan langsung ke akun Anda.'],
            ['num'=>'5','title'=>'Ambil & Mulai Jalan','desc'=>'Datang ke lokasi atau gunakan layanan antar (opsional). Cek kondisi fisik unit bersama petugas, dan Anda siap berkendara.'],
        ];
        @endphp
        
        @foreach($steps as $step)
        <div class="flex flex-col md:flex-row gap-10 items-start">
            <div class="flex-shrink-0 w-16 h-16 bg-uber-black text-uber-white rounded-full flex items-center justify-center text-2xl font-bold shadow-lg">
                {{ $step['num'] }}
            </div>
            <div class="flex-1">
                <h3 class="text-3xl font-bold text-uber-black mb-4">{{ $step['title'] }}</h3>
                <p class="text-lg text-uber-text leading-relaxed font-medium">{{ $step['desc'] }}</p>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- FAQ Section (Uber Minimalist) --}}
<section class="bg-uber-chip py-24">
    <div class="max-w-3xl mx-auto px-6">
        <h2 class="text-4xl font-bold text-uber-black mb-12 tracking-tight text-center">Pertanyaan Umum.</h2>
        
        <div class="space-y-4">
            @php
            $faqs = [
                ['q'=>'Apa syarat utama menyewa?','a'=>'Anda wajib memiliki KTP aktif dan SIM sesuai jenis kendaraan (A untuk mobil, C untuk motor).'],
                ['q'=>'Apakah biaya sewa sudah termasuk bensin?','a'=>'Biaya sewa belum termasuk BBM. Kami menyerahkan unit dalam kondisi penuh, dan harap dikembalikan dalam kondisi penuh pula.'],
                ['q'=>'Berapa lama proses verifikasinya?','a'=>'Proses verifikasi identitas biasanya memakan waktu 15-30 menit pada jam operasional (08.00 - 20.00).'],
                ['q'=>'Bagaimana jika terjadi kerusakan?','a'=>'Setiap unit dilengkapi asuransi dasar. Namun, penyewa tetap bertanggung jawab atas biaya risiko sendiri (excess fee) sesuai ketentuan.'],
            ];
            @endphp
            
            @foreach($faqs as $i => $faq)
            <div class="bg-uber-white border border-gray-100 rounded-lg overflow-hidden transition-all duration-300">
                <button class="faq-toggle w-full flex justify-between items-center p-6 text-left hover:bg-gray-50 focus:outline-none" data-index="{{ $i }}">
                    <span class="text-lg font-bold text-uber-black">{{ $faq['q'] }}</span>
                    <i class="fas fa-chevron-down text-uber-muted transition-transform"></i>
                </button>
                <div class="faq-answer hidden px-6 pb-8">
                    <p class="text-uber-text font-medium leading-relaxed">{{ $faq['a'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Bottom CTA --}}
<section class="py-24 text-center">
    <h2 class="text-4xl font-bold text-uber-black mb-10">Sudah Paham Caranya?</h2>
    <a href="{{ route('browse') }}" class="btn-primary px-12 py-5 text-lg font-bold shadow-uber">
        Lihat Semua Armada
    </a>
</section>

@endsection

@push('scripts')
<script>
    document.querySelectorAll('.faq-toggle').forEach(btn => {
        btn.addEventListener('click', function() {
            const answer = this.nextElementSibling;
            const icon = this.querySelector('i');
            const isOpen = !answer.classList.contains('hidden');

            // Toggle logic
            answer.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        });
    });
</script>
@endpush
