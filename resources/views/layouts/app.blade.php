<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('css')
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        {{-- @include('layouts.navigation') --}}

        <!-- Page Heading -->
        @include('layouts.header')

        <div class="flex">
            <div class="w-auto">
                @include('layouts.sidebar')
            </div>
            <div class="px-3 md:px-0 w-full">
                @if($message = Session::get('success'))
                <x-success-toast>{{ $message }}</x-success-toast>
                @endif
                <div class="py-3">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</body>
@stack('js')

</html>