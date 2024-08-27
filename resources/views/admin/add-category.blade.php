@extends('layouts.admin')

@section('title', 'Create Category')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md">
    <a href="{{route ('admin.all-category')}}" class="text-indigo-600 hover:text-indigo-700 font-medium mb-6 inline-block">&larr; Back</a>

    <h1 class="text-3xl font-semibold mb-6 text-center">Create Category</h1>

    <form action="{{ route('admin.store-category') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label for="title" class="block text-lg font-medium text-gray-700">Title</label>
            <input type="text" id="title" name="title" class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2" required>
        </div>


        <div>
            <label for="details" class="block text-lg font-medium text-gray-700">Description</label>
            <textarea id="details" name="details" rows="4" class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2" required></textarea>
        </div>

        <div>
            <label for="trainer" class="block text-lg font-medium text-gray-700">Trainer</label>
            <select id="trainer" name="trainer_id[]" multiple class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2">
                @foreach($trainers as $trainer)
                    <option value="{{ $trainer->id }}">{{ $trainer->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Submit</button>
        </div>
    </form>
</div>
@endsection
