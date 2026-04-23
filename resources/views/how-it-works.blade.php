@extends('layouts.app')

@section('title', 'Layanan & Cara Kerja')

@section('content')
<!-- ==============================
     HERO SECTION
     ============================== -->
<section class="relative bg-[#0A174E] text-white py-24 md:py-32 overflow-hidden">
    <!-- Decorative Glow -->
    <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-[#F5D042] rounded-full mix-blend-multiply filter blur-[150px] opacity-20 -translate-y-1/4 translate-x-1/4 pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-white rounded-full mix-blend-overlay filter blur-[120px] opacity-10 pointer-events-none translate-y-1/3 -translate-x-1/3"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10 text-center">
        <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold tracking-tight mb-6 leading-tight">
            Mobilitas Premium, <br><span class="text-[#F5D042]">Sederhana & Mudah.</span>
        </h1>
        <p class="text-lg md:text-xl text-[#EBEBDF]/80 max-w-2xl mx-auto mb-10 font-medium leading-relaxed">
            Menghadirkan standar kelas satu dalam menyewa kendaraan. Dari proses booking digital kilat, pilihan armada eksklusif, hingga asuransi perjalanan lengkap.
        </p>
        <a href="{{ route('browse') }}" class="inline-flex items-center justify-center bg-[#F5D042] text-[#0A174E] font-extrabold text-lg px-10 py-5 rounded-2xl hover:bg-white hover:scale-[1.02] active:scale-[0.98] transition-all shadow-[0_12px_30px_rgba(245,208,66,0.3)]">
            Mulai Temukan Kendaraan <i class="fas fa-arrow-right ml-3 -mt-0.5"></i>
        </a>
    </div>
</section>

<!-- ==============================
     KEUNGGULAN JATARA
     ============================== -->
<section class="py-24 bg-[#F9F9F5]">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-16 max-w-3xl mx-auto">
            <h2 class="text-3xl md:text-5xl font-extrabold text-[#0A174E] mb-4 tracking-tight">Standar Kelas Satu</h2>
            <p class="text-lg text-[#8F8F7E] font-medium">Bukan sekadar rental, kami menghadirkan pengalaman perjalanan berkelas untuk Anda.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Keunggulan 1 -->
            <div class="bg-white p-10 rounded-3xl shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-[#EBEBDF] hover:border-[#F5D042] hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                <div class="w-16 h-16 bg-[#0A174E]/5 rounded-2xl flex items-center justify-center text-[#0A174E] text-2xl mb-8 group-hover:bg-[#0A174E] group-hover:text-[#F5D042] transition-colors duration-300">
                    <i class="fas fa-gem"></i>
                </div>
                <h3 class="text-2xl font-extrabold text-[#0A174E] mb-4 tracking-tight">Armada Terpilih</h3>
                <p class="text-[#8F8F7E] leading-relaxed font-medium">
                    Setiap unit kendaraan melalui inspeksi ketat (multipoint-check). Eksterior mengkilap, kabin wangi bebas asap rokok, dan performa mesin selalu optimal.
                </p>
            </div>

            <!-- Keunggulan 2 -->
            <div class="bg-white p-10 rounded-3xl shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-[#EBEBDF] hover:border-[#F5D042] hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                <div class="w-16 h-16 bg-[#0A174E]/5 rounded-2xl flex items-center justify-center text-[#0A174E] text-2xl mb-8 group-hover:bg-[#0A174E] group-hover:text-[#F5D042] transition-colors duration-300">
                    <i class="fas fa-hand-holding-dollar"></i>
                </div>
                <h3 class="text-2xl font-extrabold text-[#0A174E] mb-4 tracking-tight">Harga Transparan</h3>
                <p class="text-[#8F8F7E] leading-relaxed font-medium">
                    Tidak ada biaya siluman atau kejutan di akhir. Apa yang Anda lihat di aplikasi adalah total final yang sudah mencakup asuransi komprehensif.
                </p>
            </div>

            <!-- Keunggulan 3 -->
            <div class="bg-white p-10 rounded-3xl shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-[#EBEBDF] hover:border-[#F5D042] hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                <div class="w-16 h-16 bg-[#0A174E]/5 rounded-2xl flex items-center justify-center text-[#0A174E] text-2xl mb-8 group-hover:bg-[#0A174E] group-hover:text-[#F5D042] transition-colors duration-300">
                    <i class="fas fa-headset"></i>
                </div>
                <h3 class="text-2xl font-extrabold text-[#0A174E] mb-4 tracking-tight">Layanan Prioritas</h3>
                <p class="text-[#8F8F7E] leading-relaxed font-medium">
                    Tim dukungan kami beroperasi 24 jam x 7 hari. Siap membantu mulai dari kendala reservasi hingga layanan bantuan darurat (Roadside Assistance) di jalan.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ==============================
     CARA KERJA (STEP BY STEP)
     ============================== -->
<section class="py-24 bg-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-16 lg:gap-24 items-center">
            
            {{-- Bagian Ilustrasi/Foto Kiri --}}
            <div class="w-full lg:w-1/2 relative group">
                <div class="absolute -inset-4 bg-[#F5D042] rounded-[3rem] transform rotate-3 opacity-20 group-hover:rotate-6 transition-all duration-500"></div>
                <div class="absolute inset-0 bg-[#0A174E] rounded-[2.5rem] transform -rotate-2 opacity-10 group-hover:-rotate-4 transition-all duration-500"></div>
                <img src="https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80" alt="Jatara App Mobile Mockup" class="relative z-10 w-full h-auto aspect-[4/5] object-cover rounded-[2.5rem] shadow-2xl border-4 border-white">
                
                {{-- Pop-up mini --}}
                <div class="absolute bottom-10 -right-5 z-40 bg-white p-5 rounded-2xl shadow-xl flex items-center gap-4 animate-bounce" style="animation-duration: 3s;">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600 text-xl"><i class="fas fa-check-circle"></i></div>
                    <div>
                        <p class="text-sm text-[#8F8F7E] font-bold uppercase tracking-wider">Status</p>
                        <p class="text-[#0A174E] font-extrabold">Verifikasi Instan</p>
                    </div>
                </div>
            </div>
            
            {{-- Konten Langkah --}}
            <div class="w-full lg:w-1/2">
                <h2 class="text-3xl md:text-5xl font-extrabold text-[#0A174E] mb-6 tracking-tight leading-tight">
                    Tanpa Ribet. <br>
                    <span class="text-[#F5D042] relative inline-block">
                        Hanya 4 Langkah.
                        <svg class="absolute w-full h-3 -bottom-1 left-0 text-[#F5D042]/30" viewBox="0 0 100 20" preserveAspectRatio="none"><path d="M0 10 Q50 20 100 10" stroke="currentColor" stroke-width="4" fill="none"/></svg>
                    </span>
                </h2>
                <p class="text-lg text-[#8F8F7E] mb-12 font-medium">Beralih dari formulir kertas yang menyebalkan ke sistem reservasi berkecepatan tinggi.</p>
                
                <div class="space-y-10 relative">
                    <div class="space-y-8">
                        @php
                            $steps = [
                                ['icon'=>'fa-search', 'title'=>'1. Temukan Kendaraan', 'desc'=>'Pilih mobil idaman Anda dari ratusan pilihan armada berkualitas di sekitar Anda.'],
                                ['icon'=>'fa-calendar-check', 'title'=>'2. Atur Jadwal', 'desc'=>'Tentukan tanggal sewa dan lokasi penjemputan sesuai kebutuhan perjalanan Anda.'],
                                ['icon'=>'fa-id-card', 'title'=>'3. Verifikasi Data', 'desc'=>'Unggah foto KTP dan SIM. Proses verifikasi AI kami dienkripsi secara aman ratusan lapis.'],
                                ['icon'=>'fa-key', 'title'=>'4. Ambil Kunci', 'desc'=>'Lakukan pembayaran yang aman, lalu ambil kendaraan Anda atau minta diantarkan.']
                            ];
                        @endphp
                        
                        @foreach($steps as $step)
                        <div class="flex gap-6 group relative z-20">
                            <div class="flex-shrink-0 w-16 h-16 rounded-full bg-white border-4 border-[#F9F9F5] shadow-lg flex items-center justify-center group-hover:border-[#F5D042] transition-colors duration-300">
                                <div class="w-10 h-10 rounded-full bg-[#0A174E] text-[#F5D042] flex items-center justify-center text-lg group-hover:bg-[#F5D042] group-hover:text-[#0A174E] transition-colors duration-300">
                                    <i class="fas {{ $step['icon'] }}"></i>
                                </div>
                            </div>
                            <div class="pt-2">
                                <h4 class="text-2xl font-extrabold text-[#0A174E] mb-2 tracking-tight">{{ $step['title'] }}</h4>
                                <p class="text-[#8F8F7E] leading-relaxed text-lg font-medium">{{ $step['desc'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==============================
     FAQ SECTION (PERTANYAAN UMUM)
     ============================== -->
<section class="py-24 bg-[#F9F9F5]">
    <div class="max-w-4xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-5xl font-extrabold text-[#0A174E] mb-4 tracking-tight border-b-4 border-[#F5D042] pb-6 inline-block w-48">FAQ Utama</h2>
            <p class="text-lg text-[#8F8F7E] font-medium mt-6">Solusi cepat untuk Anda terkait rental kendaraan Jatara.</p>
        </div>
        
        <div class="space-y-5">
            <!-- Accordion 1 -->
            <div class="bg-white rounded-2xl p-8 border border-[#EBEBDF] shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-start gap-4">
                    <div class="text-[#F5D042] text-2xl mt-1"><i class="fas fa-question-circle text-[#0A174E]"></i></div>
                    <div>
                        <h4 class="font-extrabold text-[#0A174E] text-xl mb-3">Apakah harga sewa sudah termasuk asuransi?</h4>
                        <p class="text-[#8F8F7E] text-lg font-medium leading-relaxed">
                            Secara default, setiap unit di Jatara sudah dilindungi asuransi kecelakaan dasar (Basic Coverage). Jika Anda memerlukan perlindungan Zero-Risk, harap tanyakan perluasan polis ke kontak Mitra di halaman detail armada.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Accordion 2 -->
            <div class="bg-white rounded-2xl p-8 border border-[#EBEBDF] shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-start gap-4">
                    <div class="text-[#F5D042] text-2xl mt-1"><i class="fas fa-car-side text-[#0A174E]"></i></div>
                    <div>
                        <h4 class="font-extrabold text-[#0A174E] text-xl mb-3">Bolehkah saya membawa kendaraan ke luar kota/provinsi?</h4>
                        <p class="text-[#8F8F7E] text-lg font-medium leading-relaxed">
                            Area penggunaan (Coverage Area) tergantung pada kebijakan spesifik setiap Mitra Jatara. Umumnya Anda dibebaskan (Unlimited Mileage) untuk area dalam kota raya (seperti Jabodetabek), namun diwajibkan melapor untuk rute jarak jauh antar provinsi.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Accordion 3 -->
            <div class="bg-white rounded-2xl p-8 border border-[#EBEBDF] shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-start gap-4">
                    <div class="text-[#F5D042] text-2xl mt-1"><i class="fas fa-key text-[#0A174E]"></i></div>
                    <div>
                        <h4 class="font-extrabold text-[#0A174E] text-xl mb-3">Bagaimana metode lepas kuncinya?</h4>
                        <p class="text-[#8F8F7E] text-lg font-medium leading-relaxed">
                            Kami memfokuskan layanan pada *"Lepas Kunci" (Self-Drive)*. Akun penyewa Anda yang telah lolos sistem verifikasi keamanan biometrik dari kami memperbolehkan Anda menjemput langsung mobil di lokasi pool mitra kami.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==============================
     CTA BOTTOM
     ============================== -->
<section class="py-20 bg-white">
    <div class="max-w-5xl mx-auto px-6 lg:px-8 text-center">
        <div class="bg-[#0A174E] rounded-[3rem] p-12 md:p-20 shadow-2xl relative overflow-hidden">
            <!-- decorative circles -->
            <div class="absolute -top-24 -left-24 w-64 h-64 border-[40px] border-white/5 rounded-full pointer-events-none"></div>
            <div class="absolute -bottom-24 -right-24 w-64 h-64 border-[40px] border-[#F5D042] rounded-full opacity-20 pointer-events-none"></div>
            
            <h2 class="relative z-10 text-3xl md:text-5xl font-extrabold text-white mb-6 leading-tight">Siap Menghidupkan<br>Mesin Perjalanan Anda?</h2>
            <p class="relative z-10 text-lg text-[#EBEBDF] font-medium mb-12 max-w-2xl mx-auto">Gabung dengan ribuan pengguna lain yang telah membuktikan kemudahan mobilitas tanpa batas bersama Jatara.</p>
            <div class="relative z-10 flex flex-col sm:flex-row justify-center gap-6">
                <a href="{{ route('browse') }}" class="bg-[#F5D042] text-[#0A174E] border border-transparent font-extrabold px-10 py-5 rounded-2xl hover:bg-transparent hover:border-[#F5D042] hover:text-[#F5D042] transition-colors shadow-lg">Telusuri Armada Sekarang</a>
                <a href="{{ route('register') }}" class="bg-transparent border-2 border-white/20 text-white font-extrabold px-10 py-5 rounded-2xl hover:bg-white hover:text-[#0A174E] hover:border-white transition-colors shadow-lg">Buat Akun Baru</a>
            </div>
        </div>
    </div>
</section>

@endsection