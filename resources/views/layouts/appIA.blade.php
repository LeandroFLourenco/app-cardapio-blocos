<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Cardápio')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('styles')
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-orange-600">🍔 Cardápio</a>
            <ul class="flex space-x-6">
                <li><a href="{{ route('home') }}" class="text-gray-700 hover:text-orange-600 transition">Home</a></li>
                <li><a href="{{ route('cardapio.index') }}" class="text-gray-700 hover:text-orange-600 transition">Cardápio</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </div>

    <footer class="bg-gray-800 text-white text-center py-6 mt-12">
        <p>&copy; 2026 App Cardápio. Todos os direitos reservados.</p>
    </footer>

    @stack('scripts')
</body>
</html>
