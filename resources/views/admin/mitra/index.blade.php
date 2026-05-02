@extends('layouts.admin')

@section('title', 'Kelola Mitra')

@section('content')

{{-- Breadcrumb / Header area --}}
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-title-md2 font-bold text-black dark:text-white text-2xl">
            Kelola Mitra
        </h2>
        <p class="text-sm text-body dark:text-bodydark mt-1">Daftar semua mitra penyewa di platform ini.</p>
    </div>
</div>

<div class="rounded-2xl border border-stroke bg-white shadow-sm dark:border-white/10 dark:bg-[#24303F] overflow-hidden">
    <div class="border-b border-stroke py-4 px-6 dark:border-white/10 flex justify-between items-center bg-slate-50/50 dark:bg-white/5">
        <h3 class="font-semibold text-black dark:text-white text-lg">
            Daftar Mitra 
            <span class="ml-2 inline-flex items-center justify-center rounded-full bg-primary py-1 px-3 text-xs font-medium text-white">Total: {{ $mitras->count() }}</span>
        </h3>
    </div>

    <div class="p-6">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto text-left">
                <thead class="uppercase tracking-wider text-body dark:text-bodydark font-bold text-[10px] bg-slate-50 dark:bg-white/5 rounded-xl">
                    <tr>
                        <th class="py-4 px-5 font-bold rounded-l-lg">
                            Mitra / Rental
                        </th>
                        <th class="py-4 px-5 font-bold">
                            Kontak / Auth
                        </th>
                        <th class="py-4 px-5 font-bold">
                            Status Verifikasi
                        </th>
                        <th class="py-4 px-5 font-bold rounded-r-lg">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stroke dark:divide-white/10 text-black dark:text-white">
                    @forelse($mitras as $m)
                    <tr class="hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                        <td class="py-4 px-5 align-middle">
                            <p class="font-bold text-black dark:text-white">{{ $m->name }}</p>
                            <p class="mt-1 text-[10px] font-semibold uppercase tracking-wider text-primary">{{ $m->partner_name ?? 'N/A' }}</p>
                        </td>
                        <td class="py-4 px-5 align-middle">
                            <p class="text-sm font-medium text-black dark:text-white">{{ $m->email }}</p>
                            <p class="mt-1 text-xs text-body dark:text-bodydark">{{ $m->phone ?? '-' }}</p>
                        </td>
                        <td class="py-4 px-5 align-middle">
                            <form action="{{ route('admin.mitra.update', $m->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="is_verified" value="{{ $m->is_verified ? 0 : 1 }}">
                                <button type="submit" 
                                    class="inline-flex rounded-full py-1 px-3 text-xs font-semibold shadow-sm transition-transform hover:scale-105 
                                    {{ $m->is_verified ? 'bg-success/10 text-success dark:text-emerald-400' : 'bg-danger/10 text-danger dark:text-red-400' }}">
                                    {{ $m->is_verified ? 'Terverifikasi' : 'Belum Verifikasi' }}
                                </button>
                            </form>
                        </td>
                        <td class="py-4 px-5 align-middle">
                            <form action="{{ route('admin.mitra.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Hapus mitra ini? Tindakan ini tidak dapat dibatalkan.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="hover:text-danger text-body dark:text-bodydark transition-colors" title="Hapus Mitra">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-10">
                            <div class="w-16 h-16 bg-slate-100 dark:bg-white/5 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-users text-body dark:text-bodydark text-2xl"></i>
                            </div>
                            <p class="text-black dark:text-white font-semibold">Tida ada mitra yang terdaftar.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection