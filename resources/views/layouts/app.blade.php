<!DOCTYPE html>
<html lang="{{ Session::get('locale', 'fr') }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('/img/web/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/bootstrap.js'])
</head>

<body class="bg-accent_grey">
    {{ $slot }}
    @livewireScripts
</body>
</html>