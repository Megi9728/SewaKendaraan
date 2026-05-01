@extends('layouts.driver')

@section('title', 'Dashboard Driver')
@section('page-title', 'Dashboard Driver')
@section('page-subtitle', 'Pantau jadwal dan tugas penjemputan Anda')

@section('content')
<div class="space-y-8">
    {{-- Driver Info Card --}}
    <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm overflow-hidden relative group">
        <div class="flex flex-col md:flex-row items-center gap-8 relative z-10">
            <div class="w-32 h-32 rounded-3xl overflow-hidden bg-slate-100 shadow-xl shadow-slate-200">
                <img src="{{ $driver && $driver->photo ? asset('storage/' . $driver->photo) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=random' }}" class="w-full h-full object-cover">
            </div>
            <div class="text-center md:text-left">
                <h2 class="text-3xl font-black text-slate-900 leading-tight mb-2">Halo, {{ auth()->user()->name }}!</h2>
                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-6"><i class="fas fa-id-badge mr-2"></i> ID Driver: #DRV-{{ $driver->id ?? auth()->id() }}</p>
                
                <div class="flex flex-wrap justify-center md:justify-start gap-4">
                    <div class="px-5 py-2.5 bg-green-50 text-green-700 rounded-xl border border-green-100 flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                        <span class="text-xs font-black uppercase tracking-wider">Status: {{ $driver->status ?? 'Active' }}</span>
                    </div>
                    <div class="px-5 py-2.5 bg-blue-50 text-blue-700 rounded-xl border border-blue-100 flex items-center gap-2">
                        <i class="fas fa-star text-yellow-500 text-xs"></i>
                        <span class="text-xs font-black uppercase tracking-wider">Rating: {{ number_format($driver->rating ?? 5.0, 1) }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Background Decoration --}}
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-blue-50 rounded-full opacity-50 group-hover:scale-110 transition-transform duration-700"></div>
    </div>

    {{-- Tasks Section --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        <div class="xl:col-span-2 bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-8 py-7 border-b border-slate-50 flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-black text-slate-900 leading-none">Tugas Penjemputan</h3>
                    <p class="text-xs text-slate-400 mt-2 font-medium">Daftar pesanan yang harus Anda tangani</p>
                </div>
                <span class="bg-blue-600 text-white text-[10px] font-black px-3 py-1.5 rounded-lg uppercase tracking-widest">{{ $bookings->count() }} Total</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Waktu & Unit</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Pelanggan</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($bookings as $b)
                        <tr class="hover:bg-slate-50/30 transition-colors">
                            <td class="px-8 py-5">
                                <p class="text-sm font-black text-slate-800">{{ $b->start_date->format('d M Y') }}</p>
                                <p class="text-[10px] text-blue-600 font-bold uppercase tracking-wider mt-1">{{ $b->vehicle->name }}</p>
                            </td>
                            <td class="px-8 py-5">
                                <p class="text-sm font-bold text-slate-700">{{ $b->customer->name }}</p>
                                <p class="text-[10px] text-slate-400 font-medium italic">{{ $b->days }} Hari Sewa</p>
                            </td>
                            <td class="px-8 py-5">
                                @php
                                    $colors = [
                                        'Pending' => 'bg-orange-100 text-orange-600',
                                        'Confirmed' => 'bg-blue-100 text-blue-600',
                                        'Completed' => 'bg-green-100 text-green-700',
                                        'Cancelled' => 'bg-red-100 text-red-600',
                                    ];
                                @endphp
                                <span class="text-[10px] font-black px-3 py-1.5 rounded-lg {{ $colors[$b->status] ?? 'bg-slate-100 text-slate-600' }} uppercase tracking-widest">
                                    {{ $b->status }}
                                </span>
                            </td>
                            <td class="px-8 py-5">
                                <button class="w-9 h-9 bg-slate-100 text-slate-400 rounded-xl hover:bg-blue-600 hover:text-white transition-all">
                                    <i class="fas fa-eye text-xs"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-8 py-20 text-center">
                                <div class="w-16 h-16 bg-slate-50 text-slate-200 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-calendar-alt text-2xl"></i>
                                </div>
                                <p class="text-sm font-bold text-slate-400 italic">Belum ada tugas yang diberikan.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-slate-900 rounded-[2.5rem] shadow-2xl p-10 text-white relative overflow-hidden h-fit">
            <h3 class="text-xl font-black mb-8 relative z-10">Ringkasan Performa</h3>
            
            <div class="space-y-6 relative z-10">
                <div class="flex justify-between items-center bg-white/5 p-5 rounded-2xl border border-white/5">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Tugas</span>
                    <span class="text-2xl font-black">{{ $bookings->count() }}</span>
                </div>
                <div class="flex justify-between items-center bg-white/5 p-5 rounded-2xl border border-white/5">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Tugas Selesai</span>
                    <span class="text-2xl font-black">{{ $bookings->where('status', 'Completed')->count() }}</span>
                </div>
                <div class="flex justify-between items-center bg-white/5 p-5 rounded-2xl border border-white/5">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Rating Anda</span>
                    <span class="text-2xl font-black">{{ number_format($driver->rating ?? 5.0, 1) }}</span>
                </div>
            </div>

            {{-- Decorative Icon --}}
            <i class="fas fa-route absolute -bottom-10 -right-10 text-[12rem] text-white/5 rotate-12"></i>
        </div>
    </div>
</div>
@endsection
