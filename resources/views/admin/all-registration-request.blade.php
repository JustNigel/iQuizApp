@extends('layouts.admin')

@section('title', 'Request Registration Overview')

@section('content')
<div class="max-w-6xl mx-auto bg-white p-8 rounded-lg shadow-lg">

<div class="flex justify-between mb-2">
        @php
            $previousPage = session('previous_page', 'dashboard');
        @endphp

        @if ($previousPage === 'all-students')
            <a href="{{route('admin.all-students')}}" class="text-indigo-600 hover:text-indigo-700 font-medium inline-block">&larr; Return to All Students</a>
        @else   
            <a href="{{ route('admin.dashboard.dashboard') }}" class="text-indigo-600 hover:text-indigo-700 font-medium inline-block">&larr; Return to Dashboard</a>
        @endif
    </div>
    
    <h1 class="text-3xl font-bold text-gray-900 mb-6 text-center">Student Request Registration Overview</h1>

    <div class="flex justify-center">
        <div class="overflow-x-auto w-full max-w-full">
            <table class="min-w-full bg-gray-50 border border-gray-200 rounded-lg mx-auto">
                <thead>
                    <tr class="bg-gray-100 border-b border-gray-200">
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($requests as $request)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium text-gray-700">{{ $request->name }}</td>
                        <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-600">{{ $request->username }}</td>
                        <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-600">{{ $request->email }}</td>
                        <td class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium">
                            <div class="flex justify-center space-x-3">
                                <a href="{{ route('admin.acceptRequest', $request->id) }}" class="bg-green-500 px-3 py-1 rounded-md text-white hover:bg-green-600 transition duration-150 ease-in-out"><i class="fa-solid fa-check"></i></a>
                                <a href="{{ route('admin.denyRequest', $request->id) }}" class="bg-red-500 px-3 py-1 rounded-md text-white hover:bg-red-600 transition duration-150 ease-in-out"><i class="fa-solid fa-x"></i></a>
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
