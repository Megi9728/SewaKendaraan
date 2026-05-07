@extends('layouts.admin')

@section('title', 'Kelola Armada Kendaraan')

@section('content')

{{-- Header Area --}}
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-xl font-bold text-gray-800 dark:text-white tracking-tight">
            Manajemen Armada
        </h2>
        <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5 font-medium">Tambah, edit, dan kelola unit kendaraan operasional.</p>
    </div>
    <div class="flex items-center gap-3">
        <button id="btn-tambah" class="inline-flex items-center justify-center gap-2 rounded-xl bg-brand-500 py-2.5 px-5 text-center font-bold text-white hover:bg-brand-600 transition-all active:scale-95 shadow-lg shadow-brand-500/20 text-[10px] uppercase tracking-widest">
            <i class="fas fa-plus"></i> Tambah Unit
        </button>
    </div>
</div>

@if(session('success'))
<div class="mb-8 p-4 bg-success-50 dark:bg-success-500/10 border border-success-500/10 text-success-600 dark:text-success-400 rounded-2xl flex items-center gap-3 animate-in fade-in slide-in-from-top-4 duration-300">
    <i class="fas fa-check-circle"></i>
    <p class="text-sm font-semibold">{{ session('success') }}</p>
</div>
@endif

@if($errors->any())
<div class="mb-8 p-4 bg-error-50 dark:bg-error-500/10 border border-error-500/10 text-error-600 dark:text-error-400 rounded-2xl animate-in fade-in slide-in-from-top-4 duration-300">
    <div class="flex items-center gap-3 mb-2">
        <i class="fas fa-exclamation-circle"></i>
        <p class="text-sm font-bold">Terjadi Kesalahan Form:</p>
    </div>
    <ul class="list-disc list-inside text-xs font-medium space-y-1 ml-6 opacity-80">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

{{-- ===== TOOLBAR ===== --}}
<div class="bg-white dark:bg-white/[0.03] rounded-2xl border border-gray-200 dark:border-gray-800 p-3 mb-6 flex flex-col lg:flex-row gap-3 items-center">
    <div class="relative w-full lg:flex-1">
        <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
            <i class="fas fa-search text-gray-400 text-xs"></i>
        </div>
        <input type="text" id="search-vehicle" placeholder="Cari nama, brand, atau plat..." 
               class="pl-10 pr-4 py-2.5 w-full rounded-xl border border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-white/[0.03] text-xs font-medium outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 dark:text-white transition-all">
    </div>

    <div class="flex gap-3 w-full lg:w-auto">
        <div class="relative w-full sm:w-48">
            <select id="filter-status" class="w-full appearance-none rounded-xl border border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-white/[0.03] py-2.5 pl-4 pr-10 outline-none transition focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 dark:text-white text-[10px] font-bold uppercase tracking-wider">
                <option value="">Semua Status</option>
                <option value="tersedia">Tersedia</option>
                <option value="disewa">Disewa</option>
                <option value="perawatan">Perawatan</option>
            </select>
            <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                <i class="fas fa-chevron-down text-[9px]"></i>
            </div>
        </div>
    </div>
</div>

