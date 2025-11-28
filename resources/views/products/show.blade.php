@extends('layouts.app')

@section('content')
    <div class="mb-4">
        <a href="{{ route('products.index') }}" class="text-indigo-600 hover:text-indigo-800">
            ← Zurück zur Übersicht
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="md:flex">
            <!-- Produktbild (optional, falls vorhanden) -->
            <div class="md:w-1/2 p-6 bg-gray-50">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                        class="w-full h-auto rounded">
                @else
                    <div class="w-full h-64 bg-gray-200 rounded flex items-center justify-center text-gray-400">
                        Kein Bild verfügbar
                    </div>
                @endif
            </div>

            <!-- Produktinformationen -->
            <div class="md:w-1/2 p-6">
                <p class="text-sm text-gray-500 mb-2">
                    {{ $product->category->name ?? 'Ohne Kategorie' }}
                </p>
                <h1 class="text-3xl font-bold mb-4">{{ $product->name }}</h1>

                <p class="text-4xl font-bold text-indigo-600 mb-6">
                    {{ number_format($product->price, 2, ',', '.') }} €
                </p>

                <div class="mb-6">
                    <h2 class="text-lg font-semibold mb-2">Beschreibung</h2>
                    <p class="text-gray-700">{{ $product->description ?? 'Keine Beschreibung verfügbar.' }}</p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-600">
                        <strong>Lagerbestand:</strong>
                        @if($product->stock > 0)
                            <span class="text-green-600">{{ $product->stock }} verfügbar</span>
                        @else
                            <span class="text-red-600">Nicht verfügbar</span>
                        @endif
                    </p>
                </div>

                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-6">
                    @csrf
                    <button type="submit"
                        class="w-full bg-indigo-600 text-white py-3 px-6 rounded-lg hover:bg-indigo-700 text-lg font-semibold"
                        @if($product->stock <= 0) disabled @endif>
                        @if($product->stock > 0)
                            In den Warenkorb
                        @else
                            Nicht verfügbar
                        @endif
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection