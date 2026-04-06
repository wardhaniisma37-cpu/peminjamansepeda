<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Lentora | Soft Blue Theme</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/img/Avatar.png') }}">

    <!-- Flowbite -->
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    {{-- Link Laravel --}}
    <link href="{{ mix('resources/css/app.css') }}" rel="stylesheet">

    <style>
        /* Custom Scrollbar - Soft Blue Theme */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #e0f2fe;
        }

        ::-webkit-scrollbar-thumb {
            background: #7ab7ef;
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #3b82f6;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(100%);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Hover Effects */
        .hover-scale {
            transition: transform 0.2s;
        }

        .hover-scale:hover {
            transform: scale(1.02);
        }

        /* Gradient Text - Soft Blue */
        .gradient-text {
            background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Card Hover Effect */
        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            box-shadow: 0 10px 40px rgba(59, 130, 246, 0.15);
            transform: translateY(-2px);
        }

        /* Soft Blue Custom Colors */
        .bg-soft-blue {
            background-color: #3b82f6;
        }
        
        .text-soft-blue {
            color: #3b82f6;
        }
        
        .border-soft-blue {
            border-color: #93c5fd;
        }

        /* Image Preview Styles */
        .image-preview-container {
            position: relative;
            display: inline-block;
        }

        .item-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.15);
            transition: transform 0.2s;
            cursor: pointer;
        }

        .item-image:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25);
        }

        .image-preview-large {
            max-width: 200px;
            max-height: 200px;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .upload-area {
            border: 2px dashed #cbd5e1;
            transition: all 0.3s;
            cursor: pointer;
        }

        .upload-area:hover {
            border-color: #3b82f6;
            background-color: #eff6ff;
        }

        .preview-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 12px;
            border: 2px solid #3b82f6;
        }

        /* Table Styles */
        .table-row-hover:hover {
            background-color: #eff6ff;
            transition: background-color 0.2s ease;
        }

        /* Dropdown Menu Styles */
        .dropdown-menu {
            transition: all 0.3s ease;
        }
        
        .dropdown-menu a:hover {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-50 to-sky-50">
    <!-- Sidebar Toggle Button -->
    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
        type="button"
        class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-blue-700 rounded-lg lg:hidden hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-300 bg-white shadow-md">
        <span class="sr-only">Open sidebar</span>
        <svg class="w-9 h-9" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
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

    <!-- Main Content -->
    <div class="lg:ml-64 p-6">
        <!-- Header dengan gradient soft blue -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-600 to-sky-600 p-8 mb-6 shadow-xl">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-white opacity-10 rounded-full"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-white opacity-10 rounded-full"></div>
            <div class="relative">
                <p class="text-sm text-white/80 mb-2">
                    <i class="fas fa-home mr-1"></i> Pages / Inventaris
                </p>
                <h1 class="text-3xl font-bold text-white flex items-center">
                    <i class="fas fa-box mr-3"></i>
                    Inventaris Barang
                </h1>
                <p class="text-white/70 mt-2">Kelola data inventaris barang dengan gambar</p>
            </div>
        </div>

        <!-- Main Card -->
        <div class="bg-white/90 backdrop-blur-lg rounded-2xl shadow-xl p-8 fade-in border border-blue-100">
            <!-- Header Actions -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
                <div>
                    <h2 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-sky-600 bg-clip-text text-transparent">
                        List Inventaris
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Kelola data inventaris barang dengan gambar</p>
                </div>
                <button data-modal-target="addItem-modal" data-modal-toggle="addItem-modal"
                    class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-sky-600 text-white font-medium rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 hover:scale-105 transition-all duration-300 flex items-center gap-2">
                    <i class="fas fa-plus"></i>
                    Tambah Barang
                </button>
            </div>

            <!-- Search -->
            <div class="mb-6">
                <div class="relative max-w-md">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-blue-400"></i>
                    </div>
                    <input type="text" id="table-search" 
                        class="block w-full pl-10 pr-3 py-2.5 border border-blue-200 rounded-xl bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                        placeholder="Cari barang...">
                </div>
            </div>

            <!-- Table with Image Column -->
            <div class="relative overflow-x-auto rounded-xl border border-blue-200">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-blue-800 uppercase bg-gradient-to-r from-blue-50 to-sky-50">
                        <tr>
                            <th scope="col" class="px-4 py-4 font-bold text-center">No.</th>
                            <th scope="col" class="px-4 py-4 font-bold text-center">Gambar</th>
                            <th scope="col" class="px-4 py-4 font-bold">Nama Barang</th>
                            <th scope="col" class="px-4 py-4 font-bold">Deskripsi</th>
                            <th scope="col" class="px-4 py-4 font-bold">Stock</th>
                            <th scope="col" class="px-4 py-4 font-bold">Kondisi</th>
                            <th scope="col" class="px-4 py-4 font-bold">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $item)
                        <tr class="bg-white border-b border-blue-100 table-row-hover transition-colors duration-200">
                            <td class="px-4 py-4 font-medium text-center text-gray-700">{{ $loop->iteration }}</td>
                            <td class="px-4 py-4 text-center">
