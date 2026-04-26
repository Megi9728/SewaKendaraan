@extends('layouts.app')
@section('title', 'Pusat Bantuan')
@section('content')
<div class="pt-28 pb-16 lg:pt-36 lg:pb-24 bg-[#F9F9F5]">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold text-[#0A174E] tracking-tight mb-6">Pusat Bantuan</h1>
        <p class="text-lg text-[#8F8F7E] font-medium mb-10 max-w-2xl mx-auto">Temukan jawaban cepat atas pertanyaan Anda tentang penyewaan, akun, serta panduan menggunakan layanan kami.</p>
        <div class="relative max-w-2xl mx-auto">
            <i class="fas fa-search absolute left-6 top-1/2 -translate-y-1/2 text-[#8F8F7E] text-lg"></i>
            <input type="text" placeholder="Ketik kata kunci masalah Anda..." class="w-full bg-white border border-[#EBEBDF] text-[#0A174E] text-base font-medium pl-14 pr-6 py-4 rounded-2xl focus:outline-none focus:border-[#F5D042] focus:ring-1 focus:ring-[#F5D042] transition-all shadow-[0_2px_15px_rgb(0,0,0,0.02)]">
        </div>
    </div>
</div>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
    <div class="text-center mb-12">
        <h2 class="text-2xl md:text-3xl font-bold text-[#0A174E]">Kategori Terpopuler</h2>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
        @php
        $categories = [
            ['id'=>'cat-booking', 'icon'=>'fas fa-truck-loading','title'=>'Pemesanan','desc'=>'Cara booking unit, durasi sewa, dan asuransi kendaraan.'],
            ['id'=>'cat-account', 'icon'=>'fas fa-id-card','title'=>'Akun & Identitas','desc'=>'Kelola profil, verifikasi KTP/SIM, dan keamanan data.'],
            ['id'=>'cat-payment', 'icon'=>'fas fa-wallet','title'=>'Pembayaran','desc'=>'Metode pembayaran (Transfer/E-Wallet), DP, & pengembalian.'],
            ['id'=>'cat-refund',  'icon'=>'fas fa-redo','title'=>'Pembatalan & Refund','desc'=>'Kebijakan pembatalan jadwal, denda, dan proses refund.'],
            ['id'=>'cat-pickup',  'icon'=>'fas fa-key','title'=>'Pengambilan Unit','desc'=>'Lokasi pool Jatara, jam operasional, & proses serah terima.'],
            ['id'=>'cat-review',  'icon'=>'fas fa-star','title'=>'Ulasan & Rating','desc'=>'Panduan memberikan rating dan feedback untuk armada.'],
        ];
        @endphp
        
        @foreach($categories as $cat)
        <button type="button" onclick="openFaqModal('{{ $cat['id'] }}', '{{ $cat['title'] }}')" class="text-left group block p-8 bg-white border border-[#EBEBDF] rounded-[2rem] hover:border-[#F5D042] hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-all duration-300 w-full">
            <div class="w-12 h-12 bg-[#F9F9F5] border border-[#EBEBDF] text-[#0A174E] rounded-full flex items-center justify-center text-xl mb-6 group-hover:bg-[#F5D042] group-hover:border-[#F5D042] group-hover:text-white transition-colors">
                <i class="{{ $cat['icon'] }}"></i>
            </div>
            <h3 class="text-lg font-bold text-[#0A174E] mb-3">{{ $cat['title'] }}</h3>
            <p class="text-[#8F8F7E] text-sm leading-relaxed mb-6">{{ $cat['desc'] }}</p>
            <span class="text-[11px] font-bold text-[#0A174E] tracking-widest uppercase flex items-center gap-2 group-hover:text-[#F5D042] transition-colors">
                Selengkapnya <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
            </span>
        </button>
        @endforeach
    </div>
</section>

<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pb-20 lg:pb-32 text-center">
    <div class="bg-[#0A174E] rounded-[2.5rem] p-10 lg:p-14 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-white via-transparent to-transparent"></div>
        <div class="relative z-10">
            <h2 class="text-3xl lg:text-4xl font-bold text-white mb-4">Masih Perlu Bantuan?</h2>
            <p class="text-[#8F8F7E] text-base lg:text-lg font-medium mb-10 max-w-xl mx-auto">Tim dukungan pelanggan kami siap melayani Anda setiap hari mulai pukul 08:00 hingga 22:00 WIB.</p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="https://wa.me/6281234567890" target="_blank" class="w-full sm:w-auto flex items-center justify-center gap-3 bg-[#F5D042] text-[#0A174E] px-8 py-4 rounded-xl font-bold hover:bg-white transition-colors">
                    <i class="fab fa-whatsapp text-xl"></i> Chat WhatsApp
                </a>
                <a href="mailto:support@jatara.com" class="w-full sm:w-auto flex items-center justify-center gap-3 bg-white/10 border border-white/20 text-white px-8 py-4 rounded-xl font-bold hover:bg-white/20 transition-colors">
                    <i class="fas fa-envelope text-lg"></i> Kirim Email
                </a>
            </div>
        </div>
    </div>
</section>

{{-- FAQ Modal --}}
<div id="faq-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
    <div class="absolute inset-0 bg-[#0A174E]/40 backdrop-blur-sm transition-opacity" onclick="closeFaqModal()"></div>
    <div class="bg-white rounded-[2.5rem] border border-[#EBEBDF] shadow-[0_20px_60px_rgba(10,23,78,0.1)] w-full max-w-2xl max-h-[80vh] flex flex-col z-10 overflow-hidden relative">
        
        {{-- Header --}}
        <div class="flex items-center justify-between p-6 lg:p-8 border-b border-[#EBEBDF]">
            <h3 class="text-2xl font-bold text-[#0A174E]" id="faq-modal-title">FAQ</h3>
            <button type="button" onclick="closeFaqModal()" class="w-10 h-10 rounded-full bg-[#F9F9F5] text-[#8F8F7E] hover:text-[#0A174E] hover:bg-[#EBEBDF] flex items-center justify-center transition-colors">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        {{-- Content Area --}}
        <div class="p-6 lg:p-8 overflow-y-auto" id="faq-modal-content">
            {{-- Content injected via JS --}}
        </div>
        
    </div>
</div>
@endsection

@push('scripts')
<script>
    const faqData = {
        'cat-booking': [
            { q: 'Bagaimana cara melakukan pemesanan kendaraan?', a: 'Pilih kendaraan dari menu "Cari Kendaraan", tentukan tanggal peminjaman, isi form identitas dengan lengkap, lalu lakukan pembayaran DP 30% untuk menyimpan jadwal.' },
            { q: 'Apakah ada batasan wilayah penggunaan kendaraan?', a: 'Kendaraan dapat digunakan sesuai ketentuan mitra. Umumnya bebas digunakan di dalam kota atau provinsi tempat penyewaan, namun beberapa mitra melarang kendaraan melintasi pulau tanpa izin.' },
            { q: 'Bagaimana dengan asuransi kendaraan?', a: 'Seluruh kendaraan dilindungi dengan asuransi dasar TLO (Third Party Liability). Kerusakan ringan tanpa kecelakaan besar bisa dikenakan biaya toleransi (own risk) mulai dari Rp 300.000.' }
        ],
        'cat-account': [
            { q: 'Dokumen apa saja yang diperlukan untuk pendaftaran?', a: 'Anda wajib mengunggah E-KTP asli dan SIM A/C yang masih berlaku dan sesuai dengan nama pada KTP.' },
            { q: 'Bagaimana jika KTP saya belum berbentuk e-KTP?', a: 'Saat ini mitra kami hanya menerima bentuk E-KTP atau resi asli pendaftaran dari Disdukcapil (dilengkapi foto).' },
            { q: 'Apakah data saya aman?', a: 'Data KTP dan SIM Anda dienkripsi penuh di server Jatara. Kami hanya meneruskan dokumen tersebut kepada Mitra Spesifik setelah Anda mengonfirmasi pesanan.' }
        ],
        'cat-payment': [
            { q: 'Apa metode pembayaran yang tersedia?', a: 'Kami menggunakan payment gateway Midtrans yang mendukung Virtual Account, Transfer Bank, E-Wallet (GoPay, OVO, Dana), Kartu Kredit, hingga pembayaran di gerai minimarket.' },
            { q: 'Apakah wajib membayar DP?', a: 'Ya. Sebanyak 30% dari total biaya sewa diwajibkan untuk mengunci jadwal kendaraan agar tidak dipesan pengguna lain.' },
            { q: 'Apakah ada sistem deposit saldo?', a: 'Tergantung mitra. Beberapa mitra mungkin mensyaratkan uang jaminan/deposit secara langsung saat serah terima, namun tidak ditarik melalui aplikasi Jatara.' }
        ],
        'cat-refund': [
            { q: 'Bagaimana cara membatalkan pesanan?', a: 'Pesanan dapat dibatalkan lewat menu Riwayat Sewa selagi statusnya "Dikonfirmasi" (belum melewati batas waktu). Jika dibatalkan H-1 pengambilan, deposit hangus.' },
            { q: 'Langkah refund DP bagaimana?', a: 'Refund akan diproses dan dikembalikan ke rekening/e-wallet Anda 1x24 Jam kerja apabila pembatalan dilakukan setidaknya H-3 sebelum jadwal sewa.' }
        ],
        'cat-pickup': [
            { q: 'Di mana lokasi pengambilan kendaraan?', a: 'Setelah pesanan dikonfirmasi dan dilunasi, Anda akan mendapat alamat pool/lokasi dari mitra di halaman Checkout dan Riwayat Sewa.' },
            { q: 'Bisakah kendaraan diantar ke rumah?', a: 'Saat ini pengantaran (delivery) hanya berlaku bagi opsi sewa bulanan, atau jika mitra bersangkutan menyediakan jasa delivery ekstra yang disepakati dari WhatsApp.' }
        ],
        'cat-review': [
            { q: 'Bagaimana cara memberikan ulasan?', a: 'Setiap pesanan yang berstatus Selesai (Completed), akan memunculkan tombol Ulasan di menu "Pesanan Saya". Klik tombol bintang dan berikan tanggapan.' },
            { q: 'Apakah ulasan saya dilihat publik?', a: 'Ya, ulasan Anda akan mempengaruhi Rating kendaraan dan Mitra, yang membantu pengguna lain mencari pengalaman sewa terbaik.' }
        ]
    };

    function openFaqModal(catId, title) {
        const modal = document.getElementById('faq-modal');
        const titleEl = document.getElementById('faq-modal-title');
        const contentEl = document.getElementById('faq-modal-content');
        
        titleEl.innerText = title;
        
        let faqs = faqData[catId] || [{ q: 'Informasi Tidak Tersedia', a: 'Silakan hubungi WhatsApp kami.' }];
        
        contentEl.innerHTML = '<div class="space-y-4">' + faqs.map(faq => `
            <div class="bg-[#F9F9F5] border border-[#EBEBDF] rounded-2xl p-5 hover:border-[#F5D042] transition-colors">
                <h4 class="font-bold text-[#0A174E] text-base mb-2">${faq.q}</h4>
                <p class="text-[#8F8F7E] text-sm leading-relaxed font-medium">${faq.a}</p>
            </div>
        `).join('') + '</div>';

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeFaqModal() {
        const modal = document.getElementById('faq-modal');
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }
</script>
@endpush