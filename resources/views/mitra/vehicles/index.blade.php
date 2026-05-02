@extends('layouts.admin')

@section('title', 'Manajemen Armada')

@section('content')

{{-- Header Area --}}
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-xl font-bold text-gray-800 dark:text-white tracking-tight">
            Armada Kendaraan
        </h2>
        <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5 font-medium">Kelola unit kendaraan yang Anda sewakan.</p>
    </div>
    <div class="flex items-center gap-3">
        <button id="btn-tambah" class="bg-brand-500 hover:bg-brand-600 text-white font-bold px-5 py-2.5 rounded-xl transition-all active:scale-95 shadow-lg shadow-brand-500/20 flex items-center gap-2 text-[10px] uppercase tracking-widest">
            <i class="fas fa-plus-circle"></i> TAMBAH UNIT
        </button>
    </div>
</div>

@if(session('success'))
<div class="mb-8 bg-success-50 dark:bg-success-500/10 border border-success-500/10 text-success-600 dark:text-success-400 px-6 py-4 rounded-2xl flex items-center gap-3 animate-in fade-in slide-in-from-top-4 duration-300">
    <i class="fas fa-check-circle"></i>
    <p class="font-bold text-sm">{{ session('success') }}</p>
</div>
@endif

@if($errors->any())
<div class="mb-8 bg-error-50 dark:bg-error-500/10 border border-error-500/10 text-error-600 dark:text-error-400 px-6 py-4 rounded-2xl">
    <div class="flex items-center gap-3 mb-2">
        <i class="fas fa-exclamation-circle"></i>
        <p class="font-bold text-sm">Terjadi Kesalahan:</p>
    </div>
    <ul class="list-disc list-inside text-xs font-medium space-y-1 ml-6">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

{{-- ===== TOOLBAR ===== --}}
<div class="bg-white dark:bg-white/[0.03] border border-gray-200 dark:border-gray-800 rounded-2xl p-3 mb-6 flex flex-col lg:flex-row gap-3 items-center">
    <div class="relative flex-1 w-full">
        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
        <input type="text" id="search-vehicle" placeholder="Cari nama armada atau tipe..." 
               class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-white/[0.02] border border-gray-100 dark:border-gray-800 rounded-xl text-xs font-medium focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all outline-none">
    </div>
    <div class="flex items-center gap-3 w-full lg:w-auto">
        <select id="filter-status" 
                class="flex-1 lg:w-44 bg-gray-50 dark:bg-white/[0.02] border border-gray-100 dark:border-gray-800 px-4 py-2.5 rounded-xl text-[10px] font-bold text-gray-500 uppercase tracking-wider outline-none cursor-pointer hover:border-brand-500/50 transition-all">
            <option value="">Semua Status</option>
            <option value="tersedia">Tersedia</option>
            <option value="disewa">Sedang Sewa</option>
            <option value="perawatan">Perawatan</option>
        </select>
        <div class="w-px h-8 bg-gray-100 dark:bg-gray-800 hidden lg:block mx-1"></div>
        <div class="text-right hidden sm:block">
            <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest leading-none mb-0.5">Total</p>
            <p class="text-base font-black text-gray-800 dark:text-white leading-none">{{ $vehicles->count() }}</p>
        </div>
    </div>
</div>

