<!DOCTYPE html>
<html lang="{{ Session::get('locale', 'fr') }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('/img/web/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/bootstrap.js'])

</head>

<body class="font-sans">
    <div class="flex justify-center items-center w-full h-[100vh] min-h-[700px] bg-accent_grey">
        <div
            class="min-h-[450px] max-h[600px] h-[600px] min-w-[350px] w-full   flex flex-col sm:justify-center items-center pt-6 sm:pt-0 max-w-[600px]">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-secondary_blue" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-3 py-4 bg-primary_white shadow-md overflow-hidden sm:rounded-lg">
                <div class="w-full flex justify-start">
                    <div class="hover:opacity-35 transition-opacity opacity-70 cursor-pointer select-none flex flex-row gap-x-2"
                        onclick="goBack()">
                        <div class="w-[20px]">
                            <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#2867A4">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path d="M6 3L6 6H12L12 10H6L6 13L5 13L0 8L5 3L6 3Z" fill="#2867A4"></path>
                                    <path d="M16 2L16 14H14L14 2L16 2Z" fill="#2867A4"></path>
                                </g>
                            </svg>
                        </div>
                        <p class="font-sans text-secondary_blue">{{ __('login.back') }}</p>
                    </div>
                </div>
                <div class="px-5 py-5">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    function goBack() {
       window.location.href = "{{ route('welcome') }}";
    }
</script>

</html>