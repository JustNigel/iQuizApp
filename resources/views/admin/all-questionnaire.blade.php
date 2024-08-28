@extends('layouts.admin')

@section('title', 'All Questionnaires')

@section('content')
<div class="max-w-6xl mx-auto bg-white p-8 rounded-lg shadow-lg">
    <a href="{{ route('admin.all-category') }}" class="text-indigo-600 hover:text-indigo-700 font-medium mb-6 inline-block">&larr; Back</a>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-semibold">All Existing Questionnaires</h1>
        <a href="{{ route('admin.add-another-questionnaire', ['categoryId' => $category->id]) }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200">
            Create New Questionnaire
        </a>
    </div>
    <div class="overflow-x-auto w-full max-w-full">
        <table class="min-w-full divide-y divide-gray-200"> 
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Number of Items</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Time Interval</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Passing Grade</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Trainer</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Accessible</th>
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
                        <form action="{{ route('questionnaire.toggle-visibility', $questionnaire->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="focus:outline-none" aria-label="Toggle Visibility">
                                @if($questionnaire->access_status === 'visible')
                                    <i class="fas fa-eye text-green-500"></i>
                                @else
                                    <i class="fas fa-eye-slash text-red-500"></i>
                                @endif
                            </button>
                        </form>
                    </td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">
                        <a href="{{ route('admin.edit-questionnaire', $questionnaire->id) }}" class="text-blue-600 hover:text-indigo-700 mr-4">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <a href="{{ route('admin.confirm-delete-questionnaire', $questionnaire->id) }}" class="text-red-600 hover:text-red-700">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
