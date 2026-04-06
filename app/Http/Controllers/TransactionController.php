<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // HAPUS method __construct() dengan middleware
    
    /**
     * Menampilkan halaman transaksi
     */
    public function index()
    {
        // Ambil semua transaksi dengan relasi
        $transactions = Transaction::with(['user', 'details.item'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Ambil semua item yang tersedia (stok > 0)
        $items = Item::where('stock', '>', 0)
            ->orderBy('name')
            ->get();
        
        // Untuk kompatibilitas dengan view yang menggunakan $loans
        $loans = collect();
        
        return view('transaction', compact('transactions', 'items', 'loans'));
    }
    
    /**
     * Proses transaksi penjualan/peminjaman
     */
    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'customer_name' => 'nullable|string|max:255',
            'payment_method' => 'required|in:cash,qris,transfer',
            'paid_amount' => 'required|integer|min:0',
        ]);
        
        DB::beginTransaction();
        
        try {
            $totalAmount = 0;
            $transactionDetails = [];
            
            // Hitung total dan cek stok
            foreach ($request->items as $itemData) {
                $item = Item::findOrFail($itemData['item_id']);
                
                if ($item->stock < $itemData['quantity']) {
                    throw new \Exception("Stok {$item->name} tidak mencukupi! Tersedia: {$item->stock}");
                }
                
                $subtotal = $item->price * $itemData['quantity'];
                $totalAmount += $subtotal;
                
                $transactionDetails[] = [
                    'item' => $item,
                    'item_id' => $item->id,
                    'quantity' => $itemData['quantity'],
                    'price' => $item->price,
                    'subtotal' => $subtotal,
                ];
            }
            
            // Hitung kembalian
            $changeAmount = $request->paid_amount - $totalAmount;
            
            if ($changeAmount < 0) {
                throw new \Exception("Uang yang dibayarkan kurang dari total belanja! Kurang: Rp " . number_format(abs($changeAmount), 0, ',', '.'));
            }
            
            // Buat transaksi
            $transaction = Transaction::create([
                'invoice_number' => Transaction::generateInvoiceNumber(),
                'user_id' => Auth::id(),
                'customer_name' => $request->customer_name ?? 'Umum',
                'total_amount' => $totalAmount,
                'paid_amount' => $request->paid_amount,
                'change_amount' => $changeAmount,
                'payment_method' => $request->payment_method,
                'status' => 'completed',
            ]);
            
            // Buat detail transaksi dan kurangi stok
            foreach ($transactionDetails as $detail) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'item_id' => $detail['item_id'],
                    'quantity' => $detail['quantity'],
                    'price' => $detail['price'],
                    'subtotal' => $detail['subtotal'],
                ]);
                
                // Kurangi stok
                $detail['item']->stock -= $detail['quantity'];
                $detail['item']->save();
            }
            
            DB::commit();
            
            return redirect()->route('transactions')
                ->with('success', "Transaksi berhasil! Invoice: {$transaction->invoice_number} | Kembalian: Rp " . number_format($changeAmount, 0, ',', '.'));
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal memproses transaksi: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    /**
     * Menampilkan detail transaksi (API)
     */
    public function show($id)
    {
        $transaction = Transaction::with(['user', 'details.item'])->findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $transaction
        ]);
    }
    
    /**
     * Cetak struk transaksi
     */
    public function struk($id)
    {
        $transaction = Transaction::with(['user', 'details.item'])->findOrFail($id);
        return view('struk_transaksi', compact('transaction'));
    }
    
    /**
     * Batalkan transaksi
     */
    public function cancel($id)
    {
        DB::beginTransaction();
        
        try {
            $transaction = Transaction::with('details')->findOrFail($id);
            
            if ($transaction->status === 'cancelled') {
                return redirect()->back()->with('error', 'Transaksi sudah dibatalkan sebelumnya!');
            }
            
            // Kembalikan stok barang
            foreach ($transaction->details as $detail) {
                $item = Item::findOrFail($detail->item_id);
                $item->stock += $detail->quantity;
                $item->save();
            }
            
            // Update status transaksi
            $transaction->status = 'cancelled';
            $transaction->save();
            
            DB::commit();
            
            return redirect()->route('transactions')
                ->with('success', "Transaksi {$transaction->invoice_number} berhasil dibatalkan!");
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal membatalkan transaksi: ' . $e->getMessage());
        }
    }
    
    /**
     * Hapus transaksi (hard delete)
     */
    public function destroy($id)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Hanya admin yang dapat menghapus transaksi!');
        }
        
        DB::beginTransaction();
        
        try {
            $transaction = Transaction::with('details')->findOrFail($id);
            
            // Jika transaksi belum dibatalkan, kembalikan stok dulu
            if ($transaction->status !== 'cancelled') {
                foreach ($transaction->details as $detail) {
                    $item = Item::findOrFail($detail->item_id);
                    $item->stock += $detail->quantity;
                    $item->save();
                }
            }
            
            // Hapus detail transaksi
            TransactionDetail::where('transaction_id', $id)->delete();
            
            // Hapus transaksi
            $transaction->delete();
            
            DB::commit();
            
            return redirect()->route('transactions')
                ->with('success', 'Transaksi berhasil dihapus!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }
}