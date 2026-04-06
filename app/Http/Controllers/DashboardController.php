<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Pastikan pengguna sudah login sebelum mencoba mendapatkan data pengguna
        if (Auth::check()) {
            $userRole = Auth::user()->role; // Ambil role user yang sedang login
            
            // Inisialisasi variabel dengan nilai default
            $items = collect(); // collection kosong sebagai default
            $borrowItems = 0;
            $returnItems = 0;
            $totalItems = 0;
            
            if ($userRole === 'admin') {
                // Admin: melihat semua item dan semua peminjaman
                $items = Item::all();
                $totalItems = Item::count();
                $borrowItems = Loan::where('status', 'borrowed')->count();
                $returnItems = Loan::where('status', 'returned')->count();
            } elseif ($userRole === 'petugas') {
                // Petugas: memiliki akses yang sama seperti admin untuk inventaris
                $items = Item::all();
                $totalItems = Item::count();
                $borrowItems = Loan::where('status', 'borrowed')->count();
                $returnItems = Loan::where('status', 'returned')->count();
            } elseif ($userRole === 'user') {
                // User biasa: hanya melihat peminjaman mereka sendiri
                $items = Loan::where('user_id', Auth::id())->with('item')->get();
                $borrowItems = Loan::where('user_id', Auth::id())->where('status', 'borrowed')->count();
                $returnItems = Loan::where('user_id', Auth::id())->where('status', 'returned')->count();
                $totalItems = $items->count();
            }

            return view('dashboard', compact('userRole', 'items', 'borrowItems', 'returnItems', 'totalItems'));
        }

        // Jika pengguna belum login, arahkan ke halaman login atau tampilkan pesan
        return redirect()->route('login')->withErrors(['error' => 'You must be logged in to access this page.']);
    }

    public function dashboardData(Request $request)
    {
        $user = $request->user();
        
        // Cek role user
        $userRole = $user->role;

        // Admin atau Petugas dashboard data (sama karena petugas juga bisa melihat semua data)
        if ($userRole === 'admin' || $userRole === 'petugas') {
            return response()->json([
                'success' => true,
                'data' => [
                    'total_item' => Item::count(),
                    'item_dipinjam' => Loan::where('status', 'borrowed')->count(),
                    'item_dikembalikan' => Loan::where('status', 'returned')->count(),
                ]
            ]);
        } 

        // Non-admin (user) dashboard data
        return response()->json([
            'success' => true,
            'data' => [
                'item_dipinjam' => Loan::where('user_id', $user->id)->where('status', 'borrowed')->count(),
                'item_dikembalikan' => Loan::where('user_id', $user->id)->where('status', 'returned')->count(),
            ]
        ]);
    }
    
    // Method untuk mengambil semua items (untuk AJAX)
    public function allItems()
    {
        $userRole = Auth::user()->role;
        
        if ($userRole === 'admin' || $userRole === 'petugas') {
            $items = Item::all();
            return response()->json([
                'success' => true,
                'data' => $items
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized access'
        ], 403);
    }
    
    // Method untuk mengambil detail item tertentu
    public function getItem($id)
    {
        $userRole = Auth::user()->role;
        
        if ($userRole === 'admin' || $userRole === 'petugas') {
            $item = Item::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $item
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized access'
        ], 403);
    }
    
    // Method untuk statistik dashboard (untuk chart)
    public function getStatistics()
    {
        $userRole = Auth::user()->role;
        
        if ($userRole === 'admin' || $userRole === 'petugas') {
            // Data untuk chart peminjaman per bulan
            $loansPerMonth = Loan::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')
                ->orderBy('month')
                ->get();
            
            // Data untuk chart status item
            $itemsByStatus = Item::selectRaw('status, COUNT(*) as total')
                ->groupBy('status')
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => [
                    'loans_per_month' => $loansPerMonth,
                    'items_by_status' => $itemsByStatus,
                ]
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized access'
        ], 403);
    }
}