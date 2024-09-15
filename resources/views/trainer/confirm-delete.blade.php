@extends('layouts.admin')

@section('title', 'Confirm Deletion')

@section('content')
<div class="max-w-6xl mx-auto bg-white p-8 rounded-lg shadow-lg">
    <h1 class="text-3xl font-bold text-gray-900 mb-6 text-center">Confirm Deletion</h1>

    <p class="text-center mb-6">Are you sure you want to delete all questionnaires for the category: <strong>{{ $category->title }}</strong>?</p>

    <div class="flex justify-center">
        <form action="{{ route('trainer.questionnaire.delete', $category->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Delete</button>
            <a href="{{ route('trainer.all-category') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Cancel</a>
        </form>
    </div>
</div>
@endsection
