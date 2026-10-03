<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function index()
    {
        $tables = Table::where('is_active', true)->get();
        return view('welcome', compact('tables'));
    }

    public function checkAvailability(Request $request)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
        ]);

        $bookedTableIds = Booking::where('booking_date', $request->date)
            ->where('booking_time', $request->time)
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('table_id')
            ->toArray();

        return response()->json(['booked_table_ids' => $bookedTableIds]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'table_id' => 'required|exists:tables,id',
            'customer_name' => 'required|string|max:100',
            'customer_whatsapp' => 'required|string|max:20',
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'required',
            'payment_method' => 'required|in:transfer_bca,transfer_mandiri,qris',
        ]);

        // Cek kembali ketersediaan meja agar tidak terjadi double booking
        $exists = Booking::where('table_id', $request->table_id)
            ->where('booking_date', $request->booking_date)
            ->where('booking_time', $request->booking_time)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'Maaf! Meja tersebut sudah dibooking pada jam dan tanggal yang dipilih.');
        }

        $table = Table::findOrFail($request->table_id);
        
        $packageNames = [
            'duo' => 'Paket Berdua Romantis',
            'quad' => 'Paket Berempat Komplit',
            'group8' => 'Paket Guyub Berdelapan',
            'vip' => 'Paket Sewa Hall VIP 100 Pax',
        ];

        $booking = Booking::create([
            'booking_code' => 'PCL-' . strtoupper(Str::random(6)),
            'table_id' => $table->id,
            'customer_name' => $request->customer_name,
            'customer_whatsapp' => $request->customer_whatsapp,
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
            'package_name' => $packageNames[$table->category],
            'total_price' => $table->min_order_price,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        return redirect()->route('booking.success', $booking->booking_code);
    }

    public function success($code)
    {
        $booking = Booking::with('table')->where('booking_code', $code)->firstOrFail();
        
        // Link konfirmasi otomatis ke WhatsApp Admin Resto
        $adminWA = '6281234567890'; // Ubah dengan nomor WA admin resto
        $text = "Halo Admin Pecel Resto, saya ingin konfirmasi pembayaran pemesanan meja:\n\n"
              . "Kode Booking: *{$booking->booking_code}*\n"
              . "Nama: {$booking->customer_name}\n"
              . "Meja: {$booking->table->table_number} ({$booking->package_name})\n"
              . "Tanggal: {$booking->booking_date}\n"
              . "Jam: {$booking->booking_time}\n"
              . "Metode Bayar: {$booking->payment_method}\n"
              . "Total: Rp " . number_format($booking->total_price, 0, ',', '.') . "\n\n"
              . "Mohon dikonfirmasi ya kak. Terima kasih!";
        
        $waLink = "https://wa.me/{$adminWA}?text=" . urlencode($text);

        return view('booking-success', compact('booking', 'waLink'));
    }
}