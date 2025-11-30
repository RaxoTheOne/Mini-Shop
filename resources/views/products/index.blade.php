@extends('layouts.app')

@section('content')
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Sidebar: Kategorien -->
        <aside class="lg:w-1/4 bg-white shadow p-4 rounded">
            <h2 class="text-lg font-semibold mb-4">Kategorien</h2>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-indigo-600">
                        Alle Produkte
                    </a>
                </li>
                @foreach ($categories as $category)
                    <li>
                        <a href="{{ route('products.category', $category->slug) }}"
                            class="text-gray-700 hover:text-indigo-600">
                            {{ $category->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </aside>

        <!-- Hauptbereich: Produkte -->
        <section class="lg:w-3/4">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold">
                    @isset($category)
                        Kategorie: {{ $category->name }}
                    @else
                        Alle Produkte
                    @endisset
                </h1>
                
                @if(request('search'))
                    <div class="text-sm text-gray-600">
                        <span class="font-medium">{{ $products->total() }}</span> 
                        Ergebnis{{ $products->total() !== 1 ? 'se' : '' }} für 
                        <span class="font-semibold">"{{ request('search') }}"</span>
                    </div>
                @endif
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
                        <article class="bg-white shadow rounded overflow-hidden">
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
                            </div>
                            <div class="border-t px-4 py-2 flex justify-between items-center bg-gray-50">
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="bg-indigo-600 text-white text-sm px-4 py-2 rounded hover:bg-indigo-700">
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
                    {{ $products->links() }}
                </div>
            @endif
        </section>
    </div>
@endsection