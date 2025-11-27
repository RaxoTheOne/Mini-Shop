<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Anzeigen des Bestellformulares
    public function create()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Dein Warenkorb ist leer!');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['product']->price * $item['quantity'];
        }

        return view('orders.create', compact('cart', 'total'));
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Dein Warenkorb ist leer!');
        }

        // Validierung der Bestelldaten
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:255',
            'customer_address' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        // Gesamtbetrag berechnen
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['product']->price * $item['quantity'];
        }

        // Bestellung erstellen
        $order = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'] ?? null,
            'customer_address' => $validated['customer_address'],
            'status' => 'pending',
            'total_amount' => $total,
            'notes' => $validated['notes'] ?? null,
        ]);

        // Bestellpositionen erstellen
        foreach ($cart as $id => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product']->id,
                'product_name' => $item['product']->name,
                'price' => $item['product']->price,
                'quantity' => $item['quantity'],
                'subtotal' => $item['product']->price * $item['quantity'],
            ]);
        }

        // Warenkorb leeren
        session()->forget('cart');

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Bestellung erfolgreich aufgegeben!');
    }

    // Anzeigen einer Bestellung
    public function show($id)
    {
        $order = Order::with('orderItems.product')->findOrFail($id);

        return view('orders.show', compact('order'));
    }
}
