<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    // Felder die massenweise zugewiesen werden können
    protected $fillable = [
        'order_id', 
        'product_id', 
        'product_name', 
        'price', 
        'quantity', 
        'subtotal'
    ];

    // Attribute die als bestimmte Typen gespeichert werden sollen
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'subtotal' => 'decimal:2',
        ];
    }

    // Ein Bestellposition gehört zu einer Bestellung
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Ein Bestellposition gehört zu einem Produkt
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
