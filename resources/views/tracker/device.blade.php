@extends('layouts.app')

@section('title', 'GPS Tracker - ' . $unit->plate_number)

@section('content')
<div class="min-h-screen bg-slate-900 flex flex-col items-center justify-center p-6 text-white">
    <div class="max-w-md w-full bg-slate-800 rounded-[2.5rem] p-8 shadow-2xl border border-slate-700 text-center">
        <div class="mb-8">
            <div id="status-icon" class="w-24 h-24 bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-slate-600 transition-all duration-500">
                <i class="fas fa-location-arrow text-3xl text-slate-400"></i>
            </div>
            <h1 class="text-2xl font-black mb-1 italic tracking-tight">{{ $unit->vehicle->name }}</h1>
            <p class="text-slate-400 text-xs font-black uppercase tracking-widest">{{ $unit->plate_number }}</p>
        </div>

        <div id="tracking-status" class="mb-8 py-4 px-6 bg-slate-900/50 rounded-2xl border border-slate-700">
            <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Status Perangkat</p>
            <p id="status-text" class="text-sm font-bold text-slate-300 italic">Siap untuk pelacakan</p>
            <div id="server-status" class="mt-2 text-[9px] font-bold text-slate-500 uppercase flex items-center justify-center gap-1.5 hidden">
                <div class="w-1.5 h-1.5 rounded-full bg-slate-500" id="server-dot"></div>
                <span id="server-text">Menunggu data...</span>
            </div>
        </div>

        <div id="location-data" class="hidden grid grid-cols-2 gap-4 mb-8">
            <div class="bg-slate-900/50 p-4 rounded-xl border border-slate-700">
                <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">Latitude</p>
                <p id="lat-display" class="text-xs font-black font-mono">0.000000</p>
            </div>
            <div class="bg-slate-900/50 p-4 rounded-xl border border-slate-700">
                <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">Longitude</p>
                <p id="lng-display" class="text-xs font-black font-mono">0.000000</p>
            </div>
        </div>

        <button id="toggle-btn" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-5 rounded-2xl shadow-lg shadow-blue-900/40 transition-all active:scale-95 flex items-center justify-center gap-3">
            <i class="fas fa-play"></i>
            <span>MULAI PELACAKAN</span>
        </button>

        <p class="mt-8 text-[10px] text-slate-500 leading-relaxed">
            *Pastikan GPS menyala dan izinkan browser mengakses lokasi.<br>
            Jangan tutup halaman ini agar pelacakan tetap berjalan.
        </p>
    </div>
</div>

@push('scripts')
<script>
    let watchId = null;
    let isTracking = false;
    const toggleBtn = document.getElementById('toggle-btn');
    const statusText = document.getElementById('status-text');
    const statusIcon = document.getElementById('status-icon');
    const latDisplay = document.getElementById('lat-display');
    const lngDisplay = document.getElementById('lng-display');
    const locationData = document.getElementById('location-data');

    toggleBtn.addEventListener('click', () => {
        if (!isTracking) {
            startTracking();
        } else {
            stopTracking();
        }
    });

    function startTracking() {
        if (!navigator.geolocation) {
            alert("Browser Anda tidak mendukung GPS.");
            return;
        }

        isTracking = true;
        toggleBtn.innerHTML = '<i class="fas fa-stop"></i> <span>BERHENTI PELACAKAN</span>';
        toggleBtn.classList.replace('bg-blue-600', 'bg-red-600');
        toggleBtn.classList.replace('hover:bg-blue-700', 'hover:bg-red-700');
        statusText.innerText = "Mencari sinyal GPS...";
        statusIcon.classList.replace('text-slate-400', 'text-blue-400');
        statusIcon.classList.add('animate-pulse', 'border-blue-500/30');

        watchId = navigator.geolocation.watchPosition(
            (position) => {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                latDisplay.innerText = lat.toFixed(6);
                lngDisplay.innerText = lng.toFixed(6);
                locationData.classList.remove('hidden');
                statusText.innerText = "Lokasi aktif dikirim...";
                
                sendLocation(lat, lng);
            },
            (error) => {
                let msg = "Gagal mengambil lokasi.";
                if (error.code === 1) msg = "Izin lokasi ditolak.";
                statusText.innerText = msg;
                statusText.classList.add('text-red-400');
                stopTracking();
            },
            {
                enableHighAccuracy: true,
                maximumAge: 5000,
                timeout: 10000
            }
        );
    }

    function stopTracking() {
        if (watchId !== null) {
            navigator.geolocation.clearWatch(watchId);
            watchId = null;
        }
        isTracking = false;
        toggleBtn.innerHTML = '<i class="fas fa-play"></i> <span>MULAI PELACAKAN</span>';
        toggleBtn.classList.replace('bg-red-600', 'bg-blue-600');
        toggleBtn.classList.replace('hover:bg-red-700', 'hover:bg-blue-700');
        statusText.innerText = "Pelacakan dihentikan";
        statusText.classList.remove('text-red-400');
        statusIcon.classList.remove('animate-pulse', 'border-blue-500/30');
        statusIcon.classList.replace('text-blue-400', 'text-slate-400');
    }

    function sendLocation(lat, lng) {
        const serverStatus = document.getElementById('server-status');
        const serverDot = document.getElementById('server-dot');
        const serverText = document.getElementById('server-text');
        
        serverStatus.classList.remove('hidden');
        serverDot.className = 'w-1.5 h-1.5 rounded-full bg-blue-500 animate-ping';
        serverText.innerText = 'Mengirim...';

        fetch('/tracking/update/{{ $unit->tracking_token }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                latitude: lat,
                longitude: lng
            })
        })
        .then(response => {
            if (!response.ok) throw new Error('HTTP ' + response.status);
            return response.json();
        })
        .then(data => {
            console.log('Location updated:', data);
            serverDot.className = 'w-1.5 h-1.5 rounded-full bg-green-500';
            serverDot.classList.remove('animate-ping');
            serverText.innerText = 'Terkirim';
        })
        .catch(error => {
            console.error('Error updating location:', error);
            serverDot.className = 'w-1.5 h-1.5 rounded-full bg-red-500';
            serverDot.classList.remove('animate-ping');
            serverText.innerText = 'Gagal: ' + error.message;
        });
    }
</script>
@endpush
@endsection
