@extends('layouts.app')

@section('title', 'Pusat Bantuan')

@section('content')

{{-- Uber-style Searchable Help Header --}}
<section class="bg-uber-black text-uber-white py-24 text-center">
    <div class="max-w-4xl mx-auto px-6">
        <h1 class="text-5xl font-bold tracking-tighter mb-8 italic">Ada yang bisa kami bantu?</h1>
        <div class="relative max-w-2xl mx-auto">
            <i class="fas fa-search absolute left-6 top-1/2 -translate-y-1/2 text-gray-500 text-lg"></i>
            <input type="text" placeholder="Cari jawaban dari masalah Anda..." class="w-full bg-uber-white text-uber-black text-lg font-bold pl-16 pr-8 py-5 rounded-full focus:outline-none focus:ring-4 focus:ring-gray-800 transition shadow-xl">
        </div>
    </div>
</section>

{{-- Help Categories Grid --}}
<section class="max-w-7xl mx-auto px-6 py-24">
    <h2 class="text-3xl font-bold text-uber-black mb-12 tracking-tight">Kategori Populer</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
        @php
        $categories = [
            ['icon'=>'fas fa-truck-loading','title'=>'Pemesanan','desc'=>'Cara booking unit, durasi sewa, dan asuransi unit.'],
            ['icon'=>'fas fa-id-card','title'=>'Akun & Identitas','desc'=>'Kelola profil Anda, verifikasi dokumen, dan pengaturan keamanan.'],
            ['icon'=>'fas fa-wallet','title'=>'Pembayaran','desc'=>'Metode pembayaran tersedia, biaya deposit, dan pengembalian dana.'],
            ['icon'=>'fas fa-redo','title'=>'Pembatalan','desc'=>'Kebijakan refund, denda keterlambatan, dan perubahan jadwal.'],
            ['icon'=>'fas fa-key','title'=>'Pengambilan Unit','desc'=>'Lokasi showroom, jam operasional, dan serah terima unit.'],
            ['icon'=>'fas fa-star','title'=>'Ulasan','desc'=>'Dapatkan informasi tentang cara memberikan rating bagi mitra unit kami.'],
        ];
        @endphp
        
        @foreach($categories as $cat)
        <a href="#" class="group flex flex-col p-8 border border-gray-100 rounded-xl hover:bg-uber-chip transition-all duration-300">
            <div class="w-14 h-14 bg-uber-black text-uber-white rounded-lg flex items-center justify-center text-xl mb-6 shadow-sm group-hover:scale-110 transition-transform">
                <i class="{{ $cat['icon'] }}"></i>
            </div>
            <h3 class="text-xl font-bold text-uber-black mb-3">{{ $cat['title'] }}</h3>
            <p class="text-uber-text font-medium leading-relaxed">{{ $cat['desc'] }}</p>
            <span class="mt-8 text-xs font-bold text-uber-black uppercase border-b border-uber-black inline-block w-fit">Pelajari Selengkapnya</span>
        </a>
        @endforeach
    </div>
</section>

{{-- Support Contact Section --}}
<section class="bg-uber-chip py-24">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <h2 class="text-4xl font-bold text-uber-black mb-4 tracking-tighter">Masih butuh bantuan?</h2>
        <p class="text-lg text-uber-text font-medium mb-12">Layanan konsumen kami beroperasi setiap hari mulai pukul 08.00 hingga 22.00 WIB.</p>
        
        <div class="flex flex-col md:flex-row gap-6 justify-center">
            <a href="https://wa.me/6281234567890" target="_blank" class="flex items-center justify-center gap-4 bg-uber-black text-uber-white px-10 py-5 rounded-full font-bold text-lg hover:bg-gray-800 transition shadow-uber">
                <i class="fab fa-whatsapp text-2xl"></i>
                Hubungi via WhatsApp
            </a>
            <a href="mailto:support@rentdrive.com" class="flex items-center justify-center gap-4 bg-uber-white text-uber-black border border-gray-200 px-10 py-5 rounded-full font-bold text-lg hover:bg-uber-chip transition shadow-sm">
                <i class="fas fa-envelope text-lg"></i>
                Kirimkan Email
            </a>
        </div>
    </div>
</section>

@endsection
