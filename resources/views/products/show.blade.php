@extends('layouts.app')

@section('title', $product->name . ' | Mini-Shop')

@section('content')
    <!-- Breadcrumbs -->
    <nav class="mb-4 text-sm" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2 text-gray-600">
            <li>
                <a href="{{ route('products.index') }}" class="hover:text-indigo-600">Startseite</a>
            </li>
            <li>
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clip-rule="evenodd" />
                </svg>
            </li>
            @if($product->category)
                <li>
                    <a href="{{ route('products.category', $product->category->slug) }}" class="hover:text-indigo-600">
                        {{ $product->category->name }}
                    </a>
                </li>
                <li>
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </li>
            @endif
            <li class="text-gray-900 font-medium">{{ $product->name }}</li>
        </ol>
    </nav>
    
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
                    <p class="text-sm text-gray-600 mb-2">
                        <strong>Lagerbestand:</strong>
                    </p>
                    @if($product->stock > 10)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            {{ $product->stock }} verfügbar
                        </span>
                    @elseif($product->stock > 0 && $product->stock <= 10)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            Nur noch {{ $product->stock }} verfügbar
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            Nicht verfügbar
                        </span>
                    @endif
                </div>

                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="cart-form">
                    @csrf
                    <button type="submit"
                        class="w-full bg-indigo-600 text-white py-3 px-6 rounded-lg hover:bg-indigo-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-lg font-semibold transition-all relative"
                        @if($product->stock <= 0) disabled @endif>
                        <span class="button-text">
                            @if($product->stock > 0)
                                In den Warenkorb
                            @else
                                Nicht verfügbar
                            @endif
                        </span>
                        <span class="button-loading hidden absolute inset-0 items-center justify-center">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="ml-2">Wird hinzugefügt...</span>
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Ähnliche Produkte -->
    @php
        $similarProducts = collect();
        if ($product->category_id) {
            $similarProducts = \App\Models\Product::where('category_id', '=', $product->category_id, 'and')
                ->where('id', '<>', $product->id, 'and')
                ->where('is_active', '=', true, 'and')
                ->where('stock', '>', 0, 'and')
                ->limit(4)
                ->get();
        }
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
@push('scripts')
    <script>
        document.querySelectorAll('.cart-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const button = this.querySelector('button');
                const text = button.querySelector('.button-text');
                const loading = button.querySelector('.button-loading');
                
                if (text && loading) {
                    text.classList.add('hidden');
                    loading.classList.remove('hidden');
                    button.disabled = true;
                }
            });
        });
    </script>
@endpush