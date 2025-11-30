@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-semibold mb-6">Warenkorb</h1>

    @if(empty($cart))
        <div class="bg-white shadow p-6 rounded text-center">
            <p class="text-gray-500 mb-4">Dein Warenkorb ist leer.</p>
            <a href="{{ route('products.index') }}"
                class="inline-block bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                Weiter einkaufen
            </a>
        </div>
    @else
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produkt</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Preis</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Menge</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Zwischensumme</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aktion</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($cart as $id => $item)
                            <tr>
                                <td class="px-6 py-4">
                                    <a href="{{ route('products.show', $item['product']->slug) }}"
                                        class="text-indigo-600 hover:text-indigo-800 font-medium">
                                        {{ $item['product']->name }}
                                    </a>
                                    @if($item['product']->stock < $item['quantity'])
                                        <p class="text-red-500 text-xs mt-1">
                                            ⚠️ Nur {{ $item['product']->stock }} verfügbar
                                        </p>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    {{ number_format($item['product']->price, 2, ',', '.') }} €
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        @if($item['quantity'] > 1)
                                            <form action="{{ route('cart.update', $id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="quantity" value="{{ $item['quantity'] - 1 }}">
                                                <button type="submit"
                                                    class="w-8 h-8 flex items-center justify-center bg-gray-200 hover:bg-gray-300 rounded text-gray-700 font-bold">
                                                    −
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('cart.remove', $id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="w-8 h-8 flex items-center justify-center bg-red-200 hover:bg-red-300 rounded text-red-700 font-bold">
                                                    −
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <form action="{{ route('cart.update', $id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" 
                                                name="quantity" 
                                                value="{{ $item['quantity'] }}" 
                                                min="1" 
                                                max="{{ $item['product']->stock }}"
                                                class="w-16 text-center border border-gray-300 rounded px-2 py-1"
                                                onchange="this.form.submit()">
                                        </form>
                                        
                                        <form action="{{ route('cart.update', $id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="quantity" value="{{ min($item['product']->stock, $item['quantity'] + 1) }}">
                                            <button type="submit"
                                                class="w-8 h-8 flex items-center justify-center bg-gray-200 hover:bg-gray-300 rounded text-gray-700 font-bold"
                                                @if($item['quantity'] >= $item['product']->stock) disabled @endif>
                                                +
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-semibold">
                                    {{ number_format($item['product']->price * $item['quantity'], 2, ',', '.') }} €
                                </td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('cart.remove', $id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                            Entfernen
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="bg-gray-50 px-6 py-4 flex justify-between items-center">
                <div>
                    <p class="text-lg font-semibold">Gesamt: <span class="text-indigo-600">{{ number_format($total, 2, ',', '.') }} €</span></p>
                </div>
                <div class="space-x-4">
                    <form action="{{ route('cart.clear') }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                            Warenkorb leeren
                        </button>
                    </form>
                    <a href="{{ route('orders.create') }}"
                        class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700 font-semibold">
                        Zur Kasse
                    </a>
                </div>
            </div>
        </div>
    @endif
@endsection