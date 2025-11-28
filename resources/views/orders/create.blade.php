@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-semibold mb-6">Bestellung aufgeben</h1>

    <div class="grid md:grid-cols-2 gap-8">
        <!-- Bestellformular -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Kundendaten</h2>

            <form action="{{ route('orders.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">
                        Name *
                    </label>
                    <input type="text" id="customer_name" name="customer_name" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        value="{{ old('customer_name') }}">
                    @error('customer_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-1">
                        E-Mail *
                    </label>
                    <input type="email" id="customer_email" name="customer_email" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        value="{{ old('customer_email') }}">
                    @error('customer_email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-1">
                        Telefon
                    </label>
                    <input type="text" id="customer_phone" name="customer_phone"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        value="{{ old('customer_phone') }}">
                    @error('customer_phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="customer_address" class="block text-sm font-medium text-gray-700 mb-1">
                        Adresse *
                    </label>
                    <textarea id="customer_address" name="customer_address" required rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('customer_address') }}</textarea>
                    @error('customer_address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                        Notizen (optional)
                    </label>
                    <textarea id="notes" name="notes" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full bg-indigo-600 text-white py-3 px-6 rounded-lg hover:bg-indigo-700 text-lg font-semibold">
                    Bestellung abschicken
                </button>
            </form>
        </div>

        <!-- Warenkorb-Zusammenfassung -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Bestellübersicht</h2>

            <div class="space-y-3 mb-4">
                @foreach($cart as $item)
                    <div class="flex justify-between border-b pb-2">
                        <span>{{ $item['product']->name }} ({{ $item['quantity'] }}x)</span>
                        <span class="font-semibold">
                            {{ number_format($item['product']->price * $item['quantity'], 2, ',', '.') }} €
                        </span>
                    </div>
                @endforeach
            </div>

            <div class="border-t pt-4">
                <div class="flex justify-between text-xl font-bold">
                    <span>Gesamt:</span>
                    <span class="text-indigo-600">{{ number_format($total, 2, ',', '.') }} €</span>
                </div>
            </div>
        </div>
    </div>
@endsection