<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Felder die massenweise zugewiesen werden können
    protected $fillable = ['category_id', 'name', 'slug', 'description', 'price', 'stock', 'image', 'is_active'];

    // Attribute die als bestimmte Typen gespeichert werden sollen
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    // Ein Produkt gehört zu einer Kategorie
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Ein Produkt kann in vielen Bestellungen vorkommen
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
