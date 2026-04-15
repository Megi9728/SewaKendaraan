@extends('layouts.admin')

@section('title', 'Profil Saya')
@section('page-title', $user->role === 'admin' ? 'Profil Admin' : 'Profil Mitra')
@section('page-subtitle', 'Kelola informasi akun Anda di sini')

@section('content')

@if(session('success'))
<div class="mb-6 p-4 bg-green-50 border border-green-100 text-green-700 rounded-2xl flex items-center gap-3 animate-fade-in">
    <i class="fas fa-check-circle"></i>
    <p class="text-sm font-semibold">{{ session('success') }}</p>
</div>
@endif

<div class="max-w-4xl">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- Sisi Kiri: Ringkasan --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8 text-center">
                <div class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-5 border-4 border-blue-50">
                    <i class="fas fa-user-shield text-blue-600 text-3xl"></i>
                </div>
                <h3 class="font-bold text-slate-900 text-lg">{{ $user->name }}</h3>
                <p class="text-xs font-bold {{ $user->role === 'admin' ? 'text-red-500 bg-red-50' : 'text-blue-500 bg-blue-50' }} px-3 py-1 rounded-full inline-block mt-2 uppercase tracking-widest">
                    {{ $user->role === 'admin' ? 'Administrator' : 'Mitra Rental' }}
                </p>
                
                <div class="mt-8 pt-8 border-t border-slate-50 space-y-4 text-left">
                    <div class="flex items-center gap-3 text-slate-500">
                        <i class="fas fa-envelope text-xs w-4"></i>
                        <span class="text-xs truncate">{{ $user->email }}</span>
                    </div>
                    <div class="flex items-center gap-3 text-slate-500">
                        <i class="fas fa-calendar-alt text-xs w-4"></i>
                        <span class="text-xs">Bergabung: {{ $user->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sisi Kanan: Form Edit --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-50 bg-slate-50/30">
                    <h3 class="font-bold text-slate-800">Edit Informasi Akun</h3>
                </div>
                
                <form action="{{ $user->role === 'admin' ? route('admin.profile.update') : route('mitra.profile.update') }}" method="POST" class="p-8 space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:bg-white transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:bg-white transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">No. WhatsApp</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:bg-white transition-all">
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-50">
                        <h4 class="text-sm font-bold text-slate-800 mb-6">Ubah Password <span class="text-[10px] font-normal text-slate-400 ml-1">(Biarkan kosong jika tidak diubah)</span></h4>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Password Baru</label>
                                <input type="password" name="password" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:bg-white transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:bg-white transition-all">
                            </div>
                        </div>
                    </div>

                    @if($user->role === 'mitra')
                    <div class="pt-6 border-t border-slate-50">
                        <h4 class="text-sm font-bold text-slate-800 mb-6">Lokasi Pool Utama <span class="text-[10px] font-normal text-slate-400 ml-1">(Lokasi penempatan kendaraan)</span></h4>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Alamat Lengkap Pool</label>
                                <div class="relative">
                                    <input type="text" name="pool_address" id="f-pool-address" placeholder="Contoh: Jl. Sudirman No. 123, Jakarta" value="{{ $user->pool->address ?? '' }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 pl-10 text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:bg-white transition-all">
                                    <i class="fas fa-map-marked-alt absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                </div>
                                <p class="text-[10px] text-slate-400 mt-2 italic">*Ketik alamat lengkap atau klik pada peta di bawah untuk menentukan titik koordinat secara otomatis.</p>
                                
                                <input type="hidden" name="latitude" id="f-lat" value="{{ $user->pool->latitude ?? '' }}">
                                <input type="hidden" name="longitude" id="f-lng" value="{{ $user->pool->longitude ?? '' }}">
                            </div>
                            <div id="pool-map" class="w-full h-64 rounded-2xl border border-slate-100"></div>
                        </div>
                    </div>
                    @endif

                    <div class="pt-4">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-8 py-3.5 rounded-xl transition-all active:scale-95 shadow-lg shadow-blue-100 flex items-center gap-2">
                            <i class="fas fa-save text-sm"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@if($user->role === 'mitra')
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #pool-map { 
        height: 350px; 
        border-radius: 20px; 
        z-index: 10;
        cursor: crosshair;
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    let map;
    let marker;

    // Fix Leaflet marker icon issue from CDN
    delete L.Icon.Default.prototype._getIconUrl;
    L.Icon.Default.mergeOptions({
        iconRetinaUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon-2x.png',
        iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
        shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
    });

    function initMap() {
        const defaultLat = {{ $user->pool->latitude ?? -6.200000 }};
        const defaultLng = {{ $user->pool->longitude ?? 106.816666 }};
        const loc = [defaultLat, defaultLng];

        map = L.map('pool-map').setView(loc, 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        marker = L.marker(loc, {
            draggable: true
        }).addTo(map);

        marker.on('dragend', function(event) {
            const position = marker.getLatLng();
            updateCoords(position.lat, position.lng);
        });

        // Click to place marker
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
