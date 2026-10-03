<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Penjualan Resto</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans">

    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-amber-950 text-white flex flex-col">
            <div class="p-6 font-bold text-xl border-b border-amber-900 flex items-center">
                <i class="fa-solid fa-bowl-food text-amber-400 mr-2"></i> Pecel Admin
            </div>
            <nav class="flex-1 p-4 space-y-2 text-sm">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 bg-amber-800 rounded-lg text-white">
                    <i class="fa-solid fa-chart-line mr-3"></i> Dashboard & Rekap
                </a>
                <a href="{{ route('admin.sales.index') }}" class="flex items-center px-4 py-3 hover:bg-amber-900 rounded-lg text-amber-200">
                    <i class="fa-solid fa-cash-register mr-3"></i> Input Penjualan Harian
                </a>
                <a href="{{ route('home') }}" target="_blank" class="flex items-center px-4 py-3 hover:bg-amber-900 rounded-lg text-amber-200">
                    <i class="fa-solid fa-arrow-up-right-from-square mr-3"></i> Lihat Landing Page
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-8">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Laporan Akumulasi & Penjualan</h1>
                    <p class="text-gray-500 text-sm">Data transaksi resto harian dan akumulasi bulanan</p>
                </div>

                <!-- Filter Bulan & Tahun -->
                <form method="GET" class="flex gap-2">
                    <select name="month" class="border px-3 py-2 rounded-lg bg-white text-sm">
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ sprintf('%02d', $m) }}" {{ $currentMonth == $m ? 'selected' : '' }}>
                                Bulan {{ date('F', mktime(0, 0, 0, $m, 10)) }}
                            </option>
                        @endfor
                    </select>
                    <select name="year" class="border px-3 py-2 rounded-lg bg-white text-sm">
                        <option value="2026" selected>2026</option>
                        <option value="2025">2025</option>
                    </select>
                    <button type="submit" class="bg-amber-800 text-white px-4 py-2 rounded-lg text-sm font-semibold">Filter</button>
                </form>
            </div>

            <!-- Cards Summary Bulanan -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                    <div class="text-xs font-semibold uppercase text-gray-400 mb-1">Total Pendapatan (Bulan Ini)</div>
                    <div class="text-2xl font-black text-emerald-600">Rp {{ number_format($totalRevenueMonth, 0, ',', '.') }}</div>
                    <div class="text-xs text-gray-400 mt-2">Dine-in + Booking Meja</div>
                </div>

                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                    <div class="text-xs font-semibold uppercase text-gray-400 mb-1">Pendapatan Dine-in Harian</div>
                    <div class="text-2xl font-bold text-blue-600">Rp {{ number_format($totalDineInMonth, 0, ',', '.') }}</div>
                    <div class="text-xs text-gray-400 mt-2">Total order kasir reguler</div>
                </div>

                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                    <div class="text-xs font-semibold uppercase text-gray-400 mb-1">Pendapatan Booking Meja</div>
                    <div class="text-2xl font-bold text-purple-600">Rp {{ number_format($totalBookingMonth, 0, ',', '.') }}</div>
                    <div class="text-xs text-gray-400 mt-2">Reservasi meja & Hall VIP</div>
                </div>

                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                    <div class="text-xs font-semibold uppercase text-gray-400 mb-1">Total Porsi Terjual</div>
                    <div class="text-2xl font-bold text-amber-700">{{ number_format($totalPortionsMonth) }} Porsi</div>
                    <div class="text-xs text-gray-400 mt-2">Bulan ini</div>
                </div>
            </div>

            <!-- Tabel Transaksi Reservasi Terbaru -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">5 Pemesanan Meja Terkini</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                            <tr>
                                <th class="p-3">Kode</th>
                                <th class="p-3">Pemesan</th>
                                <th class="p-3">Meja / Paket</th>
                                <th class="p-3">Tanggal & Sesi</th>
                                <th class="p-3">Nominal</th>
                                <th class="p-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($recentBookings as $b)
                            <tr>
                                <td class="p-3 font-mono font-bold">{{ $b->booking_code }}</td>
                                <td class="p-3">
                                    {{ $b->customer_name }}
                                    <div class="text-xs text-gray-400">{{ $b->customer_whatsapp }}</div>
                                </td>
                                <td class="p-3">{{ $b->table->table_number }} ({{ $b->package_name }})</td>
                                <td class="p-3">{{ $b->booking_date }} | {{ $b->booking_time }}</td>
                                <td class="p-3 font-semibold">Rp {{ number_format($b->total_price, 0, ',', '.') }}</td>
                                <td class="p-3">
                                    <span class="px-2 py-1 text-xs rounded-full {{ $b->status === 'confirmed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                        {{ ucfirst($b->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="p-4 text-center text-gray-400">Belum ada data booking.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

</body>
</html>