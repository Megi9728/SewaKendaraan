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

        {{-- Filter Jenis --}}
        <select id="filter-jenis" class="bg-white border border-slate-200 text-sm font-medium text-slate-600 px-4 py-2.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300">
            <option value="">Semua Jenis</option>
            <option value="mobil">Mobil</option>
            <option value="motor">Motor</option>
            <option value="minibus">Minibus</option>
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
                @php
                $vehicles = [
                    ['id'=>1,'name'=>'Toyota Innova Zenix','plate'=>'B 1234 ABC','jenis'=>'Mobil','tx'=>'Matic','harga'=>'650.000','status'=>'Tersedia','sc'=>'bg-green-100 text-green-700','img'=>'https://images.unsplash.com/photo-1570733577524-3a047079e80d?auto=format&fit=crop&q=80&w=80'],
                    ['id'=>2,'name'=>'Honda CR-V Turbo','plate'=>'B 5678 DEF','jenis'=>'Mobil','tx'=>'Matic','harga'=>'750.000','status'=>'Disewa','sc'=>'bg-blue-100 text-blue-700','img'=>'https://images.unsplash.com/photo-1519641471654-76ce0107ad1b?auto=format&fit=crop&q=80&w=80'],
                    ['id'=>3,'name'=>'Honda PCX 160','plate'=>'F 9999 XYZ','jenis'=>'Motor','tx'=>'Matic','harga'=>'120.000','status'=>'Tersedia','sc'=>'bg-green-100 text-green-700','img'=>'https://images.unsplash.com/photo-1558981359-219d6364c9c8?auto=format&fit=crop&q=80&w=80'],
                    ['id'=>4,'name'=>'Toyota Alphard','plate'=>'B 8888 VIP','jenis'=>'Mobil','tx'=>'Matic','harga'=>'1.200.000','status'=>'Tersedia','sc'=>'bg-green-100 text-green-700','img'=>'https://images.unsplash.com/photo-1550355291-bbee04a92027?auto=format&fit=crop&q=80&w=80'],
                    ['id'=>5,'name'=>'Yamaha NMAX 155','plate'=>'T 4444 ASD','jenis'=>'Motor','tx'=>'Matic','harga'=>'100.000','status'=>'Perawatan','sc'=>'bg-orange-100 text-orange-700','img'=>'https://images.unsplash.com/photo-1558981806-ec527fa84c39?auto=format&fit=crop&q=80&w=80'],
                    ['id'=>6,'name'=>'Mitsubishi Xpander','plate'=>'D 2222 JKL','jenis'=>'Mobil','tx'=>'Manual','harga'=>'500.000','status'=>'Disewa','sc'=>'bg-blue-100 text-blue-700','img'=>'https://images.unsplash.com/photo-1583267746897-2cf415887172?auto=format&fit=crop&q=80&w=80'],
                ];
                @endphp

                @foreach($vehicles as $v)
                <tr class="hover:bg-slate-50/70 transition-colors vehicle-row"
                    data-name="{{ strtolower($v['name']) }}"
                    data-status="{{ strtolower($v['status']) }}"
                    data-jenis="{{ strtolower($v['jenis']) }}">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl overflow-hidden bg-slate-100 flex-shrink-0">
                                <img src="{{ $v['img'] }}" class="w-full h-full object-cover" alt="{{ $v['name'] }}">
                            </div>
                            <div>
                                <p class="font-semibold text-slate-900">{{ $v['name'] }}</p>
                                <p class="text-xs text-slate-400 font-medium">{{ $v['plate'] }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-slate-500 font-medium">{{ $v['jenis'] }}</td>
                    <td class="px-6 py-4 text-slate-500">{{ $v['tx'] }}</td>
                    <td class="px-6 py-4 font-bold text-blue-600">Rp {{ $v['harga'] }}</td>
                    <td class="px-6 py-4">
                        <span class="text-xs font-bold px-3 py-1.5 rounded-full {{ $v['sc'] }}">{{ $v['status'] }}</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button onclick="openEditModal({{ $v['id'] }}, '{{ $v['name'] }}')"
                                class="w-8 h-8 flex items-center justify-center bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors"
                                title="Edit">
                                <i class="fas fa-edit text-xs"></i>
                            </button>
                            <button onclick="openDeleteModal({{ $v['id'] }}, '{{ $v['name'] }}')"
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
        <p class="text-sm text-slate-500">Menampilkan <span class="font-semibold text-slate-800">6</span> dari <span class="font-semibold text-slate-800">215</span> kendaraan</p>
        <div class="flex gap-1">
            @foreach([1,2,3,'...',9] as $page)
            <button class="w-9 h-9 rounded-xl text-xs font-semibold transition-all {{ $page == 1 ? 'bg-blue-600 text-white' : 'bg-white border border-slate-200 text-slate-600 hover:border-blue-400 hover:text-blue-600' }}">{{ $page }}</button>
            @endforeach
        </div>
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

        <form class="p-7 space-y-5" action="#" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Kendaraan</label>
                    <input type="text" name="nama" placeholder="cth: Toyota Innova Zenix" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-blue-300 focus:bg-white transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">No. Plat</label>
                    <input type="text" name="plat" placeholder="cth: B 1234 ABC" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-blue-300 focus:bg-white transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Jenis</label>
                    <select name="jenis" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-blue-300 focus:bg-white transition-all">
                        <option>Mobil</option>
                        <option>Motor</option>
                        <option>Minibus</option>
                        <option>Truk</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Transmisi</label>
                    <select name="transmisi" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-blue-300 focus:bg-white transition-all">
                        <option>Matic</option>
                        <option>Manual</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kapasitas (Kursi)</label>
                    <input type="number" name="kapasitas" placeholder="cth: 7" min="1" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-blue-300 focus:bg-white transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Harga / Hari (Rp)</label>
                    <input type="number" name="harga" placeholder="cth: 650000" min="0" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-blue-300 focus:bg-white transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Status</label>
                    <select name="status" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-blue-300 focus:bg-white transition-all">
                        <option>Tersedia</option>
                        <option>Perawatan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Foto Kendaraan</label>
                    <input type="file" name="foto" accept="image/*" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-blue-600 file:text-white file:text-xs file:font-semibold cursor-pointer">
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Deskripsi</label>
                <textarea name="deskripsi" rows="3" placeholder="Deskripsi singkat kendaraan..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-blue-300 focus:bg-white transition-all resize-none"></textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeModal('modal-form')" class="flex-1 border border-slate-200 hover:bg-slate-50 text-slate-600 font-semibold py-3 rounded-xl transition-all text-sm">
                    Batal
                </button>
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition-all active:scale-95 text-sm shadow-md">
                    <i class="fas fa-save mr-2"></i>Simpan Kendaraan
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
        <div class="flex gap-3">
            <button onclick="closeModal('modal-delete')" class="flex-1 border border-slate-200 hover:bg-slate-50 text-slate-600 font-semibold py-3 rounded-xl transition-all text-sm">Batalkan</button>
            <button onclick="confirmDelete()" class="flex-1 bg-red-500 hover:bg-red-600 text-white font-bold py-3 rounded-xl transition-all active:scale-95 text-sm">Ya, Hapus!</button>
        </div>
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
        openModal('modal-form');
    });

    // Edit Kendaraan
    function openEditModal(id, name) {
        document.getElementById('modal-title').textContent = 'Edit Kendaraan: ' + name;
        openModal('modal-form');
    }

    // Delete Kendaraan
    let deleteTargetId = null;
    function openDeleteModal(id, name) {
        deleteTargetId = id;
        document.getElementById('delete-name').textContent = name;
        openModal('modal-delete');
    }
    function confirmDelete() {
        // TODO: kirim request hapus dengan deleteTargetId
        alert('Kendaraan ID ' + deleteTargetId + ' dihapus (simulasi)');
        closeModal('modal-delete');
    }

    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal('modal-form');
            closeModal('modal-delete');
        }
    });

    // ====== SEARCH & FILTER ======
    function applyFilters() {
        const search  = document.getElementById('search-vehicle').value.toLowerCase();
        const status  = document.getElementById('filter-status').value.toLowerCase();
        const jenis   = document.getElementById('filter-jenis').value.toLowerCase();

        document.querySelectorAll('.vehicle-row').forEach(row => {
            const name    = row.dataset.name;
            const rowStat = row.dataset.status;
            const rowJen  = row.dataset.jenis;

            const matchSearch = !search || name.includes(search);
            const matchStatus = !status || rowStat.includes(status);
            const matchJenis  = !jenis  || rowJen.includes(jenis);

            row.style.display = (matchSearch && matchStatus && matchJenis) ? '' : 'none';
        });
    }

    document.getElementById('search-vehicle').addEventListener('input', applyFilters);
    document.getElementById('filter-status').addEventListener('change', applyFilters);
    document.getElementById('filter-jenis').addEventListener('change', applyFilters);
</script>
@endpush
