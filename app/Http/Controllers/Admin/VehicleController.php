<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pool;
use App\Models\Vehicle;
use App\Models\VehicleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    public function index()
    {
        $categories = VehicleCategory::all();

        if (auth('mitra')->check()) {
            $mitraId  = auth('mitra')->id();
            $vehicles = Vehicle::where('mitra_id', $mitraId)
                ->with(['images', 'units.pool', 'category'])
                ->latest()->get();
            return view('mitra.vehicles.index', compact('vehicles', 'categories'));
        }

        $vehicles = Vehicle::with(['images', 'units.pool', 'category', 'mitra'])->latest()->get();
        return view('admin.vehicles.index', compact('vehicles', 'categories'));
    }

    public function create()
    {
        $categories = VehicleCategory::all();
        return view('mitra.vehicles.create', compact('categories'));
    }

    public function show(Vehicle $vehicle)
    {
        $vehicle->load(['images', 'units.pool', 'category', 'mitra']);
        return view('mitra.vehicles.show', compact('vehicle'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                => 'required|string|max:255',
            'vehicle_category_id' => 'nullable|exists:vehicle_categories,id',
            'type'                => 'required',
            'seats'               => 'required|integer',
            'transmission'        => 'required',
            'fuel_type'           => 'nullable|string',
            'engine_capacity'     => 'nullable|string',
            'price_per_day'       => 'required|integer',
            'status'              => 'required',
            'domicile'            => 'required|string',
            'plate_number'        => 'nullable|string|max:50|unique:vehicle_units,plate_number',
            'image'               => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery'             => 'nullable|array',
            'gallery.*'           => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'description'         => 'nullable|string',
            'latitude'            => 'nullable|numeric',
            'longitude'           => 'nullable|numeric',
            'pool_address'        => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('vehicles', 'public');
        }

        $validated['plate_number'] = strtoupper($validated['plate_number'] ?? '');

        // Mitra: set mitra_id dan ambil pool milik mitra
        $poolId = null;
        if (auth('mitra')->check()) {
            $mitra                 = auth('mitra')->user();
            $validated['mitra_id'] = $mitra->id;
            $pool                  = $mitra->pools()->first();
            if (!$pool) {
                return redirect()->back()
                    ->withErrors(['pool' => 'Silakan set lokasi pool Anda di halaman Profil terlebih dahulu.'])
                    ->withInput();
            }
            $poolId = $pool->id;
        }

        $vehicle = Vehicle::create(
            collect($validated)->except(['gallery', 'plate_number', 'latitude', 'longitude', 'pool_address'])->toArray()
        );

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $img) {
                $vehicle->images()->create(['image_path' => $img->store('vehicles/gallery', 'public')]);
            }
        }

        // Pool default untuk admin
        if (!$poolId) {
            $pool   = Pool::firstOrCreate(
                ['name'    => 'Pool ' . $validated['domicile']],
                ['address' => $validated['domicile']]
            );
            $poolId = $pool->id;
        }

        $vehicle->units()->create([
            'pool_id'      => $poolId,
            'plate_number' => $validated['plate_number'],
            'status'       => strtolower($validated['status']),
        ]);

        return redirect()->back()->with('success', 'Kendaraan berhasil ditambahkan!');
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $unit   = $vehicle->units()->first();
        $unitId = $unit?->id;

        $validated = $request->validate([
            'name'                => 'required|string|max:255',
            'vehicle_category_id' => 'nullable|exists:vehicle_categories,id',
            'type'                => 'required',
            'seats'               => 'required|integer',
            'transmission'        => 'required',
            'fuel_type'           => 'nullable|string',
            'engine_capacity'     => 'nullable|string',
            'price_per_day'       => 'required|integer',
            'status'              => 'required',
            'domicile'            => 'required|string',
            'plate_number'        => 'nullable|string|max:50|unique:vehicle_units,plate_number' . ($unitId ? ',' . $unitId : ''),
            'image'               => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery'             => 'nullable|array',
            'gallery.*'           => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'description'         => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            if ($vehicle->image) Storage::disk('public')->delete($vehicle->image);
            $validated['image'] = $request->file('image')->store('vehicles', 'public');
        } elseif ($request->remove_main_image == '1') {
            if ($vehicle->image) Storage::disk('public')->delete($vehicle->image);
            $validated['image'] = null;
        }

        $validated['plate_number'] = strtoupper($validated['plate_number'] ?? '');

        $vehicle->update(
            collect($validated)->except(['gallery', 'plate_number', 'remove_main_image'])->toArray()
        );

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $img) {
                $vehicle->images()->create(['image_path' => $img->store('vehicles/gallery', 'public')]);
            }
        }

        // Pool
        $pool = Pool::firstOrCreate(
            ['name'    => 'Pool ' . $validated['domicile']],
            ['address' => $validated['domicile']]
        );

        if (!$unit) {
            $vehicle->units()->create([
                'pool_id'      => $pool->id,
                'plate_number' => $validated['plate_number'],
                'status'       => strtolower($validated['status']),
            ]);
        } else {
            $unit->update([
                'plate_number' => $validated['plate_number'],
                'status'       => strtolower($validated['status']),
            ]);
        }

        return redirect()->back()->with('success', 'Kendaraan berhasil diperbarui!');
    }

    public function destroy(Vehicle $vehicle)
    {
        // IDOR: mitra hanya bisa hapus kendaraan miliknya
        if (auth('mitra')->check() && $vehicle->mitra_id !== auth('mitra')->id()) {
            abort(403);
        }

        if ($vehicle->image) Storage::disk('public')->delete($vehicle->image);
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
