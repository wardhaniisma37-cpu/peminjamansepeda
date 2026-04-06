<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    
    protected $table = 'transactions';
    
    protected $fillable = [
        'invoice_number',
        'user_id',
        'customer_name',
        'total_amount',
        'paid_amount',
        'change_amount',
        'payment_method',
        'status',
    ];
    
    protected $casts = [
        'total_amount' => 'integer',
        'paid_amount' => 'integer',
        'change_amount' => 'integer',
    ];
    
    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    // Relasi ke detail transaksi
    public function details()
    {
        return $this->hasMany(TransactionDetail::class, 'transaction_id');
    }
    
    // Generate invoice number otomatis
    public static function generateInvoiceNumber()
    {
        $latest = self::orderBy('id', 'desc')->first();
        if ($latest && $latest->invoice_number) {
            $number = intval(substr($latest->invoice_number, -6)) + 1;
        } else {
            $number = 1;
        }
        return 'INV-' . date('Ymd') . '-' . str_pad($number, 6, '0', STR_PAD_LEFT);
    }
}