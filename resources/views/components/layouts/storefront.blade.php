@props(['title' => null, 'description' => null, 'image' => null])

@php
    $pageTitle = $title ? $title . ' — ' . config('app.name', 'TSAS') : config('app.name', 'TSAS') . ' — Мэргэжлийн ажлын хувцас';
    $pageDescription = $description ?? 'Тогооч, эмч, зөөгч, нарийн боовчин — бүх мэргэжлийн ажлын хувцсыг нэг дороос. Монгол даяар хүргэлттэй.';
    $pageImage = $image ?? asset('images/mom-hero.jpg');
    $pageUrl = url()->current();
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="{{ $pageDescription }}">

        <title>{{ $pageTitle }}</title>

        <!-- Open Graph -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ $pageUrl }}">
        <meta property="og:title" content="{{ $pageTitle }}">
        <meta property="og:description" content="{{ $pageDescription }}">
        <meta property="og:image" content="{{ $pageImage }}">
        <meta property="og:locale" content="mn_MN">
        <meta property="og:site_name" content="TSAS">

        <!-- Twitter Card -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $pageTitle }}">
        <meta name="twitter:description" content="{{ $pageDescription }}">
        <meta name="twitter:image" content="{{ $pageImage }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Source+Sans+3:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-source antialiased bg-concrete text-charcoal">
        <x-storefront.announcement-bar />
        <x-storefront.header />

        <main>
            {{ $slot }}
        </main>

        <x-storefront.footer />
        <x-storefront.mobile-bottom-bar />
    </body>
</html>
