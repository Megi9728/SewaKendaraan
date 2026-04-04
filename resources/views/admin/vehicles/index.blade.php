@extends('layouts.admin')

@section('title', 'Kelola Armada Kendaraan')
@section('page-title', 'Kelola Armada')
@section('page-subtitle', 'Tambah, edit, dan hapus unit kendaraan')

@push('styles')
<style>
    .modal-overlay { backdrop-filter: blur(4px); }
    #vehicle-form::-webkit-scrollbar { width: 6px; }
    #vehicle-form::-webkit-scrollbar-track { background: transparent; }
    #vehicle-form::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    #vehicle-form::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
</style>
@endpush

@section('content')

@if(session('success'))
<div class="mb-6 p-4 bg-green-50 border border-green-100 text-green-700 rounded-2xl flex items-center gap-3">
    <i class="fas fa-check-circle"></i>
    <p class="text-sm font-semibold">{{ session('success') }}</p>
</div>
@endif

{{-- ===== TOOLBAR ===== --}}
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div class="flex gap-3 flex-wrap">
        {{-- Search --}}
        <div class="relative">
            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                <i class="fas fa-search text-slate-400 text-sm"></i>
            </div>
            <input type="text" id="search-vehicle" placeholder="Cari kendaraan..." class="pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 w-56">
        </div>

        {{-- Filter Status --}}
        <select id="filter-status" class="bg-white border border-slate-200 text-sm font-medium text-slate-600 px-4 py-2.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300">
            <option value="">Semua Status</option>
            <option value="tersedia">Tersedia</option>
            <option value="disewa">Disewa</option>
            <option value="perawatan">Perawatan</option>
        </select>
    </div>

    <button id="btn-tambah" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-xl transition-all active:scale-95 shadow-sm text-sm flex-shrink-0">
        <i class="fas fa-plus"></i> Tambah Kendaraan
    </button>
</div>

