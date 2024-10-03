@extends('layouts.app')

@section('title', 'Home Dashboard')

@section('content')
<div class="container mx-auto p-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Categories Section -->
        <div class="bg-softwhite p-4 rounded-lg shadow-md">
            <div class="flex items-center mb-4">
                <i class="fa-solid fa-file-lines text-lg mr-1"></i>
                <h2 class="text-lg font-semibold">Questionnaires</h2>
            </div>
            <div class="flex items-center justify-between bg-gray-200 p-4 rounded-lg mb-2 hover:bg-gray-300 transition duration-300 ease-in-out">
                <a href="{{ route('category.join') }}" class="flex-grow block text-black">
                    <i class="fa-solid fa-list mr-1"></i>
                    Join an Exam
                </a>
            </div>
            <div class="flex items-center justify-between bg-gray-200 p-4 rounded-lg mb-2 hover:bg-gray-300 transition duration-300 ease-in-out">
                <a href="{{ route('category.join') }}" class="flex-grow block text-black">
                    <i class="fa-solid fa-list mr-1"></i>
                    Available Exams
                </a>
            </div>
        </div>
        
        <div class="bg-softwhite p-4 rounded-lg shadow-md">
            <div class="flex items-center mb-4">
                <i class="fa-solid fa-gear text-lg mr-1"></i>
                <h2 class="text-lg font-semibold">Manage Users</h2>
            </div>
            <div class="flex items-center justify-between bg-gray-200 p-4 rounded-lg mb-2 hover:bg-gray-300 transition duration-300 ease-in-out">
                <a href="{{route('profile')}}" class="flex-grow block text-black"> 
                    <i class="fa-solid fa-user-circle mr-1"></i>
                    Your Profile
                </a>
            </div>
        
        </div>
    </div>
</div>
@endsection
