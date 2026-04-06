<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LoanController extends Controller
{
    public function loans()
    {
        $userRole = auth()->user()->role ?? 'user';
        
        // Jika admin atau petugas, ambil semua peminjaman
        if (in_array($userRole, ['admin', 'petugas'])) {
            $loans = Loan::with(['item', 'user'])
                ->orderBy('created_at', 'desc')
                ->get();
            // Ambil semua user untuk dropdown pilihan peminjam
            $allUsers = User::where('role', 'user')->orderBy('name')->get();
        } else {
            // Jika user biasa, hanya ambil peminjaman miliknya sendiri
            $loans = Loan::with(['item', 'user'])
                ->where('user_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->get();
            $allUsers = collect(); // Empty collection untuk user biasa
        }
        
        $items = Item::where('stock', '>', 0)->get();
        
        return view('pinjamBarang', compact('loans', 'items', 'allUsers'));
    }
    
    public function processReturn(Request $request, $id)
    {
        try {
            // CEK HAK AKSES - HANYA ADMIN DAN PETUGAS
            $userRole = auth()->user()->role;
            if (!in_array($userRole, ['admin', 'petugas'])) {
                return redirect()->route('pinjamBarang')->with('error', 'Anda tidak memiliki izin untuk mengembalikan barang!');
            }
            
            $loan = Loan::findOrFail($id);
            
            // Validate request
            $rules = [
                'condition_return' => 'required|in:baik,rusak_ringan,rusak_berat,hilang',
                'penalty_amount' => 'numeric|min:0',
                'payment_method' => 'required_if:penalty_amount,>0|in:cash,transfer|nullable',
                'payment_proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
            ];
            
            // Hanya required jika kondisi rusak atau hilang
            if (in_array($request->condition_return, ['rusak_ringan', 'rusak_berat', 'hilang'])) {
                $rules['damage_description'] = 'required|string|min:3';
            } else {
                $rules['damage_description'] = 'nullable|string';
            }
            
            $validated = $request->validate($rules);
            
            // Update loan data
            $loan->status = 'returned';
            $loan->return_date = now();
            $loan->condition_return = $request->condition_return;
            $loan->damage_description = $request->damage_description ?? null;
            $loan->penalty_amount = $request->penalty_amount ?? 0;
            $loan->payment_method = $request->payment_method;
            
            // Handle file upload if transfer and penalty > 0
            if ($request->payment_method == 'transfer' && $request->penalty_amount > 0) {
                if ($request->hasFile('payment_proof')) {
                    $file = $request->file('payment_proof');
                    $filename = time() . '_' . $loan->id . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('payment-proofs', $filename, 'public');
                    $loan->payment_proof = $path;
                } else {
                    return redirect()->back()->with('error', 'Bukti transfer wajib diupload untuk pembayaran via transfer!');
                }
            }
            
            // Tambah stok barang jika kondisi baik atau rusak (kecuali hilang)
            if ($request->condition_return !== 'hilang') {
                $loan->item->increment('stock', $loan->amount);
            }
            
            $loan->save();
            
            $message = 'Barang berhasil dikembalikan!';
            if ($loan->penalty_amount > 0) {
                $message .= ' Denda: Rp ' . number_format($loan->penalty_amount, 0, ',', '.');
                if ($request->payment_method == 'transfer') {
                    $message .= ' (Pembayaran via Transfer Bank - Bukti telah diupload)';
                } else {
                    $message .= ' (Pembayaran via Tunai)';
                }
            }
            
            return redirect()->route('pinjamBarang')->with('success', $message);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return redirect()->route('pinjamBarang')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function borrow(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'item_id' => 'required|exists:items,id',
                'amount' => 'required|integer|min:1',
                'user_id' => 'required|exists:users,id',
                'borrow_date' => 'required|date',
                'description' => 'nullable|string'
            ]);
            
            // Cek stok barang
            $item = Item::findOrFail($request->item_id);
            if ($item->stock < $request->amount) {
                return back()->with('error', 'Stok barang tidak mencukupi!');
            }
            
            // Kurangi stok
            $item->decrement('stock', $request->amount);
            
            // Buat peminjaman
            $loan = Loan::create([
                'item_id' => $request->item_id,
                'user_id' => $request->user_id,
                'amount' => $request->amount,
                'borrow_date' => $request->borrow_date,
                'status' => 'borrowed',
                'description' => $request->description,
                'processed_by' => auth()->id()
            ]);
            
            return redirect()->route('pinjamBarang')->with('success', 'Barang berhasil dipinjamkan kepada ' . $loan->user->name);
            
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal meminjamkan barang: ' . $e->getMessage());
        }
    }
    
    public function printStruk($id)
    {
        try {
            $loan = Loan::with(['item', 'user'])->findOrFail($id);
            
            // Pastikan hanya yang berhak yang bisa melihat struk
            $userRole = auth()->user()->role;
            if (!in_array($userRole, ['admin', 'petugas']) && $loan->user_id != auth()->id()) {
                abort(403, 'Unauthorized access');
            }
            
            return view('struk', compact('loan'));
            
        } catch (\Exception $e) {
            return redirect()->route('pinjamBarang')->with('error', 'Gagal menampilkan struk: ' . $e->getMessage());
        }
    }
}