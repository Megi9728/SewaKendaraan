@extends('layouts.admin')

@section('title', 'Kelola Driver')
@section('page-title', 'Kelola Driver')
@section('page-subtitle', 'Daftar pengemudi berpengalaman')

@section('content')

@if(session('success'))
<div class="mb-6 p-4 bg-green-50 border border-green-100 text-green-700 rounded-2xl flex items-center gap-3">
    <i class="fas fa-check-circle"></i>
    <p class="text-sm font-semibold">{{ session('success') }}</p>
</div>
@endif

<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-bold text-slate-800">Daftar Driver</h2>
    <button onclick="openAddModal()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-5 rounded-xl transition-all shadow-lg shadow-blue-200 flex items-center gap-2">
        <i class="fas fa-plus"></i> Tambah Driver
    </button>
</div>

<div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Driver</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Kontak</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Rating</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($drivers as $d)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl overflow-hidden bg-slate-100">
                                <img src="{{ $d->photo ? asset('storage/' . $d->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($d->name) . '&background=random' }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <p class="font-bold text-slate-900">{{ $d->name }}</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">ID #DRV-{{ $d->id }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <p class="text-sm font-bold text-slate-700">{{ $d->phone }}</p>
                    </td>
                    <td class="px-6 py-5">
                        @php
                            $colors = [
                                'Available' => 'bg-green-100 text-green-700',
                                'Busy' => 'bg-orange-100 text-orange-700',
                                'Off' => 'bg-slate-100 text-slate-700',
                            ];
                        @endphp
                        <span class="text-[10px] font-black px-3 py-1 rounded-lg {{ $colors[$d->status] ?? 'bg-slate-100' }} uppercase tracking-widest">
                            {{ $d->status }}
                        </span>
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-1.5 text-yellow-500">
                            <i class="fas fa-star text-xs"></i>
                            <span class="text-sm font-black">{{ number_format($d->rating, 1) }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-5 text-right">
                        <div class="flex justify-end gap-2">
                            <button onclick='openEditModal(@json($d))' class="w-9 h-9 flex items-center justify-center bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-100 transition-all">
                                <i class="fas fa-edit text-xs"></i>
                            </button>
                            <form action="{{ route('admin.drivers.destroy', $d->id) }}" method="POST" onsubmit="return confirm('Hapus driver ini?')">
                                @csrf @method('DELETE')
                                <button class="w-9 h-9 flex items-center justify-center bg-red-50 text-red-500 rounded-xl hover:bg-red-100 transition-all">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-slate-400 font-bold">Belum ada data driver.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Add/Edit --}}
<div id="modal-driver" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm shadow-xl" onclick="closeModal()"></div>
    <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-lg z-10 overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <h3 id="modal-title" class="font-black text-slate-900 text-lg">Tambah Driver</h3>
            <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600"><i class="fas fa-times"></i></button>
        </div>
        <form id="driver-form" action="{{ route('admin.drivers.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-5">
            @csrf
            <div id="method-field"></div>
            
            <div>
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2">Nama Lengkap</label>
                <input type="text" name="name" id="f-name" required class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-5 py-3.5 text-sm font-bold text-slate-900 focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition-all">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2">No. WhatsApp</label>
                    <input type="text" name="phone" id="f-phone" required class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-5 py-3.5 text-sm font-bold text-slate-900 focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition-all" placeholder="08xxx">
                </div>
                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2">Status</label>
                    <select name="status" id="f-status" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-5 py-3.5 text-sm font-bold text-slate-900 focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition-all">
                        <option value="Available">Available</option>
                        <option value="Busy">Busy</option>
                        <option value="Off">Off</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2">Foto Driver (Square)</label>
                <input type="file" name="photo" accept="image/*" class="w-full text-xs font-bold text-slate-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:tracking-widest file:bg-blue-600 file:text-white hover:file:bg-blue-700 transition-all">
            </div>

            <div>
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2">Catatan / Deskripsi</label>
                <textarea name="description" id="f-desc" rows="3" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-5 py-3.5 text-sm font-bold text-slate-900 focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition-all resize-none"></textarea>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="button" onclick="closeModal()" class="flex-1 font-black text-slate-400 py-4 rounded-2xl hover:bg-slate-50 transition-all uppercase tracking-widest text-[10px]">Batal</button>
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-2xl transition-all shadow-xl shadow-blue-200 uppercase tracking-widest text-[10px]">Simpan Driver</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openAddModal() {
        document.getElementById('modal-title').textContent = 'Tambah Driver Baru';
        document.getElementById('driver-form').action = "{{ route('admin.drivers.store') }}";
        document.getElementById('method-field').innerHTML = '';
        document.getElementById('driver-form').reset();
        document.getElementById('modal-driver').classList.remove('hidden');
    }

    function openEditModal(driver) {
        document.getElementById('modal-title').textContent = 'Edit Driver: ' + driver.name;
        document.getElementById('driver-form').action = `/admin/drivers/${driver.id}`;
        document.getElementById('method-field').innerHTML = '@method("PUT")';
        
        document.getElementById('f-name').value = driver.name;
        document.getElementById('f-phone').value = driver.phone;
        document.getElementById('f-status').value = driver.status;
        document.getElementById('f-desc').value = driver.description || '';
        
        document.getElementById('modal-driver').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('modal-driver').classList.add('hidden');
    }
</script>
@endpush
