@extends('layouts.admin')

@section('title', 'Kelola Pemesanan')
@section('page-title', 'Kelola Pemesanan')
@section('page-subtitle', 'Monitor dan verifikasi semua transaksi sewa')

@section('content')

{{-- ===== STAT MINI ===== --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @php
    $stats = [
        ['label'=>'Total Pemesanan','value'=>'328','icon'=>'fas fa-calendar-check','color'=>'bg-blue-50 text-blue-600'],
        ['label'=>'Menunggu Konfirmasi','value'=>'3','icon'=>'fas fa-clock','color'=>'bg-yellow-50 text-yellow-600'],
        ['label'=>'Aktif Hari Ini','value'=>'28','icon'=>'fas fa-car','color'=>'bg-green-50 text-green-600'],
        ['label'=>'Selesai Bulan Ini','value'=>'142','icon'=>'fas fa-check-circle','color'=>'bg-purple-50 text-purple-600'],
    ];
    @endphp
    @foreach($stats as $s)
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex items-center gap-4">
        <div class="w-11 h-11 {{ $s['color'] }} rounded-xl flex items-center justify-center flex-shrink-0">
            <i class="{{ $s['icon'] }}"></i>
        </div>
        <div>
            <p class="text-2xl font-black text-slate-900">{{ $s['value'] }}</p>
            <p class="text-xs text-slate-400 font-medium leading-tight">{{ $s['label'] }}</p>
        </div>
    </div>
    @endforeach
</div>

{{-- ===== TOOLBAR ===== --}}
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-5">
    <div class="flex gap-3 flex-wrap items-center">
        <div class="relative">
            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                <i class="fas fa-search text-slate-400 text-sm"></i>
            </div>
            <input type="text" id="search-booking" placeholder="Cari nama / kendaraan..." class="pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-300 w-60">
        </div>

        {{-- Tab Filter Status --}}
        <div class="flex gap-1 bg-slate-100 p-1 rounded-xl" id="status-tabs">
            @foreach(['Semua'=>'','Menunggu'=>'menunggu','Aktif'=>'aktif','Selesai'=>'selesai','Dibatalkan'=>'dibatalkan'] as $label => $val)
            <button class="status-tab px-4 py-1.5 rounded-lg text-xs font-semibold text-slate-500 hover:text-slate-800 transition-all {{ $loop->first ? 'bg-white shadow-sm text-slate-800' : '' }}" data-status="{{ $val }}">
                {{ $label }}
            </button>
            @endforeach
        </div>
    </div>

    <button class="flex items-center gap-2 border border-slate-200 hover:bg-slate-50 text-slate-600 font-semibold px-4 py-2.5 rounded-xl transition-all text-sm flex-shrink-0">
        <i class="fas fa-file-export"></i> Export CSV
    </button>
</div>

{{-- ===== TABLE ===== --}}
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="text-left px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">ID</th>
                    <th class="text-left px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Pelanggan</th>
                    <th class="text-left px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Kendaraan</th>
                    <th class="text-left px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Periode Sewa</th>
                    <th class="text-left px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Total Bayar</th>
                    <th class="text-left px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Status</th>
                    <th class="text-right px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50" id="booking-table-body">
                @php
                $bookings = [
                    ['id'=>'#RD-001','name'=>'Budi Santoso','phone'=>'0812-3456-7890','vehicle'=>'Toyota Innova Zenix','start'=>'28 Mar','end'=>'31 Mar 2025','total'=>'Rp 1.975.000','status'=>'Aktif','sc'=>'bg-green-100 text-green-700'],
                    ['id'=>'#RD-002','name'=>'Sari Dewi','phone'=>'0813-9876-5432','vehicle'=>'Honda PCX 160','start'=>'27 Mar','end'=>'28 Mar 2025','total'=>'Rp 145.000','status'=>'Selesai','sc'=>'bg-slate-100 text-slate-500'],
                    ['id'=>'#RD-003','name'=>'Riko Pratama','phone'=>'0857-1111-2222','vehicle'=>'Toyota Alphard','start'=>'01 Apr','end'=>'03 Apr 2025','total'=>'Rp 2.425.000','status'=>'Menunggu','sc'=>'bg-yellow-100 text-yellow-700'],
                    ['id'=>'#RD-004','name'=>'Dina Rahayu','phone'=>'0821-3333-4444','vehicle'=>'Honda CR-V Turbo','start'=>'26 Mar','end'=>'31 Mar 2025','total'=>'Rp 3.775.000','status'=>'Aktif','sc'=>'bg-green-100 text-green-700'],
                    ['id'=>'#RD-005','name'=>'Andi Wijaya','phone'=>'0878-5555-6666','vehicle'=>'Yamaha NMAX 155','start'=>'25 Mar','end'=>'27 Mar 2025','total'=>'Rp 225.000','status'=>'Dibatalkan','sc'=>'bg-red-100 text-red-600'],
                    ['id'=>'#RD-006','name'=>'Fitri Handayani','phone'=>'0819-7777-8888','vehicle'=>'Mitsubishi Xpander','start'=>'29 Mar','end'=>'01 Apr 2025','total'=>'Rp 1.525.000','status'=>'Selesai','sc'=>'bg-slate-100 text-slate-500'],
                    ['id'=>'#RD-007','name'=>'Joko Susanto','phone'=>'0812-9999-0000','vehicle'=>'Daihatsu Xenia','start'=>'02 Apr','end'=>'04 Apr 2025','total'=>'Rp 785.000','status'=>'Menunggu','sc'=>'bg-yellow-100 text-yellow-700'],
                ];
                @endphp

                @foreach($bookings as $b)
                <tr class="booking-row hover:bg-slate-50/70 transition-colors"
                    data-name="{{ strtolower($b['name']) }} {{ strtolower($b['vehicle']) }}"
                    data-status="{{ strtolower($b['status']) }}">
                    <td class="px-6 py-4 font-bold text-slate-400 text-xs">{{ $b['id'] }}</td>
                    <td class="px-6 py-4">
                        <p class="font-semibold text-slate-900">{{ $b['name'] }}</p>
                        <p class="text-xs text-slate-400">{{ $b['phone'] }}</p>
                    </td>
                    <td class="px-6 py-4 text-slate-600 font-medium">{{ $b['vehicle'] }}</td>
                    <td class="px-6 py-4 text-slate-500 text-xs">
                        <div class="flex items-center gap-1.5">
                            <i class="fas fa-calendar-alt text-blue-400"></i>
                            {{ $b['start'] }} → {{ $b['end'] }}
                        </div>
                    </td>
                    <td class="px-6 py-4 font-bold text-blue-600">{{ $b['total'] }}</td>
                    <td class="px-6 py-4">
                        <span class="text-xs font-bold px-3 py-1.5 rounded-full {{ $b['sc'] }}">{{ $b['status'] }}</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            @if($b['status'] === 'Menunggu')
                            <button onclick="confirmBooking('{{ $b['id'] }}')"
                                class="flex items-center gap-1.5 bg-green-50 hover:bg-green-100 text-green-600 font-semibold px-3 py-1.5 rounded-lg text-xs transition-colors">
                                <i class="fas fa-check text-xs"></i> Konfirmasi
                            </button>
                            @endif
                            <button onclick="openDetailModal('{{ $b['id'] }}', '{{ $b['name'] }}')"
                                class="w-8 h-8 flex items-center justify-center bg-slate-50 hover:bg-slate-100 text-slate-500 rounded-lg transition-colors">
                                <i class="fas fa-eye text-xs"></i>
                            </button>
                            <button onclick="openCancelModal('{{ $b['id'] }}', '{{ $b['name'] }}')"
                                class="w-8 h-8 flex items-center justify-center bg-red-50 hover:bg-red-100 text-red-500 rounded-lg transition-colors {{ in_array($b['status'], ['Selesai','Dibatalkan']) ? 'opacity-30 cursor-not-allowed' : '' }}">
                                <i class="fas fa-ban text-xs"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Footer --}}
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 px-6 py-4 border-t border-slate-100 bg-slate-50/50">
        <p class="text-sm text-slate-500">Menampilkan <span class="font-semibold text-slate-800">7</span> dari <span class="font-semibold text-slate-800">328</span> pemesanan</p>
        <div class="flex gap-1">
            @foreach([1,2,3,'...',14] as $page)
            <button class="w-9 h-9 rounded-xl text-xs font-semibold transition-all {{ $page == 1 ? 'bg-blue-600 text-white' : 'bg-white border border-slate-200 text-slate-600 hover:border-blue-400 hover:text-blue-600' }}">{{ $page }}</button>
            @endforeach
        </div>
    </div>
