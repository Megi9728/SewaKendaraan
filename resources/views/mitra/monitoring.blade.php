@extends('layouts.admin')

@section('page-title', 'Live Monitoring')
@section('page-subtitle', 'Pantau posisi armada Anda secara real-time')

@section('content')
<div class="px-4 py-6">
    <div class="flex justify-end mb-6">
        <div class="bg-white border border-slate-200 px-6 py-3 rounded-2xl flex items-center gap-3 shadow-sm">
            <div class="w-2.5 h-2.5 rounded-full bg-green-500 animate-pulse"></div>
            <span class="text-[10px] font-black uppercase tracking-widest text-slate-600">Sistem Pelacakan Aktif</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        {{-- List Kendaraan --}}
        <div class="lg:col-span-1 space-y-4 max-h-[600px] overflow-y-auto pr-2 custom-scrollbar">
            @php $count = 0; @endphp
            @foreach($vehicles as $v)
                @foreach($v->units as $unit)
                @php $count++; @endphp
                <div class="bg-white p-5 rounded-2xl border {{ $unit->latitude ? 'border-slate-100 shadow-sm' : 'border-slate-50 opacity-60' }} hover:border-blue-500 transition-all cursor-pointer group" 
                     @if($unit->latitude) onclick="focusUnit({{ $unit->latitude }}, {{ $unit->longitude }}, {{ $unit->id }})" @endif>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 {{ $unit->latitude ? 'bg-blue-50 text-blue-600' : 'bg-slate-50 text-slate-300' }} rounded-xl flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-all">
                            <i class="fas fa-car text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2">
                                <div id="indicator-{{ $unit->id }}" class="w-3 h-3 rounded-full border-2 border-white shadow-sm" style="background-color: #cbd5e1;"></div>
                                <h4 class="font-black text-slate-900 leading-none group-hover:text-blue-600 transition-colors">{{ $v->name }}</h4>
                            </div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1.5 ml-5">{{ $unit->plate_number }}</p>
                        </div>
                        @php
                            $isRecentlyActive = $unit->last_tracked_at && \Carbon\Carbon::parse($unit->last_tracked_at)->greaterThan(now()->subMinutes(5));
                        @endphp
                        
                        @if($unit->latitude)
                            @if($isRecentlyActive)
                                <div class="flex flex-col items-center">
                                    <div class="w-2.5 h-2.5 rounded-full bg-green-500 shadow-lg shadow-green-200 animate-pulse"></div>
                                    <span class="text-[7px] font-black text-green-500 mt-1 uppercase">LIVE</span>
                                </div>
                            @else
                                <div class="flex flex-col items-center">
                                    <div class="w-2.5 h-2.5 rounded-full bg-slate-300 shadow-sm"></div>
                                    <span class="text-[7px] font-black text-slate-400 mt-1 uppercase">OFF</span>
                                </div>
                            @endif
                        @endif
                    </div>
                    <div class="mt-4 flex gap-2">
                        <button onclick="copyTrackerLink('{{ route('tracker.device', $unit->tracking_token) }}')" class="flex-1 bg-slate-50 hover:bg-slate-100 text-slate-400 text-[9px] font-black py-2 rounded-lg transition-all flex items-center justify-center gap-2">
                            <i class="fas fa-link"></i> SALIN LINK TRACKER
                        </button>
                    </div>
                    <div class="mt-3 pt-3 border-t border-slate-50 flex justify-between items-center">
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Update Terakhir</span>
                        <span class="text-[9px] font-bold text-slate-600">
                            {{ $unit->last_tracked_at ? \Carbon\Carbon::parse($unit->last_tracked_at)->diffForHumans() : 'Belum ada data' }}
                        </span>
                    </div>
                </div>
                @endforeach
            @endforeach

            @if($count === 0)
            <div class="bg-slate-50 rounded-[2rem] p-8 text-center border-2 border-dashed border-slate-200">
                <i class="fas fa-satellite text-4xl text-slate-200 mb-4"></i>
                <p class="text-sm font-bold text-slate-400 italic">Belum ada unit yang didaftarkan</p>
            </div>
            @endif
        </div>

        {{-- Map --}}
        <div class="lg:col-span-3">
            <div class="bg-white p-2 rounded-[3rem] shadow-2xl border border-slate-100 relative overflow-hidden">
                <div id="map" class="w-full h-[600px] rounded-[2.5rem] z-0"></div>
                
                {{-- Map Overlay Info --}}
                <div id="map-info" class="hidden absolute top-8 left-8 z-[10] bg-white/90 backdrop-blur-md p-4 rounded-2xl border border-white/20 shadow-xl max-w-xs transition-all duration-500">
                    <p class="text-[10px] font-black text-blue-500 uppercase tracking-widest mb-1">Sedang Memantau</p>
                    <p id="monitoring-name" class="text-sm font-black text-slate-900"></p>
                    <p id="monitoring-plate" class="text-[10px] font-bold text-slate-400 italic"></p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map { cursor: crosshair; }
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    // 1. Inisialisasi Peta
    const map = L.map('map').setView([-6.2088, 106.8456], 12);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

    // 2. Data Palet Warna
    const colors = ['#3b82f6', '#ef4444', '#10b981', '#f59e0b', '#8b5cf6', '#ec4899', '#06b6d4', '#14b8a6', '#f43f5e'];
    
    // 3. Helper Fungsi Marker
    function createMarkerIcon(color) {
        return L.divIcon({
            className: 'custom-marker',
            html: `<div class="flex items-center justify-center" style="background-color:${color}; width: 30px; height: 30px; border-radius: 50% 50% 50% 0; transform: rotate(-45deg); border: 3px solid white; box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.2);">
                        <i class="fas fa-car" style="color: white; font-size: 11px; transform: rotate(45deg);"></i>
                   </div>`,
            iconSize: [30, 30],
            iconAnchor: [15, 30],
            popupAnchor: [0, -30]
        });
    }

    const markers = {};
    const unitData = {};

    function focusUnit(lat, lng, id) {
        if (lat && lng) {
            map.flyTo([lat, lng], 16);
            if (markers[id]) {
                markers[id].openPopup();
                const info = unitData[id];
                document.getElementById('monitoring-name').innerText = info.name;
                document.getElementById('monitoring-plate').innerText = info.plate;
                document.getElementById('map-info').style.borderLeft = `4px solid ${info.color}`;
                document.getElementById('map-info').classList.remove('hidden');
            }
        }
    }

    // 4. Proses Data Kendaraan dari PHP ke JS
    let currentIdx = 0;
    @foreach($vehicles as $v)
        @foreach($v->units as $unit)
            @php
                $assignedColor = $unit->id % 9; // Gunakan modulo agar konsisten
            @endphp
            
            (function() {
                const color = colors[{{ $assignedColor }}];
                const uId = {{ $unit->id }};
                
                unitData[uId] = {
                    name: @json($v->name),
                    plate: @json($unit->plate_number),
                    color: color
                };

                // Update warna indikator di list
                const listInd = document.getElementById('indicator-' + uId);
                if(listInd) listInd.style.backgroundColor = color;

                @if($unit->latitude && $unit->longitude)
                    @php
                        $isActive = $unit->last_tracked_at && \Carbon\Carbon::parse($unit->last_tracked_at)->greaterThan(now()->subMinutes(5));
                        $opacity = $isActive ? 1 : 0.4;
                    @endphp
                    
                    markers[uId] = L.marker([{{ $unit->latitude }}, {{ $unit->longitude }}], {
                        icon: createMarkerIcon(color),
                        opacity: {{ $opacity }}
                    })
                    .addTo(map)
                    .bindPopup(`<div class="p-1 px-2 text-center">
                        <b style="color:${color}">${unitData[uId].name}</b><br>
                        <span class="text-[10px] font-bold text-slate-400 text-uppercase">${unitData[uId].plate}</span>
                        @if(!$isActive)
                        <br><span class="text-[9px] font-bold text-red-500 uppercase mt-1">OFFLINE</span>
                        @endif
                    </div>`);
                @endif
            })();
            currentIdx++;
        @endforeach
    @endforeach

    // 5. Autofit Peta ke semua Marker
    const markerArray = Object.values(markers);
    if (markerArray.length > 0) {
        const group = new L.featureGroup(markerArray);
        map.fitBounds(group.getBounds().pad(0.2));
    }

    // 6. Fungsi Salin Link
    function copyTrackerLink(link) {
        navigator.clipboard.writeText(link).then(() => {
            alert('Link tracker berhasil disalin! Buka link ini di HP yang ada di dalam mobil.');
        });
    }

    // Auto refresh setiap 60 detik
    setInterval(() => {
        location.reload();
    }, 60000);
</script>
@endpush
@endsection
