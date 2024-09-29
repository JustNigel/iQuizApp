@extends('layouts.app')

@section('title', 'Home Dashboard')

@section('content')
<div class="container mx-auto p-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Categories Section -->
        <div class="bg-softwhite p-4 rounded-lg shadow-md">
            <div class="flex items-center mb-4">
                <i class="fa-solid fa-folder-open text-lg mr-1"></i>
                <h2 class="text-lg font-semibold">Categories</h2>
            </div>
            <div class="flex items-center justify-between bg-gray-200 p-4 rounded-lg mb-2 hover:bg-gray-300 transition duration-300 ease-in-out">
                <a href="{{ route('admin.all-category') }}" class="flex-grow block text-black">
                    <i class="fa-solid fa-list mr-1"></i>
                    All Categories
                </a>
                <a href="{{ route('admin.add-category') }}" class="p-2 bg-gray-300 rounded hover:bg-gray-400 transition duration-300 ease-in-out">
                    <i class="fas fa-plus text-custombg-gray text-lg"></i>
                </a>
            </div>
        </div>
        <!-- Questionnaires Section -->
        <div class="bg-softwhite p-4 rounded-lg shadow-md">
            <div class="flex items-center mb-4">
                <i class="fa-solid fa-file-lines text-lg mr-1"></i>
                <h2 class="text-lg font-semibold">Questionnaires</h2>
            </div>
            <div class="flex items-center justify-between bg-gray-200 p-4 rounded-lg mb-2 hover:bg-gray-300 transition duration-300 ease-in-out">
                <a href="{{route('admin.all-questionnaires')}}" class="flex-grow block text-black">
                    <i class="fa-solid fa-rectangle-list mr-1"></i>
                    All Questionnaires
                </a>
                <a href="{{route('admin.add-questionnaire', ['from' => 'dashboard'])}}" class="p-2 bg-gray-300 rounded hover:bg-gray-400 transition duration-300 ease-in-out">
                    <i class="fas fa-plus text-custombg-gray text-lg"></i>
                </a>
            </div>         
            <div class="flex items-center justify-between bg-gray-200 p-4 rounded-lg mb-2 hover:bg-gray-300 transition duration-300 ease-in-out">
                <a href="{{route('admin.all-confirmed-students', ['from' => 'dashboard'])}}" class="flex-grow block text-black"> 
                    <i class="fa-solid fa-user-group mr-1"></i> 
                    All Students Exam
                </a>
                <div class="relative">
                
                    <a href="{{route('admin.all-exam-request')}}" class="p-2 bg-gray-300 rounded hover:bg-gray-400 transition duration-300 ease-in-out">
                        <i class="fa-solid fa-bell text-custombg-gray text-lg"></i>
                    </a>
                    @if ($pendingExamRequests->count() > 0)
                        <span class="absolute top-0 right-0 transform translate-x-1/2 -translate-y-1/2 w-4 h-4 bg-red-600 text-white text-xs rounded-full flex items-center justify-center">
                            {{ $pendingExamRequests->count() }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <!-- Users Section -->
        <div class="bg-softwhite p-4 rounded-lg shadow-md">
            <div class="flex items-center mb-4">
                <i class="fa-solid fa-gear text-lg mr-1"></i>
                <h2 class="text-lg font-semibold">Manage Users</h2>
            </div>
            <div class="flex items-center justify-between bg-gray-200 p-4 rounded-lg mb-2 hover:bg-gray-300 transition duration-300 ease-in-out">
                <a href="{{route('admin.all-trainers', ['from' => 'dashboard'])}}" class="flex-grow block text-black"> 
                    <i class="fas fa-users mr-1"></i> 
                    All Trainers
                </a>
                <a href="{{route('admin.add-trainer')}}" class="p-2 bg-gray-300 rounded hover:bg-gray-400 transition duration-300 ease-in-out">
                    <i class="fas fa-plus text-custombg-gray text-lg"></i>
                </a>
            </div>
            <div class="flex items-center justify-between bg-gray-200 p-4 rounded-lg mb-2 hover:bg-gray-300 transition duration-300 ease-in-out">
                <a href="{{route('admin.all-students', ['from' => 'dashboard'])}}" class="flex-grow block text-black"> 
                    <i class="fa-solid fa-user-group mr-1"></i> 
                    All Students
                </a>
                <div class="relative">
                    <a href="{{route('admin.all-registration-request', ['from' => 'dashboard'])}}" class="p-2 bg-gray-300 rounded hover:bg-gray-400 transition duration-300 ease-in-out">
                        <i class="fa-solid fa-bell text-custombg-gray text-lg"></i>
                    </a>
                    @if ($pendingRegistrationRequests ->count() > 0)
                        <span class="absolute top-0 right-0 transform translate-x-1/2 -translate-y-1/2 w-4 h-4 bg-red-600 text-white text-xs rounded-full flex items-center justify-center">
                            {{ $pendingRegistrationRequests->count() > 0 }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
