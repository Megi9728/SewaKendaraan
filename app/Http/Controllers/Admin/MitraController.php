<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mitra;
use Illuminate\Http\Request;

class MitraController extends Controller
{
    public function index()
    {
        $mitras = Mitra::withCount(['vehicles', 'drivers'])->latest()->get();
        return view('admin.mitra.index', compact('mitras'));
    }

    public function show(Mitra $mitra)
    {
        $mitra->load(['vehicles', 'pools', 'drivers']);
        return view('admin.mitra.show', compact('mitra'));
    }

    public function update(Request $request, Mitra $mitra)
    {
        $request->validate([
            'is_verified' => 'required|boolean',
        ]);

        $mitra->update(['is_verified' => $request->is_verified]);

        return redirect()->back()->with('success', 'Status verifikasi mitra berhasil diperbarui!');
    }

    public function destroy(Mitra $mitra)
    {
        $mitra->delete();
        return redirect()->back()->with('success', 'Data mitra berhasil dihapus!');
    }
}
