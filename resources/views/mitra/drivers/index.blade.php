@extends('layouts.admin')

@section('title', 'Kelola Sopir Mitra')
@section('page-title', 'Kelola Sopir')
@section('page-subtitle', 'Manajemen tim sopir untuk layanan jasa sopir mitra')

@push('styles')
<style>
    .modal-overlay { backdrop-filter: blur(4px); }
    #driver-form-container::-webkit-scrollbar { width: 6px; }
    #driver-form-container::-webkit-scrollbar-track { background: transparent; }
    #driver-form-container::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    #driver-form-container::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
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
                <i class="fas fa-search text-[#8F8F7E] text-sm"></i>
            </div>
            <input type="text" id="search-driver" placeholder="Cari nama sopir..." class="pl-10 pr-4 py-2.5 bg-white border border-[#D4D4C3] rounded-xl text-sm font-medium text-[#0A174E]/80 focus:outline-none focus:ring-2 focus:ring-[#0A174E]/30 focus:border-[#0A174E] w-56">
        </div>

        {{-- Filter Status --}}
        <select id="filter-status" class="bg-white border border-[#D4D4C3] text-sm font-medium text-[#0A174E]/70 px-4 py-2.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0A174E]/30">
            <option value="">Semua Status</option>
            <option value="available">Tersedia</option>
            <option value="busy">Bertugas</option>
            <option value="off">Libur</option>
        </select>
    </div>

    <button id="btn-tambah" class="flex items-center gap-2 bg-[#0A174E] hover:opacity-90 text-white font-semibold px-5 py-2.5 rounded-xl transition-all active:scale-95 shadow-sm text-sm flex-shrink-0">
        <i class="fas fa-plus text-[#F5D042]"></i> Tambah Sopir
    </button>
</div>