{{-- ===== TABLE ===== --}}
<div class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="overflow-x-auto custom-scrollbar">
        <table class="w-full text-left whitespace-nowrap">
            <thead class="bg-gray-50 dark:bg-white/[0.02] border-b border-gray-100 dark:border-gray-800">
                <tr>
                    <th class="py-3.5 px-6 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Unit & Informasi</th>
                    <th class="py-3.5 px-6 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Lokasi & Jenis</th>
                    <th class="py-3.5 px-6 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Spesifikasi</th>
                    <th class="py-3.5 px-6 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Harga/Hari</th>
                    <th class="py-3.5 px-6 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider text-center">Status</th>
                    <th class="py-3.5 px-6 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800" id="vehicle-table-body">
                @foreach($vehicles as $v)
                <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.01] transition-colors vehicle-row"
                    data-name="{{ strtolower($v->name) }}"
                    data-status="{{ strtolower($v->status) }}"
                    data-jenis="{{ strtolower($v->type) }}">
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl overflow-hidden bg-gray-100 dark:bg-white/5 border border-gray-200 dark:border-gray-800 flex-shrink-0">
                                <img src="{{ $v->image ? asset('storage/' . $v->image) : 'https://placehold.co/600x400?text=No+Image' }}" class="w-full h-full object-cover" alt="{{ $v->name }}">
                            </div>
                            <div>
                                <div class="flex items-center gap-2 mb-0.5">
                                    <p class="text-sm font-bold text-gray-800 dark:text-white tracking-tight leading-tight">{{ $v->name }}</p>
                                    @if($v->units->first() && $v->units->first()->plate_number)
                                        <span class="text-[8px] font-bold px-1.5 py-0.5 rounded-md bg-gray-100 dark:bg-white/10 text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-gray-700 uppercase leading-none">{{ $v->units->first()->plate_number }}</span>
                                    @endif
                                </div>
                                <p class="text-[10px] text-blue-600 font-bold uppercase mt-1 mb-0.5"><i class="fas fa-handshake mr-1"></i> {{ $v->mitra->name ?? 'Internal Jatara' }}</p>
                                <div class="flex items-center gap-2">
                                    <div class="flex text-[9px] text-warning-500">
                                        <i class="fas fa-star"></i>
                                        <span class="ml-1 font-bold">{{ $v->rating }}</span>
                                    </div>
                                    <span class="text-[9px] text-gray-400 font-medium">({{ $v->reviews_count }} Ulasan)</span>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex flex-col gap-0.5">
                            <div class="text-xs font-bold text-gray-800 dark:text-white/90 flex items-center gap-1.5">
                                <i class="fas fa-map-marker-alt text-error-500 text-[9px]"></i>
                                {{ $v->domicile ?? 'Jakarta' }}
                            </div>
                            <div class="text-[9px] text-gray-400 dark:text-gray-500 font-bold uppercase tracking-widest leading-none">{{ $v->type }}</div>
                        </div>
                    </td>
                    <td class="py-4 px-6">
                        <div class="grid grid-cols-2 gap-x-3 gap-y-0.5 max-w-[130px]">
                            <div class="flex items-center gap-1.5 text-[9px] font-bold text-gray-500 uppercase tracking-tighter">
                                <i class="fas fa-cogs text-[8px] opacity-50"></i>
                                {{ substr($v->transmission, 0, 3) }}
                            </div>
                            <div class="flex items-center gap-1.5 text-[9px] font-bold text-gray-500 uppercase tracking-tighter">
                                <i class="fas fa-users text-[8px] opacity-50"></i>
                                {{ $v->seats }}S
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-6">
                        <div class="text-xs font-bold text-brand-600 dark:text-brand-400">
                            <span class="text-[9px] font-medium opacity-60">Rp</span> {{ number_format($v->price_per_day, 0, ',', '.') }}
                        </div>
                    </td>
                    <td class="py-4 px-6 text-center">
                        @php
                            $statusClasses = [
                                'tersedia' => 'bg-success-50 text-success-600 border-success-200 dark:bg-success-500/10 dark:text-success-400 dark:border-success-500/20',
                                'disewa' => 'bg-brand-50 text-brand-600 border-brand-200 dark:bg-brand-500/10 dark:text-brand-400 dark:border-brand-500/20',
                                'perawatan' => 'bg-warning-50 text-warning-600 border-warning-200 dark:bg-warning-500/10 dark:text-warning-400 dark:border-warning-500/20',
                            ];
                            $class = $statusClasses[strtolower($v->status)] ?? 'bg-gray-50 text-gray-600 border-gray-200';
                        @endphp
                        <span class="inline-flex rounded-md px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider border {{ $class }}">
                            {{ $v->status }}
                        </span>
                    </td>
                    <td class="py-4 px-6 text-right">
                        <div class="flex items-center justify-end gap-1.5">
                            <button onclick="openEditModal({{ $v }})"
                                class="w-8 h-8 flex items-center justify-center bg-gray-50 dark:bg-white/5 text-gray-400 hover:text-brand-500 transition-all border border-gray-100 dark:border-gray-800 rounded-lg">
                                <i class="fas fa-edit text-[10px]"></i>
                            </button>
                            <button onclick="openDeleteModal({{ $v->id }}, '{{ $v->name }}')"
                                class="w-8 h-8 flex items-center justify-center bg-gray-50 dark:bg-white/5 text-gray-400 hover:text-error-500 transition-all border border-gray-100 dark:border-gray-800 rounded-lg">
                                <i class="fas fa-trash text-[10px]"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Table Footer --}}
    <div class="flex justify-between items-center px-8 py-5 border-t border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-white/[0.01]">
        <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">Total Terdaftar: <span class="text-gray-800 dark:text-white">{{ $vehicles->count() }}</span> Unit</p>
    </div>
