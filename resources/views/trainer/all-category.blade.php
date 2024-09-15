@extends('layouts.admin')

@section('title', 'All Categories')

@section('content')

    @if (session('success'))
        <div id="success-message" class="bg-green-100 border border-green-500 text-green-700 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div id="error-message" class="bg-red-100 border border-red-500 text-red-700 px-4 py-3 rounded-lg mb-6">
            {{ session('error') }}
        </div>
    @endif



<div class="max-w-6xl mx-auto bg-white p-8 rounded-lg shadow-lg">
    <h1 class="text-3xl font-bold text-gray-900 mb-6 text-center">All Catergories</h1>

    <div class="flex justify-center">
        <div class="overflow-x-auto w-full max-w-full">
            <table class="min-w-full bg-gray-50 border border-gray-200 rounded-lg mx-auto">
                <thead>
                    <tr class="bg-gray-100 border-b border-gray-200">
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Category Name
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Trainer Name
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Exams Created
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($categories as $category)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium text-gray-700">
                        {{ $category->title }}
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-700">
                            @foreach($category->trainers as $trainer)
                                <span class="text-black-500">{{ $trainer->name }}</span>@if(!$loop->last), @endif
                            @endforeach
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-600">
                            Missing exams created
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium">
                            <div class="flex justify-center space-x-3">
                                <a href="#" class="bg-green-500 px-3 py-1 rounded-md text-white hover:bg-green-600 transition duration-150 ease-in-out"><i class="fas fa-pencil-alt"></i></a>
                                <a href="{{ route('trainer.confirm-delete', $category->id) }}" class="bg-red-500 text-white px-3 py-1 text-sm rounded-md hover:bg-red-600 transition duration-200"> <i class="fas fa-trash"></i></a>
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
