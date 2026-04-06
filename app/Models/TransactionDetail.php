<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;
    
    protected $table = 'transaction_details';
    
    protected $fillable = [
        'transaction_id',
        'item_id',
        'quantity',
        'price',
        'subtotal',
    ];
    
    protected $casts = [
        'quantity' => 'integer',
        'price' => 'integer',
        'subtotal' => 'integer',
    ];
    
    // Relasi ke Transaction
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }
    
    // Relasi ke Item
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}