{{-- ===== TABLE ===== --}}
<div class="bg-white rounded-2xl border border-[#EBEBDF] shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-[#0A174E] border-b border-[#EBEBDF]">
                <tr>
                    <th class="text-left px-6 py-4 text-xs font-bold text-[#EBEBDF] uppercase tracking-wider">Sopir</th>
                    <th class="text-left px-6 py-4 text-xs font-bold text-[#EBEBDF] uppercase tracking-wider">Kontak</th>
                    <th class="text-left px-6 py-4 text-xs font-bold text-[#EBEBDF] uppercase tracking-wider">Alamat</th>
                    <th class="text-left px-6 py-4 text-xs font-bold text-[#EBEBDF] uppercase tracking-wider">Status</th>
                    <th class="text-right px-6 py-4 text-xs font-bold text-[#EBEBDF] uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#F9F9F5]" id="driver-table-body">
                @forelse($drivers as $d)
                <tr class="hover:bg-[#F9F9F5]/70 transition-colors driver-row" 
                    data-name="{{ strtolower($d->name) }}"
                    data-status="{{ strtolower($d->status) }}">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full overflow-hidden bg-[#EBEBDF] flex-shrink-0 border border-[#D4D4C3]">
                                <img src="{{ $d->driver_photo ? asset('storage/' . $d->driver_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($d->name) . '&background=0A174E&color=fff' }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <p class="font-bold text-[#0A174E]">{{ $d->name }}</p>
                                <p class="text-[10px] text-[#8F8F7E] font-bold uppercase tracking-wider">ID: #DRV-{{ $d->id }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col">
                            <span class="text-sm font-semibold text-[#0A174E]/80"><i class="fas fa-phone text-[#F5D042] mr-2"></i>{{ $d->phone }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-xs text-[#8F8F7E] font-medium max-w-[200px] truncate">{{ $d->address ?? '-' }}</p>
                    </td>
                    <td class="px-6 py-4">
                        @if($d->status === 'available')
                            <span class="px-2.5 py-1 bg-green-50 text-green-600 rounded-lg text-[10px] font-black uppercase border border-green-100">Tersedia</span>
                        @elseif($d->status === 'busy')
                            <span class="px-2.5 py-1 bg-blue-50 text-blue-600 rounded-lg text-[10px] font-black uppercase border border-blue-100">Bertugas</span>
                        @else
                            <span class="px-2.5 py-1 bg-red-50 text-red-600 rounded-lg text-[10px] font-black uppercase border border-red-100">Libur</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <button onclick="editDriver({{ json_encode($d) }})" class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all">
                                <i class="fas fa-edit text-xs"></i>
                            </button>
                            <form action="{{ route('mitra.drivers.destroy', $d->id) }}" method="POST" onsubmit="return confirm('Hapus data sopir ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-all">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-[#F9F9F5] rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-user-tie text-2xl text-[#D4D4C3]"></i>
                            </div>
                            <p class="text-sm font-bold text-[#0A174E]">Belum Ada Sopir</p>
                            <p class="text-xs text-[#8F8F7E] mt-1">Tambahkan tim sopir Anda untuk melayani jasa sopir.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ===== MODAL FORM ===== --}}
<div id="modal-driver" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-[#0A174E]/40 modal-overlay" onclick="closeModal()"></div>
    <div class="absolute right-0 top-0 bottom-0 w-full max-w-lg bg-white shadow-2xl flex flex-col transform translate-x-full transition-transform duration-300" id="modal-content">
        {{-- Modal Header --}}
        <div class="p-6 border-b border-[#EBEBDF] flex justify-between items-center bg-[#F9F9F5]">
            <div>
                <h3 class="text-lg font-bold text-[#0A174E]" id="modal-title">Tambah Sopir</h3>
                <p class="text-xs text-[#8F8F7E] font-medium">Lengkapi informasi data sopir mitra</p>
            </div>
            <button onclick="closeModal()" class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-white transition-colors">
                <i class="fas fa-times text-[#0A174E]"></i>
            </button>
        </div>

        {{-- Modal Body --}}
        <div class="flex-1 overflow-y-auto p-6" id="driver-form-container">
            <form id="driver-form" method="POST" enctype="multipart/form-data">
                @csrf
                <div id="method-field"></div>
                
                <div class="space-y-6">
                    {{-- Nama --}}
                    <div>
                        <label class="block text-xs font-bold text-[#0A174E] uppercase tracking-wider mb-2">Nama Lengkap Sopir</label>
                        <input type="text" name="name" id="f-name" required placeholder="Cth: Ahmad Subagjo" class="w-full px-4 py-3 bg-[#F9F9F5] border border-[#D4D4C3] rounded-xl text-sm font-semibold focus:ring-2 focus:ring-[#0A174E]/20 outline-none">
                    </div>

                    {{-- No HP --}}
                    <div>
                        <label class="block text-xs font-bold text-[#0A174E] uppercase tracking-wider mb-2">Nomor WhatsApp / HP</label>
                        <input type="text" name="phone" id="f-phone" required placeholder="Cth: 08123456789" class="w-full px-4 py-3 bg-[#F9F9F5] border border-[#D4D4C3] rounded-xl text-sm font-semibold focus:ring-2 focus:ring-[#0A174E]/20 outline-none">
                    </div>

                    {{-- Alamat --}}
                    <div>
                        <label class="block text-xs font-bold text-[#0A174E] uppercase tracking-wider mb-2">Alamat Tinggal</label>
                        <textarea name="address" id="f-address" rows="2" class="w-full px-4 py-3 bg-[#F9F9F5] border border-[#D4D4C3] rounded-xl text-sm font-semibold focus:ring-2 focus:ring-[#0A174E]/20 outline-none resize-none"></textarea>
                    </div>

                    {{-- Status (Edit Only) --}}
                    <div id="status-container" class="hidden">
                        <label class="block text-xs font-bold text-[#0A174E] uppercase tracking-wider mb-2">Status Sopir</label>
                        <select name="status" id="f-status" class="w-full px-4 py-3 bg-[#F9F9F5] border border-[#D4D4C3] rounded-xl text-sm font-semibold focus:ring-2 focus:ring-[#0A174E]/20 outline-none">
                            <option value="available">Tersedia</option>
                            <option value="busy">Bertugas</option>
                            <option value="off">Libur</option>
                        </select>
                    </div>

                    <hr class="border-[#EBEBDF]">

                    {{-- Photos --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-[#0A174E] uppercase tracking-wider mb-2">Foto Profil</label>
                            <input type="file" name="driver_photo" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-[#0A174E] uppercase tracking-wider mb-2">Foto KTP</label>
                            <input type="file" name="ktp_photo" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-[#0A174E] uppercase tracking-wider mb-2">Foto SIM</label>
                            <input type="file" name="sim_photo" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- Modal Footer --}}
        <div class="p-6 border-t border-[#EBEBDF] bg-[#F9F9F5]">
            <button type="submit" form="driver-form" class="w-full bg-[#F5D042] text-[#0A174E] py-4 rounded-xl font-bold hover:shadow-lg transition-all active:scale-95">Simpan Data Sopir</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const modal = document.getElementById('modal-driver');
    const modalContent = document.getElementById('modal-content');
    const driverForm = document.getElementById('driver-form');
    const modalTitle = document.getElementById('modal-title');
    const methodField = document.getElementById('method-field');
    const statusContainer = document.getElementById('status-container');

    // Toolbar logic
    const searchInput = document.getElementById('search-driver');
    const statusFilter = document.getElementById('filter-status');
    const rows = document.querySelectorAll('.driver-row');

    function filterTable() {
        const query = searchInput.value.toLowerCase();
        const status = statusFilter.value.toLowerCase();

        rows.forEach(row => {
            const name = row.dataset.name;
            const rowStatus = row.dataset.status;
            
            const matchQuery = name.includes(query);
            const matchStatus = status === '' || rowStatus === status;

            row.style.display = (matchQuery && matchStatus) ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterTable);
    statusFilter.addEventListener('change', filterTable);

    // Modal logic
    document.getElementById('btn-tambah').addEventListener('click', () => {
        modalTitle.innerText = 'Tambah Sopir';
        driverForm.action = "{{ route('mitra.drivers.store') }}";
        methodField.innerHTML = '';
        statusContainer.classList.add('hidden');
        driverForm.reset();
        openModal();
    });

    function openModal() {
        modal.classList.remove('hidden');
        setTimeout(() => {
            modalContent.classList.remove('translate-x-full');
        }, 10);
    }

    function closeModal() {
        modalContent.classList.add('translate-x-full');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function editDriver(driver) {
        modalTitle.innerText = 'Edit Sopir: ' + driver.name;
        driverForm.action = `/mitra/drivers/${driver.id}`;
        methodField.innerHTML = '@method("PUT")';
        statusContainer.classList.remove('hidden');
        
        document.getElementById('f-name').value = driver.name;
        document.getElementById('f-phone').value = driver.phone;
        document.getElementById('f-address').value = driver.address;
        document.getElementById('f-status').value = driver.status;
        
        openModal();
    }
</script>
@endpush
