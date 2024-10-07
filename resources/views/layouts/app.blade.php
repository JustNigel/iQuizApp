<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'iQuiz')</title>
    <script src="//unpkg.com/alpinejs" defer></script>
    <link rel="icon" href="{{ asset('images/logo.png') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" />

    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-900 font-satoshi">
    <div class="flex">
        <!-- Sidebar -->
        @include('partials.sidebar')

        <div class="flex-1">
            <!-- Header -->
            @include('partials.header')

            <!-- Main content -->
            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Vite JavaScript assets -->
    @vite('resources/js/app.js')

    @include('partials.password-eye')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

</body>
</html>
