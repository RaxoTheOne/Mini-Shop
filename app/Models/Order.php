<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Felder die massenweise zugewiesen werden können
    protected $fillable = [
        'order_number', 
        'customer_name', 
        'customer_email', 
        'customer_phone', 
        'customer_address', 
        'status', 
        'total_amount', 
        'notes',
    ];

    // Attribute die als bestimmte Typen gespeichert werden sollen
    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:2',
        ];
    }

    // Ein Bestellung hat viele Bestellpositionen
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function generateOrderNumber(): string
    {
        $prefix = 'ORD-';
        $date = now()->format('Ymd');
        $lastOrder = self::where('order_number', 'like', $prefix . $date . '%')
            ->orderBy('order_number', 'desc')
            ->first();

        if ($lastOrder) {
            $lastNumber = (int) substr($lastOrder->order_number, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . $date . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}
