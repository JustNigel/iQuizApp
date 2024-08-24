@extends('layouts.admin')

@section('title', 'Request Registration Overview')

@section('content')
<div class="max-w-6xl mx-auto bg-white p-8 rounded-lg shadow-lg">
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
                                <a href="{{ route('admin.acceptRequest', $request->id) }}" class="text-blue-500 hover:text-blue-700 transition duration-150 ease-in-out">Accept</a>
                                <a href="{{ route('admin.denyRequest', $request->id) }}" class="text-red-500 hover:text-red-700 transition duration-150 ease-in-out">Deny</a>
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
