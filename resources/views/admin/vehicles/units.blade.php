@extends('layouts.admin')

@section('title', 'Manajemen Fisik Unit - ' . $vehicle->name)
@section('page-title', 'Detail Fisik Unit')
@section('page-subtitle', 'Mengelola plat nomor dan status tiap unit kendaraan')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.kendaraan.index') }}"
            class="flex items-center gap-2 text-slate-500 hover:text-blue-600 font-semibold transition-colors">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Armada
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-100 text-green-700 rounded-2xl flex items-center gap-3">
            <i class="fas fa-check-circle"></i>
            <p class="text-sm font-semibold">{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden p-8">
        <div class="flex gap-6 items-center border-b border-slate-100 pb-8 mb-8">
            <div class="w-32 h-20 rounded-xl overflow-hidden bg-slate-50 flex-shrink-0">
                <img src="{{ $vehicle->image ? asset('storage/' . $vehicle->image) : 'https://placehold.co/600x400?text=No+Image' }}"
                    class="w-full h-full object-cover">
            </div>
            <div>
                <h2 class="text-2xl font-black text-slate-900">{{ $vehicle->name }}</h2>
                <p class="text-sm font-semibold text-slate-500 mt-1">Total: {{ $units->count() }} Unit Terdaftar di Database
                    Fisik</p>
                <p class="text-[10px] uppercase font-bold text-slate-400 mt-2">Dikelola otomatis sesuai jumlah stok
                    "Kendaraan Master"</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach ($units as $index => $unit)
                <div
                    class="bg-slate-50 border border-slate-200 p-6 rounded-2xl relative overflow-hidden group hover:border-blue-300 transition-colors">

                    <div class="flex items-center justify-between mb-4">
                        <span
                            class="block px-3 py-1 bg-white border border-slate-200 rounded-lg text-xs font-black text-slate-700">Unit
                            #{{ $index + 1 }}</span>
                        @php
                            $colors =
                                [
                                    'tersedia' => 'bg-green-100 text-green-700',
                                    'disewa' => 'bg-blue-100 text-blue-700',
                                    'maintenance' => 'bg-orange-100 text-orange-700',
                                ][$unit->status] ?? 'bg-slate-100 text-slate-700';
                        @endphp
                        <span class="px-2.5 py-1 text-[10px] font-black uppercase rounded-full {{ $colors }}">
                            {{ $unit->status }}
                        </span>
                    </div>

                    <form action="{{ route('admin.kendaraan.unit.update', $unit->id) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Plat
                                Nomor Fisik</label>
                            <input type="text" name="plate_number" value="{{ $unit->plate_number }}"
                                placeholder="B 1234 XYZ"
                                class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all uppercase placeholder:normal-case">
                        </div>

                        <div>
                            <label
                                class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Penempatan
                                Lokasi Pool</label>
                            <input type="text" value="{{ $unit->pool->name ?? 'Pool Tersistem' }}" readonly
                                class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-500 cursor-not-allowed">
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Override
                                Status Manual</label>
                            <select name="status"
                                class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
                                <option value="tersedia" {{ $unit->status == 'tersedia' ? 'selected' : '' }}>🟢 Tersedia
                                    Bebas</option>
                                <option value="disewa" {{ $unit->status == 'disewa' ? 'selected' : '' }}>🔵 Sedang Disewa
                                </option>
                                <option value="maintenance" {{ $unit->status == 'maintenance' ? 'selected' : '' }}>🟠
                                    Sedang Masuk Bengkel</option>
                            </select>
                        </div>

                        <button type="submit"
                            class="w-full mt-4 bg-slate-900 hover:bg-slate-800 text-white font-bold py-2.5 rounded-xl transition-all shadow-md text-xs uppercase tracking-wider">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
@endsection
