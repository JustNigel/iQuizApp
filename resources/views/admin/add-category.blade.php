@extends('layouts.admin')

@section('title', 'Categories: New')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md">
    @php
        // Get the previous page from the session
        $previousPage = session('previous_page', 'dashboard');
    @endphp

    @if ($previousPage === 'all-categories')
        <a href="{{ route('admin.all-category') }}" class="text-indigo-600 hover:text-indigo-700 font-medium inline-block">&larr; Return to All Categories</a>
    @else
        <a href="{{ route('admin.dashboard.dashboard') }}" class="text-indigo-600 hover:text-indigo-700 font-medium inline-block">&larr; Return to Dashboard</a>
    @endif
    
    <h1 class="text-3xl font-semibold mb-6 text-center">Create Category</h1>

    <form action="{{ route('admin.store-category') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Side: Title and Description -->
            <div class="space-y-6">
                <div>
                    <label for="title" class="block text-lg font-medium text-gray-700">Title</label>
                    <input type="text" id="title" name="title" class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2" required>
                </div>

                <div>
                    <label for="details" class="block text-lg font-medium text-gray-700">Description</label>
                    <textarea id="details" name="details" rows="4" class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2" required></textarea>
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
                        <input type="checkbox" id="trainer_{{ $trainer->id }}" name="trainer_id[]" value="{{ $trainer->id }}" class="hidden peer" onchange="updateTrainerCount()">
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
                    Selected Trainers: <span id="selectedCount">0</span>
                </div>



            </div>
        </div>

        <div>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Submit</button>
        </div>
    </form>
</div>
@endsection
