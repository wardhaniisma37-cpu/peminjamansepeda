<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - E-Bike | Soft Blue Theme</title>

    <!-- Favicon Soft Blue -->
    <link rel="icon" type="image/png" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%233b82f6'%3E%3Cpath d='M5.5 18.5L3 16l2.5-2.5L8 16l-2.5 2.5zM18.5 5.5L21 8l-2.5 2.5L16 8l2.5-2.5zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 4c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2zm0 13c-2.33 0-4.31-1.46-5.11-3.5h10.22c-.8 2.04-2.78 3.5-5.11 3.5z'/%3E%3C/svg%3E">

    <!-- Flowbite -->
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        :root {
            --soft-blue-50: #eff6ff;
            --soft-blue-100: #dbeafe;
            --soft-blue-200: #bfdbfe;
            --soft-blue-300: #93c5fd;
            --soft-blue-400: #60a5fa;
            --soft-blue-500: #3b82f6;
            --soft-blue-600: #2563eb;
            --soft-blue-700: #1d4ed8;
            --soft-blue-800: #1e40af;
            --soft-blue-900: #1e3a8a;
            
            --pure-white: #ffffff;
            --off-white: #f8fafc;
            --light-gray: #f1f5f9;
            --medium-gray: #64748b;
            --dark-gray: #334155;
            
            --shadow-sm: 0 4px 12px rgba(59, 130, 246, 0.08);
            --shadow-md: 0 8px 24px rgba(59, 130, 246, 0.12);
            --shadow-lg: 0 16px 32px rgba(59, 130, 246, 0.16);
            
            --gradient-soft: linear-gradient(135deg, #3b82f6, #2563eb);
            --gradient-card: linear-gradient(145deg, #ffffff, #f0f9ff);
        }

        body {
            background-color: var(--off-white);
            color: var(--dark-gray);
            font-family: 'Inter', sans-serif;
        }

        /* Sidebar Styles - Soft Blue */
        .sidebar {
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            border-right: 1px solid var(--soft-blue-200);
            box-shadow: 4px 0 20px rgba(59, 130, 246, 0.06);
        }

        .sidebar-logo {
            color: var(--soft-blue-700);
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .sidebar-item {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 16px;
            margin: 4px 0;
        }

        .sidebar-item:hover {
            background: var(--soft-blue-50);
            transform: translateX(4px);
            color: var(--soft-blue-700);
        }

        .sidebar-item.active {
            background: linear-gradient(135deg, var(--soft-blue-500), var(--soft-blue-600));
            color: white;
            box-shadow: 0 8px 16px rgba(59, 130, 246, 0.25);
        }

        .sidebar-item.active svg, 
        .sidebar-item.active i {
            color: white !important;
        }

        /* Header Styles */
        .page-header {
            background: linear-gradient(135deg, var(--soft-blue-600), var(--soft-blue-500));
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, transparent 70%);
            border-radius: 50%;
        }

        .page-header::after {
            content: '';
            position: absolute;
            bottom: -50%;
            left: -10%;
            width: 250px;
            height: 250px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            border-radius: 50%;
        }

        /* Welcome Card */
        .welcome-card {
            background: var(--pure-white);
            border: 1px solid var(--soft-blue-200);
            border-radius: 32px;
            box-shadow: var(--shadow-md);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .welcome-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
            border-color: var(--soft-blue-300);
        }

        .welcome-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, var(--soft-blue-100) 0%, transparent 70%);
            border-radius: 50%;
            opacity: 0.5;
        }

        .welcome-title {
            background: linear-gradient(135deg, var(--soft-blue-700), var(--soft-blue-600));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
        }

        .btn-explore {
            background: linear-gradient(135deg, var(--soft-blue-500), var(--soft-blue-600));
            color: white;
            padding: 12px 32px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 8px 16px rgba(59, 130, 246, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .btn-explore:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(59, 130, 246, 0.3);
            background: linear-gradient(135deg, var(--soft-blue-600), var(--soft-blue-700));
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: var(--pure-white);
            border: 1px solid var(--soft-blue-200);
            border-radius: 28px;
            padding: 24px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: var(--shadow-sm);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 150px;
            height: 150px;
            background: radial-gradient(circle, var(--soft-blue-100) 0%, transparent 70%);
            border-radius: 50%;
            transition: all 0.4s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px) scale(1.02);
            border-color: var(--soft-blue-400);
            box-shadow: var(--shadow-lg);
        }

        .stat-card:hover::before {
            transform: scale(1.5);
            opacity: 0.6;
        }

        .stat-info h3 {
            color: var(--medium-gray);
            font-size: 1.1rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--soft-blue-700), var(--soft-blue-600));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.2;
        }

        .stat-icon {
            background: var(--soft-blue-50);
            padding: 20px;
            border-radius: 24px;
            border: 1px solid var(--soft-blue-200);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.08);
            transition: all 0.3s ease;
        }

        .stat-card:hover .stat-icon {
            transform: rotate(5deg) scale(1.05);
            background: var(--pure-white);
            border-color: var(--soft-blue-300);
        }

        .stat-icon i {
            font-size: 32px;
            color: var(--soft-blue-500);
            transition: all 0.3s ease;
        }

        .stat-card:hover .stat-icon i {
            color: var(--soft-blue-700);
        }

        /* Chart Card */
        .chart-card {
            background: var(--pure-white);
            border: 1px solid var(--soft-blue-200);
            border-radius: 32px;
            padding: 24px;
            margin-bottom: 32px;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
        }

        .chart-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
            border-color: var(--soft-blue-300);
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .chart-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--soft-blue-700);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .chart-title i {
            font-size: 24px;
            color: var(--soft-blue-500);
        }

        .chart-tabs {
            display: flex;
            gap: 12px;
            background: var(--soft-blue-50);
            padding: 6px;
            border-radius: 50px;
        }

        .chart-tab {
            padding: 8px 24px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            background: transparent;
            color: var(--medium-gray);
        }

        .chart-tab.active {
            background: linear-gradient(135deg, var(--soft-blue-500), var(--soft-blue-600));
            color: white;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .chart-tab:hover:not(.active) {
            background: var(--soft-blue-100);
            color: var(--soft-blue-700);
        }

        .chart-container {
            position: relative;
            height: 400px;
            width: 100%;
        }

        canvas {
            max-height: 400px;
            width: 100%;
        }

        /* Feature Cards */
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
        }

        .feature-card {
            background: var(--pure-white);
            border: 1px solid var(--soft-blue-200);
            border-radius: 32px;
            padding: 40px 24px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            text-align: center;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .feature-card::before {
            content: '';
            position: absolute;
            bottom: -50%;
            left: -20%;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, var(--soft-blue-100) 0%, transparent 70%);
            border-radius: 50%;
            transition: all 0.5s ease;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            background: linear-gradient(145deg, #ffffff, var(--soft-blue-50));
            border-color: var(--soft-blue-400);
            box-shadow: var(--shadow-lg);
        }

        .feature-card:hover::before {
            transform: scale(2);
            opacity: 0.3;
        }

        .feature-icon {
            background: linear-gradient(135deg, var(--soft-blue-50), var(--soft-blue-100));
            width: 100px;
            height: 100px;
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            border: 1px solid var(--soft-blue-200);
            box-shadow: 0 8px 16px rgba(59, 130, 246, 0.1);
            transition: all 0.3s ease;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(5deg);
            background: var(--pure-white);
            border-color: var(--soft-blue-300);
        }

        .feature-icon i {
            font-size: 48px;
            color: var(--soft-blue-500);
            transition: all 0.3s ease;
        }

        .feature-card:hover .feature-icon i {
            color: var(--soft-blue-700);
        }

        .feature-card h3 {
            color: var(--soft-blue-700);
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 16px;
        }

        .feature-link {
            color: var(--soft-blue-600);
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            padding: 8px 20px;
            border-radius: 50px;
            background: var(--soft-blue-50);
        }

        .feature-card:hover .feature-link {
            background: var(--soft-blue-500);
            color: white;
            transform: translateX(4px);
        }

        .feature-link i {
            transition: transform 0.3s ease;
        }

        .feature-card:hover .feature-link i {
            transform: translateX(4px);
        }

        /* Video Card */
        .video-card {
            background: var(--pure-white);
            border: 1px solid var(--soft-blue-200);
            border-radius: 32px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: var(--shadow-sm);
            margin-bottom: 32px;
        }

        .video-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
            border-color: var(--soft-blue-300);
        }

        .video-header {
            background: linear-gradient(135deg, var(--soft-blue-50), var(--soft-blue-100));
            padding: 20px 24px;
            border-bottom: 1px solid var(--soft-blue-200);
        }

        .video-header h3 {
            color: var(--soft-blue-700);
            font-size: 1.3rem;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .video-header h3 i {
            font-size: 28px;
            color: var(--soft-blue-500);
        }

        .video-container {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
            background-color: #000;
        }

        .video-container video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .video-controls {
            background: linear-gradient(135deg, var(--soft-blue-600), var(--soft-blue-500));
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .control-btn {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            padding: 8px 12px;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .control-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.05);
        }

        .volume-slider {
            width: 100px;
            height: 4px;
            -webkit-appearance: none;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 5px;
            outline: none;
        }

        .volume-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: white;
            cursor: pointer;
        }

        .time-display {
            color: white;
            font-size: 13px;
            font-family: monospace;
        }

        /* Table Styles */
        #tabelBarangContainer {
            transform-origin: top;
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        table {
            border-collapse: separate;
            border-spacing: 0;
        }

        table thead th {
            position: sticky;
            top: 0;
            background-color: var(--soft-blue-50);
            z-index: 10;
        }

        tbody tr:hover {
            background-color: var(--soft-blue-50);
            transition: background-color 0.2s ease;
        }

        /* Alert Styles */
        .alert {
            position: fixed;
            top: 24px;
            right: 24px;
            z-index: 50;
            padding: 16px 24px;
            border-radius: 20px;
            background: white;
            box-shadow: var(--shadow-lg);
            border-left: 4px solid var(--soft-blue-500);
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .feature-grid {
                grid-template-columns: 1fr;
            }
            
            .stat-number {
                font-size: 2rem;
            }

            .video-controls {
                flex-direction: column;
                align-items: stretch;
            }

            .control-btn {
                justify-content: center;
            }

            .chart-container {
                height: 300px;
            }

            .chart-tab {
                padding: 6px 16px;
                font-size: 12px;
            }
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--soft-blue-50);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--soft-blue-300);
            border-radius: 20px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--soft-blue-400);
        }
    </style>
