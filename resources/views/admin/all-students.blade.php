@extends('layouts.admin')

@section('title', 'Student Overview')

@section('content')
<div class="max-w-6xl mx-auto bg-white p-8 rounded-lg shadow-lg">
    <div class="flex justify-between mb-2">
        @php
            $previousPage = session('previous_page', 'dashboard');
        @endphp

        @if ($previousPage === 'all-students')
            <a href="#" class="text-indigo-600 hover:text-indigo-700 font-medium inline-block">&larr; Return to All Students</a>
        @else   
            <a href="{{ route('admin.dashboard.dashboard') }}" class="text-indigo-600 hover:text-indigo-700 font-medium inline-block">&larr; Return to Dashboard</a>
        @endif
            <a href="{{ route('admin.all-registration-request', ['from' => 'all-students']) }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200">
                Registration Requests
            </a>   
    </div>
    <h1 class="text-3xl font-bold text-gray-900 mb-6 text-center">Student Overview</h1>

    <div class="flex justify-center">
        <div class="overflow-x-auto w-full max-w-full">
            <table class="min-w-full bg-gray-50 border border-gray-200 rounded-lg mx-auto">
                <thead>
                    <tr class="bg-gray-100 border-b border-gray-200">
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Student Name
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Request Status
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Username
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Email
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($student as $student)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium text-gray-700">
                            {{ $student->name }} {{ $student->last_name }}
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-green-600">
                            {{ $student->request_status }}
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-600">
                            {{ $student->username }}
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-600">
                            {{ $student->email }}
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium">
                            <div class="flex justify-center space-x-3">
                                <a href="#" class="bg-blue-500 px-3 py-1 rounded-md text-white hover:bg-blue-600 transition duration-150 ease-in-out"><i class="fas fa-pencil-alt"></i></a>
                                <a href="{{ route('admin.confirm-delete-student', $student->id) }}" class="bg-red-500 px-3 py-1 rounded-md text-white hover:bg-red-600 transition duration-150 ease-in-out"><i class="fas fa-trash"></i></a>
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