{{-- ===== TABLE ===== --}}
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="text-left px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Kendaraan</th>
                    <th class="text-left px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Domisili</th>
                    <th class="text-left px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Jenis</th>
                    <th class="text-left px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Transmisi</th>
                    <th class="text-left px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">BBM & CC</th>
                    <th class="text-left px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Stok</th>
                    <th class="text-left px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Harga/Hari</th>
                    <th class="text-left px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Status</th>
                    <th class="text-right px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50" id="vehicle-table-body">
                @foreach($vehicles as $v)
                <tr class="hover:bg-slate-50/70 transition-colors vehicle-row"
                    data-name="{{ strtolower($v->name) }}"
                    data-status="{{ strtolower($v->status) }}"
                    data-jenis="{{ strtolower($v->type) }}">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl overflow-hidden bg-slate-100 flex-shrink-0">
                                <img src="{{ $v->image ? asset('storage/' . $v->image) : 'https://placehold.co/600x400?text=No+Image' }}" class="w-full h-full object-cover" alt="{{ $v->name }}">
                            </div>
                            <div>
                                <p class="font-semibold text-slate-900">{{ $v->name }}</p>
                                <p class="text-xs text-slate-400 font-medium">Rating: {{ $v->rating }} ({{ $v->reviews_count }} Ulasan)</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-bold text-slate-600"><i class="fas fa-map-marker-alt text-red-500 mr-1"></i> {{ $v->domicile ?? 'Jakarta' }}</td>
                    <td class="px-6 py-4 text-slate-500 font-medium">{{ $v->type }}</td>
                    <td class="px-6 py-4 text-slate-500">{{ $v->transmission }}</td>
                    <td class="px-6 py-4">
                        <p class="text-xs font-bold text-slate-700">{{ $v->fuel_type ?? 'Bensin' }}</p>
                        <p class="text-[10px] text-slate-400 uppercase tracking-wider">{{ $v->engine_capacity ?? '1500' }} CC</p>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center justify-center px-2 py-0.5 rounded text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200">
                            {{ $v->units_count ?? 1 }} Unit
                        </span>
                    </td>
                    <td class="px-6 py-4 font-bold text-blue-600">Rp {{ number_format($v->price_per_day, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        @php
                            $statusClass = [
                                'Tersedia' => 'bg-green-100 text-green-700',
                                'Disewa' => 'bg-blue-100 text-blue-700',
                                'Perawatan' => 'bg-orange-100 text-orange-700'
                            ][$v->status] ?? 'bg-slate-100 text-slate-700';
                        @endphp
                        <span class="text-[10px] font-bold px-3 py-1.5 rounded-lg {{ $statusClass }} uppercase">{{ $v->status }}</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button onclick="openEditModal({{ $v }})"
                                class="w-8 h-8 flex items-center justify-center bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors"
                                title="Edit">
                                <i class="fas fa-edit text-xs"></i>
                            </button>
                            <button onclick="openDeleteModal({{ $v->id }}, '{{ $v->name }}')"
                                class="w-8 h-8 flex items-center justify-center bg-red-50 text-red-500 hover:bg-red-100 rounded-lg transition-colors"
                                title="Hapus">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Table Footer --}}
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 px-6 py-4 border-t border-slate-100 bg-slate-50/50">
        <p class="text-sm text-slate-500">Total Kendaraan: <span class="font-semibold text-slate-800">{{ $vehicles->count() }}</span> unit</p>
    </div>
</div>

{{-- ===== MODAL TAMBAH/EDIT ===== --}}
<div id="modal-form" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
    <div class="absolute inset-0 bg-slate-900/60 modal-overlay" onclick="closeModal('modal-form')"></div>
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl z-10 overflow-hidden flex flex-col">
        <div class="flex justify-between items-center px-7 py-5 border-b border-slate-100">
            <h2 id="modal-title" class="text-lg font-bold text-slate-900">Tambah Kendaraan Baru</h2>
            <button onclick="closeModal('modal-form')" class="w-9 h-9 flex items-center justify-center rounded-xl text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-all">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form id="vehicle-form" class="p-7 space-y-5 max-h-[75vh] overflow-y-auto" action="{{ route('admin.kendaraan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div id="method-field"></div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Kendaraan</label>
                    <input type="text" name="name" id="f-name" required placeholder="cth: Toyota Innova Zenix" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:bg-white transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Domisili Cabang</label>
                    <select name="domicile" id="f-domicile" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:bg-white transition-all">
                        <option value="Jakarta">Jakarta</option>
                        <option value="Bogor">Bogor</option>
                        <option value="Depok">Depok</option>
                        <option value="Tangerang">Tangerang</option>
                        <option value="Bekasi">Bekasi</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Jenis</label>
                    <select name="type" id="f-type" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:bg-white transition-all">
                        <option value="Mobil">Mobil</option>
                        <option value="Motor">Motor</option>
                        <option value="Minibus">Minibus</option>
                        <option value="SUV">SUV</option>
                        <option value="MPV">MPV</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Transmisi</label>
                    <select name="transmission" id="f-transmission" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:bg-white transition-all">
                        <option value="Matic">Matic</option>
                        <option value="Manual">Manual</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kapasitas (Kursi)</label>
                    <input type="number" name="seats" id="f-seats" required placeholder="cth: 7" min="1" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:bg-white transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Bahan Bakar</label>
                    <select name="fuel_type" id="f-fuel" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:bg-white transition-all">
                        <option value="Bensin">Bensin</option>
                        <option value="Diesel">Diesel</option>
                        <option value="Hybrid">Hybrid</option>
                        <option value="Elektrik">Elektrik</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kapasitas Mesin (CC)</label>
                    <input type="number" name="engine_capacity" id="f-cc" required placeholder="cth: 1500" min="0" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:bg-white transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Stok Unit Armada</label>
                    <input type="number" name="units_count" id="f-units" required placeholder="cth: 1" min="1" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:bg-white transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Harga / Hari (Rp)</label>
                    <input type="number" name="price_per_day" id="f-price" required placeholder="cth: 650000" min="0" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:bg-white transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Status</label>
                    <select name="status" id="f-status" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:bg-white transition-all">
                        <option value="Tersedia">Tersedia</option>
                        <option value="Disewa">Disewa</option>
                        <option value="Perawatan">Perawatan</option>
                    </select>
                </div>
                {{-- Main Photo Section --}}
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Foto Utama (Thumbnail)</label>
                    <div id="main-preview-area" class="w-full h-40 rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50 flex items-center justify-center overflow-hidden relative cursor-pointer hover:bg-slate-100 transition-all group">
                        <input type="file" name="image" id="f-image" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer z-10" onchange="previewMainImage(this)">
                        <div id="main-preview-placeholder" class="text-center group-hover:scale-110 transition-transform">
                            <i class="fas fa-camera text-slate-300 text-3xl mb-2"></i>
                            <p class="text-[10px] font-bold text-slate-400 uppercase">Klik untuk unggah</p>
                        </div>
                        <img id="main-preview-img" class="absolute inset-0 w-full h-full object-cover hidden">
                        <button type="button" id="btn-remove-main" onclick="removeMainImage(event)" class="absolute top-4 right-4 w-9 h-9 bg-red-500/90 text-white rounded-xl flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity z-20 hidden shadow-lg hover:bg-red-600">
                            <i class="fas fa-trash-alt text-xs"></i>
                        </button>
                        <input type="hidden" name="remove_main_image" id="remove-main-image-input" value="0">
                    </div>
                </div>

                {{-- Gallery Section --}}
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Galeri Foto (Banyak)</label>
                    <div class="grid grid-cols-4 sm:grid-cols-6 gap-3" id="gallery-management">
                        {{-- Existing Images (from server) --}}
                        <div id="gallery-existing" class="contents"></div>
                        
                        {{-- New Preview Items (client-side) --}}
                        <div id="gallery-new" class="contents"></div>

                        {{-- Add Button --}}
                        <div onclick="document.getElementById('f-gallery').click()" class="aspect-square rounded-xl border-2 border-dashed border-slate-200 bg-slate-50 flex flex-col items-center justify-center cursor-pointer hover:bg-slate-100 hover:border-slate-300 transition-all group">
                            <i class="fas fa-plus text-slate-300 text-lg group-hover:scale-110 transition-transform"></i>
                            <span class="text-[8px] font-bold text-slate-400 uppercase mt-1">Tambah</span>
                            <input type="file" id="f-gallery" multiple accept="image/*" class="hidden" onchange="previewGalleryImages(this)">
                        </div>
                    </div>
                    {{-- Hidden file inputs for new gallery items --}}
                    <div id="gallery-input-container" class="hidden"></div>
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Deskripsi</label>
                <textarea name="description" id="f-desc" rows="3" placeholder="Deskripsi singkat kendaraan..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:bg-white transition-all resize-none"></textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeModal('modal-form')" class="flex-1 border border-slate-200 hover:bg-slate-50 text-slate-600 font-semibold py-3 rounded-xl transition-all text-sm">
                    Batal
                </button>
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition-all active:scale-95 text-sm shadow-md">
                    <i class="fas fa-save mr-2"></i>Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ===== MODAL HAPUS ===== --}}
