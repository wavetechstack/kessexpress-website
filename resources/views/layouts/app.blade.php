<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'KessExpress') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-background font-sans antialiased">
    <div class="relative flex min-h-screen flex-col">
        <x-navigation />
        
        <main class="flex-1">
            {{ $slot }}
        </main>

        <x-footer />
    </div>

    @stack('scripts')
</body>
</html>
