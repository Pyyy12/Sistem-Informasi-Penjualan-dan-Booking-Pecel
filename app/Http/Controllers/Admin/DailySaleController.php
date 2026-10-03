<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailySale;
use App\Models\Booking;
use Illuminate\Http\Request;

class DailySaleController extends Controller
{
    public function index()
    {
        $sales = DailySale::orderBy('sale_date', 'desc')->paginate(15);
        return view('admin.sales.index', compact('sales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sale_date' => 'required|date',
            'total_portions_sold' => 'required|numeric|min:0',
            'dine_in_revenue' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        // Hitung pendapatan booking yang lunas/confirmed di tanggal tersebut secara otomatis
        $bookingRevenue = Booking::where('booking_date', $request->sale_date)
            ->where('status', 'confirmed')
            ->sum('total_price');

        $totalRevenue = $request->dine_in_revenue + $bookingRevenue;

        DailySale::updateOrCreate(
            ['sale_date' => $request->sale_date],
            [
                'total_portions_sold' => $request->total_portions_sold,
                'dine_in_revenue' => $request->dine_in_revenue,
                'booking_revenue' => $bookingRevenue,
                'total_revenue' => $totalRevenue,
                'notes' => $request->notes,
            ]
        );

        return redirect()->route('admin.sales.index')->with('success', 'Data penjualan berhasil disimpan!');
    }
}