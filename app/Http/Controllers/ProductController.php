<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Anzeigen der Produkte
    public function index(Request $request)
    {
        $query = Product::where('is_active', true)
            ->with('category');

        // Suche durchführen
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        // WICHTIG: Die Query mit Suche verwenden, nicht eine neue erstellen!
        $products = $query->orderBy('created_at', 'desc')->paginate(12)->withQueryString();

        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    // Anzeigen eines Produkts
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->with('category')
            ->firstOrFail();

        return view('products.show', compact('product'));
    }

    // Anzeigen der Produkte einer Kategorie
    public function category(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $query = Product::where('category_id', $category->id)
            ->where('is_active', true)
            ->with('category');

        // Suche auch in Kategorien unterstützen
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(12)->withQueryString();

        $categories = Category::all();

        return view('products.index', compact('products', 'categories', 'category'));
    }
}