@if($item->image && file_exists(public_path($item->image)))
    <img src="{{ asset($item->image) }}" 
         alt="{{ $item->name }}"
         class="item-image"
         onclick="showImageModal('{{ asset($item->image) }}', '{{ $item->name }}')">
@else
    <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center mx-auto border border-blue-200">
        <i class="fas fa-image text-blue-300 text-xl"></i>
    </div>
@endif  
                            </td>
                            <td class="px-4 py-4 font-medium text-gray-800">{{ $item->name }}</td>
                            <td class="px-4 py-4 text-gray-600 max-w-xs truncate">{{ $item->description }}</td>
                            <td class="px-4 py-4">
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                                    {{ $item->stock }} unit
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                @if($item->kondisi == 'baik')
                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium flex items-center gap-1 w-fit">
                                        <i class="fas fa-check-circle text-xs"></i> Baik
                                    </span>
                                @elseif($item->kondisi == 'rusak')
                                    <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium flex items-center gap-1 w-fit">
                                        <i class="fas fa-times-circle text-xs"></i> Rusak
                                    </span>
                                @elseif($item->kondisi == 'perbaikan')
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium flex items-center gap-1 w-fit">
                                        <i class="fas fa-tools text-xs"></i> Perbaikan
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-2">
                                    <button data-modal-target="editItem-modal-{{ $item->id }}" data-modal-toggle="editItem-modal-{{ $item->id }}"
                                        class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg transition-all duration-300" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button data-modal-target="deleteModal-{{ $item->id }}" data-modal-toggle="deleteModal-{{ $item->id }}"
                                        class="p-2 text-red-600 hover:bg-red-100 rounded-lg transition-all duration-300" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-12 text-gray-500">
                                <i class="fas fa-box-open text-5xl mb-3 text-blue-200"></i>
                                <p>Belum ada data barang. Silakan tambah barang baru.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Barang dengan Upload Gambar - Soft Blue -->
    <div id="addItem-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-2xl shadow-2xl">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-6 border-b rounded-t bg-gradient-to-r from-blue-600 to-sky-600">
                    <h3 class="text-xl font-semibold text-white flex items-center gap-2">
                        <i class="fas fa-plus-circle"></i>
                        Tambah Barang Baru
                    </h3>
                    <button type="button" class="text-white/80 hover:text-white hover:bg-white/20 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center transition-all duration-300" data-modal-hide="addItem-modal">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form action="{{ route('items') }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf
                    <div class="space-y-4">
                        <!-- Upload Gambar -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-image text-blue-600 mr-2"></i>Gambar Barang
                            </label>
                            <div id="uploadArea" class="upload-area rounded-xl p-6 text-center transition-all" onclick="document.getElementById('image_input').click()">
                                <input type="file" name="image" id="image_input" accept="image/*" class="hidden" onchange="previewImage(this)">
                                <div id="uploadPlaceholder">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-blue-400 mb-2"></i>
                                    <p class="text-gray-500">Klik untuk upload gambar</p>
                                    <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG (Max 2MB)</p>
                                </div>
                                <div id="imagePreviewContainer" class="hidden mt-3">
                                    <img id="imagePreview" class="preview-img mx-auto" alt="Preview">
                                    <p class="text-xs text-blue-600 mt-2" id="fileNameDisplay"></p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-box text-blue-600 mr-2"></i>Nama Barang
                            </label>
                            <input type="text" name="name" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                                placeholder="Masukkan nama barang">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-align-left text-blue-600 mr-2"></i>Deskripsi Barang
                            </label>
                            <textarea name="description" rows="3" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                                placeholder="Masukkan deskripsi barang"></textarea>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-cubes text-blue-600 mr-2"></i>Stock Barang
                            </label>
                            <input type="number" name="stock" required min="0"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                                placeholder="Masukkan jumlah stock">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-clipboard-check text-blue-600 mr-2"></i>Kondisi Barang
                            </label>
                            <select name="kondisi" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300">
                                <option value="">Pilih Kondisi</option>
                                <option value="baik">Baik</option>
                                <option value="rusak">Rusak</option>
                                <option value="perbaikan">Sedang Diperbaiki</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Modal footer -->
                    <div class="flex justify-end gap-3 mt-6 pt-6 border-t">
                        <button type="button" data-modal-hide="addItem-modal"
                            class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-all duration-300 font-medium">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-sky-600 text-white rounded-xl hover:shadow-lg hover:shadow-blue-500/30 hover:scale-105 transition-all duration-300 font-medium flex items-center gap-2">
                            <i class="fas fa-save"></i>
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Barang dengan Gambar - Soft Blue -->
    @foreach ($items as $item)
    <div id="editItem-modal-{{ $item->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-2xl shadow-2xl">
                <div class="flex items-center justify-between p-6 border-b rounded-t bg-gradient-to-r from-blue-500 to-blue-600">
                    <h3 class="text-xl font-semibold text-white flex items-center gap-2">
                        <i class="fas fa-edit"></i>
                        Edit Barang
                    </h3>
                    <button type="button" class="text-white/80 hover:text-white hover:bg-white/20 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center transition-all duration-300" data-modal-hide="editItem-modal-{{ $item->id }}">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <form action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <!-- Gambar Saat Ini -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Saat Ini</label>
