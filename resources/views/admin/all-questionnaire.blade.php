@extends('layouts.admin')

@section('title', 'All Questionnaires')

@section('content')
<div class="max-w-5xl mx-auto bg-white p-8 rounded-lg shadow-md">
    <a href="{{ route('admin.all-category') }}" class="text-indigo-600 hover:text-indigo-700 font-medium mb-6 inline-block">&larr; Back</a>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-semibold">All Existing Questionnaires</h1>
        <a href="{{ route('admin.add-another-questionnaire', ['categoryId' => $category->id]) }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200">
            Create New Questionnaire
        </a>

    </div>
    <div>
        <table class="min-w-full divide-y divide-gray-200"> 
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Number of Items</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Time Interval</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Passing Grade</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Trainer</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($questionnaires as $questionnaire)
                <tr>
                    <td class="px-6 py-4 text-center whitespace-nowrap">{{ $questionnaire->title }}</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">{{ $questionnaire->number_of_items }}</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">{{ $questionnaire->time_interval }}</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">{{ $questionnaire->passing_grade }}</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">{{ $questionnaire->category->title }}</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">{{ $questionnaire->trainer->name }}</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">
                        <a href="#" class="text-indigo-600 hover:text-indigo-700 mr-4">Edit</a>
                        <a href="#" class="text-red-600 hover:text-red-700">Delete</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
