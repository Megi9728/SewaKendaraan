@extends('layouts.admin')

@section('title', 'Edit Data Sopir')
@section('page-title', 'Edit Sopir')
@section('page-subtitle', 'Perbarui informasi data diri dan status sopir')

@section('content')
<div class="max-w-2xl">
    <a href="{{ route('mitra.drivers.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-[#8F8F7E] hover:text-[#0A174E] mb-6 transition-colors">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Sopir
    </a>

    <div class="bg-white rounded-[2rem] border border-[#EBEBDF] shadow-sm overflow-hidden">
        <div class="p-8 border-b border-[#EBEBDF] bg-[#F9F9F5] flex justify-between items-center">
            <div>
                <h3 class="text-xl font-bold text-[#0A174E]">Edit Sopir: {{ $driver->name }}</h3>
                <p class="text-xs text-[#8F8F7E] font-medium mt-1">Perbarui data diri dan dokumen pendukung sopir</p>
            </div>
            <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-white shadow-md">
                <img src="{{ $driver->driver_photo ? asset('storage/' . $driver->driver_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($driver->name) . '&background=0A174E&color=fff' }}" class="w-full h-full object-cover">
            </div>
        </div>

        <form action="{{ route('mitra.drivers.update', $driver->id) }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nama --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-[#0A174E] uppercase tracking-wider mb-2">Nama Lengkap Sopir</label>
                    <input type="text" name="name" value="{{ $driver->name }}" required class="w-full px-4 py-3 bg-[#F9F9F5] border border-[#D4D4C3] rounded-xl text-sm font-semibold focus:ring-2 focus:ring-[#0A174E]/20 outline-none transition-all">
                </div>

                {{-- No HP --}}
                <div>
                    <label class="block text-xs font-bold text-[#0A174E] uppercase tracking-wider mb-2">Nomor WhatsApp / HP</label>
                    <input type="text" name="phone" value="{{ $driver->phone }}" required class="w-full px-4 py-3 bg-[#F9F9F5] border border-[#D4D4C3] rounded-xl text-sm font-semibold focus:ring-2 focus:ring-[#0A174E]/20 outline-none transition-all">
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-xs font-bold text-[#0A174E] uppercase tracking-wider mb-2">Status Sopir</label>
                    <select name="status" class="w-full px-4 py-3 bg-[#F9F9F5] border border-[#D4D4C3] rounded-xl text-sm font-semibold focus:ring-2 focus:ring-[#0A174E]/20 outline-none transition-all">
                        <option value="available" {{ $driver->status == 'available' ? 'selected' : '' }}>Tersedia</option>
                        <option value="busy" {{ $driver->status == 'busy' ? 'selected' : '' }}>Bertugas</option>
                        <option value="off" {{ $driver->status == 'off' ? 'selected' : '' }}>Libur</option>
                    </select>
                </div>

                {{-- Alamat --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-[#0A174E] uppercase tracking-wider mb-2">Alamat Tinggal</label>
                    <textarea name="address" rows="3" class="w-full px-4 py-3 bg-[#F9F9F5] border border-[#D4D4C3] rounded-xl text-sm font-semibold focus:ring-2 focus:ring-[#0A174E]/20 outline-none resize-none transition-all">{{ $driver->address }}</textarea>
                </div>

                <div class="md:col-span-2 py-4">
                    <div class="h-px bg-[#EBEBDF]"></div>
                </div>

                {{-- Photos --}}
                <div>
                    <label class="block text-xs font-bold text-[#0A174E] uppercase tracking-wider mb-2">Perbarui Foto Profil</label>
                    <input type="file" name="driver_photo" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-[#0A174E]/5 file:text-[#0A174E] hover:file:bg-[#0A174E]/10 cursor-pointer">
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#0A174E] uppercase tracking-wider mb-2">Perbarui Foto KTP</label>
                    <input type="file" name="ktp_photo" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-[#0A174E]/5 file:text-[#0A174E] hover:file:bg-[#0A174E]/10 cursor-pointer">
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#0A174E] uppercase tracking-wider mb-2">Perbarui Foto SIM</label>
                    <input type="file" name="sim_photo" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-[#0A174E]/5 file:text-[#0A174E] hover:file:bg-[#0A174E]/10 cursor-pointer">
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full bg-[#0A174E] text-white py-4 rounded-2xl font-bold hover:shadow-xl hover:shadow-[#0A174E]/20 transition-all active:scale-95 text-lg">
                    Perbarui Data Sopir
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
