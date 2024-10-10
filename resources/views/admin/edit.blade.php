@extends('layouts.admin')

@section('title', 'Categories: Edit Category')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md">
    <main class="flex-1 p-6">
        <a href="{{ route('admin.all-category') }}" class="text-indigo-600 hover:text-indigo-700 font-medium mb-6 inline-block">&larr; Return to All Categories</a>

        <header class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Edit Category</h1>
        </header>

        <form action="{{ route('admin.update-category', $category->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left Side: Title and Description -->
                <div class="space-y-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-lg font-medium text-gray-700">Title</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $category->title) }}" class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2" required>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-lg font-medium text-gray-700">Description</label>
                        <textarea id="description" name="details" rows="4" class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2" required>{{ old('details', $category->description) }}</textarea>
                    </div>

                </div>

                <!-- Right Side: Trainer Selection -->
                <div class="col-span-1">
                    <h2 class="text-lg font-medium text-gray-700">Select Trainers</h2>

                    <!-- Search Bar -->
                    <input type="text" id="searchTrainer" placeholder="Search a Trainer" 
                        class="w-full p-2 border border-gray-300 rounded-md mt-2" 
                        onkeyup="filterTrainers()">

                    <div class="space-y-4 mt-4 h-64 overflow-y-auto border border-gray-300 rounded-md p-2" id="trainerList">
                        @foreach($trainers as $trainer)
                        <div class="flex items-center trainer-item">
                            <input type="checkbox" id="trainer_{{ $trainer->id }}" name="trainer_id[]" value="{{ $trainer->id }}" 
                                class="hidden peer" 
                                {{ in_array($trainer->id, $category->trainers->pluck('id')->toArray()) ? 'checked' : '' }} 
                                onchange="updateTrainerCount()">
                            <label for="trainer_{{ $trainer->id }}" class="flex items-center p-2 rounded-md w-full cursor-pointer peer-checked:bg-blue-100 hover:bg-blue-50">
                                @if($trainer->image_profile)
                                    <img src="{{ asset('images/profiles/' . $trainer->image_profile) }}" alt="{{ $trainer->name }}" class="w-10 h-10 rounded-full mr-2">
                                @else
                                    <i class="fas fa-user-circle text-gray-400 text-4xl mr-2"></i>
                                @endif
                                <span class="text-gray-800 trainer-name ml-2">{{ $trainer->name }} <br><p class="text-xs">{{ $trainer->type_name }}</p></span>
                            </label>
                        </div>
                        @endforeach
                    </div>

                    <!-- Trainer Selection Count -->
                    <div class="mt-2 text-right text-sm text-gray-700">
                        Selected Trainers: <span id="selectedCount">{{ count($category->trainers) }}</span>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200">Update Category</button>
            </div>
        </form>
    </main>
</div>
@endsection
