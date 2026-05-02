@extends('layouts.admin')

@section('title', 'Kelola Mitra')

@section('content')

{{-- Header Area --}}
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-xl font-bold text-gray-800 dark:text-white tracking-tight">
            Manajemen Mitra
        </h2>
        <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5 font-medium">Daftar semua mitra rental kendaraan yang terdaftar dalam platform.</p>
    </div>
    <div class="flex items-center gap-3">
        <div class="bg-white dark:bg-white/[0.03] border border-gray-200 dark:border-gray-800 px-4 py-2 rounded-xl flex items-center gap-3 shadow-sm">
            <div class="w-2 h-2 rounded-full bg-brand-500"></div>
            <span class="text-[9px] font-bold uppercase tracking-widest text-gray-500 dark:text-gray-400">Total: {{ $mitras->count() }} Mitra</span>
        </div>
    </div>
</div>

<div class="rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
    <div class="border-b border-gray-100 py-4 px-6 dark:border-gray-800 flex justify-between items-center bg-gray-50/50 dark:bg-white/[0.01]">
        <div class="flex items-center gap-3">
            <div class="w-1.5 h-5 bg-brand-500 rounded-full"></div>
            <h3 class="text-sm font-bold text-gray-800 dark:text-white">
                Daftar Mitra Terdaftar
            </h3>
        </div>
    </div>

    <div class="p-0">
        <div class="max-w-full overflow-x-auto custom-scrollbar">
            <table class="w-full text-left whitespace-nowrap">
                <thead class="bg-gray-50 dark:bg-white/[0.02]">
                    <tr>
                        <th class="py-3 px-6 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Informasi Mitra</th>
                        <th class="py-3 px-6 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Kontak & Auth</th>
                        <th class="py-3 px-6 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Verifikasi</th>
                        <th class="py-3 px-6 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($mitras as $m)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.01] transition-colors">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-brand-500/10 text-brand-600 dark:text-brand-400 flex items-center justify-center text-[10px] font-bold border border-brand-500/20">
                                    {{ substr($m->partner_name ?? $m->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-800 dark:text-white leading-tight">{{ $m->name }}</p>
                                    <p class="mt-0.5 text-[9px] font-bold uppercase tracking-widest text-brand-500">{{ $m->partner_name ?? 'Rental Belum Diset' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex flex-col gap-0.5">
                                <div class="flex items-center gap-2 text-xs font-semibold text-gray-800 dark:text-white/90">
                                    <i class="fas fa-envelope text-[9px] text-gray-400"></i>
                                    {{ $m->email }}
                                </div>
                                <div class="flex items-center gap-2 text-[10px] text-gray-400 dark:text-gray-500 font-medium">
                                    <i class="fas fa-phone text-[9px] text-gray-400"></i>
                                    {{ $m->phone ?? '-' }}
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <form action="{{ route('admin.mitra.update', $m->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="is_verified" value="{{ $m->is_verified ? 0 : 1 }}">
                                <button type="submit" 
                                    class="inline-flex items-center gap-2 rounded-full py-1 px-3 text-[9px] font-bold uppercase tracking-widest shadow-sm transition-all active:scale-95 border
                                    {{ $m->is_verified 
                                        ? 'bg-success-50 text-success-600 border-success-500/20 dark:bg-success-500/10 dark:text-success-400 dark:border-success-500/20' 
                                        : 'bg-error-50 text-error-600 border-error-500/20 dark:bg-error-500/10 dark:text-error-400 dark:border-error-500/20' }}">
                                    <div class="w-1 h-1 rounded-full {{ $m->is_verified ? 'bg-success-500' : 'bg-error-500' }}"></div>
                                    {{ $m->is_verified ? 'Verified' : 'Unverified' }}
                                </button>
                            </form>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <form action="{{ route('admin.mitra.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Hapus mitra ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-gray-50 dark:bg-white/5 flex items-center justify-center text-gray-400 hover:text-error-500 hover:bg-error-50 dark:hover:bg-error-500/10 transition-all border border-gray-100 dark:border-gray-800">
                                        <i class="fas fa-trash-alt text-[10px]"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-20 bg-gray-50/20 dark:bg-white/[0.01]">
                            <div class="w-16 h-16 bg-gray-100 dark:bg-white/5 rounded-2xl flex items-center justify-center mx-auto mb-4 border-2 border-dashed border-gray-200 dark:border-gray-800">
                                <i class="fas fa-users text-gray-300 dark:text-gray-700 text-2xl"></i>
                            </div>
                            <p class="text-gray-400 dark:text-gray-500 font-bold uppercase tracking-widest text-[10px]">Belum ada mitra yang terdaftar</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection