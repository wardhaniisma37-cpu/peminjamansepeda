<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Bike · Soft Blue Dashboard</title>

    <!-- Favicon placeholder -->
    <link rel="icon" type="image/png" href="https://flowbite.com/docs/images/logo.svg">

    <!-- Flowbite CSS + Tailwind base -->
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <!-- Tailwind CDN (for custom utilities if needed) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Override Tailwind config to soft blue theme -->
    <style>
        /* custom soft blue theme overrides */
        :root {
            --soft-blue-50: #eff6ff;
            --soft-blue-100: #e0eefe;
            --soft-blue-200: #bfdbfe;
            --soft-blue-300: #93c5fd;
            --soft-blue-400: #60a5fa;
            --soft-blue-500: #3b82f6;
            --soft-blue-600: #2563eb;
            --soft-blue-700: #1d4ed8;
            --soft-blue-800: #1e40af;
            --soft-blue-900: #1e3a8a;
        }

        /* custom scrollbar for a subtle look */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #eef2ff;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb {
            background: #bfdbfe;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #93c5fd;
        }

        body {
            background: #f5f9ff;
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        /* smooth transitions */
        .transition-soft {
            transition: all 0.2s ease;
        }

        /* card shadow soft */
        .soft-shadow {
            box-shadow: 0 8px 20px rgba(59,130,246,0.08), 0 2px 6px rgba(0,0,0,0.02);
        }

        /* sidebar active item style */
        .sidebar-active {
            background-color: #3b82f6;
            color: white !important;
        }
        .sidebar-active svg {
            color: white !important;
        }

        /* custom table hover */
        .custom-table-hover tbody tr:hover {
            background-color: #f0f7ff;
            transition: 0.15s;
        }

        /* subtle badge animation */
        .badge-pulse {
            animation: softPulse 2s infinite;
        }
        @keyframes softPulse {
            0% { box-shadow: 0 0 0 0 rgba(59,130,246,0.2); }
            70% { box-shadow: 0 0 0 6px rgba(59,130,246,0); }
            100% { box-shadow: 0 0 0 0 rgba(59,130,246,0); }
        }
    </style>
</head>
<body class="antialiased">

    <!-- mobile drawer toggle button -->
    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
        type="button"
        class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-blue-600 rounded-lg sm:hidden hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-200">
        <span class="sr-only">Open sidebar</span>
        <svg class="w-9 h-9" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" fill-rule="evenodd"
                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
            </path>
        </svg>
    </button>

<!-- Sidebar -->
<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 h-screen transition-transform sidebar -translate-x-full sm:translate-x-0" aria-label="Sidebar">
    <div class="h-full flex flex-col px-3 py-5 overflow-y-auto">
        <!-- Logo -->
        <a href="{{ route('dashboard') }}" class="flex items-center ps-2 mb-7">
            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mr-2 shadow">
                <i class="fas fa-bicycle text-white text-sm"></i>
            </div>
            <span class="sidebar-logo text-xl font-extrabold text-blue-700">E-Bike</span>
        </a>

        @php 
            $userRole = auth()->user()->role ?? 'user'; 
        @endphp

        <!-- MENU UTAMA -->
        <div class="mb-4 px-2">
            <p class="text-[0.65rem] font-bold text-blue-400 uppercase tracking-wider">Menu Utama</p>
        </div>
        
        <ul class="space-y-0.5">
            <!-- Dashboard (Semua Role) -->
            <li>
                <a href="{{ route('dashboard') }}" class="sidebar-item flex items-center text-gray-700 hover:text-blue-700">
                    <i class="fas fa-home w-5 text-blue-500"></i>
                    <span class="ms-2">Dashboard</span>
                </a>
            </li>
            
            <!-- Inventaris (Hanya Admin & Petugas) -->
            @if($userRole === 'admin' || $userRole === 'petugas')
            <li>
                <a href="{{ route('items') }}" class="sidebar-item flex items-center text-gray-700 hover:text-blue-700">
                    <i class="fas fa-box w-5 text-blue-500"></i>
                    <span class="ms-2">Inventaris</span>
                </a>
            </li>
            @endif
            

            
            <!-- Peminjaman (Semua Role) -->
            <li>
                <a href="{{ route('pinjamBarang') }}" class="sidebar-item flex items-center text-gray-700 hover:text-blue-700">
                    <i class="fas fa-hand-holding-heart w-5 text-blue-500"></i>
                    <span class="ms-2">Peminjaman</span>
                </a>
            </li>
            
            <!-- Kelola User (Hanya Admin) -->
            @if($userRole === 'admin')
            <li>
                <a href="{{ route('users') }}" class="sidebar-item flex items-center text-gray-700 hover:text-blue-700">
                    <i class="fas fa-users w-5 text-blue-500"></i>
                    <span class="ms-2">Kelola User</span>
                </a>
            </li>
            @endif
            
            <!-- Log Aktivitas (Semua Role) -->
            <li>
                <a href="{{ route('logs') }}" class="sidebar-item flex items-center text-gray-700 hover:text-blue-700">
                    <i class="fas fa-history w-5 text-blue-500"></i>
                    <span class="ms-2">Log Aktivitas</span>
                </a>
            </li>
        </ul>

        <!-- MENU ADMINISTRATION (Hanya Admin & Petugas) -->
        @if($userRole === 'admin' || $userRole === 'petugas')
        <div class="mt-6 mb-2 px-2">
            <p class="text-[0.65rem] font-bold text-blue-400 uppercase tracking-wider">Administration</p>
        </div>
        <ul class="space-y-0.5">
            <li>
                <a href="#" class="sidebar-item flex items-center text-gray-700 hover:text-blue-700">
                    <i class="fas fa-cog w-5 text-blue-500"></i>
                    <span class="ms-2">Pengaturan</span>
                </a>
            </li>
            <li>
                <a href="#" class="sidebar-item flex items-center text-gray-700 hover:text-blue-700">
                    <i class="fas fa-chart-line w-5 text-blue-500"></i>
                    <span class="ms-2">Laporan</span>
                </a>
            </li>
        </ul>
        @endif

        <!-- MENU USER BIASA (Hanya untuk User Biasa) -->
        @if($userRole === 'user')
        <div class="mt-6 mb-2 px-2">
            <p class="text-[0.65rem] font-bold text-blue-400 uppercase tracking-wider">Akun Saya</p>
        </div>
        <ul class="space-y-0.5">
            <li>
                <a href="#" class="sidebar-item flex items-center text-gray-700 hover:text-blue-700">
                    <i class="fas fa-user w-5 text-blue-500"></i>
                    <span class="ms-2">Profil Saya</span>
                </a>
            </li>
            <li>
                <a href="#" class="sidebar-item flex items-center text-gray-700 hover:text-blue-700">
                    <i class="fas fa-key w-5 text-blue-500"></i>
                    <span class="ms-2">Ubah Password</span>
                </a>
            </li>
        </ul>
        @endif

        <!-- Tombol Logout (Semua Role) -->
        <div class="mt-auto pt-5">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-item flex items-center w-full text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-xl">
                    <i class="fas fa-sign-out-alt w-5 text-red-400"></i>
                    <span class="ms-2 text-sm">Logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>

    <!-- MAIN CONTENT - Soft blue themed -->
    <div class="sm:ml-64 bg-[#f8fafd] min-h-screen pb-8">
        <!-- Hero header with soft gradient -->
        <div class="rounded-b-3xl bg-gradient-to-r from-blue-600 to-blue-400 shadow-md">
            <div class="flex flex-col items-start justify-start px-6 py-6 md:px-8 md:py-8">
                <p class="text-sm text-blue-50 tracking-wide">Pages / List User</p>
                <p class="text-2xl md:text-3xl font-bold text-white mt-1">List User</p>
            </div>
        </div>

        <!-- Main card area - elevated soft white -->
        <div class="flex flex-col justify-around gap-4 mx-4 md:mx-8 -mt-8 mb-6 p-6 md:p-8 rounded-2xl bg-white soft-shadow">
            <!-- ADDITIONAL TITLE: "List User" di atas table area (persis di atas button search) sesuai permintaan -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 pb-3 border-b border-blue-100">
                <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                    <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-800 to-blue-600 bg-clip-text text-transparent">📋 List User</h1>
                    <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-0.5 text-xs font-medium text-blue-800 w-fit badge-pulse">
                        Total {{ count($users ?? []) }} pengguna
                    </span>
                </div>
                <button data-modal-target="adduser-modal" data-modal-toggle="adduser-modal" class="font-medium text-white bg-blue-600 hover:bg-blue-700 px-5 py-2.5 rounded-xl shadow-sm transition-all duration-200 flex items-center gap-2 w-fit">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah User
                </button>
            </div>

            <!-- search & table section -->
            <div class="relative overflow-x-auto rounded-xl border border-blue-100 bg-white">
                <div class="p-4 bg-white border-b border-blue-50 flex flex-wrap justify-between items-center gap-3">
                    <div class="relative w-full md:w-80">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <input type="text" id="table-search" class="bg-gray-50 border border-blue-200 text-gray-900 text-sm rounded-xl focus:ring-blue-300 focus:border-blue-300 block w-full pl-10 p-2.5" placeholder="Cari berdasarkan nama user...">
                    </div>
                    <div class="text-sm text-blue-500 hidden md:block">
                        <span> Kelola data pengguna dengan mudah</span>
                    </div>
                </div>
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="text-xs text-blue-800 uppercase bg-blue-50/60">
                        <tr>
                            <th scope="col" class="p-4 w-12">No.</th>
                            <th scope="col" class="px-6 py-3 font-semibold">Username</th>
                            <th scope="col" class="px-6 py-3 font-semibold">Email</th>
                            <th scope="col" class="px-6 py-3 font-semibold">Password</th>
                            <th scope="col" class="px-6 py-3 font-semibold">Roles</th>
                            <th scope="col" class="px-6 py-3 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-blue-50">
                        @forelse ($users as $user)
                        <tr class="hover:bg-blue-50/40 transition-soft">
                            <td class="p-4 font-medium text-gray-700">{{ $loop->iteration }}</td>
                            <th class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap">{{ $user->name }}</th>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-gray-500 font-mono text-xs">••••••••</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $user->role == 'admin' ? 'bg-blue-100 text-blue-800' : 'bg-sky-100 text-sky-700' }}">
                                    {{ $user->role == 'admin' ? 'Admin' : ($user->role == 'petugas' ? 'Petugas' : ucfirst($user->role)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <button data-modal-target="default-modal-{{ $user->id }}" data-modal-toggle="default-modal-{{ $user->id }}" class="font-medium text-blue-600 hover:text-blue-800 hover:underline mr-3 transition">Edit</button>
                                
                                <!-- MODAL ACTION (edit/delete) -->
                                <div id="default-modal-{{ $user->id }}" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative p-4 w-full max-w-md max-h-full">
                                        <div class="relative bg-white rounded-2xl shadow-xl border border-blue-100">
                                            <div class="flex items-center justify-between p-4 md:p-5 border-b border-blue-100">
                                                <h3 class="text-lg font-semibold text-blue-900">Kelola User</h3>
                                                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-100 rounded-lg text-sm w-8 h-8" data-modal-hide="default-modal-{{ $user->id }}">
                                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
                                                </button>
                                            </div>
                                            <div class="p-5 text-gray-600 text-sm">Ingin melakukan apa dengan user <span class="font-semibold text-blue-700">{{ $user->name }}</span>?</div>
                                            <div class="flex items-center gap-3 p-5 pt-0 border-t border-blue-50">
                                                <button data-modal-target="editItem-modal-{{ $user->id }}" data-modal-toggle="editItem-modal-{{ $user->id }}" data-modal-hide="default-modal-{{ $user->id }}" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">Edit Data</button>
                                                <form action="{{ route('users.delete', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?')" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="px-4 py-2 text-sm font-medium text-red-700 bg-red-50 rounded-lg hover:bg-red-100 transition">Hapus User</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- MODAL EDIT USER (soft blue refinement) -->
                                <div id="editItem-modal-{{ $user->id }}" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative p-4 w-full max-w-2xl max-h-full">
                                        <div class="relative bg-white rounded-2xl shadow-2xl">
                                            <div class="flex items-center justify-between p-5 border-b border-blue-100">
                                                <h3 class="text-xl font-semibold text-blue-800"> Edit Users</h3>
                                                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-100 rounded-lg text-sm w-8 h-8" data-modal-hide="editItem-modal-{{ $user->id }}">✕</button>
                                            </div>
                                            <form action="{{ route('users.update', $user->id) }}" method="POST">
                                                @csrf @method('PUT')
                                                <div class="p-5 space-y-4">
                                                    <div><label class="block mb-2 text-sm font-medium text-gray-700">Nama Lengkap</label><input type="text" name="name" value="{{ $user->name }}" class="bg-gray-50 border border-gray-200 text-gray-900 rounded-xl w-full p-2.5 focus:ring-blue-300 focus:border-blue-300"></div>
                                                    <div><label class="block mb-2 text-sm font-medium text-gray-700">Email</label><input type="email" name="email" value="{{ $user->email }}" class="bg-gray-50 border border-gray-200 rounded-xl w-full p-2.5"></div>
                                                    <div><label class="block mb-2 text-sm font-medium text-gray-700">Password Baru (kosongkan jika tidak diubah)</label><input type="password" name="password" placeholder="Kosongkan jika tetap" class="bg-gray-50 border border-gray-200 rounded-xl w-full p-2.5"></div>
                                                    <div><label class="block mb-2 text-sm font-medium text-gray-700">Konfirmasi Password</label><input type="password" name="password_confirmation" class="bg-gray-50 border border-gray-200 rounded-xl w-full p-2.5"></div>
                                                    <div><label class="block mb-2 text-sm font-medium text-gray-700">Role</label>
                                                        <select name="role" class="bg-gray-50 border border-gray-200 rounded-xl w-full p-2.5">
                                                            <option value="petugas" {{ $user->role == 'petugas' ? 'selected' : '' }}>Petugas</option>
                                                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="flex p-5 border-t border-blue-50"><button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl transition">Simpan Perubahan</button></div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-400 italic">Belum ada user tersedia. Tambah user baru dengan klik tombol "Tambah User".</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- MODAL TAMBAH USER - soft blue -->
    <div id="adduser-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-xl max-h-full">
            <div class="relative bg-white rounded-2xl shadow-xl border border-blue-100">
                <div class="flex items-center justify-between p-5 border-b border-blue-100">
                    <h3 class="text-xl font-semibold text-blue-800">➕ Tambah User Baru</h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-100 rounded-lg text-sm w-8 h-8" data-modal-hide="adduser-modal">✕</button>
                </div>
                <form action="{{ route('users') }}" method="POST">
                    @csrf
                    <div class="p-6 space-y-4">
                        <div><label class="block mb-2 text-sm font-medium text-gray-700">Username</label><input type="text" name="name" class="bg-gray-50 border border-gray-200 rounded-xl w-full p-2.5 focus:ring-blue-200" placeholder="Nama lengkap" required></div>
                        <div><label class="block mb-2 text-sm font-medium text-gray-700">Email</label><input type="email" name="email" class="bg-gray-50 border border-gray-200 rounded-xl w-full p-2.5" placeholder="email@contoh.com" required></div>
                        <div><label class="block mb-2 text-sm font-medium text-gray-700">Password</label><input type="password" name="password" class="bg-gray-50 border border-gray-200 rounded-xl w-full p-2.5" required></div>
                        <div><label class="block mb-2 text-sm font-medium text-gray-700">Konfirmasi Password</label><input type="password" name="password_confirmation" class="bg-gray-50 border border-gray-200 rounded-xl w-full p-2.5" required></div>
                        <div><label class="block mb-2 text-sm font-medium text-gray-700">Role</label>
                            <select name="role" class="bg-gray-50 border border-gray-200 rounded-xl w-full p-2.5">
                                <option value="petugas">Petugas</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex p-5 pt-0 border-t border-blue-50"><button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl transition">Simpan User</button></div>
                </form>
            </div>
        </div>
    </div>

    <!-- Alert toasts (soft blue styling) -->
    @if (session('success'))
    <div id="alert-toast" class="fixed bottom-5 right-5 z-50 flex items-center p-4 rounded-xl bg-white border-l-4 border-green-400 shadow-lg">
        <div class="text-green-600 bg-green-50 p-2 rounded-full mr-3">✓</div>
        <div class="text-sm font-medium text-gray-700">{{ session('success') }}</div>
        <button onclick="this.parentElement.remove()" class="ml-4 text-gray-400 hover:text-gray-600">✕</button>
    </div>
    @endif
    @if (session('error') || $errors->any())
    <div id="alert-toast" class="fixed bottom-5 right-5 z-50 flex items-center p-4 rounded-xl bg-white border-l-4 border-red-400 shadow-lg">
        <div class="text-red-600 bg-red-50 p-2 rounded-full mr-3">⚠️</div>
        <div class="text-sm font-medium text-gray-700">{{ session('error') ?? 'Validasi gagal, periksa kembali input' }}</div>
        <button onclick="this.parentElement.remove()" class="ml-4 text-gray-400 hover:text-gray-600">✕</button>
    </div>
    @endif

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script>
        // Search filter by username
        const searchInput = document.getElementById('table-search');
        const tableRows = document.querySelectorAll('tbody tr');
        if(searchInput) {
            searchInput.addEventListener('keyup', function() {
                const term = this.value.toLowerCase();
                tableRows.forEach(row => {
                    const nameCell = row.querySelector('th');
                    const userName = nameCell ? nameCell.textContent.toLowerCase() : '';
                    if(userName.includes(term)) row.style.display = '';
                    else row.style.display = 'none';
                });
            });
        }
        // auto hide alert after 4 seconds
        setTimeout(() => {
            const alertDiv = document.getElementById('alert-toast');
            if(alertDiv) alertDiv.style.opacity = '0'; setTimeout(() => alertDiv?.remove(), 400);
        }, 3800);
    </script>
</body>
</html>