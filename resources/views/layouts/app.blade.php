<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <meta name="theme-color" content="#4F7CFF">
    <!-- <title>{{ isset($title) ? $title . ' — ' . config('app.name', 'Lakile') : config('app.name', 'Lakile') }}</title> -->

    <title>@yield('title', $seo->title)</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <meta name="description" content="@yield('meta_description', $seo->description)">
    <link rel="canonical" href="{{ $seo->canonical }}">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $seo->canonical }}">
    <meta property="og:title" content="@yield('title', $seo->title)">
    <meta property="og:description" content="@yield('meta_description', $seo->description)">
    <meta property="og:image" content="{{ $seo->image }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', $seo->title)">
    <meta name="twitter:description" content="@yield('meta_description', $seo->description)">

    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @filamentStyles
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('layouts.navigation')

        
        @isset($header)
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-12xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endisset

        
        <main>
            {{ $slot }}
        </main>
    </div>
    @livewire('notifications')
    @livewireScripts
    @filamentScripts
</body>

</html>