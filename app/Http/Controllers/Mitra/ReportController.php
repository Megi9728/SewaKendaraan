<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function export(Request $request)
    {
        $mitraId = auth('mitra')->id();
        $query = Booking::with(['vehicle.category', 'customer'])
            ->where('status', 'Completed')
            ->whereHas('vehicle', function($q) use ($mitraId) {
                $q->where('mitra_id', $mitraId);
            });

        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        if ($request->filled('category_id')) {
            $query->whereHas('vehicle', function ($q) use ($request) {
                $q->where('vehicle_category_id', $request->category_id);
            });
        }

        if ($request->filled('type')) {
            if ($request->type == 'with_driver') {
                $query->where(function($q) {
                    $q->where('driver_fee', '>', 0)->orWhereNotNull('driver_id');
                });
            } else if ($request->type == 'lepas_kunci') {
                $query->where('driver_fee', 0)->whereNull('driver_id');
            }
        }

        $bookings = $query->get();

        $filename = "Laporan_Mitra_" . date('Y-m-d_H-i-s') . ".csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID Booking', 'Tanggal', 'Pelanggan', 'Kendaraan', 'Kategori', 'Jenis Pesanan', 'Total Pendapatan'];

        $callback = function() use($bookings, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($bookings as $booking) {
                $jenis = ($booking->driver_fee > 0 || !is_null($booking->driver_id)) ? 'Dengan Sopir' : 'Lepas Kunci';
                $row['ID Booking'] = '#TRX-' . $booking->id;
                $row['Tanggal']    = $booking->created_at->format('d/m/Y');
                $row['Pelanggan']  = $booking->customer->name ?? '-';
                $row['Kendaraan']  = $booking->vehicle->name;
                $row['Kategori']   = $booking->vehicle->category->name ?? '-';
                $row['Jenis Pesanan'] = $jenis;
                $row['Total']      = $booking->total_price;

                fputcsv($file, array($row['ID Booking'], $row['Tanggal'], $row['Pelanggan'], $row['Kendaraan'], $row['Kategori'], $row['Jenis Pesanan'], $row['Total']));
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
