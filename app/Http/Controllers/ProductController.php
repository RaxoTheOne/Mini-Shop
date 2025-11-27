<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Anzeigen der Produkte
    public function index()
    {
        $products = Product::where('is_active', true)
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $categories = Category::all();
        
        return view('products.index', compact('products', 'categories'));
    }
}