<div id="modal-delete" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
    <div class="absolute inset-0 bg-slate-900/60 modal-overlay" onclick="closeModal('modal-delete')"></div>
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-sm z-10 p-8 text-center">
        <div class="w-16 h-16 bg-red-100 rounded-2xl flex items-center justify-center mx-auto mb-5">
            <i class="fas fa-trash-alt text-red-500 text-2xl"></i>
        </div>
        <h3 class="text-xl font-black text-slate-900 mb-2">Hapus Kendaraan?</h3>
        <p class="text-slate-500 text-sm mb-6">Anda akan menghapus <span id="delete-name" class="font-bold text-slate-800"></span>. Tindakan ini tidak dapat dibatalkan.</p>
        
        <form id="delete-form" action="" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex gap-3">
                <button type="button" onclick="closeModal('modal-delete')" class="flex-1 border border-slate-200 hover:bg-slate-50 text-slate-600 font-semibold py-3 rounded-xl transition-all text-sm">Batalkan</button>
                <button type="submit" class="flex-1 bg-red-500 hover:bg-red-600 text-white font-bold py-3 rounded-xl transition-all active:scale-95 text-sm">Ya, Hapus!</button>
            </div>
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
                    div.className = 'aspect-square rounded-xl overflow-hidden border border-slate-200 relative group animate-in fade-in zoom-in duration-300';
                    div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-full object-cover">
                        <button type="button" onclick="removeNewGalleryImage('${previewId}', '${file.name}')" class="absolute inset-0 bg-red-500/80 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
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
        document.getElementById('f-units').value = vehicle.units_count || 1;
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
                div.className = 'aspect-square rounded-xl overflow-hidden border border-slate-200 relative group';
                div.innerHTML = `
                    <img src="/storage/${img.image_path}" class="w-full h-full object-cover">
                    <button type="button" onclick="deleteGalleryImage(${img.id})" class="absolute inset-0 bg-red-500/80 text-white opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
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
