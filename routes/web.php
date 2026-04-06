<?php

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// ========== GUEST ROUTES (Belum Login) ==========
Route::middleware('guest')->group(function () {
    Route::get('/auth/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::get('/auth/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/auth/register', [AuthController::class, 'register']);
});

// ========== SEMUA ROUTE YANG MEMERLUKAN AUTH ==========
Route::middleware(['auth'])->group(function () {
    
    // Dashboard & Logout
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // ========== TRANSAKSI PEMINJAMAN (Baru) ==========
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::get('/transactions/{id}/struk', [TransactionController::class, 'struk'])->name('transactions.struk');
    Route::put('/transactions/{id}/cancel', [TransactionController::class, 'cancel'])->name('transactions.cancel');
    
    // ========== PEMINJAMAN (Loan) - untuk sistem peminjaman barang ==========
    Route::get('/loans', [LoanController::class, 'loans'])->name('pinjamBarang');
    Route::post('/items/borrow', [LoanController::class, 'borrow'])->name('items.borrow');
    Route::post('/loans/{loan}/return', [LoanController::class, 'return'])->name('loans.return');
    Route::post('/loans/{loan}/process-return', [LoanController::class, 'processReturn'])->name('loans.processReturn');
    Route::get('/loans/{loan}/struk', [LoanController::class, 'printStruk'])->name('loans.struk');
    Route::get('/pengembalian', [LoanController::class, 'pengembalian'])->name('pengembalian');
    
    // AJAX
    Route::get('/items/all', [ItemController::class, 'allItems'])->name('items.all');
    
    // Logs (semua role)
    Route::get('/logs', [LogController::class, 'index'])->name('logs');
    Route::post('/logs', [LogController::class, 'store'])->name('logs.store');
    Route::put('/logs/{log}', [LogController::class, 'update'])->name('logs.update');
    Route::delete('/logs/{log}', [LogController::class, 'destroy'])->name('logs.delete');
    
    // ========== ITEM MANAGEMENT (Admin & Petugas) ==========
    Route::middleware(['role:admin,petugas'])->group(function () {
        Route::get('/items', [ItemController::class, 'index'])->name('items');
        Route::post('/items', [ItemController::class, 'store'])->name('items.store');
        Route::put('/items/{item}', [ItemController::class, 'update'])->name('items.update');
        Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('items.delete');
    });
    
    // ========== USER MANAGEMENT (Hanya Admin) ==========
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.delete');
    });
});