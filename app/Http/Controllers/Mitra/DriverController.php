<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DriverController extends Controller
{
    private function authMitra()
    {
        return auth('mitra')->user();
    }

    public function index()
    {
        $mitra   = $this->authMitra();
        $drivers = Driver::where('mitra_id', $mitra->id)->latest()->get();
        return view('mitra.drivers.index', compact('drivers'));
    }

    public function create()
    {
        return view('mitra.drivers.create');
    }

    public function store(Request $request)
    {
        $mitra = $this->authMitra();

        $request->validate([
            'name'         => 'required|string|max:255',
            'phone'        => 'required|string|max:20',
            'address'      => 'nullable|string',
            'ktp_photo'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'sim_photo'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'driver_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'mitra_id' => $mitra->id,
            'name'     => $request->name,
            'phone'    => $request->phone,
            'address'  => $request->address,
            'status'   => 'available',
        ];

        foreach (['ktp_photo', 'sim_photo', 'driver_photo'] as $file) {
            if ($request->hasFile($file)) {
                if (in_array($file, ['ktp_photo', 'sim_photo'])) {
                    $data[$file] = \App\Services\ImageService::storeWithWatermark($request->file($file), 'drivers/' . $file);
                } else {
                    $data[$file] = $request->file($file)->store('drivers/' . $file, 'public');
                }
            }
        }

        Driver::create($data);

        return redirect()->route('mitra.drivers.index')
            ->with('success', 'Sopir berhasil ditambahkan!');
    }

    public function edit(Driver $driver)
    {
        $this->authorizeDriver($driver);
        return view('mitra.drivers.edit', compact('driver'));
    }

    public function update(Request $request, Driver $driver)
    {
        $this->authorizeDriver($driver);

        $request->validate([
            'name'         => 'required|string|max:255',
            'phone'        => 'required|string|max:20',
            'address'      => 'nullable|string',
            'status'       => 'required|in:available,busy,off',
            'ktp_photo'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'sim_photo'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'driver_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'name'    => $request->name,
            'phone'   => $request->phone,
            'address' => $request->address,
            'status'  => $request->status,
        ];

        foreach (['ktp_photo', 'sim_photo', 'driver_photo'] as $file) {
            if ($request->hasFile($file)) {
                // Hapus file lama
                if ($driver->$file) Storage::disk('public')->delete($driver->$file);
                
                if (in_array($file, ['ktp_photo', 'sim_photo'])) {
                    $data[$file] = \App\Services\ImageService::storeWithWatermark($request->file($file), 'drivers/' . $file);
                } else {
                    $data[$file] = $request->file($file)->store('drivers/' . $file, 'public');
                }
            }
        }

        $driver->update($data);

        return redirect()->route('mitra.drivers.index')
            ->with('success', 'Data sopir berhasil diperbarui!');
    }

    public function destroy(Driver $driver)
    {
        $this->authorizeDriver($driver);

        foreach (['ktp_photo', 'sim_photo', 'driver_photo'] as $file) {
            if ($driver->$file) Storage::disk('public')->delete($driver->$file);
        }

        $driver->delete();

        return redirect()->route('mitra.drivers.index')
            ->with('success', 'Data sopir berhasil dihapus!');
    }

    private function authorizeDriver(Driver $driver)
    {
        if ($driver->mitra_id !== $this->authMitra()->id) {
            abort(403, 'Anda tidak memiliki akses ke data sopir ini.');
        }
    }
}
