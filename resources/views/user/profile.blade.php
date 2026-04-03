@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="bg-slate-50 min-h-screen py-10">
    <div class="max-w-4xl mx-auto px-6">
        
        {{-- Header Profil --}}
        <div class="flex items-center gap-6 mb-10">
            <div class="w-20 h-20 bg-blue-600 rounded-2xl flex items-center justify-center text-white text-3xl font-black shadow-lg shadow-blue-200 uppercase">
                {{ substr($user->name, 0, 1) }}
            </div>
            <div>
                <h1 class="text-2xl font-black text-slate-900">Halo, {{ $user->name }}! 👋</h1>
                <p class="text-slate-500">Kelola akun dan pengaturan profil Anda</p>
            </div>
        </div>

        {{-- Notifikasi Sukses --}}
        @if(session('success'))
        <div class="mb-8 p-4 bg-green-50 border border-green-100 text-green-700 rounded-2xl flex items-center gap-3 animate-fade-in text-sm font-semibold">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Statistik Singkat --}}
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Informasi Akun</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-[10px] text-slate-400 font-bold uppercase">Email</p>
                            <p class="text-sm text-slate-700 font-semibold truncate">{{ $user->email }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 font-bold uppercase">Bergabung</p>
                            <p class="text-sm text-slate-700 font-semibold">{{ $user->created_at->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 font-bold uppercase">Status Akun</p>
                            <span class="text-[10px] px-2 py-0.5 bg-blue-50 text-blue-600 rounded-md font-bold uppercase">Pelanggan Aktif</span>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-600 p-8 rounded-3xl shadow-xl shadow-blue-100 relative overflow-hidden">
                    <div class="relative z-10 text-white">
                        <p class="text-xs font-bold opacity-80 uppercase tracking-widest mb-1">Siap Jalan?</p>
                        <h4 class="text-xl font-black mb-4">Cek Koleksi Armada</h4>
                        <a href="{{ route('browse') }}" class="inline-block bg-white text-blue-600 px-6 py-2.5 rounded-xl text-sm font-bold hover:scale-105 transition-all">Sewa Sekarang</a>
                    </div>
                    <i class="fas fa-car absolute -right-4 -bottom-4 text-white/10 text-7xl transform -rotate-12"></i>
                </div>
            </div>

            {{-- Form Edit --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center">
                        <h3 class="font-bold text-slate-900 border-l-4 border-blue-600 pl-4">Edit Profil</h3>
                    </div>

                    <form action="{{ route('profile.update') }}" method="POST" class="p-8 space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-1">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 px-1">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:bg-white transition-all">
                            </div>

                            <div class="md:col-span-1">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 px-1">Alamat Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:bg-white transition-all">
                            </div>

                            <div class="md:col-span-1">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 px-1">No. WhatsApp</label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:bg-white transition-all">
                            </div>
                        </div>

                        <div class="pt-6 border-t border-slate-50">
                            <p class="text-sm font-bold text-slate-900 mb-6">Ubah Password <span class="text-[10px] text-slate-400 font-normal ml-1">(Kosongkan jika tidak diganti)</span></p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 px-1">Password Baru</label>
                                    <input type="password" name="password" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:bg-white transition-all">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 px-1">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:bg-white transition-all">
                                </div>
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-bold px-10 py-4 rounded-2xl transition-all active:scale-95 shadow-lg shadow-blue-100 flex items-center justify-center gap-3">
                                <i class="fas fa-save"></i> Simpan Perubahan Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
