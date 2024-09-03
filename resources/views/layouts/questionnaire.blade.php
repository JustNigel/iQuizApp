<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Questionnaire')</title>
    <script src="//unpkg.com/alpinejs" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @vite('resources/js/questionnaire.js')

    <script src="{{ asset('js/questionnaire.js') }}" defer></script>
</head>
<body class="bg-gray-100 text-gray-900 font-satoshi">
    <div class="flex flex-col h-screen border-1">
        @include('partials.questionnaire-header', ['headerTitle' => $headerTitle ?? 'Default Title'])

        <div class="flex flex-1 overflow-hidden">
            <aside class="w-1/4 bg-white shadow-lg overflow-y-auto">
                @include('admin.questionnaire-partials.questionnaire-sidebar') 
            </aside>

            <main class="flex-1 bg-gray-100 p-6 overflow-y-auto">
                @include('admin.questionnaire-partials.questionnaire-main-content')
            </main>

            <aside class="w-1/4 bg-white shadow-lg">
                @include('admin.questionnaire-partials.questionnaire-settings') 
            </aside>
        </div>
    </div>

    @vite('resources/js/app.js')
</body>
</html>
