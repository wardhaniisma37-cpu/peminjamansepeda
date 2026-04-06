<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Aktivitas · Lentora</title>
    
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: #f6faff; }
        .sidebar { background: linear-gradient(180deg, #ffffff 0%, #f5faff 100%); border-right: 1px solid rgba(59, 130, 246, 0.2); width: 260px; }
        .sidebar-item { transition: all 0.2s ease; border-radius: 14px; margin: 3px 0; padding: 0.6rem 1rem; font-size: 0.85rem; }
        .sidebar-item.active { background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; }
        .page-header { background: linear-gradient(115deg, #2563eb, #3b82f6); border-radius: 28px; padding: 1.2rem 1.8rem; margin-bottom: 1.5rem; }
        .card { background: white; border-radius: 24px; box-shadow: 0 2px 6px rgba(59, 130, 246, 0.06); padding: 1.2rem 1.5rem; }
        .badge-borrow { background: #fef3c7; color: #d97706; }
        .badge-return { background: #d1fae5; color: #059669; }
        .badge-create { background: #dbeafe; color: #2563eb; }
        .badge-update { background: #e0e7ff; color: #4f46e5; }
        .badge-delete { background: #fee2e2; color: #dc2626; }
        .badge-default { background: #f3f4f6; color: #6b7280; }
        .gradient-text { background: linear-gradient(135deg, #1d4ed8, #3b82f6); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; }
        .btn-outline { padding: 0.45rem 1.1rem; font-size: 0.8rem; border-radius: 40px; background: transparent; border: 1px solid #93c5fd; cursor: pointer; display: inline-flex; align-items: center; }
        .btn-outline:hover { background: #eff6ff; }
    </style>
</head>
<body>
    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-blue-600 rounded-lg sm:hidden hover:bg-blue-100 bg-white shadow">
        <i class="fas fa-bars text-xl"></i>
    </button>

    <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 h-screen transition-transform sidebar -translate-x-full sm:translate-x-0" aria-label="Sidebar">
        <div class="h-full flex flex-col px-3 py-5 overflow-y-auto">
            <a href="{{ route('dashboard') }}" class="flex items-center ps-2 mb-7">
                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mr-2 shadow">
                    <i class="fas fa-bicycle text-white text-sm"></i>
                </div>
                <span class="sidebar-logo text-xl font-extrabold text-blue-700">E-Bike</span>
            </a>
            @php $userRole = auth()->user()->role ?? 'user'; @endphp
            <ul class="space-y-0.5">
                <li><a href="{{ route('dashboard') }}" class="sidebar-item flex items-center text-gray-700"><i class="fas fa-home w-5"></i><span class="ms-2">Dashboard</span></a></li>
                @if($userRole === 'admin' || $userRole === 'petugas')
                <li><a href="{{ route('items') }}" class="sidebar-item flex items-center text-gray-700"><i class="fas fa-box w-5"></i><span class="ms-2">Inventaris</span></a></li>
                @endif
                <li><a href="{{ route('pinjamBarang') }}" class="sidebar-item flex items-center text-gray-700"><i class="fas fa-hand-holding-heart w-5"></i><span class="ms-2">Peminjaman</span></a></li>
                @if($userRole === 'admin')
                <li><a href="{{ route('users') }}" class="sidebar-item flex items-center text-gray-700"><i class="fas fa-users w-5"></i><span class="ms-2">Kelola User</span></a></li>
                @endif
                <li><a href="{{ route('logs') }}" class="sidebar-item active flex items-center"><i class="fas fa-history w-5"></i><span class="ms-2">Log Aktivitas</span></a></li>
            </ul>
            <div class="mt-auto pt-5">
                <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="sidebar-item flex items-center w-full text-gray-700 hover:bg-red-50"><i class="fas fa-sign-out-alt w-5 text-red-400"></i><span class="ms-2">Logout</span></button></form>
            </div>
        </div>
    </aside>

    <div class="sm:ml-64 p-5 lg:p-6">
        <div class="page-header">
            <h1 class="text-white font-bold text-2xl">Log Aktivitas</h1>
            <p class="text-blue-100 text-sm">Riwayat semua aktivitas pengguna dalam sistem</p>
        </div>

        <div class="card">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold gradient-text"> Riwayat Aktivitas</h2>
                <button onclick="window.location.reload()" class="btn-outline text-sm">
                    <i class="fas fa-sync-alt mr-1"></i> Refresh
                </button>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left">Waktu</th>
                            <th class="px-6 py-3 text-left">Pengguna</th>
                            <th class="px-6 py-3 text-left">Aksi</th>
                            <th class="px-6 py-3 text-left">Barang</th>
                            <th class="px-6 py-3 text-left">Jumlah</th>
                            <th class="px-6 py-3 text-left">Keterangan</th>
                            <th class="px-6 py-3 text-left">IP Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logs as $log)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 text-gray-500 text-xs">
                                {{ \Carbon\Carbon::parse($log->created_at)->format('d/m/Y H:i:s') }}
                            </td>
                            <td class="px-6 py-4 font-medium">
                                {{ $log->user->name ?? 'System' }}
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $action = strtolower($log->action);
                                    $badgeClass = 'badge-default';
                                    $icon = 'fa-info-circle';
                                    
                                    if(in_array($action, ['borrow', 'pinjam'])) {
                                        $badgeClass = 'badge-borrow';
                                        $icon = 'fa-hand-holding-heart';
                                        $displayAction = 'Peminjaman';
                                    } elseif(in_array($action, ['return', 'kembali', 'returned'])) {
                                        $badgeClass = 'badge-return';
                                        $icon = 'fa-undo-alt';
                                        $displayAction = 'Pengembalian';
                                    } elseif($action == 'create') {
                                        $badgeClass = 'badge-create';
                                        $icon = 'fa-plus-circle';
                                        $displayAction = 'Tambah Data';
                                    } elseif($action == 'update') {
                                        $badgeClass = 'badge-update';
                                        $icon = 'fa-edit';
                                        $displayAction = 'Update Data';
                                    } elseif($action == 'delete') {
                                        $badgeClass = 'badge-delete';
                                        $icon = 'fa-trash';
                                        $displayAction = 'Hapus Data';
                                    } else {
                                        $displayAction = ucfirst($log->action);
                                    }
                                @endphp
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold {{ $badgeClass }}">
                                    <i class="fas {{ $icon }}"></i>
                                    {{ $displayAction }}
                                </span>
                            </td>
                            <!-- PERBAIKAN: Cek apakah item ada sebelum mengakses name -->
                            <td class="px-6 py-4">
                                @if($log->item && $log->item->name)
                                    <span class="inline-flex items-center gap-1">
                                        <i class="fas fa-box text-blue-500 text-xs"></i>
                                        {{ $log->item->name }}
                                    </span>
                                @else
                                    <span class="text-gray-400 text-xs">
                                        <i class="fas fa-trash-alt text-red-400 mr-1"></i>
                                        Item telah dihapus
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($log->amount)
                                    <span class="font-medium">{{ $log->amount }}</span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-600 text-sm">
                                {{ $log->description ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-gray-400 text-xs">
                                {{ $log->ip_address ?? '-' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-8 text-gray-400">
                                <i class="fas fa-inbox text-3xl mb-2 block"></i>
                                Belum ada aktivitas yang tercatat
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if(isset($logs) && method_exists($logs, 'links'))
            <div class="mt-4">
                {{ $logs->links() }}
            </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</body>
</html>