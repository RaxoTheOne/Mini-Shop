<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Anzeigen des Warenkorbs
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['product']->price * $item['quantity'];
        }

        return view('cart.index', compact('cart', 'total'));
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