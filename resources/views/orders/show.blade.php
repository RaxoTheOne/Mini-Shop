@extends('layouts.app')

@section('title', 'Bestellung ' . $order->order_number . ' | Mini-Shop')

@section('content')
    <!-- Bestellübersicht -->
    <div class="bg-white shadow rounded-lg p-6 max-w-3xl mx-auto">
        <div class="text-center mb-6">
            <div class="inline-block bg-green-100 rounded-full p-3 mb-4">
                <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Bestellung erfolgreich!</h1>
            <p class="text-gray-600">Vielen Dank für deine Bestellung.</p>
        </div>

        <!-- Statusanzeige -->
        <div class="mb-6 text-center">
            @php
                $statusColor = [
                    'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
                    'processing' => 'bg-blue-100 text-blue-800 border-blue-300',
                    'shipped' => 'bg-purple-100 text-purple-800 border-purple-300',
                    'completed' => 'bg-green-100 text-green-800 border-green-300',
                ];
                $statusLabels = [
                    'pending' => 'Ausstehend',
                    'processing' => 'In Bearbeitung',
                    'shipped' => 'Versendet',
                    'completed' => 'Abgeschlossen',
                    'cancelled' => 'Storniert',
                ];
                $color = $statusColor[$order->status] ?? 'bg-gray-100 text-gray-800 border-gray-300';
                $label = $statusLabels[$order->status] ?? ucfirst($order->status);
            @endphp
            <span class="inline-block px-4 py-2 rounded-full border-2 font-semibold text-sm {{ $color }}">
                Status: {{ $label }}
            </span>
        </div>

        <!-- Bestellnummer und Bestelldatum -->
        <div class="border-t border-b py-6 mb-6">
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-lg font-semibold mb-2">Bestellnummer</h2>
                    <p class="text-indigo-600 font-mono font-bold">{{ $order->order_number }}</p>
                </div>
                <div>
                    <h2 class="text-lg font-semibold mb-2">Bestelldatum</h2>
                    <p class="text-gray-700">{{ $order->created_at->format('d.m.Y H:i') }} Uhr</p>
                </div>
            </div>
        </div>

        <div class="mb-6">
            <h2 class="text-lg font-semibold mb-4">Kundendaten</h2>
            <div class="bg-gray-50 p-4 rounded">
                <p><strong>Name:</strong> {{ $order->customer_name }}</p>
                <p><strong>E-Mail:</strong> {{ $order->customer_email }}</p>
                @if($order->customer_phone)
                    <p><strong>Telefon:</strong> {{ $order->customer_phone }}</p>
                @endif
                <p><strong>Adresse:</strong> {{ $order->customer_address }}</p>
            </div>
        </div>

        <div class="mb-6">
            <h2 class="text-lg font-semibold mb-4">Bestellte Produkte</h2>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Produkt</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Preis</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Menge</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Zwischensumme</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($order->orderItems as $item)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="flex items-center space-x-3">
                                        @if($item->product && $item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                alt="{{ $item->product_name }}"
                                                class="w-12 h-12 object-cover rounded">
                                        @else
                                            <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center shrink-0">
                                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                        <span class="font-medium">{{ $item->product_name }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3">{{ number_format($item->price, 2, ',', '.') }} €</td>
                                <td class="px-4 py-3">{{ $item->quantity }}</td>
                                <td class="px-4 py-3 font-semibold">
                                    {{ number_format($item->subtotal, 2, ',', '.') }} €
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="3" class="px-4 py-3 text-right font-semibold">Gesamt:</td>
                            <td class="px-4 py-3 font-bold text-indigo-600 text-lg">
                                {{ number_format($order->total_amount, 2, ',', '.') }} €
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        @if($order->notes)
            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-2">Notizen</h2>
                <p class="text-gray-700 bg-gray-50 p-4 rounded">{{ $order->notes }}</p>
            </div>
        @endif

        <div class="text-center pt-6 border-t">
            <p class="text-gray-600 mb-4">Wir bearbeiten deine Bestellung so schnell wie möglich.</p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('products.index') }}"
                    class="inline-block bg-gray-600 text-white px-6 py-2 rounded hover:bg-gray-700 transition-colors">
                    ← Zurück zur Übersicht
                </a>
                <a href="{{ route('products.index') }}"
                    class="inline-block bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700 transition-colors">
                    Weiter einkaufen
                </a>
            </div>
        </div>
    </div>
@endsection