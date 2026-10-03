<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailySale;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $currentMonth = $request->get('month', Carbon::now()->format('m'));
        $currentYear = $request->get('year', Carbon::now()->format('Y'));

        // Akumulasi Bulanan
        $monthlySales = DailySale::whereMonth('sale_date', $currentMonth)
            ->whereYear('sale_date', $currentYear)
            ->get();

        $totalRevenueMonth = $monthlySales->sum('total_revenue');
        $totalPortionsMonth = $monthlySales->sum('total_portions_sold');
        $totalDineInMonth = $monthlySales->sum('dine_in_revenue');
        $totalBookingMonth = $monthlySales->sum('booking_revenue');

        // Rekap Hari Ini
        $todaySale = DailySale::where('sale_date', Carbon::today())->first();

        // 5 Booking Terakhir
        $recentBookings = Booking::with('table')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'monthlySales',
            'totalRevenueMonth',
            'totalPortionsMonth',
            'totalDineInMonth',
            'totalBookingMonth',
            'todaySale',
            'recentBookings',
            'currentMonth',
            'currentYear'
        ));
    }
}