@if($item->image && file_exists(public_path($item->image)))
    <div class="mb-3">
        <img src="{{ asset($item->image) }}" 
             class="w-24 h-24 object-cover rounded-xl shadow-md border border-blue-200" 
             alt="Current Image">
    </div>
@else
    <div class="mb-3 p-4 bg-blue-50 rounded-xl text-center border border-blue-200">
        <i class="fas fa-image text-blue-300 text-3xl"></i>
        <p class="text-gray-500 text-sm mt-1">Tidak ada gambar</p>
    </div>
@endif
                            <label class="block text-sm font-medium text-gray-700 mb-2 mt-3">
                                <i class="fas fa-upload text-blue-600 mr-2"></i>Ganti Gambar (Opsional)
                            </label>
                            <input type="file" name="image" accept="image/*" 
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300">
                            <p class="text-xs text-gray-400 mt-1">Biarkan kosong jika tidak ingin mengubah gambar</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Barang</label>
                            <input type="text" name="name" value="{{ $item->name }}" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                            <textarea name="description" rows="3" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300">{{ $item->description }}</textarea>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Stock</label>
                            <input type="number" name="stock" value="{{ $item->stock }}" required min="0"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kondisi</label>
                            <select name="kondisi" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300">
                                <option value="baik" {{ $item->kondisi == 'baik' ? 'selected' : '' }}>Baik</option>
                                <option value="rusak" {{ $item->kondisi == 'rusak' ? 'selected' : '' }}>Rusak</option>
                                <option value="perbaikan" {{ $item->kondisi == 'perbaikan' ? 'selected' : '' }}>Sedang Diperbaiki</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="flex justify-end gap-3 mt-6 pt-6 border-t">
                        <button type="button" data-modal-hide="editItem-modal-{{ $item->id }}"
                            class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-all duration-300 font-medium">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-sky-600 text-white rounded-xl hover:shadow-lg hover:shadow-blue-500/30 hover:scale-105 transition-all duration-300 font-medium flex items-center gap-2">
                            <i class="fas fa-save"></i>
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus - Soft Blue -->
    <div id="deleteModal-{{ $item->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-2xl shadow-2xl">
                <div class="p-6 text-center">
                    <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-exclamation-triangle text-3xl text-red-500"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Hapus Barang</h3>
                    <p class="text-gray-500 mb-6">Apakah Anda yakin ingin menghapus barang <span class="font-semibold text-blue-600">"{{ $item->name }}"</span>? Tindakan ini tidak dapat dibatalkan.</p>
                    
                    <form action="{{ route('items.delete', $item->id) }}" method="POST" class="flex justify-center gap-3">
                        @csrf
                        @method('DELETE')
                        <button type="button" data-modal-hide="deleteModal-{{ $item->id }}"
                            class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-all duration-300 font-medium">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-6 py-2.5 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl hover:shadow-lg hover:shadow-red-500/30 hover:scale-105 transition-all duration-300 font-medium flex items-center gap-2">
                            <i class="fas fa-trash"></i>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Modal untuk Preview Gambar Besar -->
    <div id="imageModal" class="fixed inset-0 z-50 hidden bg-black/80 flex items-center justify-center p-4 backdrop-blur-sm" onclick="hideImageModal()">
        <div class="relative max-w-2xl max-h-[90vh]" onclick="event.stopPropagation()">
            <button onclick="hideImageModal()" class="absolute -top-12 right-0 text-white text-3xl hover:text-blue-300 transition-colors">&times;</button>
            <img id="modalImage" src="" alt="Preview" class="max-w-full max-h-[85vh] rounded-2xl shadow-2xl border-4 border-white">
            <p id="modalImageCaption" class="text-white text-center mt-3 text-sm bg-black/50 inline-block px-4 py-2 rounded-full mx-auto w-fit"></p>
        </div>
    </div>

    <!-- Alert Notifications - Soft Blue -->
    @if (session('success'))
    <div id="successAlert" class="fixed top-4 right-4 z-50 flex items-center p-4 bg-blue-100 border-l-4 border-blue-500 rounded-lg shadow-lg fade-in" role="alert">
        <i class="fas fa-check-circle text-blue-500 mr-3 text-xl"></i>
        <div class="text-sm font-medium text-blue-700">{{ session('success') }}</div>
        <button type="button" class="ml-4 text-blue-500 hover:text-blue-700" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    @if ($errors->any())
    <div id="validationAlert" class="fixed top-4 right-4 z-50 flex items-start p-4 bg-red-100 border-l-4 border-red-500 rounded-lg shadow-lg fade-in" role="alert">
        <i class="fas fa-exclamation-triangle text-red-500 mr-3 text-xl"></i>
        <div>
            <div class="text-sm font-medium text-red-700 mb-1">Validasi Gagal:</div>
            <ul class="text-xs text-red-600 list-disc list-inside">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <button type="button" class="ml-4 text-red-500 hover:text-red-700" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    
    <script>
        // Image preview function for upload
        function previewImage(input) {
            const previewContainer = document.getElementById('imagePreviewContainer');
            const previewImg = document.getElementById('imagePreview');
            const placeholder = document.getElementById('uploadPlaceholder');
            const fileNameDisplay = document.getElementById('fileNameDisplay');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                    fileNameDisplay.textContent = input.files[0].name;
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                previewContainer.classList.add('hidden');
                placeholder.classList.remove('hidden');
            }
        }

        // Show image modal for larger preview
        function showImageModal(imageUrl, itemName) {
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImage');
            const caption = document.getElementById('modalImageCaption');
            modalImg.src = imageUrl;
            caption.textContent = itemName;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function hideImageModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Search functionality
        const searchInput = document.getElementById('table-search');
        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase();
                const tableRows = document.querySelectorAll('tbody tr');
                
                tableRows.forEach(row => {
                    const productName = row.querySelector('td:nth-child(3)')?.textContent.toLowerCase() || '';
                    if (productName.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }

        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('[id$="Alert"]');
            alerts.forEach(alert => {
                if (alert) {
                    alert.style.transition = 'opacity 0.5s';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }
            });
        }, 5000);

        // Close modal with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                hideImageModal();
            }
        });
    </script>
</body>

</html>