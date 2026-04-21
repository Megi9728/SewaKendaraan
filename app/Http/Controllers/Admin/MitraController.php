<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class MitraController extends Controller
{
    public function index()
    {
        $mitras = User::where('role', 'mitra')->latest()->get();
        return view('admin.mitra.index', compact('mitras'));
    }

    public function update(Request $request, User $mitra)
    {
        $request->validate([
            'is_verified' => 'required|boolean',
        ]);

        $mitra->update(['is_verified' => $request->is_verified]);

        return redirect()->back()->with('success', 'Status verifikasi mitra berhasil diperbarui!');
    }

    public function destroy(User $mitra)
    {
        $mitra->delete();
        return redirect()->back()->with('success', 'Data mitra berhasil dihapus!');
    }
}
