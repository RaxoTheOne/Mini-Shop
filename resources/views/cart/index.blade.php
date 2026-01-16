@extends('layouts.app')

@section('title', 'Warenkorb | Mini-Shop')

@section('content')
    <h1 class="text-2xl font-semibold mb-6">Warenkorb</h1>

    @if(empty($cart))
        <div class="bg-white shadow p-12 rounded-lg text-center max-w-md mx-auto">
            <div class="mb-6">
                <svg class="w-24 h-24 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <h2 class="text-2xl font-semibold text-gray-700 mb-2">Dein Warenkorb ist leer</h2>
            <p class="text-gray-500 mb-6">Füge einige Produkte hinzu, um zu beginnen.</p>
            <a href="{{ route('products.index') }}"
                class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 font-semibold transition-colors">
                Produkte durchstöbern
            </a>
        </div>
        @else
        <!-- Desktop: Tabelle -->
        <div class="bg-white shadow rounded-lg overflow-hidden hidden md:block">
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
                                    <div class="flex items-center space-x-3">
                                        @if($item['product']->image)
                                            <img src="{{ asset('storage/' . $item['product']->image) }}"
                                                alt="{{ $item['product']->name }}" class="w-16 h-16 object-cover rounded">
                                        @else
                                            <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                        <div>
                                            <a href="{{ route('products.show', $item['product']->slug) }}"
                                                class="text-indigo-600 hover:text-indigo-800 font-medium">
                                                {{ $item['product']->name }}
                                            </a>
                                            @if($item['product']->stock < $item['quantity'])
                                                <p class="text-red-500 text-xs mt-1">
                                                    ⚠️ Nur {{ $item['product']->stock }} verfügbar
                                                </p>
                                            @endif
                                        </div>
                                    </div>
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
                                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                                                max="{{ $item['product']->stock }}"
                                                class="w-16 text-center border border-gray-300 rounded px-2 py-1"
                                                onchange="this.form.submit()">
                                        </form>

                                        <form action="{{ route('cart.update', $id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="quantity"
                                                value="{{ min($item['product']->stock, $item['quantity'] + 1) }}">
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
                                        <button type="submit" 
                                            class="text-red-600 hover:text-red-800 text-sm font-medium"
                                            title="Entfernen">
                                            Entfernen
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="bg-gray-50 px-6 py-4 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div>
                    <p class="text-lg font-semibold">Gesamt: <span
                            class="text-indigo-600">{{ number_format($total, 2, ',', '.') }} €</span></p>
                </div>
                <div class="flex flex-col sm:flex-row gap-2 sm:space-x-4 w-full sm:w-auto">
                    <form action="{{ route('cart.clear') }}" method="POST" class="inline w-full sm:w-auto"
                        onsubmit="return confirm('Möchtest du den Warenkorb wirklich leeren?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full sm:w-auto bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                            Warenkorb leeren
                        </button>
                    </form>
                    <a href="{{ route('orders.create') }}"
                        class="w-full sm:w-auto text-center bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700 font-semibold">
                        Zur Kasse
                    </a>
                </div>
            </div>
        </div>

        <!-- Mobile: Karten-Layout -->
        <div class="md:hidden space-y-4">
            @foreach($cart as $id => $item)
                <div class="bg-white shadow rounded-lg p-4">
                    <div class="flex items-start space-x-4">
                        @if($item['product']->image)
                            <img src="{{ asset('storage/' . $item['product']->image) }}"
                                alt="{{ $item['product']->name }}" class="w-20 h-20 object-cover rounded shrink-0">
                        @else
                            <div class="w-20 h-20 bg-gray-200 rounded flex items-center justify-center shrink-0">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('products.show', $item['product']->slug) }}"
                                class="text-indigo-600 hover:text-indigo-800 font-medium block mb-1">
                                {{ $item['product']->name }}
                            </a>
                            <p class="text-gray-600 text-sm mb-2">
                                {{ number_format($item['product']->price, 2, ',', '.') }} €
                            </p>
                            @if($item['product']->stock < $item['quantity'])
                                <p class="text-red-500 text-xs mb-2">
                                    ⚠️ Nur {{ $item['product']->stock }} verfügbar
                                </p>
                            @endif
                            
                            <!-- Menge Controls -->
                            <div class="flex items-center space-x-2 mb-3">
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
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                                        max="{{ $item['product']->stock }}"
                                        class="w-16 text-center border border-gray-300 rounded px-2 py-1"
                                        onchange="this.form.submit()">
                                </form>

                                <form action="{{ route('cart.update', $id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="quantity"
                                        value="{{ min($item['product']->stock, $item['quantity'] + 1) }}">
                                    <button type="submit"
                                        class="w-8 h-8 flex items-center justify-center bg-gray-200 hover:bg-gray-300 rounded text-gray-700 font-bold"
                                        @if($item['quantity'] >= $item['product']->stock) disabled @endif>
                                        +
                                    </button>
                                </form>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <p class="font-semibold text-lg">
                                    {{ number_format($item['product']->price * $item['quantity'], 2, ',', '.') }} €
                                </p>
                                <form action="{{ route('cart.remove', $id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                        class="text-red-600 hover:text-red-800 text-sm font-medium">
                                        Entfernen
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Mobile Footer -->
            <div class="bg-white shadow rounded-lg p-4 sticky bottom-0">
                <div class="mb-4 pb-4 border-b">
                    <p class="text-lg font-semibold text-center">Gesamt: <span
                            class="text-indigo-600">{{ number_format($total, 2, ',', '.') }} €</span></p>
                </div>
                <div class="space-y-2">
                    <a href="{{ route('orders.create') }}"
                        class="block w-full text-center bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 font-semibold">
                        Zur Kasse
                    </a>
                    <form action="{{ route('cart.clear') }}" method="POST" class="inline w-full"
                        onsubmit="return confirm('Möchtest du den Warenkorb wirklich leeren?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-gray-600 text-white px-4 py-3 rounded-lg hover:bg-gray-700">
                            Warenkorb leeren
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection