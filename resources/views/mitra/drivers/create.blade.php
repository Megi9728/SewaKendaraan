@extends('layouts.admin')

@section('title', 'Tambah Sopir Baru')
@section('page-title', 'Tambah Sopir')
@section('page-subtitle', 'Daftarkan sopir baru ke tim mitra Anda')

@section('content')
<div class="max-w-2xl">
    <a href="{{ route('mitra.drivers.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-[#8F8F7E] hover:text-[#0A174E] mb-6 transition-colors">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Sopir
    </a>

    <div class="bg-white rounded-[2rem] border border-[#EBEBDF] shadow-sm overflow-hidden">
        <div class="p-8 border-b border-[#EBEBDF] bg-[#F9F9F5]">
            <h3 class="text-xl font-bold text-[#0A174E]">Informasi Sopir</h3>
            <p class="text-xs text-[#8F8F7E] font-medium mt-1">Lengkapi data diri dan dokumen pendukung sopir</p>
        </div>

        <form action="{{ route('mitra.drivers.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nama --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-[#0A174E] uppercase tracking-wider mb-2">Nama Lengkap Sopir</label>
                    <input type="text" name="name" required placeholder="Cth: Ahmad Subagjo" class="w-full px-4 py-3 bg-[#F9F9F5] border border-[#D4D4C3] rounded-xl text-sm font-semibold focus:ring-2 focus:ring-[#0A174E]/20 outline-none transition-all">
                </div>

                {{-- No HP --}}
                <div>
                    <label class="block text-xs font-bold text-[#0A174E] uppercase tracking-wider mb-2">Nomor WhatsApp / HP</label>
                    <input type="text" name="phone" required placeholder="Cth: 08123456789" class="w-full px-4 py-3 bg-[#F9F9F5] border border-[#D4D4C3] rounded-xl text-sm font-semibold focus:ring-2 focus:ring-[#0A174E]/20 outline-none transition-all">
                </div>

                {{-- Alamat --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-[#0A174E] uppercase tracking-wider mb-2">Alamat Tinggal</label>
                    <textarea name="address" rows="3" class="w-full px-4 py-3 bg-[#F9F9F5] border border-[#D4D4C3] rounded-xl text-sm font-semibold focus:ring-2 focus:ring-[#0A174E]/20 outline-none resize-none transition-all"></textarea>
                </div>

                <div class="md:col-span-2 py-4">
                    <div class="h-px bg-[#EBEBDF]"></div>
                </div>

                {{-- Photos --}}
                <div>
                    <label class="block text-xs font-bold text-[#0A174E] uppercase tracking-wider mb-2">Foto Profil</label>
                    <input type="file" name="driver_photo" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-[#0A174E]/5 file:text-[#0A174E] hover:file:bg-[#0A174E]/10 cursor-pointer">
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#0A174E] uppercase tracking-wider mb-2">Foto KTP</label>
                    <input type="file" name="ktp_photo" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-[#0A174E]/5 file:text-[#0A174E] hover:file:bg-[#0A174E]/10 cursor-pointer">
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#0A174E] uppercase tracking-wider mb-2">Foto SIM</label>
                    <input type="file" name="sim_photo" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-[#0A174E]/5 file:text-[#0A174E] hover:file:bg-[#0A174E]/10 cursor-pointer">
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full bg-[#F5D042] text-[#0A174E] py-4 rounded-2xl font-bold hover:shadow-xl hover:shadow-[#F5D042]/20 transition-all active:scale-95 text-lg">
                    Simpan Data Sopir
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
