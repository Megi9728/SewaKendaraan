@extends('layouts.admin')

@section('title', 'Dashboard Mitra')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-5">
        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
            <i class="fas fa-car text-xl"></i>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest leading-none mb-1">Total Armada</p>
            <p class="text-2xl font-black text-slate-900">{{ $stats['total_mobil'] }}</p>
        </div>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-5">
        <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-xl flex items-center justify-center">
            <i class="fas fa-calendar-check text-xl"></i>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest leading-none mb-1">Total Booking</p>
            <p class="text-2xl font-black text-slate-900">{{ $stats['total_booking'] }}</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center">
        <h3 class="text-lg font-black text-slate-900">Pesanan Masuk (Terbaru)</h3>
        <a href="{{ route('mitra.booking.index') }}" class="text-xs font-bold text-blue-600 uppercase tracking-widest">Lihat Semua</a>
    </div>
    <div class="p-8">
        <p class="text-center text-slate-400 italic">Antarmuka pengelolaan booking untuk mitra sedang disiapkan.</p>
    </div>
</div>
@endsection
