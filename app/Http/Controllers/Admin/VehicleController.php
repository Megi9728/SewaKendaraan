<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::latest()->get();
        return view('admin.vehicles.index', compact('vehicles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required',
            'seats' => 'required|integer',
            'transmission' => 'required',
            'price_per_day' => 'required|integer',
            'status' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('vehicles', 'public');
            $validated['image'] = $imagePath;
        }

        Vehicle::create($validated);

        return redirect()->back()->with('success', 'Kendaraan berhasil ditambahkan!');
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required',
            'seats' => 'required|integer',
            'transmission' => 'required',
            'price_per_day' => 'required|integer',
            'status' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            if ($vehicle->image) {
                Storage::disk('public')->delete($vehicle->image);
            }
            $imagePath = $request->file('image')->store('vehicles', 'public');
            $validated['image'] = $imagePath;
        }

        $vehicle->update($validated);

        return redirect()->back()->with('success', 'Kendaraan berhasil diperbarui!');
    }

    public function destroy(Vehicle $vehicle)
    {
        if ($vehicle->image) {
            Storage::disk('public')->delete($vehicle->image);
        }
        $vehicle->delete();
        return redirect()->back()->with('success', 'Kendaraan berhasil dihapus!');
    }
}
