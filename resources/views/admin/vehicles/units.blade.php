@extends('layouts.admin')

@section('title', 'Manajemen Fisik Unit - ' . $vehicle->name)
@section('page-title', 'Detail Fisik Unit')
@section('page-subtitle', 'Mengelola plat nomor dan status tiap unit kendaraan')

@section('content')
    {{-- Breadcrumb / Header area --}}
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-title-md2 font-bold text-black dark:text-white text-2xl">
            Detail Fisik Unit
        </h2>
        <p class="text-sm text-body dark:text-bodydark mt-1">Mengelola plat nomor dan status tiap unit kendaraan</p>
    </div>
</div>

<div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.kendaraan.index') }}"
            class="flex items-center gap-2 text-body dark:text-bodydark hover:text-primary font-bold transition-colors">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Armada
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-success/10 border border-success/20 text-success rounded-xl flex items-center gap-3">
            <i class="fas fa-check-circle"></i>
            <p class="text-sm font-semibold">{{ session('success') }}</p>
        </div>
    @endif

    <div class="rounded-2xl border border-stroke bg-white shadow-sm dark:border-white/10 dark:bg-[#24303F] overflow-hidden p-4 sm:p-8">
        <div class="flex flex-col sm:flex-row gap-6 items-center border-b border-stroke dark:border-white/10 pb-8 mb-8 text-center sm:text-left">
            <div class="w-32 h-20 rounded-xl overflow-hidden bg-slate-50 flex-shrink-0">
                <img src="{{ $vehicle->image ? asset('storage/' . $vehicle->image) : 'https://placehold.co/600x400?text=No+Image' }}"
                    class="w-full h-full object-cover">
            </div>
            <div>
                <h2 class="text-2xl font-bold text-black dark:text-white">{{ $vehicle->name }}</h2>
                <p class="text-sm font-medium text-body dark:text-bodydark mt-1">Total: {{ $units->count() }} Unit Terdaftar di Database
                    Fisik</p>
                <p class="text-[10px] uppercase font-bold text-body dark:text-bodydark mt-2">Dikelola otomatis sesuai jumlah stok
                    "Kendaraan Master"</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach ($units as $index => $unit)
                <div class="bg-slate-50 dark:bg-white/5 border border-stroke dark:border-white/10 p-4 sm:p-6 rounded-xl relative overflow-hidden group hover:border-primary transition-colors">

                    <div class="flex items-center justify-between mb-4">
                        <span class="block px-3 py-1 bg-white dark:bg-[#24303F] border border-stroke dark:border-white/10 rounded-lg text-xs font-bold text-black dark:text-white shadow-sm">Unit
                            #{{ $index + 1 }}</span>
                        @php
                            $colors =
                                [
                                    'tersedia' => 'bg-success/10 text-success',
                                    'disewa' => 'bg-primary/10 text-primary',
                                    'maintenance' => 'bg-warning/10 text-warning dark:text-orange-400',
                                ][$unit->status] ?? 'bg-body/10 text-body dark:text-bodydark';
                        @endphp
                        <span class="px-2.5 py-1 text-[10px] font-black uppercase rounded-full {{ $colors }}">
                            {{ $unit->status }}
                        </span>
                    </div>

                    <form action="{{ route('admin.kendaraan.unit.update', $unit->id) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-[10px] font-bold text-body dark:text-bodydark uppercase tracking-wider mb-2">Plat
                                Nomor Fisik</label>
                            <input type="text" name="plate_number" value="{{ $unit->plate_number }}" placeholder="B 1234 XYZ" class="w-full rounded border-[1.5px] border-stroke bg-transparent py-2.5 px-4 text-sm font-medium outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary text-black dark:text-white uppercase placeholder:normal-case">
                        </div>

                        <div>
                            <label
                                class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Penempatan
                                Lokasi Pool</label>
                            <input type="text" value="{{ $unit->pool->name ?? 'Pool Tersistem' }}" readonly class="w-full rounded border-[1.5px] border-stroke bg-gray-100 py-2.5 px-4 text-sm font-medium outline-none dark:border-white/10 dark:bg-white/5 text-body dark:text-bodydark cursor-not-allowed">
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-body dark:text-bodydark uppercase tracking-wider mb-2">Override
                                Status Manual</label>
                            <div class="relative"><select name="status" class="w-full appearance-none rounded border-[1.5px] border-stroke bg-transparent py-2.5 px-4 text-sm font-medium outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary text-black dark:text-white relative z-20">
                                <option value="tersedia" {{ $unit->status == 'tersedia' ? 'selected' : '' }}>🟢 Tersedia
                                    Bebas</option>
                                <option value="disewa" {{ $unit->status == 'disewa' ? 'selected' : '' }}>🔵 Sedang Disewa
                                </option>
                                <option value="maintenance" {{ $unit->status == 'maintenance' ? 'selected' : '' }}>🟠
                                    Sedang Masuk Bengkel</option>
                            </select><div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none z-30"><i class="fas fa-chevron-down text-body dark:text-bodydark text-xs"></i></div></div>
                        </div>

                        <button type="submit" class="w-full mt-4 bg-primary hover:bg-opacity-90 text-white font-bold py-2.5 rounded-lg transition-all shadow-sm text-xs uppercase tracking-wider">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
@endsection
