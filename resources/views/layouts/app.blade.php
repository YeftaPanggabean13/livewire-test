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
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center gap-6">
            <a href="/" class="text-xl font-bold text-blue-600">User & Order Tracker</a>
            <a href="/city-report"
                class="text-gray-700 hover:text-blue-600 font-medium {{ request()->is('city-report*') ? 'text-blue-600 font-semibold' : '' }}">
                City</a>
            <a href="/users"
                class="text-gray-700 hover:text-blue-600 font-medium {{ request()->is('user*') ? 'text-blue-600 font-semibold' : '' }}">
                User</a>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto">
        {{ $slot }}
    </main>

    @livewireScripts
</body>

</html>