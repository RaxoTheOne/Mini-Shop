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
                    @php
                        $imageUrl = asset('storage/' . $product->image);
                    @endphp
                    <!-- Test: Einfaches Bild ohne komplexe CSS-Klassen -->
                    <div
                        style="width: 100%; background: #f9fafb; padding: 10px; border-radius: 8px; border: 2px solid #e5e7eb;">
                        <img src="{{ $imageUrl }}" alt="{{ $product->name }}"
                            style="width: 100%; height: auto; display: block; border-radius: 4px;"
                            onload="console.log('✓ Bild erfolgreich geladen!', this.src); this.parentElement.style.borderColor='#10b981';"
                            onerror="console.error('✗ FEHLER beim Laden:', this.src, event); alert('Bild konnte nicht geladen werden: ' + this.src);">
                    </div>
                    <p class="mt-2 text-xs text-center text-gray-500">
                        <a href="{{ $imageUrl }}" target="_blank" class="text-blue-600 hover:underline">
                            Bild direkt öffnen: {{ $imageUrl }}
                        </a>
                    </p>
                @else
                    <div
                        class="w-full h-64 bg-gray-200 rounded flex items-center justify-center text-gray-400 border border-gray-300">
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

    <!-- Ähnliche Produkte -->
    @php
        $similarProducts = \App\Models\Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->limit(4)
            ->get();
    @endphp

    @if($similarProducts->count() > 0)
        <div class="mt-12">
            <h2 class="text-2xl font-semibold mb-6">Ähnliche Produkte</h2>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($similarProducts as $similarProduct)
                    <article class="bg-white shadow rounded overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="w-full h-48 bg-gray-100 overflow-hidden">
                            @if($similarProduct->image)
                                <a href="{{ route('products.show', $similarProduct->slug) }}">
                                    <img src="{{ asset('storage/' . $similarProduct->image) }}" alt="{{ $similarProduct->name }}"
                                        class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                </a>
                            @else
                                <a href="{{ route('products.show', $similarProduct->slug) }}"
                                    class="w-full h-full flex items-center justify-center bg-linear-to-br from-gray-100 to-gray-200">
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-semibold">
                                <a href="{{ route('products.show', $similarProduct->slug) }}" class="hover:text-indigo-600">
                                    {{ $similarProduct->name }}
                                </a>
                            </h3>
                            <p class="text-xl font-bold text-indigo-600 mt-2">
                                {{ number_format($similarProduct->price, 2, ',', '.') }} €
                            </p>
                        </div>
                        <div class="border-t px-4 py-2 bg-gray-50">
                            <a href="{{ route('products.show', $similarProduct->slug) }}"
                                class="block text-center text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                                Details ansehen
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    @endif
@endsection