</head>

<body class="bg-off-white">
    <!-- Mobile Menu Button -->
    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
        type="button"
        class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-blue-600 rounded-lg sm:hidden hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-200">
        <span class="sr-only">Open sidebar</span>
        <i class="fas fa-bars text-2xl"></i>
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
    <div class="sm:ml-64 p-8">
        <!-- Page Header -->
        <div class="page-header rounded-[32px] p-8 mb-8">
            <div class="relative z-10">
                <div class="flex items-center gap-2 text-blue-100 mb-2">
                    <i class="fas fa-home text-sm"></i>
                    <span class="text-sm font-medium">Pages / Dashboard</span>
                </div>
                <h1 class="text-3xl font-bold text-white">Dashboard Overview</h1>
                <p class="text-blue-100 mt-2">Welcome back, {{ auth()->user()->name }}!</p>
            </div>
        </div>

        <!-- Welcome Card -->
        <div class="welcome-card p-8 mb-8">
            <div class="flex flex-col lg:flex-row items-center justify-between relative z-10">
                <div class="flex-1">
                    <h1 class="welcome-title text-4xl font-bold mb-4">Welcome, {{ auth()->user()->name }}! </h1>
                    <p class="text-gray-600 text-lg mb-6 max-w-2xl">
                        E-Bike adalah aplikasi yang dirancang untuk merampingkan proses manajemen inventaris, 
                        mulai dari pencatatan hingga pembaruan stok barang dengan tampilan yang modern dan mudah digunakan.
                    </p>
                    @if($userRole === 'admin' || $userRole === 'petugas')
                    <button id="lihatBarangBtn" class="btn-explore inline-flex items-center gap-2">
                        <span>Lihat Semua Barang</span>
                        <i class="fas fa-chevron-down" id="arrowIcon"></i>
                    </button>
                    @endif
                </div>
                <div class="flex-shrink-0 mt-6 lg:mt-0">
                    <div class="w-48 h-48 bg-blue-100 rounded-full flex items-center justify-center shadow-xl">
                        <i class="fas fa-bicycle text-7xl text-blue-500"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Card - Statistik Peminjaman -->
        <div class="chart-card">
            <div class="chart-header">
                <div class="chart-title">
                    <i class="fas fa-chart-line"></i>
                    <span>Statistik Peminjaman</span>
                </div>
                <div class="chart-tabs">
                    <button class="chart-tab active" data-period="weekly">
                        <i class="fas fa-calendar-week mr-1"></i> Mingguan
                    </button>
                    <button class="chart-tab" data-period="monthly">
                        <i class="fas fa-calendar-alt mr-1"></i> Bulanan
                    </button>
                </div>
            </div>
            <div class="chart-container">
                <canvas id="loanChart"></canvas>
            </div>
        </div>

        <!-- Video Card - SEPEDA LISTRIK PROMO -->
        <div class="video-card">
            <div class="video-header">
                <h3>
                    <i class="fas fa-video"></i>
                    Promo Sepeda Listrik Terbaru!
                </h3>
                <p class="text-gray-500 text-sm mt-2">Sepeda listrik dengan teknologi terkini, hemat energi, dan ramah lingkungan</p>
            </div>
            <div class="video-container">
                <video id="promoVideo" poster="{{ asset('video/poster.jpg') ?? '' }}">
                    <source src="{{ asset('video/sepeda listrik2.mp4') }}" type="video/mp4">
                    Browser Anda tidak mendukung tag video.
                </video>
            </div>
            <div class="video-controls">
                <button class="control-btn" id="playPauseBtn">
                    <i class="fas fa-play"></i> Play/Pause
                </button>
                <button class="control-btn" id="muteBtn">
                    <i class="fas fa-volume-up"></i> Mute
                </button>
                <input type="range" id="volumeSlider" class="volume-slider" min="0" max="1" step="0.1" value="1">
                <span class="time-display" id="timeDisplay">00:00 / 00:00</span>
                <button class="control-btn" id="fullscreenBtn">
                    <i class="fas fa-expand"></i> 
                </button>
            </div>
        </div>

        <!-- Stats Cards Grid -->
        <div class="stats-grid">
            @if($userRole === 'admin' || $userRole === 'petugas')
            <div class="stat-card">
                <div class="stat-info">
                    <h3><i class="fas fa-boxes mr-2 text-blue-500"></i>Total Inventaris</h3>
                    <div class="stat-number">{{ $totalItems }}</div>
                    <p class="text-sm text-blue-400 mt-2"><i class="fas fa-arrow-up text-green-500"></i> Semua barang</p>
                </div>
                <div class="stat-icon"><i class="fas fa-cube"></i></div>
            </div>
            @endif
            <div class="stat-card">
                <div class="stat-info">
                    <h3><i class="fas fa-hand-holding-heart mr-2 text-blue-500"></i>Sedang Dipinjam</h3>
                    <div class="stat-number">{{ $borrowItems }}</div>
                    <p class="text-sm text-blue-400 mt-2"><i class="fas fa-clock text-yellow-500"></i> Sedang digunakan</p>
                </div>
                <div class="stat-icon"><i class="fas fa-clock"></i></div>
            </div>
            <div class="stat-card">
                <div class="stat-info">
                    <h3><i class="fas fa-check-circle mr-2 text-blue-500"></i>Sudah Dikembalikan</h3>
                    <div class="stat-number">{{ $returnItems }}</div>
                    <p class="text-sm text-blue-400 mt-2"><i class="fas fa-check text-green-500"></i> Selesai</p>
                </div>
                <div class="stat-icon"><i class="fas fa-check-double"></i></div>
            </div>
        </div>

        <!-- Container for Tabel Barang (khusus admin & petugas) -->
        @if($userRole === 'admin' || $userRole === 'petugas')
        <div id="tabelBarangContainer" class="hidden mt-6 transition-all duration-300 ease-in-out">
            <div class="bg-white rounded-3xl border border-blue-200 shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-50 to-white px-6 py-4 border-b border-blue-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-blue-700">
                            <i class="fas fa-boxes mr-2"></i>Daftar Semua Barang
                        </h3>
                        <span class="text-sm text-blue-500">Total: {{ $items->count() }} barang</span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-blue-700 uppercase bg-blue-50">
                            <tr>
                                <th scope="col" class="px-6 py-4">No</th>
                                <th scope="col" class="px-6 py-4 font-bold">Nama Barang</th>
                                <th scope="col" class="px-6 py-4">Deskripsi</th>
                                <th scope="col" class="px-6 py-4">Stok</th>
                                <th scope="col" class="px-6 py-4">Kondisi</th>
                                <th scope="col" class="px-6 py-4">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $index => $item)
                            <tr class="bg-white border-b border-blue-100 hover:bg-blue-50 transition-colors">
                                <td class="px-6 py-4 font-medium">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 font-medium text-blue-700">{{ $item->name }}</td>
                                <td class="px-6 py-4">{{ Str::limit($item->description, 50) }}</td>
                                <td class="px-6 py-4">
                                    @if($item->stock > 5)
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">{{ $item->stock }}</span>
                                    @elseif($item->stock > 0)
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">{{ $item->stock }}</span>
                                    @else
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">{{ $item->stock }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($item->kondisi === 'baik')
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Baik</span>
                                    @elseif($item->kondisi === 'perbaikan')
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">Perbaikan</span>
                                    @else
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">Rusak</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($item->status === 'tersedia')
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700"><i class="fas fa-check-circle mr-1"></i>Tersedia</span>
                                    @else
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700"><i class="fas fa-times-circle mr-1"></i>Dipinjam</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-400 italic">Belum ada barang tersedia</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        <!-- Feature Cards -->
        <div class="feature-grid">
            <div class="feature-card group">
                <div class="feature-icon"><i class="fas fa-hand-holding-heart"></i></div>
                <h3>Peminjaman</h3>
                <p class="text-gray-500 mb-6">Kelola proses peminjaman barang dengan mudah dan cepat</p>
                <a href="{{ route('pinjamBarang') }}" class="feature-link"><span>Klik Disini</span><i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="feature-card group">
                <div class="feature-icon"><i class="fas fa-rotate-left"></i></div>
                <h3>Pengembalian</h3>
                <p class="text-gray-500 mb-6">Proses pengembalian barang dengan sistem yang terintegrasi</p>
                <a href="{{ route('pinjamBarang') }}" class="feature-link"><span>Klik Disini</span><i class="fas fa-arrow-right"></i></a>
            </div>
        </div>

        <!-- Success Alert -->
        <div class="alert" id="demoAlert">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center"><i class="fas fa-check text-blue-500"></i></div>
                <div><p class="font-semibold text-gray-800">Dashboard Dimuat!</p><p class="text-sm text-gray-600">Selamat datang di dashboard E-Bike.</p></div>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data untuk grafik (contoh data - nanti bisa diambil dari database)
            // Data Mingguan (Senin - Minggu)
            const weeklyData = {
                labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                borrowed: [12, 19, 15, 17, 25, 22, 18],
                returned: [10, 15, 12, 14, 20, 18, 15]
            };
            
            // Data Bulanan (Januari - Desember)
            const monthlyData = {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
                borrowed: [45, 52, 48, 60, 75, 82, 78, 85, 72, 68, 55, 50],
                returned: [40, 48, 42, 55, 68, 75, 70, 78, 65, 60, 48, 42]
            };
            
            // Inisialisasi Chart
            const ctx = document.getElementById('loanChart').getContext('2d');
            let currentChart = null;
            
            function createChart(data) {
                if (currentChart) {
                    currentChart.destroy();
                }
                
                currentChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [
                            {
                                label: 'Dipinjam',
                                data: data.borrowed,
                                backgroundColor: 'rgba(59, 130, 246, 0.7)',
                                borderColor: '#3b82f6',
                                borderWidth: 2,
                                borderRadius: 8,
                                barPercentage: 0.65,
                                categoryPercentage: 0.8
                            },
                            {
                                label: 'Dikembalikan',
                                data: data.returned,
                                backgroundColor: 'rgba(16, 185, 129, 0.7)',
                                borderColor: '#10b981',
                                borderWidth: 2,
                                borderRadius: 8,
                                barPercentage: 0.65,
                                categoryPercentage: 0.8
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    usePointStyle: true,
                                    boxWidth: 10,
                                    font: {
                                        family: 'Inter',
                                        size: 12
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                titleFont: {
                                    family: 'Inter',
                                    size: 13
                                },
                                bodyFont: {
                                    family: 'Inter',
                                    size: 12
                                },
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        let value = context.raw;
                                        return `${label}: ${value} peminjaman`;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(59, 130, 246, 0.1)',
                                    drawBorder: true
                                },
                                title: {
                                    display: true,
                                    text: 'Jumlah Peminjaman',
                                    font: {
                                        family: 'Inter',
                                        size: 12,
                                        weight: '500'
                                    }
                                },
                                ticks: {
                                    stepSize: 10,
                                    callback: function(value) {
                                        return value + ' kali';
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                title: {
                                    display: true,
                                    text: 'Periode',
                                    font: {
                                        family: 'Inter',
                                        size: 12,
                                        weight: '500'
                                    }
                                },
                                ticks: {
                                    font: {
                                        family: 'Inter',
                                        size: 11
                                    }
                                }
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },
                        animation: {
                            duration: 1000,
                            easing: 'easeInOutQuart'
                        }
                    }
                });
            }
            
            // Load chart awal (Mingguan)
            createChart(weeklyData);
            
            // Tab切换逻辑
            const tabs = document.querySelectorAll('.chart-tab');
            let activePeriod = 'weekly';
            
            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const period = this.getAttribute('data-period');
                    
                    // Update active tab
                    tabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Update chart berdasarkan period
                    if (period === 'weekly') {
                        createChart(weeklyData);
                        activePeriod = 'weekly';
                    } else if (period === 'monthly') {
                        createChart(monthlyData);
                        activePeriod = 'monthly';
                    }
                });
            });
            
            // Video player functionality
            const video = document.getElementById('promoVideo');
            const playPauseBtn = document.getElementById('playPauseBtn');
            const muteBtn = document.getElementById('muteBtn');
            const volumeSlider = document.getElementById('volumeSlider');
            const timeDisplay = document.getElementById('timeDisplay');
            const fullscreenBtn = document.getElementById('fullscreenBtn');

            if (video) {
                // Format time helper
                function formatTime(seconds) {
                    if (isNaN(seconds)) return '00:00';
                    const mins = Math.floor(seconds / 60);
                    const secs = Math.floor(seconds % 60);
                    return `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
                }

                // Update time display
                function updateTimeDisplay() {
                    const current = formatTime(video.currentTime);
                    const duration = formatTime(video.duration);
                    timeDisplay.textContent = `${current} / ${duration}`;
                }

                // Play/Pause button
                playPauseBtn.addEventListener('click', function() {
                    if (video.paused) {
                        video.play();
                        this.innerHTML = '<i class="fas fa-pause"></i> Play/Pause';
                    } else {
                        video.pause();
                        this.innerHTML = '<i class="fas fa-play"></i> Play/Pause';
                    }
                });

                // Update play/pause icon when video ends
                video.addEventListener('ended', function() {
                    playPauseBtn.innerHTML = '<i class="fas fa-play"></i> Play/Pause';
                });

                // Mute button
                muteBtn.addEventListener('click', function() {
                    video.muted = !video.muted;
                    if (video.muted) {
                        this.innerHTML = '<i class="fas fa-volume-mute"></i> Unmute';
                        volumeSlider.value = 0;
                    } else {
                        this.innerHTML = '<i class="fas fa-volume-up"></i> Mute';
                        volumeSlider.value = video.volume;
                    }
                });

                // Volume slider
                volumeSlider.addEventListener('input', function() {
                    video.volume = this.value;
                    video.muted = false;
                    muteBtn.innerHTML = '<i class="fas fa-volume-up"></i> Mute';
                });

                // Time update
                video.addEventListener('timeupdate', updateTimeDisplay);
                video.addEventListener('loadedmetadata', updateTimeDisplay);

                // Fullscreen
                fullscreenBtn.addEventListener('click', function() {
                    if (video.requestFullscreen) {
                        video.requestFullscreen();
                    } else if (video.webkitRequestFullscreen) {
                        video.webkitRequestFullscreen();
                    } else if (video.msRequestFullscreen) {
                        video.msRequestFullscreen();
                    }
                });
            }

            // Toggle table visibility
            const lihatBarangBtn = document.getElementById('lihatBarangBtn');
            const tabelContainer = document.getElementById('tabelBarangContainer');
            let tabelVisible = false;
            
            if (lihatBarangBtn && tabelContainer) {
                lihatBarangBtn.addEventListener('click', function() {
                    tabelVisible = !tabelVisible;
                    if (tabelVisible) {
                        tabelContainer.classList.remove('hidden');
                        this.innerHTML = '<span>Sembunyikan Barang</span> <i class="fas fa-chevron-up" id="arrowIcon"></i>';
                    } else {
                        tabelContainer.classList.add('hidden');
                        this.innerHTML = '<span>Lihat Semua Barang</span> <i class="fas fa-chevron-down" id="arrowIcon"></i>';
                    }
                });
            }
            
            // Auto dismiss alert
            setTimeout(() => {
                const demoAlert = document.getElementById('demoAlert');
                if(demoAlert) {
                    demoAlert.style.animation = 'slideIn 0.3s reverse';
                    setTimeout(() => { if(demoAlert) demoAlert.remove(); }, 300);
                }
            }, 4500);
        });
    </script>
</body>

</html>