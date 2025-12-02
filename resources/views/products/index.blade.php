@extends('layouts.app')

@section('content')
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Sidebar: Kategorien & Filter -->
        <aside class="lg:w-1/4 space-y-4">
            <!-- Kategorien -->
            <div class="bg-white shadow p-4 rounded">
                <h2 class="text-lg font-semibold mb-4">Kategorien</h2>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('products.index', request()->except('category')) }}" 
                            class="text-gray-700 hover:text-indigo-600 {{ !isset($category) ? 'font-semibold text-indigo-600' : '' }}">
                            Alle Produkte
                        </a>
                    </li>
                    @foreach ($categories as $cat)
                        <li>
                            <a href="{{ route('products.category', $cat->slug) }}"
                                class="text-gray-700 hover:text-indigo-600 {{ (isset($category) && $category->id === $cat->id) ? 'font-semibold text-indigo-600' : '' }}">
                                {{ $cat->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Filter -->
            <div class="bg-white shadow p-4 rounded">
                <h2 class="text-lg font-semibold mb-4">Filter</h2>
                <form method="GET" action="{{ isset($category) ? route('products.category', $category->slug) : route('products.index') }}" class="space-y-4">
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    
                    <!-- Verfügbarkeit -->
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="available" value="1" 
                                {{ request('available') == '1' ? 'checked' : '' }}
                                onchange="this.form.submit()"
                                class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="ml-2 text-sm text-gray-700">Nur verfügbare Produkte</span>
                        </label>
                    </div>

                    <!-- Preisbereich -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Preisbereich</label>
                        <div class="flex space-x-2">
                            <input type="number" name="min_price" 
                                value="{{ request('min_price') }}" 
                                placeholder="Min" 
                                step="0.01"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <input type="number" name="max_price" 
                                value="{{ request('max_price') }}" 
                                placeholder="Max" 
                                step="0.01"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <button type="submit" class="mt-2 w-full bg-indigo-600 text-white text-sm px-4 py-2 rounded hover:bg-indigo-700">
                            Filter anwenden
                        </button>
                    </div>

                    <!-- Filter zurücksetzen -->
                    @if(request('available') || request('min_price') || request('max_price'))
                        <a href="{{ isset($category) ? route('products.category', $category->slug) : route('products.index') }}" 
                            class="block text-center text-sm text-gray-600 hover:text-indigo-600">
                            Filter zurücksetzen
                        </a>
                    @endif
                </form>
            </div>
        </aside>

        <!-- Hauptbereich: Produkte -->
        <section class="lg:w-3/4">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <h1 class="text-2xl font-semibold">
                    @isset($category)
                        Kategorie: {{ $category->name }}
                    @else
                        Alle Produkte
                    @endisset
                </h1>
                
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                    @if(request('search'))
                        <div class="text-sm text-gray-600">
                            <span class="font-medium">{{ $products->total() }}</span> 
                            Ergebnis{{ $products->total() !== 1 ? 'se' : '' }} für 
                            <span class="font-semibold">"{{ request('search') }}"</span>
                        </div>
                    @endif

                    <!-- Sortierung -->
                    <form method="GET" action="{{ isset($category) ? route('products.category', $category->slug) : route('products.index') }}" class="flex items-center">
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        @if(request('available'))
                            <input type="hidden" name="available" value="{{ request('available') }}">
                        @endif
                        @if(request('min_price'))
                            <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                        @endif
                        @if(request('max_price'))
                            <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                        @endif
                        <label for="sort" class="text-sm text-gray-700 mr-2">Sortieren:</label>
                        <select name="sort" id="sort" 
                            onchange="this.form.submit()"
                            class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Neueste zuerst</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Preis: Niedrig zu Hoch</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Preis: Hoch zu Niedrig</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name: A-Z</option>
                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name: Z-A</option>
                        </select>
                    </form>
                </div>
            </div>

            @if ($products->isEmpty())
                <div class="bg-white shadow p-6 rounded text-center text-gray-500">
                    @if(request('search'))
                        <p class="mb-4">Keine Produkte gefunden für "{{ request('search') }}".</p>
                        <a href="{{ route('products.index') }}" class="text-indigo-600 hover:text-indigo-800">
                            Alle Produkte anzeigen
                        </a>
                    @else
                        Keine Produkte gefunden.
                    @endif
                </div>
            @else
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($products as $product)
                        <article class="bg-white shadow rounded overflow-hidden hover:shadow-lg transition-shadow">
                            <!-- Produktbild -->
                            <div class="w-full h-48 bg-gray-100 overflow-hidden">
                                @if($product->image)
                                    <a href="{{ route('products.show', $product->slug) }}">
                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                            alt="{{ $product->name }}"
                                            class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                    </a>
                                @else
                                    <a href="{{ route('products.show', $product->slug) }}" class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </a>
                                @endif
                            </div>
                            <div class="p-4">
                                <p class="text-sm text-gray-500">{{ $product->category->name ?? 'Ohne Kategorie' }}</p>
                                <h2 class="text-lg font-semibold mt-1">
                                    <a href="{{ route('products.show', $product->slug) }}" class="hover:text-indigo-600">
                                        {{ $product->name }}
                                    </a>
                                </h2>
                                <p class="text-gray-700 mt-2 line-clamp-2">
                                    {{ Str::limit($product->description, 100) }}
                                </p>
                                <p class="text-xl font-bold text-indigo-600 mt-4">
                                    {{ number_format($product->price, 2, ',', '.') }} €
                                </p>
                                @if($product->stock <= 0)
                                    <p class="text-red-500 text-sm mt-2">Nicht verfügbar</p>
                                @elseif($product->stock < 5)
                                    <p class="text-orange-500 text-sm mt-2">Nur noch {{ $product->stock }} verfügbar</p>
                                @endif
                            </div>
                            <div class="border-t px-4 py-2 flex justify-between items-center bg-gray-50">
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="bg-indigo-600 text-white text-sm px-4 py-2 rounded hover:bg-indigo-700 disabled:bg-gray-400 disabled:cursor-not-allowed"
                                        @if($product->stock <= 0) disabled @endif>
                                        In den Warenkorb
                                    </button>
                                </form>
                                <a href="{{ route('products.show', $product->slug) }}"
                                    class="text-sm text-gray-600 hover:text-indigo-600">
                                    Details
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $products->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </section>
    </div>
@endsection