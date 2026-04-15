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
        if (auth()->user()->isMitra()) {
            $mitraId = auth()->id();
            $vehicles = Vehicle::where('mitra_id', $mitraId)->with(['images', 'units.pool'])->latest()->get();
            return view('mitra.vehicles.index', compact('vehicles'));
        }
        
        $vehicles = Vehicle::with(['images', 'units.pool'])->latest()->get();
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
            'price_per_day' => 'required|integer',
            'driver_price' => 'required|integer',
            'status' => 'required',
            'domicile' => 'required|string',
            'plate_number' => 'nullable|string|max:50|unique:vehicle_units,plate_number',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery' => 'nullable|array',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'pool_address' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('vehicles', 'public');
            $validated['image'] = $imagePath;
        }

        $validated['plate_number'] = strtoupper($validated['plate_number']);

        if (auth()->user()->isMitra()) {
            $validated['mitra_id'] = auth()->id();
            
            if (!auth()->user()->pool_id) {
                return redirect()->back()->withErrors(['pool' => 'Silakan set lokasi pool Anda di halaman Profil terlebih dahulu.'])->withInput();
            }
        }

        $vehicle = Vehicle::create(collect($validated)->except(['gallery', 'plate_number', 'latitude', 'longitude', 'pool_address'])->toArray());

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $path = $image->store('vehicles/gallery', 'public');
                $vehicle->images()->create(['image_path' => $path]);
            }
        }
        
        $poolId = auth()->user()->pool_id;
        
        $vehicle->units()->create([
            'pool_id' => $poolId,
            'plate_number' => $request->plate_number,
            'status' => 'tersedia'
        ]);

        return redirect()->back()->with('success', 'Kendaraan berhasil ditambahkan!');
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $unit = $vehicle->units()->first();
        $unitId = $unit ? $unit->id : null;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required',
            'seats' => 'required|integer',
            'transmission' => 'required',
            'fuel_type' => 'nullable|string',
            'engine_capacity' => 'nullable|integer',
            'price_per_day' => 'required|integer',
            'driver_price' => 'required|integer',
            'status' => 'required',
            'domicile' => 'required|string',
            'plate_number' => 'nullable|string|max:50|unique:vehicle_units,plate_number' . ($unitId ? ',' . $unitId : ''),
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery' => 'nullable|array',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'pool_address' => 'nullable|string',
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

        $validated['plate_number'] = strtoupper($validated['plate_number']);

        $vehicle->update(collect($validated)->except(['gallery', 'plate_number'])->toArray());

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $path = $image->store('vehicles/gallery', 'public');
                $vehicle->images()->create(['image_path' => $path]);
            }
        }

        $pool = \App\Models\Pool::firstOrCreate(
            ['name' => 'Pool ' . $validated['domicile']], 
            ['address' => $validated['domicile']]
        );

        $unit = $vehicle->units()->first();
        if (!$unit) {
            $vehicle->units()->create([
                'pool_id' => $pool->id,
                'plate_number' => $request->plate_number,
                'status' => 'tersedia'
            ]);
        } else {
            $unit->update([
                'plate_number' => $request->plate_number,
            ]);
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
