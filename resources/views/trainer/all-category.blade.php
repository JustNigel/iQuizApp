@extends('layouts.admin')

@section('title', 'All Categories')

@section('content')

<main class="flex-1 p-6">

    @if (session('success'))
        <div id="success-message" class="bg-green-100 border border-green-500 text-green-700 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div id="error-message" class="bg-red-100 border border-red-500 text-red-700 px-4 py-3 rounded-lg mb-6">
            {{ session('error') }}
        </div>
    @endif

    <header class="mb-6">
        <a href="{{ route('trainer.all-category') }}"><h1 class="text-3xl font-bold text-gray-800 mb-5">All Categories</h1> </a>
        <a href="{{route('admin.add-questionnaire')}}" class="bg-transparent border-2 border-blue-500 text-black px-4 py-2 rounded-md hover:bg-blue-600 hover:text-white transition duration-200">
            Add New Questionnaire
        </a>
    </header>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($categories as $category)
        <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition transform hover:-translate-y-1 duration-300">
            <h2 class="text-2xl font-semibold text-gray-900 mb-3">{{ $category->title }}</h2>
            <p class="text-gray-700 mb-4">{{ $category->description }}</p>
            <p class="text-gray-800 mb-6">
                <strong class="font-semibold">Trainers: </strong>
                @foreach($category->trainers as $trainer)
                    <a href="{{ route('admin.filter-by-trainer', ['trainerId' => $trainer->id]) }}" class="text-black-500 hover:underline">{{ $trainer->name }}</a>@if(!$loop->last), @endif
                @endforeach
            </p>
            <div class="flex justify-center space-x-3">
                <a href="{{ route('admin.all-questionnaire', ['categoryId' => $category->id]) }}" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-200">Edit Questionnaire</a>
                <a href="{{ route('admin.confirm-delete', $category->id) }}" class="bg-red-500 text-white px-3 py-1 text-sm rounded-md hover:bg-red-600 transition duration-200">Delete Category</a>
            </div>
        </div>
        @endforeach
    </div>
</main>

@include('partials.time-interval')

@endsection
