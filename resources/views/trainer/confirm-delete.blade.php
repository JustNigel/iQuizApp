@extends('layouts.admin')

@section('title', 'Confirm Deletion')

@section('content')
<div class="max-w-lg mx-auto mt-8">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold mb-4">Confirm Deletion</h2>
        <p class="text-center mb-6">Are you sure you want to delete all questionnaires you associated with for the category: <strong>{{ $category->title }}</strong>?</p>

        <div class="mt-6 flex justify-end space-x-3">
            <form action="{{ route('trainer.questionnaire.delete', $category->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition duration-200">Delete</button>
                <a href="{{ route('trainer.all-category') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition duration-200">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
