<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get Started</title>
    @vite('resources/css/app.css') {{-- Ensure Tailwind CSS is included --}}
</head>
<body class="bg-gray-100 overflow-hidden min-h-screen flex flex-col">
    {{-- Include the header --}}
    <header class="bg-custombg-gray text-white py-4">
        @include('partials.questionnaire-header', ['headerTitle' => 'Get Started'])
    </header>

    {{-- Main content area --}}
    <main class="flex-grow flex items-center justify-center">
        <div class="bg-gray-50 shadow-lg rounded-lg p-6 max-w-lg w-full mx-4 sm:mx-6 md:mx-8 lg:mx-auto">
            <h1 class="text-2xl font-bold mb-4">Get Started</h1>
            <p class="text-gray-700 mb-6">Before taking the exam, please review the information below to ensure you're prepared.</p>

            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-2">{{$questionnaire -> title}}</h2>
                <ul class="list-disc list-inside text-gray-700 mx-auto max-w-md">
                    <li><strong>Number of Items:</strong> {{$questionnaire -> number_of_items}}</li>
                    <li><strong>Time Allotted:</strong>{{$questionnaire -> time_interval}}</li>
                    <li><strong>Passing Grade:</strong> {{$questionnaire -> passing_grade}}</li>
                </ul>
            </div>

            <p class="text-gray-700 mb-4">Good luck!</p>

            <a href="#" class="block text-center bg-custombg-gray text-gray-50 font-bold py-2 px-4 rounded hover:bg-custombg-gray-dark">
                Take the Exam
            </a>
        </div>
    </main>
</body>
</html>
