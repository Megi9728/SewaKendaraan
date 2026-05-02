@extends('layouts.app')

@section('title', 'Sewa Kendaraan Cepat & Praktis')

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Sora:wght@600;700;800&display=swap"
        rel="stylesheet">
    <style>
        .home-shell {
            --jt-oxford: #0a174e;
            --jt-pale: #ebebdf;
            --jt-maize: #f5d042;
            --jt-ink: #111827;
            --jt-muted: #5c6373;
            --jt-border: rgba(10, 23, 78, 0.14);
            --jt-soft: #f3f4f6;
            font-family: 'Manrope', sans-serif;
            background: #ffffff;
            overflow-x: hidden;
        }

        .home-shell h1,
        .home-shell h2,
        .home-shell h3,
        .home-shell h4 {
            font-family: 'Sora', sans-serif;
            letter-spacing: -0.02em;
        }

        .jt-card {
            border: 1px solid var(--jt-border);
            background: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 12px 28px rgba(10, 23, 78, 0.07);
        }

        .jt-cta {
            background: var(--jt-maize);
            color: var(--jt-oxford);
            border-radius: 0.5rem;
            font-weight: 700;
            transition: transform 0.2s ease, box-shadow 0.2s ease, filter 0.2s ease;
        }

        .jt-cta:hover {
            filter: brightness(0.94);
            transform: translateY(-2px);
            box-shadow: 0 10px 18px rgba(245, 208, 66, 0.35);
        }

        .jt-section {
            padding-top: 4.5rem;
            padding-bottom: 4.5rem;
        }

        .jt-search-form {
            background: #fff;
            border-radius: 1rem;
            border: 1px solid var(--jt-pale);
            box-shadow: 0 20px 40px rgba(10, 23, 78, 0.08);
            padding: 1.5rem;
            max-width: 1100px;
            margin: -3rem auto 0;
            position: relative;
            z-index: 20;
        }

        .jt-input {
            width: 100%;
            border-radius: 0.5rem;
            border: 1px solid #d1d5db;
            background: #f9fafb;
            color: var(--jt-oxford);
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
            font-weight: 600;
            outline: none;
            transition: all 0.2s ease;
        }

        .jt-input:focus {
            border-color: var(--jt-oxford);
            box-shadow: 0 0 0 2px rgba(10, 23, 78, 0.1);
        }

        .jt-feature {
            text-align: left;
        }

        @media (max-width: 768px) {
            .jt-section {
                padding-top: 3.5rem;
                padding-bottom: 3.5rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="home-shell">
        <section class="px-2 md:px-4 pt-0 pb-0 absolute inset-x-0 top-[1rem] md:top-[1.25rem] z-0">
        <div class="jt-hero relative h-[700px] md:h-[800px] lg:h-[850px] rounded-[1.5rem] md:rounded-[2.5rem] overflow-hidden bg-[#0A174E]">
            <img src="https://images.unsplash.com/photo-1503736334956-4c8f8e92946d?auto=format&fit=crop&w=1800&q=80"
                alt="Hero kendaraan Jatara" class="absolute inset-0 h-full w-full object-cover">
            <div class="absolute inset-0 bg-[#0A174E]/60 md:bg-[#0A174E]/40"></div>
            <div class="relative z-10 p-6 md:p-14 lg:p-20 h-full flex flex-col justify-center items-center text-center mt-12 md:mt-16">      
                <div class="max-w-[800px]">
                    <h1 class="text-white text-5xl md:text-[72px] lg:text-[84px] leading-[1.05] font-bold mb-6 tracking-tight">
                        Sewa kendaraan cepat <br class="hidden md:block">dan terjangkau
                    </h1>
                    <p class="text-[#EBEBDF] text-lg md:text-xl font-medium mb-12 max-w-[600px] mx-auto">
                        Make every customer interaction better, faster, and more consistent with the optimization platform for human and AI agents.
                    </p>
                    
                </div>
            </div>
        </div>
    </section>
    
    <!-- spacer to push the rest of the content down below the absolute hero -->
    <div class="h-[700px] md:h-[800px] lg:h-[850px]"></div>

        <section class="px-4">
            <form action="{{ route('browse') }}" method="GET"
                class="jt-search-form grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                <div>
                    <label
                        class="block text-[11px] font-bold text-[#0A174E] uppercase tracking-widest mb-2 px-1">Lokasi</label>
                    <select name="domicile" class="jt-input">
                        <option value="">Semua Lokasi</option>
                        <option value="Jakarta">Jakarta</option>
                        <option value="Bogor">Bogor</option>
                        <option value="Depok">Depok</option>
                        <option value="Tangerang">Tangerang</option>
                        <option value="Bekasi">Bekasi</option>
                    </select>
                </div>

                <div>
                    <label
                        class="block text-[11px] font-bold text-[#0A174E] uppercase tracking-widest mb-2 px-1">Tipe</label>
                    <select name="type" class="jt-input">
                        <option value="">Semua Tipe</option>
                        <option value="Mobil">Mobil</option>
                        <option value="Motor">Motor</option>
                        <option value="SUV">SUV</option>
                        <option value="MPV">MPV</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-[#0A174E] uppercase tracking-widest mb-2 px-1">Tanggal
                        Mulai</label>
                    <input type="date" name="start_date" class="jt-input text-gray-500" min="{{ date('Y-m-d') }}">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-[#0A174E] uppercase tracking-widest mb-2 px-1">Tanggal
                        Akhir</label>
                    <input type="date" name="end_date" class="jt-input text-gray-500" min="{{ date('Y-m-d') }}">
                </div>

                <button type="submit"
                    class="bg-[#0A174E] text-white hover:opacity-90 hover:shadow-lg transition py-[14px] px-6 rounded-lg text-sm font-bold w-full h-[52px]">
                    Cari Unit
                </button>
            </form>
        </section>

        <section class="jt-section max-w-[1400px] mx-auto px-4 md:px-8 mt-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
                <h2 class="text-4xl md:text-[2.5rem] w-full md:w-3/5 leading-tight font-bold">Kenyamanan fleksibel dengan
                    tarif sewa terbaik dalam kota</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-12">
                <article
                    class="jt-feature group p-6 rounded-2xl hover:bg-[#EBEBDF]/30 transition border border-transparent hover:border-[#EBEBDF]">
                    <div class="bg-[#EBEBDF] w-16 h-16 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-car-side text-[22px] text-[#0A174E] mb-0"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-[#0A174E]">Unit Prima</h3>
                    <p class="text-gray-600 leading-relaxed font-medium">Semua armada dirawat berkala agar perjalanan aman,
                        nyaman, dan mulus.</p>
                </article>
                <article
                    class="jt-feature group p-6 rounded-2xl hover:bg-[#EBEBDF]/30 transition border border-transparent hover:border-[#EBEBDF]">
                    <div class="bg-[#EBEBDF] w-16 h-16 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-laptop text-[22px] text-[#0A174E] mb-0"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-[#0A174E]">Booking Mudah</h3>
                    <p class="text-gray-600 leading-relaxed font-medium">Cukup beberapa klik, Anda langsung terhubung ke
                        katalog dan jadwal secara real-time.</p>
                </article>
                <article
                    class="jt-feature group p-6 rounded-2xl hover:bg-[#EBEBDF]/30 transition border border-transparent hover:border-[#EBEBDF]">
                    <div class="bg-[#EBEBDF] w-16 h-16 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-tags text-[22px] text-[#0A174E] mb-0"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-[#0A174E]">Harga Terjangkau</h3>
                    <p class="text-gray-600 leading-relaxed font-medium">Tarif transparan dan sangat kompetitif, tanpa biaya
                        tersembunyi di checkout.</p>
                </article>
                <article
                    class="jt-feature group p-6 rounded-2xl hover:bg-[#EBEBDF]/30 transition border border-transparent hover:border-[#EBEBDF]">
                    <div class="bg-[#EBEBDF] w-16 h-16 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-headset text-[22px] text-[#0A174E] mb-0"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-[#0A174E]">Dukungan 24/7</h3>
                    <p class="text-gray-600 leading-relaxed font-medium">Tim support ramah kami siap membantu kapan pun Anda
                        membutuhkan bantuan di jalan.</p>
                </article>
            </div>
        </section>

        <!-- Koleksi Kendaraan -->
        <section class="max-w-[1400px] mx-auto px-4 md:px-8 mt-16">
            <div class="flex items-end justify-between gap-4 mb-10">
                <h2 class="text-4xl font-bold text-[#0A174E]">Koleksi Kendaraan</h2>
                <a href="{{ route('browse') }}"
                    class="hidden md:inline-flex bg-[#F5D042] text-[#0A174E] hover:brightness-95 transition items-center gap-3 px-6 py-3 rounded-md text-sm font-bold">
                    Lihat Semua <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($vehicles as $v)
                    <a href="{{ route('vehicle.detail', $v->id) }}"
                        class="block bg-[#F9F9F5] rounded-3xl p-6 group hover:-translate-y-1 hover:shadow-xl transition duration-300">
                        <div class="aspect-[16/10] mb-6 relative">
                            <!-- Using object-cover to match real photos, but styling cleanly -->
                            <img src="{{ $v->image ? (strpos($v->image, 'http') === 0 ? $v->image : asset('storage/' . $v->image)) : 'https://placehold.co/800x500?text=' . urlencode($v->name) }}"
                                alt="{{ $v->name }}"
                                class="w-full h-full object-cover rounded-2xl group-hover:scale-[1.02] transition duration-500 ease-out">
                            <div
                                class="absolute top-3 right-3 bg-white px-3 py-1.5 rounded-md text-xs font-black text-[#0A174E] shadow-sm">
                                {{ $v->type }}
                            </div>
                        </div>

                        <div class="flex justify-between items-start mb-6">
                            <h3 class="text-xl font-bold text-[#0A174E] w-2/3 leading-tight">{{ $v->name }}</h3>
                            <div class="text-right">
                                <p class="font-black text-xl text-[#0A174E]">Rp
                                    {{ number_format($v->price_per_day, 0, ',', '.') }}</p>
                                <p class="text-gray-500 text-xs font-semibold">/ hari</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-2 border-t border-gray-200 pt-6">
                            <div class="flex flex-col gap-1">
                                <i class="fas fa-chair text-lg text-gray-400"></i>
                                <span class="text-[10px] font-bold text-gray-400 uppercase">Kursi</span>
                                <span class="text-sm font-bold text-[#0A174E]">{{ $v->seats ?? '4' }}</span>
                            </div>
                            <div class="flex flex-col gap-1">
                                <i class="fas fa-cogs text-lg text-gray-400"></i>
                                <span class="text-[10px] font-bold text-gray-400 uppercase">Transmisi</span>
                                <span class="text-sm font-bold text-[#0A174E]">{{ $v->transmission ?? 'Auto' }}</span>
                            </div>
                            <div class="flex flex-col gap-1">
                                <i class="fas fa-gas-pump text-lg text-gray-400"></i>
                                <span class="text-[10px] font-bold text-gray-400 uppercase">BBM</span>
                                <span class="text-sm font-bold text-[#0A174E]">{{ $v->fuel_type ?? 'Bensin' }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-8 text-center md:hidden">
                <a href="{{ route('browse') }}"
                    class="inline-flex bg-[#F5D042] text-[#0A174E] hover:brightness-95 transition items-center gap-3 px-6 py-3 rounded-md text-sm font-bold">
                    Lihat Semua Kendaraan
                </a>
            </div>
        </section>

        <!-- Running Text Slogan -->
        <section class="mt-24 mb-10 overflow-hidden bg-[#0A174E] py-8 select-none">
            <div class="flex whitespace-nowrap animate-marquee">
                <div class="flex items-center gap-12 text-white/90 text-2xl md:text-4xl font-bold uppercase tracking-tighter mx-4">
                    <span>Sewa Kendaraan Jatara</span>
                    <span class="w-3 h-3 rounded-full bg-[#F5D042]"></span>
                    <span>Unit Prima & Terawat</span>
                    <span class="w-3 h-3 rounded-full bg-[#F5D042]"></span>
                    <span>Booking Mudah & Cepat</span>
                    <span class="w-3 h-3 rounded-full bg-[#F5D042]"></span>
                    <span>Harga Terjangkau</span>
                    <span class="w-3 h-3 rounded-full bg-[#F5D042]"></span>
                    <span>Layanan 24/7</span>
                    <span class="w-3 h-3 rounded-full bg-[#F5D042]"></span>
                    <span>Sewa Kendaraan Jatara</span>
                    <span class="w-3 h-3 rounded-full bg-[#F5D042]"></span>
                </div>
                <!-- Duplicate for seamless loop -->
                <div class="flex items-center gap-12 text-white/90 text-2xl md:text-4xl font-bold uppercase tracking-tighter mx-4">
                    <span>Sewa Kendaraan Jatara</span>
                    <span class="w-3 h-3 rounded-full bg-[#F5D042]"></span>
                    <span>Unit Prima & Terawat</span>
                    <span class="w-3 h-3 rounded-full bg-[#F5D042]"></span>
                    <span>Booking Mudah & Cepat</span>
                    <span class="w-3 h-3 rounded-full bg-[#F5D042]"></span>
                    <span>Harga Terjangkau</span>
                    <span class="w-3 h-3 rounded-full bg-[#F5D042]"></span>
                    <span>Layanan 24/7</span>
                    <span class="w-3 h-3 rounded-full bg-[#F5D042]"></span>
                    <span>Sewa Kendaraan Jatara</span>
                    <span class="w-3 h-3 rounded-full bg-[#F5D042]"></span>
                </div>
            </div>
        </section>

        @push('styles')
        <style>
            @keyframes marquee {
                0% { transform: translateX(0); }
                100% { transform: translateX(-50%); }
            }
            .animate-marquee {
                display: flex;
                width: max-content;
                animation: marquee 30s linear infinite;
            }
        </style>
        @endpush

        <section class="max-w-[1400px] mx-auto px-4 md:px-8 mt-24 mb-16 relative">
            <div
                class="bg-[#0A174E] rounded-[2rem] overflow-hidden flex flex-col lg:flex-row relative shadow-[0_30px_60px_-15px_rgba(10,23,78,0.3)]">
                <div class="lg:w-1/2 p-10 md:p-16 lg:p-24 relative z-10 flex flex-col justify-center">
                    <h2 class="text-white text-4xl md:text-5xl font-bold mb-12 leading-tight">Sewa kendaraan Anda<br>dalam
                        3 langkah mudah</h2>

                    <div class="space-y-10">
                        <div class="flex gap-6">
                            <div
                                class="flex-shrink-0 w-12 h-12 rounded-full bg-[#F5D042] flex items-center justify-center text-[#0A174E] font-bold text-xl">
                                01</div>
                            <div>
                                <h3 class="text-white text-xl font-bold mb-2">Pilih kendaraan Anda</h3>
                                <p class="text-[#EBEBDF]/70 leading-relaxed font-medium">Jelajahi berbagai pilihan
                                    kendaraan kami, mulai dari mobil kota yang ringkas hingga SUV yang luas. Pilih kendaraan
                                    yang paling sesuai dengan kebutuhan Anda.</p>
                            </div>
                        </div>
                        <div class="flex gap-6">
                            <div
                                class="flex-shrink-0 w-12 h-12 rounded-full bg-[#F5D042] flex items-center justify-center text-[#0A174E] font-bold text-xl">
                                02</div>
                            <div>
                                <h3 class="text-white text-xl font-bold mb-2">Pesan secara online</h3>
                                <p class="text-[#EBEBDF]/70 leading-relaxed font-medium">Pesan mobil Anda hanya dalam
                                    beberapa klik dengan sistem pemesanan kami yang ramah pengguna. Pilih tanggal, lokasi,
                                    dan konfirmasi reservasi Anda secara instan.</p>
                            </div>
                        </div>
                        <div class="flex gap-6">
                            <div
                                class="flex-shrink-0 w-12 h-12 rounded-full bg-[#F5D042] flex items-center justify-center text-[#0A174E] font-bold text-xl">
                                03</div>
                            <div>
                                <h3 class="text-white text-xl font-bold mb-2">Ambil & berkendara</h3>
                                <p class="text-[#EBEBDF]/70 leading-relaxed font-medium">Kunjungi lokasi pengambilan
                                    terdekat dan ambil kuncinya. Nikmati perjalanan yang lancar melintasi kota dengan
                                    kendaraan kami yang andal dan terawat.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lg:w-1/2 min-h-[400px] lg:min-h-full relative">
                    <img src="https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&w=1200&q=80"
                        alt="Kendaraan Jatara" class="absolute inset-0 w-full h-full object-cover">
                </div>
            </div>
        </section>

        <section class="max-w-[1400px] mx-auto px-4 md:px-8 py-16">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-[#0A174E]">Testimoni dari penyewa<br>yang puas</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-[#F9F9F5] p-8 rounded-3xl border border-[#EBEBDF] hover:shadow-lg transition duration-300">
                    <div class="flex text-[#F5D042] mb-6 text-sm gap-1">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                            class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-gray-600 font-medium leading-relaxed mb-8">"Saya membutuhkan sewa dadakan untuk liburan
                        keluarga, dan layanan ini memudahkannya! Proses pemesanan lancar, mobil dalam kondisi prima, dan
                        harga sangat terjangkau. Sangat direkomendasikan!"</p>
                    <div class="flex items-center gap-4">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="User"
                            class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-sm">
                        <h4 class="font-bold text-[#0A174E]">Budi Santoso</h4>
                    </div>
                </div>

                <div class="bg-[#F9F9F5] p-8 rounded-3xl border border-[#EBEBDF] hover:shadow-lg transition duration-300">
                    <div class="flex text-[#F5D042] mb-6 text-sm gap-1">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                            class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-gray-600 font-medium leading-relaxed mb-8">"Sebagai orang yang sering bepergian untuk
                        urusan dinas, saya sangat mengandalkan sewa kendaraan. Perusahaan ini selalu menjadi pilihan utama
                        karena armada yang terawat dengan baik dan layanan pelanggan yang memuaskan!"</p>
                    <div class="flex items-center gap-4">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="User"
                            class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-sm">
                        <h4 class="font-bold text-[#0A174E]">Siti Aminah</h4>
                    </div>
                </div>

                <div class="bg-[#F9F9F5] p-8 rounded-3xl border border-[#EBEBDF] hover:shadow-lg transition duration-300">
                    <div class="flex text-[#F5D042] mb-6 text-sm gap-1">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                            class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                    </div>
                    <p class="text-gray-600 font-medium leading-relaxed mb-8">"Mobil sangat irit bahan bakar dan ramah
                        lingkungan. Saya suka karena perusahaan ini menawarkan opsi berkelanjutan bagi pelancong modern.
                        Tarif sewa sangat kompetitif."</p>
                    <div class="flex items-center gap-4">
                        <img src="https://randomuser.me/api/portraits/men/67.jpg" alt="User"
                            class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-sm">
                        <h4 class="font-bold text-[#0A174E]">Andi Pratama</h4>
                    </div>
                </div>
            </div>
        </section>

        <!-- Excellence Section (Redesigned to avoid duplicate feel) -->
        <section class="max-w-[1400px] mx-auto px-4 md:px-8 py-24 mb-10">
            <div class="flex flex-col lg:flex-row gap-12 lg:gap-20 items-stretch">
                <div class="lg:w-[45%] flex flex-col justify-between py-6">
                    <div>
                        <h2 class="text-4xl md:text-[3.5rem] font-bold text-[#0A174E] leading-[1.1] mb-6 tracking-tight">
                            Mendorong keunggulan dalam layanan sewa mobil</h2>
                        <p class="text-gray-600 font-medium text-lg leading-relaxed mb-10 max-w-md">Dengan armada kendaraan
                            yang beragam dan komitmen terhadap kepuasan pelanggan, kami berusaha membuat perjalanan Anda
                            mulus dan menyenangkan.</p>

                        <a href="{{ route('how.it.works') }}"
                            class="inline-flex items-center p-1.5 pl-6 text-base font-bold bg-[#F5D042] text-[#0A174E] rounded-xl hover:shadow-[0_10px_20px_rgba(245,208,66,0.3)] transition-all hover:-translate-y-1">
                            <span class="mr-4">Cari tahu tentang kami</span>
                            <div class="bg-[#0A174E] text-white p-3 rounded-lg flex items-center justify-center">
                                <i class="fas fa-arrow-right text-sm"></i>
                            </div>
                        </a>
                    </div>

                    <div class="grid grid-cols-2 gap-6 md:gap-10 mt-20">
                        <div>
                            <h3 class="text-2xl md:text-3xl font-extrabold text-[#0A174E] mb-3 tracking-tight uppercase">Terpercaya</h3>
                            <p class="text-gray-500 font-medium text-sm md:text-base leading-relaxed pr-2">Partner mobilitas andalan dengan ribuan ulasan positif</p>
                        </div>
                        <div>
                            <h3 class="text-2xl md:text-3xl font-extrabold text-[#0A174E] mb-3 tracking-tight uppercase">Premium</h3>
                            <p class="text-gray-500 font-medium text-sm md:text-base leading-relaxed pr-2">Standar armada terbaik untuk kenyamanan perjalanan Anda</p>
                        </div>
                    </div>
                </div>
                <div class="lg:w-[55%] min-h-[500px] lg:min-h-[700px] relative">
                    <img src="https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?auto=format&fit=crop&w=1200&q=80"
                        alt="Supercar on winding road" class="absolute inset-0 w-full h-full object-cover rounded-[2rem]">
                </div>
            </div>
        </section>
    </div>
@endsection
