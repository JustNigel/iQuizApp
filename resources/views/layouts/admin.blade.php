<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Include meta tags, CSS, and other head elements -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}">
    <script src="//unpkg.com/alpinejs" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" />
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

    <script>
        function filterTrainers() {
            const input = document.getElementById('searchTrainer').value.toLowerCase();
            const trainerItems = document.querySelectorAll('.trainer-item');
            
            trainerItems.forEach(item => {
                const name = item.querySelector('.trainer-name').textContent.toLowerCase();
                if (name.includes(input)) {
                    item.style.display = ''; // Show item
                } else {
                    item.style.display = 'none'; // Hide item
                }
            });
        }

        function updateTrainerCount() {
            const selectedTrainers = document.querySelectorAll('input[name="trainer_id[]"]:checked').length;
            document.getElementById('selectedCount').textContent = selectedTrainers;
        }

        // Call updateTrainerCount on page load in case some trainers are pre-selected
        window.onload = function() {
            updateTrainerCount();
        };
    </script>
</body>
</html>
