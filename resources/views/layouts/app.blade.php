<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <header class="bg-white shadow-md p-4">
        <div class="max-w-4xl mx-auto flex justify-between">
            <h2 class="text-xl font-bold">App Cardápio</h2>

            <nav class="space-x-4">
                <a href="/" class="text-blue-600 hover:underline">Home</a>
                <a href="/teste" class="text-blue-600 hover:underline">Teste</a>
            </nav>
        </div>
    </header>
    <main class="max-w-4xl mx-auto mt-8 bg-white p-6 shadow rounded">
        @yield('content')
    </main>
    <footer class="text-center text-sm text-gray-600 mt-10">
        <p>&copy; 2026 App Cardápio. Todos os direitos reservados.</p>
    </footer>
</body>
</html>