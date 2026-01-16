<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Dein zuverlässiger Online-Shop für alle deine Bedürfnisse.">
    <meta name="keywords" content="Online-Shop, E-Commerce, Produkte, Shopping">
    <title>@yield('title', 'Mini-Shop | Dein Online-Shop')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-linear-to-br from-gray-50 to-gray-100 text-gray-900 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white/95 backdrop-blur-sm shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('products.index') }}" class="flex items-center space-x-2 group">
                    <svg class="w-4 h-4 text-indigo-600 group-hover:text-purple-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    <span class="text-xl font-bold bg-linear-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                        Mini-Shop
                    </span>
                </a>
                <div class="flex items-center space-x-4">
                    <!-- Suchfeld (responsive) -->
                    <form action="{{ route('products.index') }}" method="GET" class="flex items-center flex-1 md:flex-initial">
                        <div class="relative flex-1 md:w-64">
                            <input type="text" 
                                name="search" 
                                value="{{ request('search') }}"
                                placeholder="Produkte suchen..." 
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm">
                            <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <button type="submit" class="ml-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm font-medium hidden md:block">
                            Suchen
                        </button>
                        @if(request('search'))
                            <a href="{{ route('products.index') }}" class="ml-2 text-gray-500 hover:text-gray-700" title="Suche zurücksetzen">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </a>
                        @endif
                    </form>
                    
                    <a href="{{ route('products.index') }}"
                        class="flex items-center space-x-1.5 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('products.*') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-gray-100 hover:text-indigo-600' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <span>Produkte</span>
                    </a>
                    <a href="{{ route('cart.index') }}"
                        class="relative flex items-center space-x-1.5 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('cart.*') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-gray-100 hover:text-indigo-600' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span>Warenkorb</span>
                        @php
                            $cart = session()->get('cart', []);
                            $cartCount = 0;
                            foreach ($cart as $item) {
                                $cartCount += $item['quantity'];
                            }
                        @endphp
                        @if($cartCount > 0)
                        <span class="absolute -top-0.5 -right-0.5 bg-linear-to-r from-red-500 to-pink-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center shadow-lg">
                            {{ $cartCount }}
                        </span>
                    @endif
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Flash Messages - Verbessert -->
@if (session('success'))
<div id="flash-success" class="mb-6 bg-linear-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 p-4 rounded-lg shadow-md flex items-center justify-between group">
    <div class="flex items-center flex-1">
        <svg class="w-5 h-5 text-green-500 mr-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                clip-rule="evenodd" />
        </svg>
        <p class="text-green-800 font-medium">{{ session('success') }}</p>
    </div>
    <button onclick="this.closest('div').remove()" 
        class="ml-4 text-green-500 hover:text-green-700 transition-colors shrink-0"
        aria-label="Schließen">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>
@endif

@if (session('error'))
<div id="flash-error" class="mb-6 bg-linear-to-r from-red-50 to-rose-50 border-l-4 border-red-500 p-4 rounded-lg shadow-md flex items-center justify-between group">
    <div class="flex items-center flex-1">
        <svg class="w-5 h-5 text-red-500 mr-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                clip-rule="evenodd" />
        </svg>
        <p class="text-red-800 font-medium">{{ session('error') }}</p>
    </div>
    <button onclick="this.closest('div').remove()" 
        class="ml-4 text-red-500 hover:text-red-700 transition-colors shrink-0"
        aria-label="Schließen">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>
@endif

        @yield('content')
    </main>

    <!-- Auto-Dismiss für Flash Messages - Verbessert -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const flashMessages = document.querySelectorAll('#flash-success, #flash-error');
        flashMessages.forEach(function(message) {
            // Auto-Dismiss nach 6 Sekunden (länger als vorher für bessere UX)
            const autoDismiss = setTimeout(function() {
                message.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
                message.style.opacity = '0';
                message.style.transform = 'translateY(-10px)';
                setTimeout(function() {
                    message.remove();
                }, 500);
            }, 6000);

            // Cancel auto-dismiss wenn User manuell schließt
            const closeButton = message.querySelector('button');
            if (closeButton) {
                closeButton.addEventListener('click', function() {
                    clearTimeout(autoDismiss);
                });
            }
        });
    });
</script>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 mt-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="grid md:grid-cols-3 gap-8">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Mini-Shop</h3>
                        <p class="text-gray-600 text-sm">
                            Dein zuverlässiger Online-Shop für alle deine Bedürfnisse.
                        </p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Schnellzugriff</h3>
                        <ul class="space-y-2 text-sm">
                            <li>
                                <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-indigo-600">
                                    Alle Produkte
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('cart.index') }}" class="text-gray-600 hover:text-indigo-600">
                                    Warenkorb
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informationen</h3>
                        <p class="text-gray-600 text-sm">
                            &copy; {{ date('Y') }} Mini-Shop. Alle Rechte vorbehalten.
                        </p>
                        <p class="text-gray-500 text-xs mt-2">
                            Erstellt mit ❤️ und Laravel, Benney der Coolste Programmierer💻
                        </p>
                    </div>
                </div>
            </div>
        </footer>
</body>

</html>