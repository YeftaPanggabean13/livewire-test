<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livewire Test</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-white shadow mb-8">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <a href="/" class="text-xl font-bold text-blue-600">Livewire Test App</a>
            <a href="/users" class="ml-6 text-gray-700 hover:text-blue-600">Users</a>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto">
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>