</div>

{{-- ===== MODAL DETAIL PEMESANAN ===== --}}
<div id="modal-detail" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
    <div class="absolute inset-0 bg-slate-900/60" style="backdrop-filter:blur(4px)" onclick="closeModal('modal-detail')"></div>
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md z-10 overflow-hidden">
        <div class="flex justify-between items-center px-7 py-5 border-b border-slate-100">
            <h2 class="text-lg font-bold text-slate-900">Detail Pemesanan <span id="detail-id" class="text-blue-600"></span></h2>
            <button onclick="closeModal('modal-detail')" class="w-9 h-9 flex items-center justify-center rounded-xl text-slate-400 hover:bg-slate-100 transition-all">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-7 space-y-4">
            <div class="bg-slate-50 rounded-2xl p-4 space-y-3">
                @php
                $detailRows = [['Pemesan','Budi Santoso'],['No. HP','0812-3456-7890'],['Kendaraan','Toyota Innova Zenix B 1234 ABC'],['Tanggal Mulai','28 Maret 2025, 08:00'],['Tanggal Selesai','31 Maret 2025, 08:00'],['Durasi','3 Hari'],['Harga/Hari','Rp 650.000'],['Biaya Layanan','Rp 25.000'],['Total Bayar','Rp 1.975.000']];
                @endphp
                @foreach($detailRows as [$key, $val])
                <div class="flex justify-between items-start text-sm {{ $key === 'Total Bayar' ? 'pt-3 border-t border-slate-200 font-black' : '' }}">
                    <span class="{{ $key === 'Total Bayar' ? 'text-slate-900' : 'text-slate-400' }}">{{ $key }}</span>
                    <span class="{{ $key === 'Total Bayar' ? 'text-blue-600 text-base' : 'text-slate-800 font-medium text-right max-w-48' }}">{{ $val }}</span>
                </div>
                @endforeach
            </div>
            <div class="flex gap-3">
                <button onclick="closeModal('modal-detail')" class="flex-1 border border-slate-200 hover:bg-slate-50 text-slate-600 font-semibold py-3 rounded-xl text-sm transition-all">Tutup</button>
                <button class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl text-sm transition-all active:scale-95">
                    <i class="fas fa-print mr-1"></i>Cetak Bukti
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ===== MODAL CANCEL ===== --}}
<div id="modal-cancel" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
    <div class="absolute inset-0 bg-slate-900/60" style="backdrop-filter:blur(4px)" onclick="closeModal('modal-cancel')"></div>
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-sm z-10 p-8 text-center">
        <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center mx-auto mb-5">
            <i class="fas fa-ban text-orange-500 text-2xl"></i>
        </div>
        <h3 class="text-xl font-black text-slate-900 mb-2">Batalkan Pemesanan?</h3>
        <p class="text-slate-500 text-sm mb-6">Batalkan pemesanan <span id="cancel-id" class="font-bold text-slate-800"></span> atas nama <span id="cancel-name" class="font-bold text-slate-800"></span>?</p>
        <div class="flex gap-3">
            <button onclick="closeModal('modal-cancel')" class="flex-1 border border-slate-200 hover:bg-slate-50 text-slate-600 font-semibold py-3 rounded-xl text-sm transition-all">Tidak</button>
            <button class="flex-1 bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 rounded-xl text-sm transition-all active:scale-95">Ya, Batalkan</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
        document.body.style.overflow = '';
    }
    function openDetailModal(id, name) {
        document.getElementById('detail-id').textContent = id;
        document.getElementById('modal-detail').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function openCancelModal(id, name) {
        document.getElementById('cancel-id').textContent = id;
        document.getElementById('cancel-name').textContent = name;
        document.getElementById('modal-cancel').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function confirmBooking(id) {
        if (confirm('Konfirmasi pemesanan ' + id + '?')) {
            alert('Pemesanan ' + id + ' berhasil dikonfirmasi (simulasi).');
        }
    }

    // Search
    document.getElementById('search-booking').addEventListener('input', function() {
        const q = this.value.toLowerCase();
        document.querySelectorAll('.booking-row').forEach(row => {
            row.style.display = row.dataset.name.includes(q) ? '' : 'none';
        });
    });

    // Status tab filter
    document.querySelectorAll('.status-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            document.querySelectorAll('.status-tab').forEach(t => {
                t.classList.remove('bg-white', 'shadow-sm', 'text-slate-800');
                t.classList.add('text-slate-500');
            });
            this.classList.add('bg-white', 'shadow-sm', 'text-slate-800');
            this.classList.remove('text-slate-500');

            const status = this.dataset.status;
            document.querySelectorAll('.booking-row').forEach(row => {
                row.style.display = (!status || row.dataset.status === status) ? '' : 'none';
            });
        });
    });

    // Escape to close
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            ['modal-detail','modal-cancel'].forEach(closeModal);
        }
    });
</script>
@endpush
