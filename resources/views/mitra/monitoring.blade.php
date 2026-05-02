@extends('layouts.admin')

@section('title', 'Live Monitoring')

@section('content')

{{-- Header Area --}}
<div class="mb-8 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">
            Pelacakan Real-Time
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Pantau posisi dan status armada Anda secara langsung.</p>
    </div>
    <div class="flex items-center gap-3">
        <div class="bg-white dark:bg-white/[0.03] border border-gray-200 dark:border-gray-800 px-6 py-2.5 rounded-2xl flex items-center gap-3 shadow-sm">
            <div class="w-2.5 h-2.5 rounded-full bg-success-500 animate-pulse"></div>
            <span class="text-[10px] font-bold uppercase tracking-widest text-gray-500 dark:text-gray-400">Sistem Pelacakan Aktif</span>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
    {{-- Sidebar: List Unit --}}
    <div class="lg:col-span-1 flex flex-col gap-4 max-h-[700px] overflow-y-auto pr-2 custom-scrollbar">
        @php $count = 0; @endphp
        @foreach($vehicles as $v)
            @foreach($v->units as $unit)
            @php $count++; @endphp
            <div class="bg-white dark:bg-white/[0.03] p-5 rounded-[2rem] border {{ $unit->latitude ? 'border-gray-100 dark:border-gray-800 shadow-sm' : 'border-gray-50 dark:border-white/5 opacity-60' }} hover:border-brand-500 transition-all cursor-pointer group relative overflow-hidden" 
                 @if($unit->latitude) onclick="focusUnit({{ $unit->latitude }}, {{ $unit->longitude }}, {{ $unit->id }})" @endif>
                
                {{-- Background Accent --}}
                <div class="absolute top-0 right-0 w-24 h-24 bg-brand-500/5 rounded-full -mr-12 -mt-12 transition-transform group-hover:scale-150"></div>

                <div class="flex items-center gap-4 relative z-10">
                    <div class="w-12 h-12 {{ $unit->latitude ? 'bg-brand-500/10 text-brand-600 dark:text-brand-400' : 'bg-gray-100 text-gray-400' }} rounded-2xl flex items-center justify-center group-hover:bg-brand-500 group-hover:text-white transition-all duration-300">
                        <i class="fas fa-car text-lg"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <div id="indicator-{{ $unit->id }}" class="w-2.5 h-2.5 rounded-full border-2 border-white dark:border-gray-900 shadow-sm flex-shrink-0"></div>
                            <h4 class="font-bold text-gray-800 dark:text-white truncate group-hover:text-brand-500 transition-colors">{{ $v->name }}</h4>
                        </div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-tighter ml-4.5">{{ $unit->plate_number }}</p>
                    </div>
                    
                    @if($unit->latitude)
                        @php $isActive = $unit->last_tracked_at && \Carbon\Carbon::parse($unit->last_tracked_at)->greaterThan(now()->subMinutes(5)); @endphp
                        <div class="flex flex-col items-center">
                            <div class="w-2.5 h-2.5 rounded-full {{ $isActive ? 'bg-success-500 animate-pulse' : 'bg-gray-300' }}"></div>
                            <span class="text-[7px] font-black {{ $isActive ? 'text-success-500' : 'text-gray-400' }} mt-1 tracking-tighter uppercase">{{ $isActive ? 'LIVE' : 'OFF' }}</span>
                        </div>
                    @endif
                </div>

                <div class="mt-5 flex flex-col gap-3 relative z-10">
                    <button onclick="copyTrackerLink('{{ route('tracker.device', $unit->tracking_token) }}', event)" 
                            class="w-full bg-gray-50 dark:bg-white/5 hover:bg-brand-500 hover:text-white text-gray-500 dark:text-gray-400 text-[10px] font-bold py-3 rounded-xl transition-all flex items-center justify-center gap-2 border border-gray-100 dark:border-gray-800 active:scale-95 shadow-sm">
                        <i class="fas fa-link text-[10px]"></i> SALIN LINK TRACKER
                    </button>
                    <div class="flex justify-between items-center px-1">
                        <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Update</span>
                        <span class="text-[9px] font-bold text-gray-600 dark:text-gray-400">
                            {{ $unit->last_tracked_at ? \Carbon\Carbon::parse($unit->last_tracked_at)->diffForHumans() : 'No Data' }}
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        @endforeach

        @if($count === 0)
        <div class="bg-gray-50 dark:bg-white/[0.02] rounded-[2.5rem] p-12 text-center border-2 border-dashed border-gray-100 dark:border-gray-800">
            <i class="fas fa-satellite text-4xl text-gray-200 dark:text-gray-700 mb-4 block"></i>
            <p class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Belum ada unit</p>
        </div>
        @endif
    </div>

    {{-- Main: Map --}}
    <div class="lg:col-span-3">
        <div class="bg-white dark:bg-white/[0.03] p-3 rounded-[3rem] shadow-2xl border border-gray-200 dark:border-gray-800 relative overflow-hidden h-[700px]">
            <div id="map" class="w-full h-full rounded-[2.5rem] z-0"></div>
            
            {{-- Map Overlay Info --}}
            <div id="map-info" class="hidden absolute top-10 left-10 z-[10] bg-white/95 dark:bg-gray-900/95 backdrop-blur-xl p-6 rounded-3xl border border-white/20 shadow-2xl max-w-xs animate-in slide-in-from-left-4 duration-500">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-brand-500 flex items-center justify-center text-white shadow-lg shadow-brand-500/20">
                        <i class="fas fa-car-side text-lg"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-brand-500 uppercase tracking-widest mb-0.5">Memantau Unit</p>
                        <p id="monitoring-name" class="text-base font-bold text-gray-800 dark:text-white tracking-tight"></p>
                        <p id="monitoring-plate" class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-tighter"></p>
                    </div>
                </div>
            </div>

            {{-- Map Legend --}}
            <div class="absolute bottom-10 right-10 z-[10] bg-white/90 dark:bg-gray-900/90 backdrop-blur-md px-6 py-4 rounded-2xl border border-white/20 shadow-xl hidden sm:block">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Keterangan Status</p>
                <div class="flex flex-col gap-2.5">
                    <div class="flex items-center gap-3">
                        <div class="w-2.5 h-2.5 rounded-full bg-success-500"></div>
                        <span class="text-[10px] font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wide">Aktif (Live)</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-2.5 h-2.5 rounded-full bg-gray-300 dark:bg-gray-700"></div>
                        <span class="text-[10px] font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wide">Offline (>5m)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map { cursor: crosshair; }
    .custom-marker { border: none !important; background: transparent !important; }
    .leaflet-container { font-family: inherit; }
    .leaflet-popup-content-wrapper { border-radius: 1.5rem !important; padding: 5px !important; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1), 0 8px 10px -6px rgba(0,0,0,0.1) !important; }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    // Initialize Map
    const map = L.map('map', { zoomControl: false }).setView([-6.2088, 106.8456], 12);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);
    L.control.zoom({ position: 'bottomright' }).addTo(map);

    // Color Palette
    const colors = ['#465fff', '#12b76a', '#f79009', '#f04438', '#7a5af8', '#ee46bc', '#0ba5ec', '#2e90fa', '#667085'];
    
    // Marker Icon Generator
    function createMarkerIcon(color) {
        return L.divIcon({
            className: 'custom-marker',
            html: `<div class="flex items-center justify-center relative" style="width: 44px; height: 44px;">
                        <div class="absolute inset-0 bg-white dark:bg-gray-900 rounded-full scale-110 shadow-2xl border border-gray-100 dark:border-gray-800"></div>
                        <div class="relative flex items-center justify-center shadow-lg" style="background-color:${color}; width: 34px; height: 34px; border-radius: 50% 50% 50% 0; transform: rotate(-45deg); border: 3px solid white;">
                            <i class="fas fa-car" style="color: white; font-size: 11px; transform: rotate(45deg);"></i>
                        </div>
                   </div>`,
            iconSize: [44, 44],
            iconAnchor: [22, 40],
            popupAnchor: [0, -35]
        });
    }

    const markers = {};
    const unitData = {};

    function focusUnit(lat, lng, id) {
        if (lat && lng) {
            map.flyTo([lat, lng], 16, { duration: 1.5 });
            if (markers[id]) {
                markers[id].openPopup();
                const info = unitData[id];
                document.getElementById('monitoring-name').innerText = info.name;
                document.getElementById('monitoring-plate').innerText = info.plate;
                document.getElementById('map-info').style.borderLeft = `6px solid ${info.color}`;
                document.getElementById('map-info').classList.remove('hidden');
            }
        }
    }

    // Process Unit Data
    @foreach($vehicles as $v)
        @foreach($v->units as $unit)
            (function() {
                const color = colors[{{ $unit->id % 9 }}];
                const uId = {{ $unit->id }};
                
                unitData[uId] = {
                    name: @json($v->name),
                    plate: @json($unit->plate_number),
                    color: color
                };

                const listInd = document.getElementById('indicator-' + uId);
                if(listInd) listInd.style.backgroundColor = color;

                @if($unit->latitude && $unit->longitude)
                    @php $isActive = $unit->last_tracked_at && \Carbon\Carbon::parse($unit->last_tracked_at)->greaterThan(now()->subMinutes(5)); @endphp
                    
                    markers[uId] = L.marker([{{ $unit->latitude }}, {{ $unit->longitude }}], {
                        icon: createMarkerIcon(color),
                        opacity: {{ $isActive ? 1 : 0.7 }}
                    })
                    .addTo(map)
                    .bindPopup(`<div class="p-3 text-center">
                        <p class="text-xs font-black uppercase tracking-widest mb-1" style="color:${color}">${unitData[uId].name}</p>
                        <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-tighter mb-3">${unitData[uId].plate}</p>
                        <div class="px-3 py-1 rounded-full text-[8px] font-black uppercase tracking-widest {{ $isActive ? 'bg-success-500 text-white shadow-lg shadow-success-500/20' : 'bg-gray-100 text-gray-400 dark:bg-white/5' }}">
                            {{ $isActive ? 'LIVE TRACKING' : 'OFFLINE' }}
                        </div>
                    </div>`);
                @endif
            })();
        @endforeach
    @endforeach

    // Auto-fit bounds
    const markerArray = Object.values(markers);
    if (markerArray.length > 0) {
        const group = new L.featureGroup(markerArray);
        map.fitBounds(group.getBounds().pad(0.3));
    }

    // Utility: Copy Link
    function copyTrackerLink(link, event) {
        if(event) event.stopPropagation();
        navigator.clipboard.writeText(link).then(() => {
            alert('Link tracker disalin! Berikan ke pengemudi untuk pelacakan langsung.');
        });
    }

    // Auto Refresh (3 min)
    setInterval(() => { location.reload(); }, 180000);
</script>
@endpush
