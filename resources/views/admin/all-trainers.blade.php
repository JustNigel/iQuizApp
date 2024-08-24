@extends('layouts.admin')

@section('title', 'Trainer Overview')

@section('content')
<div class="max-w-6xl mx-auto bg-white p-8 rounded-lg shadow-lg">
    <h1 class="text-3xl font-bold text-gray-900 mb-6 text-center">Trainer Overview</h1>

    <div class="flex justify-center">
        <div class="overflow-x-auto w-full max-w-full">
            <table class="min-w-full bg-gray-50 border border-gray-200 rounded-lg mx-auto">
                <thead>
                    <tr class="bg-gray-100 border-b border-gray-200">
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Trainer Name
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Exams Created
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Number of Respondents
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            View All Categories
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($trainers as $trainer)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium text-gray-700">
                            {{ $trainer->name }} {{ $trainer->last_name }}
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-600">
                            @foreach($trainer->examCategories as $category)
                                <div>{{ $category->title }}</div>
                            @endforeach
                        </td>
                        
                        <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-600">
                            0
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-600">
                            <div class="flex justify-center space-x-3">
                                <a href="#" class="text-blue-500 hover:text-blue-700 transition duration-150 ease-in-out">View Categories</a>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium">
                            <div class="flex justify-center space-x-3">
                                <a href="#" class="text-blue-500 hover:text-blue-700 transition duration-150 ease-in-out">Edit</a>
                                <a href="{{ route('admin.delete-trainer', $trainer->id) }}" class="text-red-500 hover:text-red-700 transition duration-150 ease-in-out">Delete</a>
                            </div>
                        </td>
                    </tr>
                    <!-- Repeat rows as needed -->
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

<!-- <tbody class="divide-y divide-gray-200">
                    @foreach($trainers as $trainer)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium text-gray-700">
                            {{ $trainer->name }}
                        </td>   
                        <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-600">
                            @foreach($trainer->examCategories as $category)
                                <div>{{ $category->title }}</div>
                            @endforeach
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium">
                            <div class="flex justify-center space-x-3">
                                <a href="#" class="text-blue-500 hover:text-blue-700 transition duration-150 ease-in-out">View Details</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody> -->