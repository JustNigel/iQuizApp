@extends('layouts.admin')

@section('title', 'Request Exam Overview')

@section('content')
<div class="max-w-6xl mx-auto bg-white p-8 rounded-lg shadow-lg">
    <div class="flex justify-between mb-6">
        <a href="{{route('admin.dashboard.dashboard')}}" class="text-indigo-600 hover:text-indigo-700 font-medium inline-block">&larr; Return to Dashboard</a>
        <a href="{{ route('admin.all-confirmed-students') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200">
            View All Students Exam
        </a>
    </div>
    <h1 class="text-3xl font-bold text-gray-900 mb-6 text-center">Student Request Exam Overview</h1>

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
                    @foreach($exam_requests as $exam_request)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium text-gray-700">{{ $exam_request->name }} {{$exam_request->last_name}}</td>
                        <td class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium text-gray-700">{{ $exam_request->title}}</td>
                        <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-600">{{ $exam_request->questionnaire_title }}</td>
                        <td class="px-6 py-4 text-orange-600 text-center whitespace-nowrap text-sm text-gray-600">{{ $exam_request->request_status }}</td>
                        <td class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium">
                            <div class="flex justify-center space-x-3">
                                <form action="{{ route('exam.request.accept', $exam_request->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="bg-green-500 px-3 py-1 rounded-md text-white hover:bg-green-600 transition duration-150 ease-in-out"><i class="fa-solid fa-check"></i></button>
                                </form>
                                <form action="{{ route('admin.denyExamRequest', $exam_request->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 px-3 py-1 rounded-md text-white hover:bg-red-600 transition duration-150 ease-in-out"><i class="fa-solid fa-x"></i></button>
                                </form>
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
