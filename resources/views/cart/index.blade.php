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
                                    class="text-indigo-600 hover:text-indigo-800">
                                    {{ $item['product']->name }}
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                {{ number_format($item['product']->price, 2, ',', '.') }} €
                            </td>
                            <td class="px-6 py-4">
                                {{ $item['quantity'] }}
                            </td>
                            <td class="px-6 py-4 font-semibold">
                                {{ number_format($item['product']->price * $item['quantity'], 2, ',', '.') }} €
                            </td>
                            <td class="px-6 py-4">
                                <form action="{{ route('cart.remove', $id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                        Entfernen
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="bg-gray-50 px-6 py-4 flex justify-between items-center">
                <div>
                    <p class="text-lg font-semibold">Gesamt: {{ number_format($total, 2, ',', '.') }} €</p>
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
                        class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                        Zur Kasse
                    </a>
                </div>
            </div>
        </div>
    @endif
@endsection