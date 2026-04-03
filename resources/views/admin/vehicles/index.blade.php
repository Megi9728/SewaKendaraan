@extends('layouts.admin')

@section('title', 'Kelola Armada Kendaraan')
@section('page-title', 'Kelola Armada')
@section('page-subtitle', 'Tambah, edit, dan hapus unit kendaraan')

@push('styles')
<style>
    .modal-overlay { backdrop-filter: blur(4px); }
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
                    <th class="text-left px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Jenis</th>
                    <th class="text-left px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Transmisi</th>
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
                    <td class="px-6 py-4 text-slate-500 font-medium">{{ $v->type }}</td>
                    <td class="px-6 py-4 text-slate-500">{{ $v->transmission }}</td>
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
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl z-10 overflow-hidden">
        <div class="flex justify-between items-center px-7 py-5 border-b border-slate-100">
            <h2 id="modal-title" class="text-lg font-bold text-slate-900">Tambah Kendaraan Baru</h2>
            <button onclick="closeModal('modal-form')" class="w-9 h-9 flex items-center justify-center rounded-xl text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-all">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form id="vehicle-form" class="p-7 space-y-5" action="{{ route('admin.kendaraan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div id="method-field"></div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Kendaraan</label>
                    <input type="text" name="name" id="f-name" required placeholder="cth: Toyota Innova Zenix" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:bg-white transition-all">
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
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Foto Kendaraan</label>
                    <input type="file" name="image" accept="image/*" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium text-slate-900 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-blue-600 file:text-white file:text-xs file:font-semibold cursor-pointer">
                    <p class="text-[10px] text-slate-400 mt-1 italic">*Kosongkan jika tidak ingin mengubah gambar</p>
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
    document.getElementById('btn-tambah').addEventListener('click', function() {
        document.getElementById('modal-title').textContent = 'Tambah Kendaraan Baru';
        document.getElementById('vehicle-form').action = "{{ route('admin.kendaraan.store') }}";
        document.getElementById('method-field').innerHTML = '';
        document.getElementById('vehicle-form').reset();
        openModal('modal-form');
    });

    // Edit Kendaraan
    function openEditModal(vehicle) {
        document.getElementById('modal-title').textContent = 'Edit Kendaraan: ' + vehicle.name;
        document.getElementById('vehicle-form').action = `/admin/kendaraan/${vehicle.id}`;
        document.getElementById('method-field').innerHTML = '@method("PUT")';
        
        // Fill fields
        document.getElementById('f-name').value = vehicle.name;
        document.getElementById('f-type').value = vehicle.type;
        document.getElementById('f-transmission').value = vehicle.transmission;
        document.getElementById('f-seats').value = vehicle.seats;
        document.getElementById('f-price').value = vehicle.price_per_day;
        document.getElementById('f-status').value = vehicle.status;
        document.getElementById('f-desc').value = vehicle.description || '';
        
        openModal('modal-form');
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
