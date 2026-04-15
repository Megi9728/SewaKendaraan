@extends('layouts.admin')

@section('title', 'Kelola Mitra')

@section('content')
<div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
        <div>
            <h3 class="text-lg font-black text-slate-900 leading-none">Daftar Mitra</h3>
            <p class="text-xs text-slate-400 mt-2 font-bold uppercase tracking-widest">Total: {{ $mitras->count() }} Mitra</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama Mitra / Rental</th>
                    <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Kontak</th>
                    <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Verifikasi</th>
                    <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($mitras as $m)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-8 py-5">
                        <p class="font-bold text-slate-900">{{ $m->name }}</p>
                        <p class="text-[10px] text-blue-600 font-bold uppercase tracking-wider">{{ $m->partner_name ?? 'N/A' }}</p>
                    </td>
                    <td class="px-8 py-5">
                        <p class="text-xs font-bold text-slate-700">{{ $m->email }}</p>
                        <p class="text-[10px] text-slate-400 font-medium">{{ $m->phone }}</p>
                    </td>
                    <td class="px-8 py-5">
                        <form action="{{ route('admin.mitra.update', $m->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="is_verified" value="{{ $m->is_verified ? 0 : 1 }}">
                            <button type="submit" class="px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all {{ $m->is_verified ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $m->is_verified ? 'Terverifikasi' : 'Belum Verifikasi' }}
                            </button>
                        </form>
                    </td>
                    <td class="px-8 py-5">
                        <form action="{{ route('admin.mitra.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Hapus mitra ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-slate-400 hover:text-red-600 transition-colors">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
