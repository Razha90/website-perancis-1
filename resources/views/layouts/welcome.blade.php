<!DOCTYPE html>
<html lang="{{ Session::get('locale', 'fr') }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="{{ asset('/img/web/logo.png') }}">
  <title>{{ config('app.name') }}</title>
  @vite(['resources/css/app.css', 'resources/js/bootstrap.js'])
  @livewireStyles
</head>

<body>
  {{ $slot }}
</body>

@livewireScripts

</html>