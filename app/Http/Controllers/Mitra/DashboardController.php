<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Driver;
use App\Models\Payment;
use App\Models\Vehicle;

class DashboardController extends Controller
{
    public function index()
    {
        $mitra = auth('mitra')->user();
        $mitraId = $mitra->id;

        $stats = [
            'total_mobil'   => Vehicle::where('mitra_id', $mitraId)->count(),
            'total_booking' => Booking::whereHas('vehicle', fn($q) => $q->where('mitra_id', $mitraId))->count(),
            'pending'       => Booking::where('status', 'Pending')->whereHas('vehicle', fn($q) => $q->where('mitra_id', $mitraId))->count(),
            'active'        => Booking::whereIn('status', ['Active', 'Picked_Up'])->whereHas('vehicle', fn($q) => $q->where('mitra_id', $mitraId))->count(),
            'revenue'       => Payment::whereHas('booking.vehicle', fn($q) => $q->where('mitra_id', $mitraId))->where('payment_status', 'fully_paid')->sum('amount'),
            'total_drivers' => Driver::where('mitra_id', $mitraId)->count(),
        ];

        $chartData   = [];
        $chartLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $month         = now()->subMonths($i);
            $chartLabels[] = $month->translatedFormat('F');
            $chartData[]   = Booking::whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->whereHas('vehicle', fn($q) => $q->where('mitra_id', $mitraId))
                ->count();
        }

        $weeklyChartData = [];
        $weeklyChartLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $startOfWeek = now()->startOfWeek()->subWeeks($i);
            $endOfWeek = now()->endOfWeek()->subWeeks($i);
            $weeklyChartLabels[] = $startOfWeek->format('d M') . ' - ' . $endOfWeek->format('d M');
            $weeklyChartData[]   = Booking::whereBetween('created_at', [$startOfWeek, $endOfWeek])
                ->whereHas('vehicle', fn($q) => $q->where('mitra_id', $mitraId))
                ->count();
        }

        return view('mitra.dashboard', compact('stats', 'chartData', 'chartLabels', 'weeklyChartData', 'weeklyChartLabels', 'mitra'));
    }
}