{{-- ===== TABLE ===== --}}
<div class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="overflow-x-auto custom-scrollbar">
        <table class="w-full text-left whitespace-nowrap">
            <thead class="bg-gray-50 dark:bg-white/[0.02] border-b border-gray-100 dark:border-gray-800">
                <tr>
                    <th class="py-3.5 px-6 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Kendaraan</th>
                    <th class="py-3.5 px-6 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Domisili</th>
                    <th class="py-3.5 px-6 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider text-center">Spesifikasi</th>
                    <th class="py-3.5 px-6 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Harga/Hari</th>
                    <th class="py-3.5 px-6 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider text-center">Status</th>
                    <th class="py-3.5 px-6 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @foreach($vehicles as $v)
                <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.01] transition-colors vehicle-row"
                    data-name="{{ strtolower($v->name) }}"
                    data-status="{{ strtolower($v->status) }}">
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-800 flex-shrink-0 border border-gray-100 dark:border-gray-700 shadow-sm">
                                <img src="{{ $v->image ? asset('storage/' . $v->image) : 'https://placehold.co/600x400?text=No+Image' }}" class="w-full h-full object-cover transition-transform hover:scale-110" alt="{{ $v->name }}">
                            </div>
                            <div>
                                <div class="flex items-center gap-2 mb-0.5">
                                    <p class="text-sm font-bold text-gray-800 dark:text-white tracking-tight leading-tight">{{ $v->name }}</p>
                                    @if($v->units->first() && $v->units->first()->plate_number)
                                        <span class="text-[8px] font-black px-1.5 py-0.5 rounded bg-gray-900 text-white dark:bg-white dark:text-black tracking-tighter leading-none">{{ $v->units->first()->plate_number }}</span>
                                    @endif
                                </div>
                                <p class="text-[9px] font-bold text-brand-500 uppercase tracking-widest leading-none">{{ $v->type }} • {{ $v->transmission }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-map-marker-alt text-error-500 text-[9px]"></i>
                            <span class="text-xs font-bold text-gray-700 dark:text-gray-300 tracking-tight leading-none">{{ $v->domicile ?? 'Jakarta' }}</span>
                        </div>
                    </td>
                    <td class="py-4 px-6 text-center">
                        <div class="flex flex-col gap-0.5 items-center">
                            <span class="text-[9px] font-bold text-gray-800 dark:text-white uppercase tracking-widest leading-none">{{ $v->fuel_type ?? 'Bensin' }}</span>
                            <span class="text-[8px] font-medium text-gray-400 uppercase leading-none">{{ $v->engine_capacity ?? '1500' }} CC</span>
                        </div>
                    </td>
                    <td class="py-4 px-6">
                        <div class="text-xs font-bold text-gray-800 dark:text-white tracking-tight">
                            <span class="text-[9px] font-medium opacity-60">Rp</span> {{ number_format($v->price_per_day, 0, ',', '.') }}
                        </div>
                    </td>
                    <td class="py-4 px-6 text-center">
                        @php
                            $statusClasses = [
                                'Tersedia' => 'bg-success-50 text-success-600 border-success-500/20 dark:bg-success-500/10 dark:text-success-400',
                                'Disewa' => 'bg-brand-50 text-brand-600 border-brand-500/20 dark:bg-brand-500/10 dark:text-brand-400',
                                'Perawatan' => 'bg-warning-50 text-warning-600 border-warning-500/20 dark:bg-warning-500/10 dark:text-warning-400'
                            ];
                        @endphp
                        <span class="inline-flex rounded-md px-2 py-1 text-[8px] font-bold uppercase tracking-widest border {{ $statusClasses[$v->status] ?? 'bg-gray-100' }}">
                            {{ $v->status }}
                        </span>
                    </td>
                    <td class="py-4 px-6 text-right">
                        <div class="flex items-center justify-end gap-1.5">
                            <button onclick="openEditModal({{ json_encode($v->load(['images', 'units'])) }})"
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
</div>

{{-- ===== MODAL TAMBAH/EDIT ===== --}}
<div id="modal-form" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-md" onclick="closeModal('modal-form')"></div>
    <div class="bg-white dark:bg-[#121212] rounded-[3rem] shadow-2xl w-full max-w-3xl z-10 overflow-hidden flex flex-col border border-white/10 animate-in zoom-in duration-300">
        <div class="flex justify-between items-center px-10 py-8 border-b border-gray-100 dark:border-gray-800/50">
            <div>
                <h2 id="modal-title" class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">Tambah Armada</h2>
                <p class="text-xs font-bold text-brand-500 uppercase tracking-widest mt-1">Detail Informasi Kendaraan</p>
            </div>
            <button onclick="closeModal('modal-form')" class="w-12 h-12 flex items-center justify-center rounded-2xl text-gray-400 hover:bg-gray-100 dark:hover:bg-white/5 transition-all border border-gray-100 dark:border-gray-800">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form id="vehicle-form" class="p-10 space-y-8 max-h-[70vh] overflow-y-auto custom-scrollbar" action="{{ route('mitra.vehicles.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div id="method-field"></div>
            
            @if(!auth('mitra')->user()->pool_id)
            <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 flex items-center gap-3">
                <i class="fas fa-exclamation-triangle text-amber-500"></i>
                <p class="text-xs text-amber-700 font-medium">Anda belum menyetel lokasi pool. <a href="{{ route('mitra.profile') }}" class="font-bold underline">Set lokasi sekarang</a> agar armada dapat dipesan.</p>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Main Info --}}
                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">Nama Armada</label>
                        <input type="text" name="name" id="f-name" required placeholder="cth: Toyota Innova Zenix" 
                               class="w-full bg-gray-50 dark:bg-white/[0.02] border border-gray-100 dark:border-gray-800 rounded-2xl px-5 py-4 text-sm font-bold text-gray-800 dark:text-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 outline-none transition-all">
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">Tipe</label>
                            <select name="type" id="f-type" class="w-full bg-gray-50 dark:bg-white/[0.02] border border-gray-100 dark:border-gray-800 rounded-2xl px-5 py-4 text-sm font-bold text-gray-800 dark:text-white outline-none cursor-pointer hover:border-brand-500/50 transition-all">
                                <option value="Mobil">Mobil</option>
                                <option value="Motor">Motor</option>
                                <option value="SUV">SUV</option>
                                <option value="MPV">MPV</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">Domisili</label>
                            <select name="domicile" id="f-domicile" class="w-full bg-gray-50 dark:bg-white/[0.02] border border-gray-100 dark:border-gray-800 rounded-2xl px-5 py-4 text-sm font-bold text-gray-800 dark:text-white outline-none cursor-pointer hover:border-brand-500/50 transition-all">
                                @foreach(['Jakarta', 'Bogor', 'Depok', 'Tangerang', 'Bekasi', 'Bandung', 'Bali'] as $city)
                                    <option value="{{ $city }}">{{ $city }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">Bahan Bakar</label>
                            <select name="fuel_type" id="f-fuel" class="w-full bg-gray-50 dark:bg-white/[0.02] border border-gray-100 dark:border-gray-800 rounded-2xl px-5 py-4 text-sm font-bold text-gray-800 dark:text-white outline-none cursor-pointer transition-all">
                                <option value="Bensin">Bensin</option>
                                <option value="Diesel">Diesel</option>
                                <option value="Hybrid">Hybrid</option>
                                <option value="Elektrik">Elektrik</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">Transmisi</label>
                            <select name="transmission" id="f-transmission" class="w-full bg-gray-50 dark:bg-white/[0.02] border border-gray-100 dark:border-gray-800 rounded-2xl px-5 py-4 text-sm font-bold text-gray-800 dark:text-white outline-none cursor-pointer transition-all">
                                <option value="Matic">Matic</option>
                                <option value="Manual">Manual</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Image Info --}}
                <div class="space-y-6">
                    <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">Foto Utama</label>
                    <div id="main-preview-area" class="w-full h-64 rounded-3xl border-2 border-dashed border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-white/[0.02] flex items-center justify-center overflow-hidden relative group cursor-pointer hover:border-brand-500/50 transition-all">
                        <input type="file" name="image" id="f-image" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer z-10" onchange="previewMainImage(this)">
                        <div id="main-preview-placeholder" class="text-center group-hover:scale-110 transition-transform duration-500">
                            <div class="w-16 h-16 bg-brand-50 dark:bg-brand-500/10 rounded-2xl flex items-center justify-center text-brand-500 mx-auto mb-4">
                                <i class="fas fa-camera text-2xl"></i>
                            </div>
                            <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Pilih Foto Thumbnail</p>
                        </div>
                        <img id="main-preview-img" class="absolute inset-0 w-full h-full object-cover hidden group-hover:scale-105 transition-transform duration-700">
                        <button type="button" id="btn-remove-main" onclick="removeMainImage(event)" class="absolute top-5 right-5 w-10 h-10 bg-error-500 text-white rounded-xl flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all z-20 hidden shadow-xl active:scale-90">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                        <input type="hidden" name="remove_main_image" id="remove-main-image-input" value="0">
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">Plat Nomor</label>
                    <input type="text" name="plate_number" id="f-plate" placeholder="B 1234 ABC" 
                           class="w-full bg-gray-50 dark:bg-white/[0.02] border border-gray-100 dark:border-gray-800 rounded-2xl px-5 py-4 text-sm font-bold text-gray-800 dark:text-white outline-none transition-all uppercase">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">Harga/Hari</label>
                    <input type="number" name="price_per_day" id="f-price" required placeholder="650000" 
                           class="w-full bg-gray-50 dark:bg-white/[0.02] border border-gray-100 dark:border-gray-800 rounded-2xl px-5 py-4 text-sm font-bold text-gray-800 dark:text-white outline-none transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">Kursi</label>
                    <input type="number" name="seats" id="f-seats" required placeholder="5" 
                           class="w-full bg-gray-50 dark:bg-white/[0.02] border border-gray-100 dark:border-gray-800 rounded-2xl px-5 py-4 text-sm font-bold text-gray-800 dark:text-white outline-none transition-all text-center">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">Mesin (CC)</label>
                    <input type="number" name="engine_capacity" id="f-cc" required placeholder="1500" 
                           class="w-full bg-gray-50 dark:bg-white/[0.02] border border-gray-100 dark:border-gray-800 rounded-2xl px-5 py-4 text-sm font-bold text-gray-800 dark:text-white outline-none transition-all text-center">
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">Galeri Foto Armada</label>
                <div class="grid grid-cols-4 sm:grid-cols-6 lg:grid-cols-8 gap-4" id="gallery-management">
                    <div id="gallery-existing" class="contents"></div>
                    <div id="gallery-new" class="contents"></div>
                    <div onclick="document.getElementById('f-gallery').click()" class="aspect-square rounded-2xl border-2 border-dashed border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-white/[0.02] flex flex-col items-center justify-center cursor-pointer hover:border-brand-500/50 hover:bg-brand-50/10 transition-all group">
                        <i class="fas fa-plus text-gray-300 dark:text-gray-600 group-hover:scale-125 transition-transform"></i>
                        <input type="file" id="f-gallery" multiple accept="image/*" class="hidden" onchange="previewGalleryImages(this)">
                    </div>
                </div>
                <div id="gallery-input-container" class="hidden"></div>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">Deskripsi Armada</label>
                <textarea name="description" id="f-desc" rows="4" placeholder="Jelaskan kondisi unit, fitur unggulan, atau catatan khusus..." 
                          class="w-full bg-gray-50 dark:bg-white/[0.02] border border-gray-100 dark:border-gray-800 rounded-[2rem] px-6 py-5 text-sm font-medium text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all resize-none"></textarea>
            </div>

            <div class="flex gap-4 pt-6 pb-2">
                <button type="button" onclick="closeModal('modal-form')" class="flex-1 font-bold py-5 rounded-2xl transition-all text-sm bg-gray-100 dark:bg-white/5 text-gray-500 dark:text-gray-400 active:scale-95">Batal</button>
                <button type="submit" class="flex-[2] bg-brand-500 hover:bg-brand-600 text-white font-black py-5 rounded-2xl transition-all active:scale-95 text-sm shadow-xl shadow-brand-500/25 uppercase tracking-widest">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ===== MODAL HAPUS ===== --}}
