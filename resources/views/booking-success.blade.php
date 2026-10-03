<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Sukses - Pecel Nusantara Resto</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-amber-50 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl overflow-hidden border border-amber-200">
        <div class="bg-amber-800 text-white p-6 text-center">
            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3">
                <i class="fa-solid fa-check text-3xl text-amber-300"></i>
            </div>
            <h1 class="text-2xl font-bold">Booking Terdaftar!</h1>
            <p class="text-xs text-amber-200 mt-1">Selesaikan instruksi pembayaran di bawah ini</p>
        </div>

        <div class="p-6 space-y-4">
            <div class="bg-amber-50 p-4 rounded-xl text-center border border-amber-200">
                <span class="text-xs text-gray-500 uppercase tracking-widest">Kode Reservasi Anda</span>
                <div class="text-2xl font-black text-amber-900 tracking-wider mt-1">{{ $booking->booking_code }}</div>
            </div>

            <div class="text-sm divide-y divide-gray-100">
                <div class="py-2 flex justify-between">
                    <span class="text-gray-500">Meja / Area:</span>
                    <span class="font-semibold">{{ $booking->table->table_number }} ({{ $booking->package_name }})</span>
                </div>
                <div class="py-2 flex justify-between">
                    <span class="text-gray-500">Waktu Kedatangan:</span>
                    <span class="font-semibold">{{ $booking->booking_date }} | {{ $booking->booking_time }}</span>
                </div>
                <div class="py-2 flex justify-between">
                    <span class="text-gray-500">Metode Bayar:</span>
                    <span class="font-semibold uppercase">{{ str_replace('_', ' ', $booking->payment_method) }}</span>
                </div>
                <div class="py-2 flex justify-between items-center">
                    <span class="text-gray-500">Total Nominal:</span>
                    <span class="font-bold text-lg text-emerald-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Detail Instruksi Rekening -->
            <div class="bg-gray-50 p-3 rounded-lg text-xs text-gray-600">
                @if($booking->payment_method === 'transfer_bca')
                    Transfer ke BCA: <strong>8910293847</strong> a/n Pecel Resto PT
                @elseif($booking->payment_method === 'transfer_mandiri')
                    Transfer ke Mandiri: <strong>137001928374</strong> a/n Pecel Resto PT
                @else
                    Scan QRIS yang disediakan kasir atau kirim bukti via WhatsApp
                @endif
            </div>

            <!-- Tombol Konfirmasi WA -->
            <a href="{{ $waLink }}" target="_blank"
                class="w-full block text-center bg-green-500 hover:bg-green-600 text-white font-bold py-3.5 px-4 rounded-xl shadow transition">
                <i class="fa-brands fa-whatsapp text-lg mr-2"></i> Konfirmasi Pembayaran via WhatsApp
            </a>

            <a href="{{ route('home') }}" class="block text-center text-xs text-amber-800 hover:underline">
                &larr; Kembali ke Halaman Utama
            </a>
        </div>
    </div>

</body>
</html>