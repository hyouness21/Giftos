<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'GIFTOS — Curated gifts, beautifully wrapped')</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700|cinzel:700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="flex min-h-full flex-col bg-zinc-50 font-sans text-zinc-800 antialiased">
        @include('partials.navbar')

        <main class="flex-1">
            @yield('content')
        </main>

        <footer class="border-t border-giftos/10 bg-white py-8 text-center text-sm text-zinc-500">
            <p>&copy; 2022 GIFTOS. Thoughtful gifts for every moment.</p>
        </footer>
        @stack('body')
        @stack('scripts')
    </body>
</html>