<div id="modal-delete" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" onclick="closeModal('modal-delete')"></div>
    <div class="bg-white dark:bg-[#121212] rounded-[3rem] shadow-2xl w-full max-w-sm z-10 p-12 text-center border border-white/10 animate-in zoom-in duration-300">
        <div class="w-24 h-24 bg-error-50 dark:bg-error-500/10 rounded-[2.5rem] flex items-center justify-center mx-auto mb-8">
            <i class="fas fa-trash-alt text-error-500 text-4xl"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-3 tracking-tight">Hapus Unit?</h3>
        <p class="text-gray-500 dark:text-gray-400 text-sm mb-10 leading-relaxed">Anda akan menghapus <span id="delete-name" class="font-black text-gray-800 dark:text-white underline decoration-error-500/30"></span>.</p>
        
        <form id="delete-form" action="" method="POST" class="flex flex-col gap-4">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-full bg-error-500 hover:bg-error-600 text-white font-black py-5 rounded-2xl transition-all active:scale-95 text-sm shadow-xl shadow-error-500/25">Hapus Sekarang</button>
            <button type="button" onclick="closeModal('modal-delete')" class="w-full font-bold py-4 rounded-2xl transition-all text-sm bg-gray-100 dark:bg-white/5 text-gray-500 dark:text-gray-400">Batal</button>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // ====== MODAL LOGIC ======
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
        document.body.style.overflow = '';
    }

    // Reset Form
    function resetVehicleForm() {
        document.getElementById('modal-title').textContent = 'Tambah Armada';
        document.getElementById('vehicle-form').action = "{{ route('mitra.vehicles.store') }}";
        document.getElementById('method-field').innerHTML = '';
        document.getElementById('vehicle-form').reset();
        resetImagePreviews();
    }

    document.getElementById('btn-tambah').addEventListener('click', function() {
        resetVehicleForm();
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

    // Main Image Logic
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

    // Gallery Logic
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
                    div.className = 'aspect-square rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-800 relative group animate-in fade-in zoom-in duration-300 shadow-sm';
                    div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-full object-cover transition-transform group-hover:scale-110">
                        <button type="button" onclick="removeNewGalleryImage('${previewId}', '${file.name}')" class="absolute inset-0 bg-error-500/80 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <i class="fas fa-trash-alt"></i>
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

    // Edit Logic
    function openEditModal(vehicle) {
        resetVehicleForm();
        document.getElementById('modal-title').textContent = 'Edit Armada';
        document.getElementById('vehicle-form').action = `/mitra/vehicles/${vehicle.id}`;
        document.getElementById('method-field').innerHTML = '<input type="hidden" name="_method" value="PUT">';

        document.getElementById('f-name').value = vehicle.name;
        document.getElementById('f-domicile').value = vehicle.domicile || 'Jakarta';
        document.getElementById('f-type').value = vehicle.type;
        document.getElementById('f-transmission').value = vehicle.transmission;
        document.getElementById('f-seats').value = vehicle.seats;
        document.getElementById('f-fuel').value = vehicle.fuel_type || 'Bensin';
        document.getElementById('f-cc').value = vehicle.engine_capacity || 1500;
        document.getElementById('f-plate').value = (vehicle.units && vehicle.units.length > 0) ? vehicle.units[0].plate_number : '';
        document.getElementById('f-price').value = vehicle.price_per_day;
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
                div.className = 'aspect-square rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-800 relative group shadow-sm';
                div.innerHTML = `
                    <img src="/storage/${img.image_path}" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                    <button type="button" onclick="deleteGalleryImage(${img.id})" class="absolute inset-0 bg-error-500/80 text-white opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
                        <i class="fas fa-trash-alt"></i>
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
            form.method = 'POST'; form.action = `/mitra/vehicles/image/${id}`;
            form.innerHTML = `<input type="hidden" name="_token" value="{{ csrf_token() }}"><input type="hidden" name="_method" value="DELETE">`;
            document.body.appendChild(form); form.submit();
        }
    }

    // Delete Logic
    function openDeleteModal(id, name) {
        document.getElementById('delete-name').textContent = name;
        document.getElementById('delete-form').action = `/mitra/vehicles/${id}`;
        openModal('modal-delete');
    }

    // Filter Logic
    function applyFilters() {
        const search = document.getElementById('search-vehicle').value.toLowerCase();
        const status = document.getElementById('filter-status').value.toLowerCase();

        document.querySelectorAll('.vehicle-row').forEach(row => {
            const name = row.dataset.name;
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
