<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\VehicleCategory;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function home()
    {
        $vehicles = Vehicle::with('category')->latest()->take(6)->get();
        return view('home', compact('vehicles'));
    }

    public function browse(Request $request)
    {
        $query = Vehicle::with('category');

        if ($request->filled('category')) {
            $query->where('vehicle_category_id', $request->category);
        }

        if ($request->filled('domicile')) {
            $query->where('domicile', $request->domicile);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->where(function ($q) use ($request) {
                $q->whereRaw('(SELECT COUNT(*) FROM vehicle_units WHERE vehicle_units.vehicle_id = vehicles.id AND vehicle_units.status != "maintenance") > (
                    SELECT COUNT(*) FROM bookings
                    WHERE bookings.vehicle_id = vehicles.id
                    AND status NOT IN ("Cancelled", "Rejected", "Completed")
                    AND (
                        (start_date BETWEEN ? AND ?) OR
                        (end_date BETWEEN ? AND ?) OR
                        (start_date <= ? AND end_date >= ?)
                    )
                )', [
                    $request->start_date, $request->end_date,
                    $request->start_date, $request->end_date,
                    $request->start_date, $request->end_date,
                ]);
            });
        }

        $sort = $request->get('sort', 'latest');
        match ($sort) {
            'price_asc'  => $query->orderBy('price_per_day', 'asc'),
            'price_desc' => $query->orderBy('price_per_day', 'desc'),
            'rating'     => $query->orderBy('rating', 'desc'),
            default      => $query->latest(),
        };

        $vehicles   = $query->get();
        $categories = VehicleCategory::all();
        return view('browse', compact('vehicles', 'categories'));
    }

    public function vehicleDetail(Vehicle $vehicle)
    {
        $vehicle->load(['images', 'mitra', 'units.pool', 'category', 'bookings' => function ($q) {
            $q->whereNotNull('review')->where('review', '!=', '')->with('customer')->latest();
        }]);
        return view('vehicle-detail', compact('vehicle'));
    }

    public function howItWorks()
    {
        return view('how-it-works');
    }

    public function help()
    {
        return view('help');
    }
}
