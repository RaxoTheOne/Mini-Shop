<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Felder die massenweise zugewiesen werden können
    protected $fillable = ['name', 'slug', 'description'];

    // Eine Kategorie hat viele Produkte
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
