<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Penjualan Harian - Admin Pecel Resto</title>
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
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 hover:bg-amber-900 rounded-lg text-amber-200">
                    <i class="fa-solid fa-chart-line mr-3"></i> Dashboard & Rekap
                </a>
                <a href="{{ route('admin.sales.index') }}" class="flex items-center px-4 py-3 bg-amber-800 rounded-lg text-white">
                    <i class="fa-solid fa-cash-register mr-3"></i> Input Penjualan Harian
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Pencatatan Penjualan Harian</h1>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Form Input -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Input Data Hari Ini</h2>
                    <form action="{{ route('admin.sales.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                            <input type="date" name="sale_date" value="{{ date('Y-m-d') }}" required class="w-full px-3 py-2 border rounded-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Total Porsi Terjual</label>
                            <input type="number" name="total_portions_sold" min="0" placeholder="Contoh: 150" required class="w-full px-3 py-2 border rounded-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Omzet Dine-in / Kasir (Rp)</label>
                            <input type="number" name="dine_in_revenue" min="0" placeholder="Contoh: 3500000" required class="w-full px-3 py-2 border rounded-lg">
                            <span class="text-xs text-gray-400">Omzet reservasi meja akan diakumulasikan otomatis oleh sistem.</span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Tambahan</label>
                            <textarea name="notes" rows="2" class="w-full px-3 py-2 border rounded-lg"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-amber-800 hover:bg-amber-900 text-white font-bold py-2.5 rounded-lg shadow transition">
                            Simpan Rekap Harian
                        </button>
                    </form>
                </div>

                <!-- Histori Penjualan Harian -->
                <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Histori Penjualan Harian</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                                <tr>
                                    <th class="p-3">Tanggal</th>
                                    <th class="p-3">Porsi</th>
                                    <th class="p-3">Dine-in</th>
                                    <th class="p-3">Booking</th>
                                    <th class="p-3">Total Omzet</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($sales as $sale)
                                <tr>
                                    <td class="p-3 font-semibold">{{ $sale->sale_date->format('d M Y') }}</td>
                                    <td class="p-3">{{ $sale->total_portions_sold }}</td>
                                    <td class="p-3">Rp {{ number_format($sale->dine_in_revenue, 0, ',', '.') }}</td>
                                    <td class="p-3">Rp {{ number_format($sale->booking_revenue, 0, ',', '.') }}</td>
                                    <td class="p-3 font-bold text-emerald-600">Rp {{ number_format($sale->total_revenue, 0, ',', '.') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="p-4 text-center text-gray-400">Belum ada catatan penjualan harian.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $sales->links() }}
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>
</html>