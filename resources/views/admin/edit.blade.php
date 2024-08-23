@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')

<main class="flex-1 p-6">
    <header class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Edit Category</h1>
    </header>

    <form action="{{ route('admin.update-category', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <!-- Title -->
        <div class="mb-4">
            <label for="title" class="block text-gray-700 font-bold mb-2">Title:</label>
            <input type="text" name="title" id="title" value="{{ old('title', $category->title) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        
        <!-- Description -->
        <div class="mb-4">
            <label for="description" class="block text-gray-700 font-bold mb-2">Description:</label>
            <textarea name="description" id="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('description', $category->description) }}</textarea>
        </div>
        
        <!-- Trainer -->
        <div class="mb-4">
            <label for="trainers" class="block text-gray-700 font-bold mb-2">Trainers:</label>
            <select name="trainer_id[]" id="trainers" multiple class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @foreach($trainers as $trainer)
                    <option value="{{ $trainer->id }}" {{ in_array($trainer->id, $category->trainers->pluck('id')->toArray()) ? 'selected' : '' }}>
                        {{ $trainer->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200">Update Category</button>
        </div>
    </form>
</main>

@endsection
