@extends('layouts.admin')

@section('title', 'All Questionnaires')

@section('content')
    <div class="max-w-6xl mx-auto bg-white p-8 rounded-lg shadow-lg">  
    <a href="{{ route('admin.dashboard.dashboard') }}" class="text-indigo-600 hover:text-indigo-700 font-medium inline-block">&larr; Return to Dashboard</a>
   
        <h1 class="text-3xl font-bold text-gray-900 mb-6 text-center">All Questionnaires</h1>

        <div class="flex justify-center">
            <div class="overflow-x-auto w-full max-w-full">
                <table class="min-w-full bg-white rounded-lg mx-auto">
                    <thead>
                        <tr class="bg-gray-100 border-b border-gray-200">
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Number of Items</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Time Interval</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Passing Grade</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Accessible</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($questionnaires as $questionnaire)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium text-gray-700">{{ $questionnaire->title }}</td>
                            <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-600">{{ $questionnaire->number_of_items }}</td>
                            <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-600">{{ $questionnaire->time_interval }}</td>
                            <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-600">{{ $questionnaire->passing_grade }}</td>
                            <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-600">{{ $questionnaire->category->title ?? 'N/A' }}</td>
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
                            <td class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium">
                                <div class="flex justify-center space-x-3">
                                    <a title="Edit Questionnaire" href="{{route('admin.edit-questionnaire', [$questionnaire->id, 'from' => 'all-questionnaires'])}}" class="bg-blue-500 px-3 py-1 rounded-md text-white hover:bg-blue-600 transition duration-150 ease-in-out">
                                        <i class="fa-solid fa-gear"></i></a>
                                    <a title="View History" target="_blank" href="#" class="bg-green-500 px-3 py-1 rounded-md text-white hover:bg-green-600 transition duration-150 ease-in-out">
                                        <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                                    <a title="Delete Questionnaire" href="{{ route('admin.confirm-delete-questionnaire', $questionnaire->id) }}" class="bg-red-500 px-3 py-1 rounded-md text-white hover:bg-red-600 transition duration-150 ease-in-out">
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
            {{ $questionnaires->links() }} 
        </div>

    </div>
    @include('partials.time-interval')
@endsection
