@php
    $role = auth('admin')->check() ? 'admin' : (auth('mitra')->check() ? 'mitra' : 'customer');
    $user = auth($role)->user();
@endphp
@extends('layouts.admin')

@section('title', 'Profil Akun')

@section('content')

{{-- Header Area --}}
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-xl font-bold text-gray-800 dark:text-white tracking-tight leading-tight">
            {{ $role === 'admin' ? 'Profil Administrator' : 'Pengaturan Mitra' }}
        </h2>
        <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5 font-medium">Kelola data pribadi, keamanan, dan lokasi operasional Anda.</p>
    </div>
</div>

@if(session('success'))
<div class="mb-8 bg-success-50 dark:bg-success-500/10 border border-success-500/10 text-success-600 dark:text-success-400 px-6 py-4 rounded-2xl flex items-center gap-3 animate-in fade-in slide-in-from-top-4 duration-300">
    <i class="fas fa-check-circle"></i>
    <p class="font-bold text-sm">{{ session('success') }}</p>
</div>
@endif

<div class="max-w-6xl">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Profile Card --}}
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-white/[0.03] rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm p-6 text-center relative overflow-hidden group">
                {{-- Accent Decor --}}
                <div class="absolute top-0 left-0 w-full h-2 bg-brand-500"></div>
                <div class="absolute -right-12 -bottom-12 w-32 h-32 bg-brand-500/5 rounded-full group-hover:scale-150 transition-transform duration-700"></div>

                <div class="w-20 h-20 bg-brand-50 dark:bg-brand-500/10 rounded-2xl flex items-center justify-center mx-auto mb-4 border-2 border-white dark:border-gray-900 shadow-lg group-hover:scale-105 transition-all duration-500 relative z-10">
                    <i class="fas fa-user-shield text-brand-600 dark:text-brand-400 text-3xl"></i>
                </div>
                
                <div class="relative z-10">
                    <h3 class="font-bold text-gray-800 dark:text-white text-lg tracking-tight leading-tight">{{ $user->name }}</h3>
                    <div class="mt-2 inline-flex items-center gap-2 px-3 py-1 rounded-full {{ $role === 'admin' ? 'bg-error-50 text-error-600 dark:bg-error-500/10 dark:text-error-400' : 'bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400' }}">
                        <div class="w-1.5 h-1.5 rounded-full {{ $role === 'admin' ? 'bg-error-500' : 'bg-brand-500' }}"></div>
                        <span class="text-[9px] font-black uppercase tracking-widest">{{ $role === 'admin' ? 'Admin' : 'Mitra' }}</span>
                    </div>
                </div>
                
                <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-800 space-y-4 text-left relative z-10">
                    <div class="flex items-center gap-3 text-gray-500 dark:text-gray-400">
                        <div class="w-8 h-8 rounded-lg bg-gray-50 dark:bg-white/5 flex items-center justify-center text-gray-400">
                            <i class="fas fa-envelope text-[10px]"></i>
                        </div>
                        <div>
                            <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest leading-none mb-1">Email</p>
                            <p class="text-xs font-bold text-gray-800 dark:text-gray-300 truncate max-w-[150px]">{{ $user->email }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 text-gray-500 dark:text-gray-400">
                        <div class="w-8 h-8 rounded-lg bg-gray-50 dark:bg-white/5 flex items-center justify-center text-gray-400">
                            <i class="fas fa-id-card text-[10px]"></i>
                        </div>
                        <div>
                            <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest leading-none mb-1">ID Anggota</p>
                            <p class="text-xs font-bold text-gray-800 dark:text-gray-300 truncate">#JT{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 text-gray-500 dark:text-gray-400">
                        <div class="w-8 h-8 rounded-lg bg-gray-50 dark:bg-white/5 flex items-center justify-center text-gray-400">
                            <i class="fas fa-calendar-alt text-[10px]"></i>
                        </div>
                        <div>
                            <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest leading-none mb-1">Bergabung</p>
                            <p class="text-xs font-bold text-gray-800 dark:text-gray-300">{{ $user->created_at->translatedFormat('F Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Form --}}
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-white/[0.03] rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">
                <div class="px-8 py-5 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between bg-gray-50/50 dark:bg-white/[0.01]">
                    <div class="flex items-center gap-4">
                        <div class="w-1.5 h-8 bg-brand-500 rounded-full"></div>
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white tracking-tight">Konfigurasi Dasar</h3>
                    </div>
                    <i class="fas fa-sliders-h text-gray-300 dark:text-gray-600"></i>
                </div>
                
                <form action="{{ $role === 'admin' ? route('admin.profile.update') : route('mitra.profile.update') }}" method="POST" class="p-8 space-y-6">
                    @csrf
                    @method('PUT')
                    
                    {{-- Personal Info --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                        <div class="sm:col-span-2">
                            <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                   class="w-full bg-gray-50 dark:bg-white/[0.02] border border-gray-100 dark:border-gray-800 rounded-2xl px-6 py-4 text-sm font-bold text-gray-800 dark:text-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 outline-none transition-all shadow-sm">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">Email Akun</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                   class="w-full bg-gray-50 dark:bg-white/[0.02] border border-gray-100 dark:border-gray-800 rounded-2xl px-6 py-4 text-sm font-bold text-gray-800 dark:text-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 outline-none transition-all shadow-sm">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">Nomor WhatsApp</label>
                            <div class="relative">
                                <span class="absolute left-6 top-1/2 -translate-y-1/2 text-gray-400 font-bold text-xs">+62</span>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" 
                                       class="w-full bg-gray-50 dark:bg-white/[0.02] border border-gray-100 dark:border-gray-800 rounded-2xl px-6 py-4 pl-14 text-sm font-bold text-gray-800 dark:text-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 outline-none transition-all shadow-sm">
                            </div>
                        </div>
                    </div>

                    {{-- Security --}}
                    <div class="pt-10 border-t border-gray-100 dark:border-gray-800">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-1.5 h-6 bg-indigo-500 rounded-full"></div>
                            <h4 class="font-bold text-gray-800 dark:text-white tracking-tight">Privasi & Keamanan</h4>
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">Password Baru</label>
                                <input type="password" name="password" placeholder="••••••••" 
                                       class="w-full bg-gray-50 dark:bg-white/[0.02] border border-gray-100 dark:border-gray-800 rounded-2xl px-6 py-4 text-sm font-bold text-gray-800 dark:text-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 outline-none transition-all shadow-sm">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" placeholder="••••••••" 
                                       class="w-full bg-gray-50 dark:bg-white/[0.02] border border-gray-100 dark:border-gray-800 rounded-2xl px-6 py-4 text-sm font-bold text-gray-800 dark:text-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 outline-none transition-all shadow-sm">
                            </div>
                        </div>
                        <p class="text-[10px] text-gray-400 dark:text-gray-500 mt-5 italic flex items-center gap-2">
                            <i class="fas fa-info-circle text-brand-500"></i>
                            Kosongkan jika Anda tidak ingin mengubah password saat ini.
                        </p>
                    </div>

                    {{-- Operational Location for Mitra --}}
                    @if($role === 'mitra')
                    <div class="pt-8 border-t border-gray-100 dark:border-gray-800">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-1.5 h-6 bg-warning-500 rounded-full"></div>
                            <h4 class="font-bold text-gray-800 dark:text-white tracking-tight leading-tight">Lokasi Operasional Pool</h4>
                        </div>
                        
                        <div class="space-y-8">
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">Alamat Lengkap Pool Utama</label>
                                <div class="relative">
                                    <input type="text" name="pool_address" id="f-pool-address" placeholder="Contoh: Jl. Sudirman No. 123, Jakarta" value="{{ $user->pool->address ?? '' }}" 
                                           class="w-full bg-gray-50 dark:bg-white/[0.02] border border-gray-100 dark:border-gray-800 rounded-2xl px-6 py-4 pl-14 text-sm font-bold text-gray-800 dark:text-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 outline-none transition-all shadow-sm">
                                    <i class="fas fa-map-marked-alt absolute left-6 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                </div>
                                <p class="text-[10px] text-gray-400 dark:text-gray-500 mt-3 italic flex items-center gap-2">
                                    <i class="fas fa-location-crosshairs text-warning-500"></i>
                                    Klik atau geser pin pada peta untuk menentukan koordinat GPS pool Anda secara presisi.
                                </p>
                                
                                <input type="hidden" name="latitude" id="f-lat" value="{{ $user->pool->latitude ?? '' }}">
                                <input type="hidden" name="longitude" id="f-lng" value="{{ $user->pool->longitude ?? '' }}">
                            </div>

                            <div class="p-3 bg-gray-100 dark:bg-white/5 rounded-[2.5rem] border border-gray-100 dark:border-gray-800 overflow-hidden shadow-inner">
                                <div id="pool-map" class="w-full h-80 rounded-[2rem] z-0"></div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="pt-10 flex flex-col sm:flex-row gap-4">
                        <button type="submit" class="flex-1 bg-brand-500 hover:bg-brand-600 text-white font-black py-5 rounded-2xl transition-all active:scale-95 shadow-xl shadow-brand-500/25 flex items-center justify-center gap-3 text-sm uppercase tracking-widest">
                            <i class="fas fa-save"></i>
                            Perbarui Profil Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    {{-- Danger Zone: Hapus Akun --}}
    <div class="mt-8 bg-white dark:bg-white/[0.03] rounded-2xl border border-error-100 dark:border-error-900/30 shadow-sm overflow-hidden p-8 flex flex-col sm:flex-row items-center justify-center gap-6">
        <form action="{{ route('profile.destroy') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun secara permanen? Semua data yang terkait akan hilang dan tidak dapat dipulihkan.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-error-50 dark:bg-error-500/10 hover:bg-error-600 dark:hover:bg-error-500 text-error-600 dark:text-error-400 hover:text-white font-bold px-6 py-3 rounded-2xl transition-all border border-error-200 dark:border-error-500/20 hover:border-error-600 flex items-center gap-2 text-sm whitespace-nowrap">
                <i class="fas fa-trash-alt"></i> Hapus Akun Saya
            </button>
        </form>
    </div>
</div>

@endsection

@if($role === 'mitra')
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #pool-map { cursor: crosshair; }
    .leaflet-container { font-family: inherit; border-radius: 2rem !important; }
    .custom-marker { border: none !important; background: transparent !important; }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    let map;
    let marker;

    function initMap() {
        const defaultLat = {{ $user->pool->latitude ?? -6.200000 }};
        const defaultLng = {{ $user->pool->longitude ?? 106.816666 }};
        const loc = [defaultLat, defaultLng];

        map = L.map('pool-map', { zoomControl: false }).setView(loc, 15);
        L.control.zoom({ position: 'bottomright' }).addTo(map);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        const brandIcon = L.divIcon({
            className: 'custom-marker',
            html: `<div class="flex items-center justify-center relative" style="width: 44px; height: 44px;">
                        <div class="absolute inset-0 bg-white dark:bg-gray-900 rounded-full scale-110 shadow-xl border border-gray-100 dark:border-gray-800"></div>
                        <div class="relative flex items-center justify-center shadow-lg" style="background-color:#F5D042; width: 34px; height: 34px; border-radius: 50% 50% 50% 0; transform: rotate(-45deg); border: 3px solid white;">
                            <i class="fas fa-map-pin" style="color: #0A174E; font-size: 11px; transform: rotate(45deg);"></i>
                        </div>
                   </div>`,
            iconSize: [44, 44],
            iconAnchor: [22, 40]
        });

        marker = L.marker(loc, {
            draggable: true,
            icon: brandIcon
        }).addTo(map);

        marker.on('dragend', function(event) {
            const position = marker.getLatLng();
            updateCoords(position.lat, position.lng);
        });

        map.on('click', function(e) {
            const lat = e.latlng.lat;
            const lng = e.latlng.lng;
            marker.setLatLng([lat, lng]);
            updateCoords(lat, lng);
        });
    }

    function updateCoords(lat, lng) {
        document.getElementById('f-lat').value = lat;
        document.getElementById('f-lng').value = lng;
    }

    window.onload = initMap;
</script>
@endpush
@endif
