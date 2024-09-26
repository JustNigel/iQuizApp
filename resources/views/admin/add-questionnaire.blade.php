@extends('layouts.admin')

@section('title', 'Questionnaires: New')

@section('content')
@if (session('error'))
    <div id="error-message" class="bg-red-100 border border-red-500 text-red-700 px-4 py-3 rounded-lg mb-6">
        {{ session('error') }}
    </div>
    @endif
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md">
    <a href="{{ route('admin.all-category') }}" class="text-indigo-600 hover:text-indigo-700 font-medium mb-6 inline-block">&larr; Back</a>

    <h1 class="text-3xl font-semibold mb-6 text-center">Create Questionnaire</h1>

    <!-- Submit to Confirmation Route -->
    <form action="{{ route('admin.confirm-add-questionnaire') }}" method="GET" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 gap-6">
            <div class="flex items-center">
                <label for="title" class="w-1/4 text-lg font-medium text-gray-700">Questionnaire Name:</label>
                <input type="text" id="title" name="title" class="block w-3/4 border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2" required>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div class="flex items-center">
                    <label for="number_of_items" class="w-full text-lg font-medium text-gray-700">Number of Items:</label>
                    <input type="number" id="number_of_items" name="number_of_items" class="block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2" required>
                </div>

                <div class="flex items-center">
                    <label for="time_interval" class="w-full text-lg font-medium text-gray-700">Time Interval (mins):</label>
                    <input type="number" id="time_interval" name="time_interval" class="block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2" required>
                </div>

                <div class="flex items-center">
                    <label for="passing_grade" class="w-full text-lg font-medium text-gray-700">Passing Grade (%):</label>
                    <input type="number" id="passing_grade" name="passing_grade" class="block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2">
                </div>

                <div class="flex items-center">
                    <label for="category" class="w-full text-lg font-medium text-gray-700">Category:</label>
                    <select id="category" name="category_id" class="block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2" required>
                        <option value="" disabled selected>Select a category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center">
                    <label for="trainer" class="w-full text-lg font-medium text-gray-700">Trainer Name:</label>
                    <select id="trainer" name="trainer_id" class="block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2">
                        <option value="" disabled selected>Select a trainer</option>
                        @foreach($trainers as $trainer)
                            <option value="{{ $trainer->id }}">{{ $trainer->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center">
                    <label for="shuffle" class="w-1/6 text-lg font-medium text-gray-700">Shuffle:</label>

                    <!-- Hidden input for unchecked value -->
                    <input type="hidden" name="shuffle" value="0">
                    
                    <!-- Checkbox for checked value -->
                    <input type="checkbox" id="shuffle" name="shuffle" value="1" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 mt-6 rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Submit
            </button>
        </div>
    </form>
</div>

@include('partials.time-interval')

@endsection
