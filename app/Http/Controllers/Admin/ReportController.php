<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function export(Request $request)
    {
        $query = Booking::with(['vehicle.mitra', 'vehicle.category', 'customer'])
            ->where('status', 'Completed');

        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        if ($request->filled('domicile')) {
            $query->whereHas('vehicle', function ($q) use ($request) {
                $q->where('domicile', $request->domicile);
            });
        }

        if ($request->filled('category_id')) {
            $query->whereHas('vehicle', function ($q) use ($request) {
                $q->where('vehicle_category_id', $request->category_id);
            });
        }

        $bookings = $query->get();

        $filename = "Laporan_Admin_" . date('Y-m-d_H-i-s') . ".csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID Booking', 'Tanggal', 'Pelanggan', 'Mitra', 'Kendaraan', 'Kategori', 'Wilayah', 'Total Pendapatan'];

        $callback = function() use($bookings, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($bookings as $booking) {
                $row['ID Booking'] = '#TRX-' . $booking->id;
                $row['Tanggal']    = $booking->created_at->format('d/m/Y');
                $row['Pelanggan']  = $booking->customer->name ?? '-';
                $row['Mitra']      = $booking->vehicle->mitra->name ?? 'Internal';
                $row['Kendaraan']  = $booking->vehicle->name;
                $row['Kategori']   = $booking->vehicle->category->name ?? '-';
                $row['Wilayah']    = $booking->vehicle->domicile ?? '-';
                $row['Total']      = $booking->total_price;

                fputcsv($file, array($row['ID Booking'], $row['Tanggal'], $row['Pelanggan'], $row['Mitra'], $row['Kendaraan'], $row['Kategori'], $row['Wilayah'], $row['Total']));
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
