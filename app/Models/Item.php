<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    
    protected $table = 'items';
    
    protected $fillable = [
        'name',
        'stock',
        'price',
        'description',
        'image'
    ];
    
    protected $casts = [
        'stock' => 'integer',
        'price' => 'integer'
    ];
    
    // Relasi ke Loan
    public function loans()
    {
        return $this->hasMany(Loan::class, 'item_id');
    }
    
    // Cek apakah stok tersedia
    public function hasStock($quantity)
    {
        return $this->stock >= $quantity;
    }
    
    // Kurangi stok
    public function decreaseStock($quantity)
    {
        $this->stock -= $quantity;
        $this->save();
        return $this;
    }
    
    // Tambah stok (TAMBAHKAN METHOD INI)
    public function increaseStock($quantity)
    {
        $this->stock += $quantity;
        $this->save();
        return $this;
    }
    
    // Update stok langsung
    public function updateStock($quantity)
    {
        $this->stock = $quantity;
        $this->save();
        return $this;
    }
}