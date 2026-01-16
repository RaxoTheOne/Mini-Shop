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
        $product = Product::where('id', '=', $id, 'and')
            ->where('is_active', '=', true, 'and')
            ->firstOrFail();

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            // Prüfen ob noch genug Lagerbestand vorhanden ist
            if ($cart[$id]['quantity'] >= $product->stock) {
                return redirect()->back()
                    ->with('error', "Produkt ist nicht mehr verfügbar. Verfügbar: {$product->stock} Stück.");
            }
            $cart[$id]['quantity']++;
        } else {
            // Prüfen ob das Produkt überhaupt noch verfügbar ist
            if ($product->stock <= 0) {
                return redirect()->back()
                    ->with('error', 'Dieses Produkt ist derzeit nicht verfügbar.');
            }
            $cart[$id] = [
                'product' => $product,
                'quantity' => 1,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Produkt zum Warenkorb hinzugefügt');
    }

    // Produktmenge im Warenkorb aktualisieren/
    public function update($id, Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
    ]);

    $cart = session()->get('cart', []);

    if (!isset($cart[$id])) {
        return redirect()->route('cart.index')
            ->with('error', 'Produkt nicht im Warenkorb gefunden!');
    }

    $product = $cart[$id]['product'];
    
    // Prüfen ob genug Lagerbestand vorhanden ist
    if ($request->quantity > $product->stock) {
        return redirect()->route('cart.index')
            ->with('error', 'Nicht genug Lagerbestand verfügbar. Verfügbar: ' . $product->stock);
    }

    if ($request->quantity <= 0) {
        unset($cart[$id]);
    } else {
        $cart[$id]['quantity'] = $request->quantity;
    }

    session()->put('cart', $cart);

    return redirect()->route('cart.index')
        ->with('success', 'Menge aktualisiert!');
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