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
            $total += $item['price']->price * $item['quantity'];
        }

        return view('cart.index', compact('cart', 'total'));
    }
}
