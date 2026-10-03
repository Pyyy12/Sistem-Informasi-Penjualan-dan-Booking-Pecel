<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pecel Nusantara Resto - Reservasi Meja & Hall VIP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .seat-duo { border-color: #3b82f6; }
        .seat-quad { border-color: #10b981; }
        .seat-group { border-color: #f59e0b; }
        .seat-vip { border-color: #8b5cf6; }
        .seat-disabled { background-color: #e5e7eb; cursor: not-allowed; opacity: 0.6; }
    </style>
</head>
<body class="bg-amber-50 font-sans text-gray-800">

    <!-- Topbar & Kontak WA -->
    <header class="bg-amber-900 text-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <i class="fa-solid fa-bowl-rice text-2xl text-amber-400"></i>
                <span class="text-xl font-bold tracking-wide">Pecel Nusantara Resto</span>
            </div>
            <div class="flex items-center space-x-4">
                <a href="https://wa.me/6281234567890" target="_blank" class="flex items-center bg-green-500 hover:bg-green-600 px-3 py-1.5 rounded-full text-sm font-semibold transition">
                    <i class="fa-brands fa-whatsapp text-lg mr-2"></i> +62 812-3456-7890
                </a>
                <a href="{{ route('admin.dashboard') }}" class="text-xs bg-amber-800 hover:bg-amber-700 px-2 py-1 rounded text-amber-200">Panel Admin</a>
            </div>
        </div>
    </header>

    <!-- Hero Banner -->
    <section class="bg-gradient-to-r from-amber-800 to-amber-700 text-white py-12 px-4 text-center">
        <h1 class="text-4xl font-extrabold mb-3">Nikmati Kelezatan Sambal Pecel Asli</h1>
        <p class="text-amber-200 text-lg max-w-2xl mx-auto">Pilih denah kursi Anda seperti bioskop. Meja Berdua, Ber-4, Ber-8, hingga Hall Acara VIP 100 orang.</p>
    </section>

    <!-- Flash Message -->
    @if(session('error'))
    <div class="max-w-7xl mx-auto px-4 mt-6">
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
            {{ session('error') }}
        </div>
    </div>
    @endif

    <!-- Main Booking Section -->
    <main class="max-w-7xl mx-auto px-4 py-8">
        <form action="{{ route('booking.store') }}" method="POST" id="bookingForm">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Kolom Kiri & Tengah: Layout Meja -->
                <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-amber-200">
                    <h2 class="text-2xl font-bold text-amber-900 mb-4 flex items-center">
                        <i class="fa-solid fa-chair text-amber-600 mr-2"></i> Denah Tempat Duduk Resto
                    </h2>

                    <!-- Filter Tanggal & Waktu -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 bg-amber-50 p-4 rounded-xl border border-amber-200">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Tanggal Reservasi</label>
                            <input type="date" id="booking_date" name="booking_date" required min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}"
                                class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-amber-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Jam Sesi</label>
                            <select id="booking_time" name="booking_time" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-amber-500">
                                <option value="11:00">11:00 - Makan Siang 1</option>
                                <option value="13:00">13:00 - Makan Siang 2</option>
                                <option value="17:00">17:00 - Makan Malam 1</option>
                                <option value="19:00">19:00 - Makan Malam 2</option>
                            </select>
                        </div>
                    </div>

                    <!-- Legenda Kursi -->
                    <div class="flex flex-wrap gap-4 text-xs font-semibold mb-6 pb-4 border-b border-gray-100">
                        <div class="flex items-center"><span class="w-4 h-4 bg-blue-50 border-2 border-blue-500 rounded mr-1"></span> Berdua (2 Org)</div>
                        <div class="flex items-center"><span class="w-4 h-4 bg-emerald-50 border-2 border-emerald-500 rounded mr-1"></span> Ber-4 (4 Org)</div>
                        <div class="flex items-center"><span class="w-4 h-4 bg-amber-50 border-2 border-amber-500 rounded mr-1"></span> Ber-8 (8 Org)</div>
                        <div class="flex items-center"><span class="w-4 h-4 bg-purple-50 border-2 border-purple-500 rounded mr-1"></span> Hall VIP (100 Org)</div>
                        <div class="flex items-center"><span class="w-4 h-4 bg-gray-200 border-2 border-gray-400 rounded mr-1"></span> Terisi / Booked</div>
                    </div>

                    <!-- Denah Grid -->
                    <div class="space-y-6">
                        <!-- Meja Berdua -->
                        <div>
                            <span class="text-xs uppercase tracking-wider font-bold text-blue-700">Area Romantis / Meja Berdua (Rp 50.000)</span>
                            <div class="grid grid-cols-3 sm:grid-cols-6 gap-3 mt-2">
                                @foreach($tables->where('category', 'duo') as $tbl)
                                    <button type="button" onclick="selectSeat('{{ $tbl->id }}', '{{ $tbl->table_number }}', 50000, 'Paket Berdua')"
                                        id="seat-btn-{{ $tbl->id }}"
                                        class="seat-btn border-2 seat-duo p-3 rounded-lg text-center hover:bg-blue-100 transition focus:outline-none">
                                        <i class="fa-solid fa-user-group text-blue-500 mb-1"></i>
                                        <div class="font-bold text-sm">{{ $tbl->table_number }}</div>
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Meja Berempat -->
                        <div>
                            <span class="text-xs uppercase tracking-wider font-bold text-emerald-700">Area Keluarga Kecil / Meja Ber-4 (Rp 100.000)</span>
                            <div class="grid grid-cols-3 sm:grid-cols-6 gap-3 mt-2">
                                @foreach($tables->where('category', 'quad') as $tbl)
                                    <button type="button" onclick="selectSeat('{{ $tbl->id }}', '{{ $tbl->table_number }}', 100000, 'Paket Ber-4')"
                                        id="seat-btn-{{ $tbl->id }}"
                                        class="seat-btn border-2 seat-quad p-3 rounded-lg text-center hover:bg-emerald-100 transition focus:outline-none">
                                        <i class="fa-solid fa-users text-emerald-500 mb-1"></i>
                                        <div class="font-bold text-sm">{{ $tbl->table_number }}</div>
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Meja Berdelapan -->
                        <div>
                            <span class="text-xs uppercase tracking-wider font-bold text-amber-700">Area Rombongan / Meja Ber-8 (Rp 200.000)</span>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-2">
                                @foreach($tables->where('category', 'group8') as $tbl)
                                    <button type="button" onclick="selectSeat('{{ $tbl->id }}', '{{ $tbl->table_number }}', 200000, 'Paket Ber-8')"
                                        id="seat-btn-{{ $tbl->id }}"
                                        class="seat-btn border-2 seat-group p-4 rounded-lg text-center hover:bg-amber-100 transition focus:outline-none">
                                        <i class="fa-solid fa-people-group text-amber-500 text-lg mb-1"></i>
                                        <div class="font-bold text-sm">{{ $tbl->table_number }}</div>
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Hall VIP -->
                        <div>
                            <span class="text-xs uppercase tracking-wider font-bold text-purple-700">Grand Hall VIP (Kapasitas 100 Orang - Rp 2.500.000)</span>
                            @foreach($tables->where('category', 'vip') as $tbl)
                                <button type="button" onclick="selectSeat('{{ $tbl->id }}', '{{ $tbl->table_number }}', 2500000, 'Hall VIP (100 Orang)')"
                                    id="seat-btn-{{ $tbl->id }}"
                                    class="seat-btn w-full mt-2 border-2 seat-vip bg-purple-50 p-6 rounded-xl text-center hover:bg-purple-100 transition focus:outline-none">
                                    <i class="fa-solid fa-crown text-purple-600 text-2xl mb-1"></i>
                                    <div class="font-bold text-lg text-purple-900">{{ $tbl->table_number }}</div>
                                    <div class="text-xs text-purple-600">Cocok untuk Reuni, Pernikahan, atau Gathering Akbar</div>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Rincian Pemesanan & Form Data Diri -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-amber-200 h-fit sticky top-20">
                    <h3 class="text-xl font-bold text-amber-900 mb-4 pb-2 border-b">Konfirmasi Reservasi</h3>
                    
                    <input type="hidden" name="table_id" id="selected_table_id" required>

                    <div class="bg-amber-50 rounded-xl p-4 mb-4 border border-amber-200">
                        <div class="text-xs text-gray-500">Meja Dipilih:</div>
                        <div id="display_seat" class="font-bold text-lg text-amber-900">Belum memilih meja</div>
                        <div id="display_price" class="text-sm font-semibold text-emerald-600 mt-1">Rp 0</div>
                    </div>

                    <div class="space-y-4 text-sm">
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Nama Pemesan</label>
                            <input type="text" name="customer_name" required placeholder="Contoh: Budi Santoso"
                                class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-amber-500">
                        </div>
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Nomor WhatsApp Aktif</label>
                            <input type="tel" name="customer_whatsapp" required placeholder="08xxxxxxxxxx"
                                class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-amber-500">
                        </div>
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Pilih Metode Pembayaran</label>
                            <select name="payment_method" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-amber-500">
                                <option value="qris">QRIS (BCA, Gopay, OVO, ShopeePay)</option>
                                <option value="transfer_bca">Transfer Bank BCA</option>
                                <option value="transfer_mandiri">Transfer Bank Mandiri</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Catatan Tambahan (Opsional)</label>
                            <textarea name="notes" rows="2" placeholder="Contoh: Request sambal pedas sedang" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-amber-500"></textarea>
                        </div>
                    </div>

                    <button type="submit" id="btn-submit" disabled
                        class="w-full mt-6 bg-gray-400 text-white font-bold py-3 rounded-xl transition duration-200 shadow cursor-not-allowed">
                        Selesaikan Booking
                    </button>
                </div>

            </div>
        </form>
    </main>

    <script>
        function selectSeat(id, number, price, label) {
            document.getElementById('selected_table_id').value = id;
            document.getElementById('display_seat').innerText = number + ' (' + label + ')';
            document.getElementById('display_price').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(price);
            
            // Highlight seat
            document.querySelectorAll('.seat-btn').forEach(btn => btn.classList.remove('ring-4', 'ring-amber-500'));
            const activeBtn = document.getElementById('seat-btn-' + id);
            if (activeBtn) activeBtn.classList.add('ring-4', 'ring-amber-500');

            const submitBtn = document.getElementById('btn-submit');
            submitBtn.disabled = false;
            submitBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
            submitBtn.classList.add('bg-amber-600', 'hover:bg-amber-700', 'cursor-pointer');
        }

        // Live check ketersediaan meja via AJAX
        async function fetchAvailability() {
            const date = document.getElementById('booking_date').value;
            const time = document.getElementById('booking_time').value;

            try {
                const response = await fetch("{{ route('booking.check') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ date: date, time: time })
                });

                const data = await response.json();
                
                // Reset styling
                document.querySelectorAll('.seat-btn').forEach(btn => {
                    btn.disabled = false;
                    btn.classList.remove('seat-disabled');
                });

                // Disable seat yang sudah terisi
                data.booked_table_ids.forEach(id => {
                    const btn = document.getElementById('seat-btn-' + id);
                    if (btn) {
                        btn.disabled = true;
                        btn.classList.add('seat-disabled');
                    }
                });
            } catch (err) {
                console.error(err);
            }
        }

        document.getElementById('booking_date').addEventListener('change', fetchAvailability);
        document.getElementById('booking_time').addEventListener('change', fetchAvailability);
        window.addEventListener('load', fetchAvailability);
    </script>
</body>
</html>