</div>

{{-- ===== MODAL TAMBAH/EDIT ===== --}}
<div id="modal-form" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeModal('modal-form')"></div>
    <div class="bg-white dark:bg-[#121212] rounded-[2.5rem] shadow-2xl w-full max-w-4xl z-10 overflow-hidden flex flex-col border border-white/10 animate-in zoom-in duration-300">
        <div class="flex justify-between items-center px-10 py-8 border-b border-gray-100 dark:border-gray-800">
            <div>
                <h2 id="modal-title" class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">Tambah Kendaraan Baru</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Lengkapi informasi unit kendaraan di bawah ini.</p>
            </div>
            <button onclick="closeModal('modal-form')" class="w-11 h-11 flex items-center justify-center rounded-2xl text-gray-400 hover:bg-gray-100 dark:hover:bg-white/5 hover:text-gray-600 transition-all">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <form id="vehicle-form" class="p-10 space-y-8 max-h-[70vh] overflow-y-auto custom-scrollbar" action="{{ route('admin.kendaraan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div id="method-field"></div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Column 1: Core Info --}}
                <div class="md:col-span-2 space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="sm:col-span-2">
                            <label class="block text-theme-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-2.5">Nama Kendaraan</label>
                            <input type="text" name="name" id="f-name" placeholder="Contoh: Toyota Avanza 2024" 
                                   class="w-full bg-gray-50 dark:bg-white/[0.03] border border-gray-200 dark:border-gray-800 rounded-2xl px-5 py-3.5 text-sm font-medium text-gray-800 dark:text-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-theme-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-2.5">Domisili Cabang</label>
                            <div class="relative">
                                <select name="domicile" id="f-domicile" class="w-full appearance-none bg-gray-50 dark:bg-white/[0.03] border border-gray-200 dark:border-gray-800 rounded-2xl px-5 py-3.5 pr-10 text-sm font-medium text-gray-800 dark:text-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 outline-none transition-all">
                                    <option value="Jakarta">Jakarta</option>
                                    <option value="Bogor">Bogor</option>
                                    <option value="Depok">Depok</option>
                                    <option value="Tangerang">Tangerang</option>
                                    <option value="Bekasi">Bekasi</option>
                                </select>
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                                    <i class="fas fa-chevron-down text-[10px]"></i>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-theme-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-2.5">Jenis Unit</label>
                            <div class="relative">
                                <select name="type" id="f-type" class="w-full appearance-none bg-gray-50 dark:bg-white/[0.03] border border-gray-200 dark:border-gray-800 rounded-2xl px-5 py-3.5 pr-10 text-sm font-medium text-gray-800 dark:text-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 outline-none transition-all">
                                    <option value="Mobil">Mobil</option>
                                    <option value="Motor">Motor</option>
                                    <option value="Minibus">Minibus</option>
                                    <option value="SUV">SUV</option>
                                    <option value="MPV">MPV</option>
                                </select>
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                                    <i class="fas fa-chevron-down text-[10px]"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-6">
                        <div>
                            <label class="block text-theme-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-2.5">Transmisi</label>
                            <select name="transmission" id="f-transmission" class="w-full bg-gray-50 dark:bg-white/[0.03] border border-gray-200 dark:border-gray-800 rounded-2xl px-4 py-3.5 text-sm font-medium text-gray-800 dark:text-white outline-none">
                                <option value="Matic">Matic</option>
                                <option value="Manual">Manual</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-theme-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-2.5">Kapasitas</label>
                            <input type="number" name="seats" id="f-seats" placeholder="7" class="w-full bg-gray-50 dark:bg-white/[0.03] border border-gray-200 dark:border-gray-800 rounded-2xl px-4 py-3.5 text-sm font-medium text-gray-800 dark:text-white outline-none">
                        </div>
                        <div>
                            <label class="block text-theme-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-2.5">BBM</label>
                            <select name="fuel_type" id="f-fuel" class="w-full bg-gray-50 dark:bg-white/[0.03] border border-gray-200 dark:border-gray-800 rounded-2xl px-4 py-3.5 text-sm font-medium text-gray-800 dark:text-white outline-none">
                                <option value="Bensin">Bensin</option>
                                <option value="Diesel">Diesel</option>
                                <option value="Hybrid">Hybrid</option>
                                <option value="Elektrik">Elektrik</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-theme-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-2.5">Mesin (CC)</label>
                            <input type="number" name="engine_capacity" id="f-cc" placeholder="1500" class="w-full bg-gray-50 dark:bg-white/[0.03] border border-gray-200 dark:border-gray-800 rounded-2xl px-4 py-3.5 text-sm font-medium text-gray-800 dark:text-white outline-none">
                        </div>
                    </div>
                </div>

                {{-- Column 2: Photo & Price --}}
                <div class="space-y-6">
                    <div>
                        <label class="block text-theme-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-2.5">Foto Utama</label>
                        <div id="main-preview-area" class="w-full aspect-[4/3] rounded-3xl border-2 border-dashed border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-white/[0.03] flex flex-col items-center justify-center overflow-hidden relative group cursor-pointer hover:border-brand-500/50 transition-all">
                            <input type="file" name="image" id="f-image" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer z-10" onchange="previewMainImage(this)">
                            <div id="main-preview-placeholder" class="text-center group-hover:scale-105 transition-transform duration-500">
                                <div class="w-12 h-12 rounded-2xl bg-brand-500/10 text-brand-500 flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-camera text-xl"></i>
                                </div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Klik atau Tarik Foto</p>
                            </div>
                            <img id="main-preview-img" class="absolute inset-0 w-full h-full object-cover hidden">
                            <button type="button" id="btn-remove-main" onclick="removeMainImage(event)" class="absolute top-4 right-4 w-10 h-10 bg-error-500 text-white rounded-2xl flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all z-20 hidden shadow-xl active:scale-90">
                                <i class="fas fa-trash-alt text-xs"></i>
                            </button>
                            <input type="hidden" name="remove_main_image" id="remove-main-image-input" value="0">
                        </div>
                    </div>

                    <div>
                        <label class="block text-theme-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-2.5">Sewa Per Hari (Rp)</label>
                        <div class="relative">
                            <input type="number" name="price_per_day" id="f-price" placeholder="500000" 
                                   class="w-full bg-brand-50/50 dark:bg-brand-500/5 border border-brand-200 dark:border-brand-500/20 rounded-2xl px-5 py-3.5 pl-12 text-sm font-bold text-brand-600 dark:text-brand-400 focus:ring-2 focus:ring-brand-500/20 outline-none transition-all">
                            <div class="absolute left-5 top-1/2 -translate-y-1/2 font-bold text-brand-600/50 dark:text-brand-400/50 text-xs">Rp</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4">
                <div>
                    <label class="block text-theme-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-3">Galeri Foto Pendukung</label>
                    <div class="grid grid-cols-4 gap-3" id="gallery-management">
                        <div id="gallery-existing" class="contents"></div>
                        <div id="gallery-new" class="contents"></div>
                        
                        <div onclick="document.getElementById('f-gallery').click()" class="aspect-square rounded-2xl border-2 border-dashed border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-white/[0.03] flex flex-col items-center justify-center cursor-pointer hover:bg-brand-50 dark:hover:bg-brand-500/5 hover:border-brand-500/30 transition-all group">
                            <i class="fas fa-plus text-gray-300 dark:text-gray-700 text-lg group-hover:scale-110 transition-transform"></i>
                            <input type="file" id="f-gallery" multiple accept="image/*" class="hidden" onchange="previewGalleryImages(this)">
                        </div>
                    </div>
                    <div id="gallery-input-container" class="hidden"></div>
                </div>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-theme-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-2.5">Status & Inventori</label>
                        <div class="grid grid-cols-2 gap-4">
                            <select name="status" id="f-status" class="w-full bg-gray-50 dark:bg-white/[0.03] border border-gray-200 dark:border-gray-800 rounded-2xl px-4 py-3.5 text-sm font-medium text-gray-800 dark:text-white outline-none">
                                <option value="Tersedia">Tersedia</option>
                                <option value="Disewa">Disewa</option>
                                <option value="Perawatan">Perawatan</option>
                            </select>
                            <input type="text" name="plate_number" id="f-plate" placeholder="Plat Nomor (B 1234 ABC)" class="w-full bg-gray-50 dark:bg-white/[0.03] border border-gray-200 dark:border-gray-800 rounded-2xl px-4 py-3.5 text-sm font-medium text-gray-800 dark:text-white outline-none uppercase tracking-widest">
                        </div>
                    </div>
                    <div>
                        <label class="block text-theme-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-2.5">Deskripsi Unit</label>
                        <textarea name="description" id="f-desc" rows="3" placeholder="Jelaskan kondisi dan fitur unit ini..." 
                                  class="w-full bg-gray-50 dark:bg-white/[0.03] border border-gray-200 dark:border-gray-800 rounded-2xl px-5 py-4 text-sm font-medium text-gray-800 dark:text-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 outline-none transition-all resize-none"></textarea>
                    </div>
                </div>
            </div>

            <div class="flex gap-4 pt-8 border-t border-gray-100 dark:border-gray-800">
                <button type="button" onclick="closeModal('modal-form')" class="flex-1 border border-gray-200 dark:border-gray-800 dark:text-gray-400 font-bold py-4 rounded-2xl transition-all hover:bg-gray-50 dark:hover:bg-white/5 active:scale-95 text-sm">
                    Batal
                </button>
                <button type="submit" class="flex-[2] bg-brand-500 hover:bg-brand-600 text-white font-bold py-4 rounded-2xl transition-all active:scale-95 text-sm shadow-xl shadow-brand-500/20">
                    <i class="fas fa-save mr-3 opacity-70"></i>Simpan Perubahan Unit
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ===== MODAL HAPUS ===== --}}
<div id="modal-delete" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" onclick="closeModal('modal-delete')"></div>
    <div class="bg-white dark:bg-[#121212] rounded-[2.5rem] shadow-2xl w-full max-w-sm z-10 p-10 text-center border border-white/10 animate-in zoom-in duration-300">
        <div class="w-20 h-20 bg-error-50 dark:bg-error-500/10 rounded-[2rem] flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-trash-alt text-error-500 text-3xl"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-2 tracking-tight">Hapus Unit?</h3>
        <p class="text-gray-500 dark:text-gray-400 text-sm mb-8 leading-relaxed">Anda akan menghapus permanen unit <span id="delete-name" class="font-bold text-gray-800 dark:text-white"></span>.</p>
        
        <form id="delete-form" action="" method="POST" class="space-y-3">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-full bg-error-500 hover:bg-error-600 text-white font-bold py-4 rounded-2xl transition-all active:scale-95 text-sm shadow-lg shadow-error-500/20">Ya, Hapus Sekarang</button>
            <button type="button" onclick="closeModal('modal-delete')" class="w-full bg-gray-100 dark:bg-white/5 text-gray-600 dark:text-gray-400 font-bold py-4 rounded-2xl transition-all active:scale-95 text-sm">Batalkan</button>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // ====== MODAL ======
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
        document.body.style.overflow = '';
    }

    // Tambah Kendaraan
    document.getElementById('btn-tambah').addEventListener('click', function() {
        document.getElementById('modal-title').textContent = 'Tambah Kendaraan Baru';
        document.getElementById('vehicle-form').action = "{{ route('admin.kendaraan.store') }}";
        document.getElementById('method-field').innerHTML = '';
        document.getElementById('vehicle-form').reset();
        resetImagePreviews();
        openModal('modal-form');
    });

    function resetImagePreviews() {
        const img = document.getElementById('main-preview-img');
        img.src = '';
        img.classList.add('hidden');
        document.getElementById('main-preview-placeholder').classList.remove('hidden');
        document.getElementById('btn-remove-main').classList.add('hidden');
        document.getElementById('remove-main-image-input').value = "0";

        document.getElementById('gallery-existing').innerHTML = '';
        document.getElementById('gallery-new').innerHTML      = '';
        document.getElementById('gallery-input-container').innerHTML = '';
        galleryFilesSelected = []; 
    }

    // Main Image Preview
    window.previewMainImage = function(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.getElementById('main-preview-img');
                img.src = e.target.result;
                img.classList.remove('hidden');
                document.getElementById('main-preview-placeholder').classList.add('hidden');
                document.getElementById('btn-remove-main').classList.remove('hidden');
                document.getElementById('remove-main-image-input').value = "0";
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    window.removeMainImage = function(e) {
        if(e) e.stopPropagation();
        const img = document.getElementById('main-preview-img');
        img.src = '';
        img.classList.add('hidden');
        document.getElementById('f-image').value = ''; 
        document.getElementById('main-preview-placeholder').classList.remove('hidden');
        document.getElementById('btn-remove-main').classList.add('hidden');
        document.getElementById('remove-main-image-input').value = "1";
    }

    // Multi Gallery Previews
    let galleryFilesSelected = []; 

    window.previewGalleryImages = function(input) {
        if (input.files) {
            const container = document.getElementById('gallery-new');
            Array.from(input.files).forEach(file => {
                galleryFilesSelected.push(file);
                const reader = new FileReader();
                const previewId = 'new-img-' + Math.random().toString(36).substr(2, 9);
                reader.onload = e => {
                    const div = document.createElement('div');
                    div.id = previewId;
                    div.className = 'aspect-square rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-800 relative group animate-in fade-in zoom-in duration-300';
                    div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-full object-cover">
                        <button type="button" onclick="removeNewGalleryImage('${previewId}', '${file.name}')" class="absolute inset-0 bg-error-500/80 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <i class="fas fa-trash-alt text-[10px]"></i>
                        </button>
                    `;
                    container.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
            syncGalleryInput();
        }
    }

    function syncGalleryInput() {
        const inputStore = document.getElementById('gallery-input-container');
        inputStore.innerHTML = '';
        const dataTransfer = new DataTransfer();
        galleryFilesSelected.forEach(f => dataTransfer.items.add(f));
        const virtualInput = document.createElement('input');
        virtualInput.type = 'file'; virtualInput.name = 'gallery[]';
        virtualInput.multiple = true; virtualInput.files = dataTransfer.files;
        inputStore.appendChild(virtualInput);
    }

    window.removeNewGalleryImage = function(id, fileName) {
        document.getElementById(id).remove();
        galleryFilesSelected = galleryFilesSelected.filter(f => f.name !== fileName);
        syncGalleryInput();
    }

    // Edit Kendaraan
    function openEditModal(vehicle) {
        document.getElementById('modal-title').textContent = 'Edit Kendaraan: ' + vehicle.name;
        document.getElementById('vehicle-form').action = `/admin/kendaraan/${vehicle.id}`;
        document.getElementById('method-field').innerHTML = '@method("PUT")';
        document.getElementById('vehicle-form').reset();
        resetImagePreviews();

        document.getElementById('f-name').value = vehicle.name;
        document.getElementById('f-domicile').value = vehicle.domicile || 'Jakarta';
        document.getElementById('f-type').value = vehicle.type;
        document.getElementById('f-transmission').value = vehicle.transmission;
        document.getElementById('f-seats').value = vehicle.seats;
        document.getElementById('f-fuel').value = vehicle.fuel_type || 'Bensin';
        document.getElementById('f-cc').value = vehicle.engine_capacity || 1500;
        document.getElementById('f-plate').value = (vehicle.units && vehicle.units.length > 0) ? vehicle.units[0].plate_number : '';
        document.getElementById('f-price').value = vehicle.price_per_day;
        document.getElementById('f-status').value = vehicle.status;
        document.getElementById('f-desc').value = vehicle.description || '';
        
        if (vehicle.image) {
            const img = document.getElementById('main-preview-img');
            img.src = '/storage/' + vehicle.image;
            img.classList.remove('hidden');
            document.getElementById('main-preview-placeholder').classList.add('hidden');
            document.getElementById('btn-remove-main').classList.remove('hidden');
        }

        const galleryExisting = document.getElementById('gallery-existing');
        if (vehicle.images && vehicle.images.length > 0) {
            vehicle.images.forEach(img => {
                const div = document.createElement('div');
                div.className = 'aspect-square rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-800 relative group';
                div.innerHTML = `
                    <img src="/storage/${img.image_path}" class="w-full h-full object-cover">
                    <button type="button" onclick="deleteGalleryImage(${img.id})" class="absolute inset-0 bg-error-500/80 text-white opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
                        <i class="fas fa-trash-alt text-[10px]"></i>
                    </button>
                `;
                galleryExisting.appendChild(div);
            });
        }
        openModal('modal-form');
    }

    window.deleteGalleryImage = function(id) {
        if (confirm('Hapus gambar ini dari galeri?')) {
            const form = document.createElement('form');
            form.method = 'POST'; form.action = `/admin/kendaraan/image/${id}`;
            form.innerHTML = `@csrf @method("DELETE")`;
            document.body.appendChild(form); form.submit();
        }
    }

    // Delete Kendaraan
    function openDeleteModal(id, name) {
        document.getElementById('delete-name').textContent = name;
        document.getElementById('delete-form').action = `/admin/kendaraan/${id}`;
        openModal('modal-delete');
    }

    // ====== SEARCH & FILTER ======
    function applyFilters() {
        const search  = document.getElementById('search-vehicle').value.toLowerCase();
        const status  = document.getElementById('filter-status').value.toLowerCase();

        document.querySelectorAll('.vehicle-row').forEach(row => {
            const name    = row.dataset.name;
            const rowStat = row.dataset.status;

            const matchSearch = !search || name.includes(search);
            const matchStatus = !status || rowStat.includes(status);

            row.style.display = (matchSearch && matchStatus) ? '' : 'none';
        });
    }

    document.getElementById('search-vehicle').addEventListener('input', applyFilters);
    document.getElementById('filter-status').addEventListener('change', applyFilters);
</script>
@endpush
