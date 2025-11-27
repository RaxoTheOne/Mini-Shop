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

    // Produkt zum Warenkorb hinzufügen
    public function add($id)
    {
        $product = Product::where('id', $id)
            ->where('is_active', true)
            ->firstOrFail();

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'product' => $product,
                'quantity' => 1,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Produkt zum Warenkorb hinzugefügt');
    }

    // Produkt aus dem Warenkorb entfernen
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Produkt aus dem Warenkorb entfernt!');
    }

    // Warenkorb leeren
    public function clear()
    {
        session()->forget('cart');

        return redirect()->route('cart.index')->with('success', 'Warenkorb geleert!');
    }
}
