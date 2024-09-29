@extends('layouts.admin')

@section('title', 'Category: All Categories')

@section('content')
    @if (session('success'))
            <div id="success-message" class="bg-green-100 border border-green-500 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
    @endif
    @if (session('error'))
        <div id="success-message" class="bg-red-100 border border-red-500 text-red-700 px-4 py-3 rounded-lg mb-6">
                {{ session('error') }}
            </div>
    @endif
    
<div class="max-w-6xl mx-auto bg-white p-8 rounded-lg shadow-lg">
    <div class="flex justify-between mb-6">
        <div>
            @if (Route::is('admin.filter-by-trainer'))
                <a href="{{ route('admin.all-category') }}" class="text-indigo-600 hover:text-indigo-700 font-medium inline-block">&larr; Return to All Categories</a>
            @else
                <a href="{{ route('admin.dashboard.dashboard') }}" class="text-indigo-600 hover:text-indigo-700 font-medium inline-block">&larr; Return to Dashboard</a>
            @endif
        </div>
        <div>
            <a href="{{ route('admin.add-category', ['from' => 'all-categories']) }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200 mr-4">
                <i class="fa-solid fa-plus mr-2"></i>New Category
            </a>
            <a href="{{ route('admin.add-questionnaire', ['from' => 'all-categories']) }}" class="bg-green-500 border-2 border-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 hover:text-white transition duration-200">
                <i class="fa-solid fa-plus mr-2"></i>New Questionnaire
            </a>
        </div>
    </div>

    <h1 class="text-3xl font-bold text-gray-900 mb-6 text-center">All Categories</h1>

    <div class="flex justify-center">
        <div class="overflow-x-auto w-full max-w-full">
            <table class="min-w-full bg-white rounded-lg mx-auto">
                <thead>
                    <tr class="bg-gray-100 border-b border-gray-200">
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Category Title</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Trainers</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($categories as $category)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium text-gray-700">{{ $category->title }}</td>
                        <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-600">{{ $category->description }}</td>
                        <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-600">
                            @foreach($category->trainers as $trainer)
                                <a href="{{ route('admin.filter-by-trainer', ['trainerId' => $trainer->id]) }}" class="text-black-500 hover:underline">{{ $trainer->name }}</a>@if(!$loop->last), @endif
                            @endforeach
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium">
                            <div class="flex justify-center space-x-3">
                                <a title="Edit Category" href="{{ route('admin.edit', $category->id) }}" class="bg-blue-500 px-3 py-1 rounded-md text-white hover:bg-blue-600 transition duration-150 ease-in-out">
                                    <i class="fa-solid fa-gear"></i></a>
                                <a title="View All Questionnaires" href="{{ route('admin.all-questionnaire', ['categoryId' => $category->id]) }}" target="_blank" class="bg-green-500 px-3 py-1 rounded-md text-white hover:bg-green-600 transition duration-150 ease-in-out">
                                    <i class="fa-solid fa-list"></i></a>
                                <a title="Delete Category" href="{{ route('admin.confirm-delete', $category->id) }}" class="bg-red-500 px-3 py-1 rounded-md text-white hover:bg-red-600 transition duration-150 ease-in-out">
                                    <i class="fa-solid fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-6">
        {{ $categories->links() }}
    </div>
</div>

    @include('partials.time-interval')

@endsection
