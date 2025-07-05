<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="description"
          content="@yield('description', 'Prompt Dünyası - En iyi AI promptları bulabileceğiniz pazar yeri')">
    <meta name="keywords" content="@yield('keywords', 'AI, prompt, yapay zeka, ChatGPT')">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Prompt Dünyası')</title>

    <link rel="stylesheet"
          href="{{ asset('assets/css/style.css') }}?v={{ filemtime(public_path('assets/css/style.css')) }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/loader.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"/>

    @stack('head')
</head>
<body class="theme-dark-active">
@include('partials.header')

@yield('content')

@include('partials.footer')

<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
@stack('scripts')
</body>
</html>
