<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VehicleUnit;
use App\Models\Vehicle;

class VehicleTrackingController extends Controller
{
    public function updateLocation($token, Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $unit = VehicleUnit::where('tracking_token', $token)->firstOrFail();
        
        $unit->update([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'last_tracked_at' => now(),
        ]);

        return response()->json(['status' => 'success']);
    }

    public function monitor()
    {
        $mitraId  = auth('mitra')->id();
        $vehicles = Vehicle::where('mitra_id', $mitraId)
            ->with('units')
            ->get();

        return view('mitra.monitoring', compact('vehicles'));
    }

    public function device($token)
    {
        $unit = VehicleUnit::where('tracking_token', $token)->with('vehicle')->firstOrFail();
        return view('tracker.device', compact('unit'));
    }
}
