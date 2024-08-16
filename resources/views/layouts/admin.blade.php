<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Include meta tags, CSS, and other head elements -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <script src="//unpkg.com/alpinejs" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body>
    <div class="flex">
            <!-- Sidebar -->
            @include('partials.sidebar')

            <div class="flex-1">
                <!-- Header -->
                @include('partials.header', ['headerTitle' => $headerTitle ?? 'Default Title']) <!-- Pass headerTitle to the header partial -->


                <!-- Main content -->
                <main class="p-6">
                    @yield('content')
                </main>
            </div>
    </div>

</body>
</html>
