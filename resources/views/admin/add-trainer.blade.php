@extends('layouts.admin')

@section('title', 'Add Trainer')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md">
    <h1 class="text-3xl font-semibold mb-6">Add Trainer</h1>

    <form action="{{ route('admin.store-trainer') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label for="name" class="block text-lg font-medium text-gray-700">First Name</label>
            <input type="text" id="name" name="name" class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2" value="{{ old('name') }}" required>
            @error('name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="last_name" class="block text-lg font-medium text-gray-700">Last Name</label>
            <input type="text" id="last_name" name="last_name" class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2" value="{{ old('last_name') }}" required>
            @error('last_name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-lg font-medium text-gray-700">Email</label>
            <input type="email" id="email" name="email" class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2" value="{{ old('email') }}" required>
            @error('email')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-lg font-medium text-gray-700">Password</label>
            <input type="password" id="password" name="password" class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2" required>
            @error('password')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-lg font-medium text-gray-700">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2" required>
            @error('password_confirmation')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block text-lg font-medium text-gray-700">Role</label>
            <div class="mt-2 flex items-center space-x-6">
                <div>
                    <input type="radio" id="admin" name="type_name" value="admin" class="mr-2" {{ old('type_name') === 'admin' ? 'checked' : '' }} required>
                    <label for="admin" class="text-gray-700">Admin</label>
                </div>
                <div>
                    <input type="radio" id="trainer" name="type_name" value="trainer" class="mr-2" {{ old('type_name') === 'trainer' ? 'checked' : '' }} required>
                    <label for="trainer" class="text-gray-700">Trainer</label>
                </div>
            </div>
            @error('type_name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Register</button>
        </div>
    </form>
</div>
@endsection
