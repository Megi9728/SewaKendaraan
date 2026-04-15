<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DriverController extends Controller
{
    public function index()
    {
        $query = Driver::query();
        if (auth()->user()->isMitra()) {
            $query->where('mitra_id', auth()->id());
            $drivers = $query->latest()->get();
            return view('mitra.drivers.index', compact('drivers'));
        }
        $drivers = $query->latest()->get();
        return view('admin.drivers.index', compact('drivers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'phone' => 'required|string',
            'status' => 'required|in:Available,Busy,Off',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string'
        ]);

        // 1. Create User
        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'phone' => $validated['phone'],
            'role' => 'driver',
        ]);

        // 2. Add photo if exists
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('drivers', 'public');
        }

        // 3. Create Driver
        $validated['user_id'] = $user->id;
        if (auth()->user()->isMitra()) {
            $validated['mitra_id'] = auth()->id();
        }
        Driver::create(collect($validated)->except(['email', 'password'])->toArray());

        return redirect()->back()->with('success', 'Driver dan akun berhasil ditambahkan!');
    }

    public function update(Request $request, Driver $driver)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $driver->user_id,
            'password' => 'nullable|string|min:6',
            'phone' => 'required|string',
            'status' => 'required|in:Available,Busy,Off',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string'
        ]);

        // 1. Prepare User Data
        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
        ];
        if ($request->filled('password')) {
            $userData['password'] = bcrypt($validated['password']);
        }

        if ($driver->user) {
            $driver->user->update($userData);
        } else {
            // Jika driver lama belum punya akun, buatkan baru
            if (!isset($userData['password'])) {
                $userData['password'] = bcrypt('password123');
            }
            $userData['role'] = 'driver';
            $user = \App\Models\User::create($userData);
            $driver->user_id = $user->id;
        }

        // 2. Update Photo
        if ($request->hasFile('photo')) {
            if ($driver->photo) {
                Storage::disk('public')->delete($driver->photo);
            }
            $validated['photo'] = $request->file('photo')->store('drivers', 'public');
        }

        // 3. Update Driver
        $driver->update(collect($validated)->except(['email', 'password'])->toArray());

        return redirect()->back()->with('success', 'Data driver dan akun berhasil diperbarui!');
    }

    public function destroy(Driver $driver)
    {
        if ($driver->photo) {
            Storage::disk('public')->delete($driver->photo);
        }
        
        // Delete user first (cascades to driver if foreign key set, but we do it manually to be safe)
        if ($driver->user) {
            $driver->user->delete();
        }
        
        $driver->delete();
        return redirect()->back()->with('success', 'Driver dan akun berhasil dihapus!');
    }
}
