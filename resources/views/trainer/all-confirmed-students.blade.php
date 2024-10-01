@extends('layouts.admin')

@section('title', 'All Students Confirmed Exams')

@section('content')
<div class="max-w-6xl mx-auto bg-white p-8 rounded-lg shadow-lg">
    <div class="flex justify-between mb-6">
        @php
            // Get the previous page from the session
            $previousPage = session('previous_page', 'dashboard');
        @endphp

        @if ($previousPage === 'all-exams')
            <a href="{{route('trainer.dashboard')}}" class="text-indigo-600 hover:text-indigo-700 font-medium inline-block">&larr; Return to All Categories</a>
        @else
            <a href="{{route('trainer.dashboard')}}" class="text-indigo-600 hover:text-indigo-700 font-medium inline-block">&larr; Return to Dashboard</a>
        @endif

        <div class="flex space-x-4">
            <a href="#" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200">
                Review Exam History
            </a>
            <a href="#" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-200">
                Accepted Students
            </a>
            <a href="{{ route('trainer.all-exam-request', ['from' => 'all-exams']) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 transition duration-200">
                Exam Requests
            </a>
        </div>
    </div>

    

    <h1 class="text-3xl font-bold text-gray-900 mb-6 text-center">All Students Exam Overview</h1>

    <div class="flex justify-center">
        <div class="overflow-x-auto w-full max-w-full">
            <table class="min-w-full bg-gray-50 border border-gray-200 rounded-lg mx-auto">
                <thead>
                    <tr class="bg-gray-100 border-b border-gray-200">
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Student Name</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Exam Requested</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Request Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($confirmedStudents as $confirmedStudent)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium text-gray-700">{{ $confirmedStudent->name }} {{ $confirmedStudent->last_name }}</td>
                        <td class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium text-gray-700">{{ $confirmedStudent->title }}</td>
                        <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-600">{{ $confirmedStudent->questionnaire_title }}</td>
                        <td class="px-6 py-4 text-orange-600 text-center whitespace-nowrap text-sm text-gray-600">{{ $confirmedStudent->request_status }}</td>
                        <td class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium">
                            <div class="flex justify-center space-x-3">
                                <a href="#" class="text-blue-500 hover:text-blue-700 transition duration-150 ease-in-out"><i class="fa-solid fa-eye"></i></a>
                                <a href="{{route('trainer.confirm-delete-access', $confirmedStudent -> id)}}" class="text-red-500 hover:text-red-700 transition duration-150 ease-in-out"><i class="fa-solid fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>
@endsection
