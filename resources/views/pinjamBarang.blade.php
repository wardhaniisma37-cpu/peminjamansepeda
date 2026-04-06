<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Transaksi · Lentora | Kasir</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/img/Avatar.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * { font-family: 'Inter', 'Plus Jakarta Sans', system-ui, sans-serif; }
        :root {
            --soft-blue-50: #eff6ff; --soft-blue-100: #dbeafe; --soft-blue-200: #bfdbfe;
            --soft-blue-300: #93c5fd; --soft-blue-400: #60a5fa; --soft-blue-500: #3b82f6;
            --soft-blue-600: #2563eb; --soft-blue-700: #1d4ed8; --pure-white: #ffffff;
            --off-white: #f8fafc; --medium-gray: #64748b; --dark-gray: #1e293b;
            --shadow-sm: 0 2px 6px rgba(59, 130, 246, 0.06);
            --shadow-md: 0 6px 14px rgba(59, 130, 246, 0.1);
            --gradient-soft: linear-gradient(135deg, #3b82f6, #2563eb);
        }
        body { background: #f6faff; color: var(--dark-gray); font-size: 0.9rem; }
        .sidebar { background: linear-gradient(180deg, #ffffff 0%, #f5faff 100%); border-right: 1px solid rgba(59, 130, 246, 0.2); width: 260px; transition: all 0.2s ease; }
        .sidebar-item { transition: all 0.2s ease; border-radius: 14px; margin: 3px 0; padding: 0.6rem 1rem; font-size: 0.85rem; }
        .sidebar-item.active { background: var(--gradient-soft); color: white; box-shadow: 0 4px 10px rgba(37, 99, 235, 0.2); }
        .page-header { background: linear-gradient(115deg, var(--soft-blue-600), var(--soft-blue-500)); border-radius: 28px; padding: 1.2rem 1.8rem !important; margin-bottom: 1.5rem; box-shadow: var(--shadow-md); }
        .page-header h1 { font-size: 1.7rem; letter-spacing: -0.3px; }
        .card { background: var(--pure-white); border: 1px solid var(--soft-blue-100); border-radius: 24px; box-shadow: var(--shadow-sm); transition: all 0.2s; padding: 1.2rem 1.5rem; }
        .card:hover { box-shadow: var(--shadow-md); transform: translateY(-1px); }
        .stat-card { padding: 1rem 1.2rem; }
        .stat-card h3 { font-size: 1.8rem; margin-top: 0.25rem; }
        .table-container { border-radius: 24px; overflow-x: auto; }
        .table-header th { padding: 0.9rem 1rem; font-size: 0.7rem; letter-spacing: 0.03em; }
        .table-row td { padding: 0.75rem 1rem; font-size: 0.85rem; }
        .status-badge { padding: 0.2rem 0.7rem; font-size: 0.7rem; font-weight: 600; border-radius: 30px; gap: 4px; display: inline-flex; align-items: center; }
        .btn-primary { background: var(--gradient-soft); padding: 0.5rem 1.1rem; font-size: 0.8rem; border-radius: 40px; gap: 6px; border: none; cursor: pointer; display: inline-flex; align-items: center; color: white; text-decoration: none; }
        .btn-primary:hover { opacity: 0.9; }
        .btn-outline { padding: 0.45rem 1.1rem; font-size: 0.8rem; border-radius: 40px; background: transparent; border: 1px solid var(--soft-blue-300); cursor: pointer; display: inline-flex; align-items: center; text-decoration: none; color: var(--dark-gray); }
        .btn-outline:hover { background: var(--soft-blue-50); }
        .form-label { font-size: 0.75rem; margin-bottom: 0.25rem; font-weight: 600; display: block; }
        .form-input, .form-select { padding: 0.55rem 1rem; font-size: 0.85rem; border-radius: 18px; width: 100%; border: 1px solid var(--soft-blue-200); background: white; }
        .form-input:focus, .form-select:focus { outline: none; border-color: var(--soft-blue-500); box-shadow: 0 0 0 2px rgba(59,130,246,0.1); }
        .alert { position: fixed; top: 20px; right: 20px; max-width: 360px; padding: 0.8rem 1.2rem; z-index: 9999; background: white; border-radius: 20px; box-shadow: var(--shadow-md); border-left: 4px solid var(--soft-blue-500); animation: slideIn 0.2s ease; }
        .condition-card, .payment-card { cursor: pointer; transition: all 0.3s; border: 2px solid transparent; }
        .condition-card:hover, .payment-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-md); }
        .condition-card.selected, .payment-card.selected { border-color: var(--soft-blue-500); background-color: var(--soft-blue-50); }
        .gradient-text { background: linear-gradient(135deg, var(--soft-blue-700), var(--soft-blue-500)); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; }
        .search-filter { transition: all 0.2s ease; }
        .search-filter:focus { border-color: var(--soft-blue-500); box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
        @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        @keyframes fadeOut { to { opacity: 0; visibility: hidden; } }
        @media (max-width: 768px) { .sm\:ml-64 { margin-left: 0; } .card { padding: 1rem; } .page-header { padding: 1rem 1.2rem !important; } }
    </style>
</head>
<body class="bg-[#f6faff]">

    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-blue-600 rounded-lg sm:hidden hover:bg-blue-100 bg-white shadow">
        <i class="fas fa-bars text-xl"></i>
    </button>

    <!-- Sidebar -->
    <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 h-screen transition-transform sidebar -translate-x-full sm:translate-x-0" aria-label="Sidebar">
        <div class="h-full flex flex-col px-3 py-5 overflow-y-auto">
            <a href="{{ route('dashboard') }}" class="flex items-center ps-2 mb-7">
                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mr-2 shadow">
                    <i class="fas fa-bicycle text-white text-sm"></i>
                </div>
                <span class="sidebar-logo text-xl font-extrabold text-blue-700">E-Bike</span>
            </a>
            @php $userRole = auth()->user()->role ?? 'user'; @endphp
            <div class="mb-4 px-2"><p class="text-[0.65rem] font-bold text-blue-400 uppercase tracking-wider">Menu Utama</p></div>
            <ul class="space-y-0.5">
                <li><a href="{{ route('dashboard') }}" class="sidebar-item flex items-center text-gray-700 hover:text-blue-700"><i class="fas fa-home w-5 text-blue-500"></i><span class="ms-2">Dashboard</span></a></li>
                @if($userRole === 'admin' || $userRole === 'petugas')
                <li><a href="{{ route('items') }}" class="sidebar-item flex items-center text-gray-700 hover:text-blue-700"><i class="fas fa-box w-5 text-blue-500"></i><span class="ms-2">Inventaris</span></a></li>
                @endif
                <li><a href="{{ route('pinjamBarang') }}" class="sidebar-item flex items-center text-gray-700 hover:text-blue-700 active"><i class="fas fa-hand-holding-heart w-5 text-blue-500"></i><span class="ms-2">Peminjaman</span></a></li>
                @if($userRole === 'admin')
                <li><a href="{{ route('users') }}" class="sidebar-item flex items-center text-gray-700 hover:text-blue-700"><i class="fas fa-users w-5 text-blue-500"></i><span class="ms-2">Kelola User</span></a></li>
                @endif
                <li><a href="{{ route('logs') }}" class="sidebar-item flex items-center text-gray-700 hover:text-blue-700"><i class="fas fa-history w-5 text-blue-500"></i><span class="ms-2">Log Aktivitas</span></a></li>
            </ul>
            @if($userRole === 'admin' || $userRole === 'petugas')
            <div class="mt-6 mb-2 px-2"><p class="text-[0.65rem] font-bold text-blue-400 uppercase tracking-wider">Administration</p></div>
            <ul class="space-y-0.5">
                <li><a href="#" class="sidebar-item flex items-center text-gray-700"><i class="fas fa-cog w-5 text-blue-500"></i><span class="ms-2">Pengaturan</span></a></li>
                <li><a href="#" class="sidebar-item flex items-center text-gray-700"><i class="fas fa-chart-line w-5 text-blue-500"></i><span class="ms-2">Laporan</span></a></li>
            </ul>
            @endif
            <div class="mt-auto pt-5">
                <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="sidebar-item flex items-center w-full text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-xl"><i class="fas fa-sign-out-alt w-5 text-red-400"></i><span class="ms-2 text-sm">Logout</span></button></form>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="sm:ml-64 p-5 lg:p-6">
        <div class="page-header">
            <div class="relative z-10">
                <div class="flex items-center gap-1 text-blue-100 text-xs mb-1"><i class="fas fa-home text-[10px]"></i><span>Pages / Transaksi</span></div>
                <h1 class="text-white font-bold text-2xl tracking-tight">Transaksi Peminjaman & Pengembalian</h1>
                <p class="text-blue-100 text-sm mt-0.5">Proses peminjaman dan pengembalian barang dengan denda</p>
            </div>
        </div>

        <!-- Stats cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-6">
            <div class="card stat-card"><div><p class="text-blue-500 text-xs">Total Peminjaman</p><h3 class="text-2xl font-bold gradient-text">{{ $loans->count() }}</h3></div></div>
            <div class="card stat-card"><div><p class="text-blue-500 text-xs">Sedang Dipinjam</p><h3 class="text-2xl font-bold gradient-text">{{ $loans->where('status', 'borrowed')->count() }}</h3></div></div>
            <div class="card stat-card"><div><p class="text-blue-500 text-xs">Dikembalikan</p><h3 class="text-2xl font-bold gradient-text">{{ $loans->where('status', 'returned')->count() }}</h3></div></div>
            <div class="card stat-card"><div><p class="text-blue-500 text-xs">Total Denda</p><h3 class="text-2xl font-bold gradient-text">Rp {{ number_format($loans->sum('penalty_amount'), 0, ',', '.') }}</h3></div></div>
        </div>

        <!-- Tabel Peminjaman -->
        <div class="card !p-0 mb-7 overflow-hidden">
            <div class="flex justify-between items-center px-5 pt-4 pb-2 flex-wrap gap-3">
                <h2 class="text-lg font-bold gradient-text">Riwayat Peminjaman</h2>
                @if(in_array($userRole, ['admin', 'petugas']))
                <div class="flex gap-2">
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-xs"></i>
                        <input type="text" id="searchInput" placeholder="Cari peminjam atau barang..." class="pl-9 pr-4 py-2 text-sm border border-blue-200 rounded-xl focus:outline-none focus:border-blue-500 w-64">
                    </div>
                    <select id="statusFilter" class="px-3 py-2 text-sm border border-blue-200 rounded-xl focus:outline-none focus:border-blue-500">
                        <option value="all">Semua Status</option>
                        <option value="borrowed">Dipinjam</option>
                        <option value="returned">Dikembalikan</option>
                    </select>
                </div>
                @endif
            </div>
            <div class="table-container">
                <table class="w-full text-sm" id="loanTable">
                    <thead class="bg-blue-50">
                        <tr>
                            <th class="px-4 py-3">No</th>
                            <th>Barang</th>
                            <th>Jml</th>
                            <th>Peminjam</th>
                            @if(in_array($userRole, ['admin', 'petugas']))
                            <th>Petugas</th>
                            @endif
                            <th>Status</th>
                            <th>Tgl Pinjam</th>
                            <th>Tgl Kembali</th>
                            <th>Denda</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($loans as $loan)
                        <tr class="border-b hover:bg-blue-50/50" data-status="{{ $loan->status }}" data-borrower="{{ strtolower($loan->user?->name ?? '') }}" data-item="{{ strtolower($loan->item?->name ?? '') }}">
                            <td class="px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2">{{ $loan->item?->name ?? 'Item tidak ditemukan' }}</td>
                            <td class="px-4 py-2">{{ $loan->amount }}</td>
                            <td class="px-4 py-2 font-medium">{{ $loan->user?->name ?? 'User tidak ditemukan' }}</td>
                            @if(in_array($userRole, ['admin', 'petugas']))
                            <td class="px-4 py-2">
                                @if($loan->processed_by)
                                    <span class="text-xs text-gray-600">{{ $loan->processor?->name ?? '-' }}</span>
                                @else
                                    <span class="text-xs text-gray-400">-</span>
                                @endif
                            </td>
                            @endif
                            <td class="px-4 py-2">
                                @if($loan->status == 'returned') 
                                    <span class="status-badge bg-green-100 text-green-800"><i class="fas fa-check-circle"></i> Dikembalikan</span>
                                @else
                                    <span class="status-badge bg-amber-100 text-amber-800"><i class="fas fa-clock"></i> Dipinjam</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($loan->borrow_date)->format('d/m/Y') }}</td>
                            <td class="px-4 py-2">{{ $loan->return_date ? \Carbon\Carbon::parse($loan->return_date)->format('d/m/Y') : '-' }}</td>
                            <td class="px-4 py-2">@if($loan->penalty_amount > 0) Rp {{ number_format($loan->penalty_amount, 0, ',', '.') }} @else - @endif</td>
                            <td class="px-4 py-2">
                                @if ($loan->status !== 'returned')
                                    @if(in_array($userRole, ['admin', 'petugas']))
                                        <button data-modal-target="return-modal-{{ $loan->id }}" data-modal-toggle="return-modal-{{ $loan->id }}" class="btn-primary text-xs py-1.5 px-3" type="button">
                                            <i class="fas fa-undo-alt"></i> Kembalikan
                                        </button>
                                    @else
                                        <span class="text-xs text-gray-400 italic">Menunggu petugas</span>
                                    @endif
                                @else
                                    <a href="{{ route('loans.struk', $loan->id) }}" class="btn-outline text-xs py-1.5 px-3">
                                        <i class="fas fa-print"></i> Cetak Struk
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ in_array($userRole, ['admin', 'petugas']) ? '10' : '9' }}" class="text-center py-8 text-gray-400">
                                <i class="fas fa-inbox text-3xl mb-2 block"></i>Belum ada data peminjaman
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Form Peminjaman Baru -->
        <div class="card">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-9 h-9 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-plus-circle text-blue-500 text-lg"></i>
                </div>
                <h2 class="text-xl font-bold gradient-text">Tambah Peminjaman Baru</h2>
            </div>
            <form action="{{ route('items.borrow') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                    <div>
                        <label class="form-label">Nama Barang</label>
                        <select name="item_id" class="form-select" required>
                            <option value="" disabled selected>Pilih Barang</option>
                            @foreach ($items as $item)
                            <option value="{{ $item->id }}">{{ $item->name }} (Stok: {{ $item->stock }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Jumlah</label>
                        <input type="number" name="amount" class="form-input" placeholder="Jumlah" required min="1">
                    </div>
                    
                    @if(in_array($userRole, ['admin', 'petugas']) && isset($allUsers) && $allUsers->count() > 0)
                    <div>
                        <label class="form-label">Peminjam (Pilih User)</label>
                        <select name="user_id" class="form-select" required>
                            <option value="" disabled selected>Pilih Peminjam</option>
                            @foreach($allUsers as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->role }})</option>
                            @endforeach
                        </select>
                    </div>
                    @elseif(in_array($userRole, ['admin', 'petugas']) && (!isset($allUsers) || $allUsers->count() == 0))
                    <div>
                        <label class="form-label">Peminjam (Pilih User)</label>
                        <select name="user_id" class="form-select" required>
                            <option value="" disabled selected>Tidak ada user tersedia</option>
                        </select>
                    </div>
                    @else
                    <div>
                        <label class="form-label">Peminjam</label>
                        <input type="text" class="form-input" value="{{ Auth::user()->name }}" readonly>
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    </div>
                    @endif
                    
                    <div>
                        <label class="form-label">Tanggal Pinjam</label>
                        <input type="date" name="borrow_date" class="form-input" value="{{ now()->format('Y-m-d') }}" readonly>
                    </div>
                    <div class="lg:col-span-2">
                        <label class="form-label">Keterangan</label>
                        <input type="text" name="description" class="form-input" placeholder="Keperluan / keterangan">
                    </div>
                </div>
                <div class="flex justify-end mt-6">
                    <button type="submit" class="btn-primary px-6 py-2">
                        <i class="fas fa-paper-plane mr-1"></i> Submit Peminjaman
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL PENGEMBALIAN -->
    @foreach ($loans as $loan)
        @if($loan->status !== 'returned')
        <div id="return-modal-{{ $loan->id }}" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <div class="relative bg-white rounded-2xl shadow-xl border border-blue-100">
                    <div class="flex items-center justify-between p-5 border-b rounded-t bg-gradient-to-r from-blue-600 to-blue-500">
                        <h3 class="text-xl font-semibold text-white flex items-center gap-2">
                            <i class="fas fa-undo-alt"></i> Form Pengembalian Barang
                        </h3>
                        <button type="button" class="text-white/80 hover:text-white hover:bg-white/20 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center" data-modal-hide="return-modal-{{ $loan->id }}">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    
                    <form action="{{ route('loans.processReturn', $loan->id) }}" method="POST" enctype="multipart/form-data" id="return-form-{{ $loan->id }}">
                        @csrf
                        <div class="p-6 space-y-4">
                            <!-- Info Peminjaman -->
                            <div class="bg-blue-50 rounded-xl p-4">
                                <div class="grid grid-cols-2 gap-3 text-sm">
                                    <div><span class="text-gray-500">Barang:</span> <span class="font-semibold">{{ $loan->item->name ?? 'N/A' }}</span></div>
                                    <div><span class="text-gray-500">Jumlah:</span> <span class="font-semibold">{{ $loan->amount }} unit</span></div>
                                    <div><span class="text-gray-500">Peminjam:</span> <span class="font-semibold">{{ $loan->user->name ?? 'N/A' }}</span></div>
                                    <div><span class="text-gray-500">Tgl Pinjam:</span> <span class="font-semibold">{{ \Carbon\Carbon::parse($loan->borrow_date)->format('d/m/Y') }}</span></div>
                                </div>
                            </div>

                            <!-- Kondisi Barang -->
                            <div>
                                <label class="form-label text-base font-semibold">Kondisi Barang Saat Dikembalikan</label>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-2">
                                    <div class="condition-card border rounded-xl p-3 text-center cursor-pointer" data-condition="baik" data-penalty="0" data-modal-id="{{ $loan->id }}">
                                        <i class="fas fa-check-circle text-green-500 text-2xl mb-1"></i>
                                        <p class="font-medium text-sm">Baik</p>
                                        <p class="text-xs text-gray-400">Tidak ada denda</p>
                                        <input type="radio" name="condition_return" value="baik" class="condition-radio hidden" required>
                                    </div>
                                    <div class="condition-card border rounded-xl p-3 text-center cursor-pointer" data-condition="rusak_ringan" data-penalty="150000" data-modal-id="{{ $loan->id }}">
                                        <i class="fas fa-tools text-yellow-500 text-2xl mb-1"></i>
                                        <p class="font-medium text-sm">Rusak Ringan</p>
                                        <p class="text-xs text-yellow-600">Denda Rp150.000</p>
                                        <input type="radio" name="condition_return" value="rusak_ringan" class="condition-radio hidden">
                                    </div>
                                    <div class="condition-card border rounded-xl p-3 text-center cursor-pointer" data-condition="rusak_berat" data-penalty="500000" data-modal-id="{{ $loan->id }}">
                                        <i class="fas fa-exclamation-triangle text-orange-500 text-2xl mb-1"></i>
                                        <p class="font-medium text-sm">Rusak Berat</p>
                                        <p class="text-xs text-orange-600">Denda Rp500.000</p>
                                        <input type="radio" name="condition_return" value="rusak_berat" class="condition-radio hidden">
                                    </div>
                                    <div class="condition-card border rounded-xl p-3 text-center cursor-pointer" data-condition="hilang" data-penalty="3350000" data-modal-id="{{ $loan->id }}">
                                        <i class="fas fa-search text-red-500 text-2xl mb-1"></i>
                                        <p class="font-medium text-sm">Hilang</p>
                                        <p class="text-xs text-red-600">Denda Rp3.350.000</p>
                                        <input type="radio" name="condition_return" value="hilang" class="condition-radio hidden">
                                    </div>
                                </div>
                            </div>

                            <!-- Deskripsi Kerusakan -->
                            <div id="damage-section-{{ $loan->id }}" class="hidden">
                                <label class="form-label">Deskripsi Kerusakan</label>
                                <textarea name="damage_description" class="form-input" rows="2" placeholder="Jelaskan kerusakan yang terjadi..."></textarea>
                            </div>

                            <!-- Info Denda -->
                            <div id="penalty-info-{{ $loan->id }}" class="hidden">
                                <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                                    <div class="flex items-center justify-between">
                                        <span class="font-semibold text-red-700"><i class="fas fa-money-bill-wave mr-2"></i>Denda yang Harus Dibayar:</span>
                                        <span id="penalty-amount-display-{{ $loan->id }}" class="text-2xl font-bold text-red-600">Rp 0</span>
                                    </div>
                                    <input type="hidden" name="penalty_amount" id="penalty-input-{{ $loan->id }}" value="0">
                                </div>
                            </div>

                            <!-- Metode Pembayaran -->
                            <div id="payment-section-{{ $loan->id }}" class="hidden">
                                <label class="form-label font-semibold">Metode Pembayaran Denda</label>
                                <div class="grid grid-cols-2 gap-3 mt-2">
                                    <div class="payment-card border rounded-xl p-3 text-center cursor-pointer" data-method="cash" data-modal-id="{{ $loan->id }}">
                                        <i class="fas fa-money-bill-wave text-green-500 text-2xl mb-1"></i>
                                        <p class="font-medium">Tunai (Cash)</p>
                                        <input type="radio" name="payment_method" value="cash" class="payment-radio hidden">
                                    </div>
                                    <div class="payment-card border rounded-xl p-3 text-center cursor-pointer" data-method="transfer" data-modal-id="{{ $loan->id }}">
                                        <i class="fas fa-university text-blue-500 text-2xl mb-1"></i>
                                        <p class="font-medium">Transfer Bank</p>
                                        <input type="radio" name="payment_method" value="transfer" class="payment-radio hidden">
                                    </div>
                                </div>
                            </div>

                            <!-- Upload Bukti Transfer -->
                            <div id="proof-section-{{ $loan->id }}" class="hidden">
                                <label class="form-label">Upload Bukti Transfer</label>
                                <input type="file" name="payment_proof" class="form-input" accept="image/*,application/pdf">
                                <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG, PDF (Max 2MB)</p>
                            </div>

                            <!-- Info Rekening -->
                            <div id="bank-info-{{ $loan->id }}" class="hidden">
                                <div class="bg-blue-50 rounded-xl p-3 text-sm">
                                    <p class="font-semibold">Rekening Tujuan:</p>
                                    <p>🏦 Bank BCA: 1234567890 a.n. E-Bike Rental</p>
                                    <p>🏦 Bank Mandiri: 9876543210 a.n. E-Bike Rental</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 p-6 border-t border-blue-100">
                            <button type="button" data-modal-hide="return-modal-{{ $loan->id }}" class="btn-outline">
                                <i class="fas fa-times mr-1"></i> Batal
                            </button>
                            <button type="submit" class="btn-primary" id="submit-btn-{{ $loan->id }}">
                                <i class="fas fa-check mr-1"></i> Proses Pengembalian
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
    @endforeach

    @if (session('success'))
    <div class="alert">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                <i class="fas fa-check text-green-500 text-sm"></i>
            </div>
            <div>
                <p class="font-semibold text-sm">Berhasil!</p>
                <p class="text-xs text-gray-600">{{ session('success') }}</p>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-gray-400">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    @endif

    @if (session('error'))
    <div class="alert border-l-4 border-red-500">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                <i class="fas fa-exclamation text-red-500 text-sm"></i>
            </div>
            <div>
                <p class="font-semibold text-sm">Error!</p>
                <p class="text-xs text-gray-600">{{ session('error') }}</p>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-gray-400">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script>
        // Constants for penalties
        const PENALTY_RINGAN = 150000;
        const PENALTY_BERAT = 500000;
        const PENALTY_HILANG = 3350000;

        // Function to initialize event listeners for a specific modal
        function initModalListeners(modalId) {
            const modal = document.getElementById(modalId);
            if (!modal) return;

            // Get modal suffix ID
            const modalSuffix = modalId.split('-').pop();
            
            // Get elements
            const conditionCards = modal.querySelectorAll('.condition-card');
            const damageSection = document.getElementById('damage-section-' + modalSuffix);
            const penaltyInfo = document.getElementById('penalty-info-' + modalSuffix);
            const paymentSection = document.getElementById('payment-section-' + modalSuffix);
            const penaltyAmountSpan = document.getElementById('penalty-amount-display-' + modalSuffix);
            const penaltyInput = document.getElementById('penalty-input-' + modalSuffix);
            const proofSection = document.getElementById('proof-section-' + modalSuffix);
            const bankInfo = document.getElementById('bank-info-' + modalSuffix);

            // Condition card click handlers
            conditionCards.forEach(card => {
                // Remove existing listener to avoid duplicates
                card.removeEventListener('click', card._listener);
                
                card._listener = function(e) {
                    e.preventDefault();
                    
                    // Remove selected class from all condition cards
                    conditionCards.forEach(c => {
                        c.classList.remove('selected', 'border-blue-500', 'bg-blue-50');
                        const radio = c.querySelector('.condition-radio');
                        if (radio) radio.checked = false;
                    });
                    
                    // Add selected class to clicked card
                    this.classList.add('selected', 'border-blue-500', 'bg-blue-50');
                    
                    // Check the radio button
                    const radio = this.querySelector('.condition-radio');
                    if (radio) {
                        radio.checked = true;
                        // Trigger change event
                        const changeEvent = new Event('change', { bubbles: true });
                        radio.dispatchEvent(changeEvent);
                    }
                    
                    const condition = this.dataset.condition;
                    
                    if (condition !== 'baik') {
                        // Show damage section
                        if (damageSection) damageSection.classList.remove('hidden');
                        
                        // Set penalty based on condition
                        let penalty = 0;
                        switch(condition) {
                            case 'rusak_ringan': 
                                penalty = PENALTY_RINGAN; 
                                break;
                            case 'rusak_berat': 
                                penalty = PENALTY_BERAT; 
                                break;
                            case 'hilang': 
                                penalty = PENALTY_HILANG; 
                                break;
                            default: 
                                penalty = 0;
                        }
                        
                        const formattedPenalty = 'Rp ' + new Intl.NumberFormat('id-ID').format(penalty);
                        if (penaltyAmountSpan) penaltyAmountSpan.innerHTML = formattedPenalty;
                        if (penaltyInput) penaltyInput.value = penalty;
                        if (penaltyInfo) penaltyInfo.classList.remove('hidden');
                        if (paymentSection) paymentSection.classList.remove('hidden');
                    } else {
                        // Hide all sections for "baik" condition
                        if (damageSection) damageSection.classList.add('hidden');
                        if (penaltyInfo) penaltyInfo.classList.add('hidden');
                        if (paymentSection) paymentSection.classList.add('hidden');
                        if (proofSection) proofSection.classList.add('hidden');
                        if (bankInfo) bankInfo.classList.add('hidden');
                        if (penaltyInput) penaltyInput.value = 0;
                        
                        // Uncheck payment methods
                        const paymentRadios = modal.querySelectorAll('.payment-radio');
                        paymentRadios.forEach(radio => radio.checked = false);
                        
                        // Remove selected class from payment cards
                        const paymentCards = modal.querySelectorAll('.payment-card');
                        paymentCards.forEach(card => {
                            card.classList.remove('selected', 'border-blue-500', 'bg-blue-50');
                        });
                    }
                };
                
                card.addEventListener('click', card._listener);
            });

            // Payment card click handlers
            const paymentCards = modal.querySelectorAll('.payment-card');
            paymentCards.forEach(card => {
                // Remove existing listener to avoid duplicates
                card.removeEventListener('click', card._paymentListener);
                
                card._paymentListener = function(e) {
                    e.preventDefault();
                    
                    // Remove selected class from all payment cards
                    paymentCards.forEach(c => {
                        c.classList.remove('selected', 'border-blue-500', 'bg-blue-50');
                        const radio = c.querySelector('.payment-radio');
                        if (radio) radio.checked = false;
                    });
                    
                    // Add selected class to clicked card
                    this.classList.add('selected', 'border-blue-500', 'bg-blue-50');
                    
                    // Check the radio button
                    const radio = this.querySelector('.payment-radio');
                    if (radio) {
                        radio.checked = true;
                        const changeEvent = new Event('change', { bubbles: true });
                        radio.dispatchEvent(changeEvent);
                    }
                    
                    // Show/hide proof and bank info based on payment method
                    if (this.dataset.method === 'transfer') {
                        if (proofSection) proofSection.classList.remove('hidden');
                        if (bankInfo) bankInfo.classList.remove('hidden');
                    } else {
                        if (proofSection) proofSection.classList.add('hidden');
                        if (bankInfo) bankInfo.classList.add('hidden');
                    }
                };
                
                card.addEventListener('click', card._paymentListener);
            });
        }

        // Initialize all modals when page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize all existing modals
            @foreach ($loans as $loan)
                @if($loan->status !== 'returned')
                    initModalListeners('return-modal-{{ $loan->id }}');
                @endif
            @endforeach
            
            // Observe for dynamically shown modals (when Flowbite shows them)
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                        const modal = mutation.target;
                        // Check if modal is becoming visible (not hidden)
                        if (!modal.classList.contains('hidden') && modal.classList.contains('flex')) {
                            const modalId = modal.id;
                            if (modalId && modalId.startsWith('return-modal-')) {
                                // Re-initialize to ensure event listeners are attached
                                initModalListeners(modalId);
                            }
                        }
                    }
                });
            });
            
            // Observe all modals
            document.querySelectorAll('[id^="return-modal-"]').forEach(modal => {
                observer.observe(modal, { attributes: true });
            });

            // Search and filter functionality for admin/petugas
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter');
            
            if (searchInput && statusFilter) {
                function filterTable() {
                    const searchTerm = searchInput.value.toLowerCase();
                    const statusValue = statusFilter.value;
                    const rows = document.querySelectorAll('#loanTable tbody tr:not(.empty-row)');
                    
                    rows.forEach(row => {
                        const borrower = row.dataset.borrower || '';
                        const item = row.dataset.item || '';
                        const status = row.dataset.status || '';
                        
                        const matchesSearch = searchTerm === '' || borrower.includes(searchTerm) || item.includes(searchTerm);
                        const matchesStatus = statusValue === 'all' || status === statusValue;
                        
                        if (matchesSearch && matchesStatus) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                }
                
                searchInput.addEventListener('keyup', filterTable);
                statusFilter.addEventListener('change', filterTable);
            }
            
            // Auto hide alerts
            setTimeout(() => {
                document.querySelectorAll('.alert').forEach(alert => {
                    alert.style.animation = 'fadeOut 0.2s forwards';
                    setTimeout(() => {
                        if (alert && alert.remove) alert.remove();
                    }, 200);
                });
            }, 4000);
        });
    </script>
</body>
</html>