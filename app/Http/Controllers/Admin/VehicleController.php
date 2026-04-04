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
        $vehicles = Vehicle::with('images')->latest()->get();
        return view('admin.vehicles.index', compact('vehicles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required',
            'seats' => 'required|integer',
            'transmission' => 'required',
            'fuel_type' => 'nullable|string',
            'engine_capacity' => 'nullable|integer',
            'units_count' => 'required|integer',
            'price_per_day' => 'required|integer',
            'status' => 'required',
            'domicile' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery' => 'nullable|array',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('vehicles', 'public');
            $validated['image'] = $imagePath;
        }

        $vehicle = Vehicle::create(collect($validated)->except(['gallery'])->toArray());

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $path = $image->store('vehicles/gallery', 'public');
                $vehicle->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->back()->with('success', 'Kendaraan berhasil ditambahkan!');
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required',
            'seats' => 'required|integer',
            'transmission' => 'required',
            'fuel_type' => 'nullable|string',
            'engine_capacity' => 'nullable|integer',
            'units_count' => 'required|integer',
            'price_per_day' => 'required|integer',
            'status' => 'required',
            'domicile' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery' => 'nullable|array',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            if ($vehicle->image) {
                Storage::disk('public')->delete($vehicle->image);
            }
            $imagePath = $request->file('image')->store('vehicles', 'public');
            $validated['image'] = $imagePath;
        } elseif ($request->remove_main_image == "1") {
            if ($vehicle->image) {
                Storage::disk('public')->delete($vehicle->image);
            }
            $validated['image'] = null;
        }

        $vehicle->update(collect($validated)->except(['gallery'])->toArray());

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $path = $image->store('vehicles/gallery', 'public');
                $vehicle->images()->create(['image_path' => $path]);
            }
        }

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

    public function destroyImage(\App\Models\VehicleImage $image)
    {
        Storage::disk('public')->delete($image->image_path);
        $image->delete();
        return redirect()->back()->with('success', 'Gambar galeri berhasil dihapus!');
    }
}
