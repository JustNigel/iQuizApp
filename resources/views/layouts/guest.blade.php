<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'iQuiz')</title>

        <link rel="icon" href="{{ asset('images/logo.png') }}">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="//unpkg.com/alpinejs" defer></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js" integrity="sha512-r0dOv5VWXKpZGz7wLZBdyD8HmrAEblgD6OUYF6jL6FdqTEUdT2jVJyzf5FQ30W+UE8dT5G0TgMmnOnibozVQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
        <!-- Scripts -->
        @vite(['resources/css/app.css'])

        <style>
        html, body {
            height: 100%;
        }
        </style>


    </head>
    <body class="text-gray-900 font-poppins bg-cover bg-no-repeat min-h-screen" style="background-image: url('/images/bg-img3.png');">
        <div class="flex flex-col min-h-full relative justify-center">
            <div class="absolute top-0 left-0 w-full h-full bg-bg-violet opacity-94 z-[-1]"></div>
            <div class="w-[400px] mx-auto mt-6">
                <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 z-10 wrapper">
                    <div class="z-10 mt-4">
                        <a href="/">
                            <x-application-logo class="w-10 h-10 fill-current" />
                        </a>
                    </div>

                    <div class="w-full sm:max-w-md mt-6 px-6 py-4 shadow-md overflow-hidden sm:rounded-lg z-10">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>

        @include('partials.password-eye')
        @vite('resources/js/app.js')
    </body>
</html>
