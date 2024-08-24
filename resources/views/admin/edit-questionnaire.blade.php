@extends('layouts.admin')

@section('title', 'Edit Questionnaire')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md">
    <a href="{{ route('admin.all-questionnaire', ['categoryId' => $questionnaire->category_id]) }}" class="text-indigo-600 hover:text-indigo-700 font-medium mb-6 inline-block">&larr; Back</a>

    <h1 class="text-3xl font-semibold mb-6 text-center">Edit Questionnaire</h1>

    <form action="{{ route('admin.update-questionnaire', $questionnaire->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6">
            <div class="flex items-center">
                <label for="title" class="w-1/4 text-lg font-medium text-gray-700">Questionnaire Name:</label>
                <input type="text" id="title" name="title" value="{{ old('title', $questionnaire->title) }}" class="block w-3/4 border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2" required>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div class="flex items-center">
                    <label for="number_of_items" class="w-full text-lg font-medium text-gray-700">Number of Items:</label>
                    <input type="number" id="number_of_items" name="number_of_items" value="{{ old('number_of_items', $questionnaire->number_of_items) }}" class="block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2" required>
                </div>

                <div class="flex items-center">
                    <label for="time_interval" class="w-full text-lg font-medium text-gray-700">Time Interval (mins):</label>
                    <input type="number" id="time_interval" name="time_interval" value="{{ old('time_interval', $questionnaire->time_interval) }}" class="block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2" required>
                </div>

                <div class="flex items-center">
                    <label for="passing_grade" class="w-full text-lg font-medium text-gray-700">Passing Grade (%):</label>
                    <input type="number" id="passing_grade" name="passing_grade" value="{{ old('passing_grade', $questionnaire->passing_grade) }}" class="block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2">
                </div>

                <div class="flex items-center">
                    <label for="category" class="w-full text-lg font-medium text-gray-700">Category:</label>
                    <select id="category" name="category_id" class="block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2" required>
                        <option value="" disabled>Select a category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $category->id == $questionnaire->category_id ? 'selected' : '' }}>
                                {{ $category->title }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <div class="flex items-center">
                    <label for="trainer" class="w-full text-lg font-medium text-gray-700">Trainer Name:</label>
                    <select id="trainer" name="trainer_id[]" class="block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2" multiple>
                        @foreach($trainers as $trainer)
                            <option value="{{ $trainer->id }}" {{ in_array($trainer->id, old('trainer_id', $questionnaire->trainers->pluck('id')->toArray())) ? 'selected' : '' }}>
                                {{ $trainer->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center">
                    <label for="shuffle" class="w-1/6 text-lg font-medium text-gray-700">Shuffle:</label>
                    <input type="checkbox" id="shuffle" name="shuffle" value="1" {{ old('shuffle', $questionnaire->shuffle) ? 'checked' : '' }} class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            </div>
        </div>

        <div>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 mt-6 rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Update</button>
        </div>
    </form>
</div>
@endsection
