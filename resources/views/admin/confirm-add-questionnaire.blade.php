@extends('layouts.admin')

@section('content')
<div class="max-w-lg mx-auto mt-8">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold mb-4">Confirm Submission</h2>
        <p>Are you sure you want to insert the following information "<strong>{{ $data['title'] }}</strong>"?</p>
        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('admin.add-questionnaire') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition duration-200">Cancel</a>
            
            <form action="{{ route('admin.store-questionnaire') }}" method="POST">
                @csrf
                <input type="hidden" name="title" value="{{ $data['title'] }}">
                <input type="hidden" name="number_of_items" value="{{ $data['number_of_items'] }}">
                <input type="hidden" name="time_interval" value="{{ $data['time_interval'] }}">
                <input type="hidden" name="passing_grade" value="{{ $data['passing_grade'] }}">
                <input type="hidden" name="category_id" value="{{ $data['category_id'] }}">
                <input type="hidden" name="trainer_id" value="{{ $data['trainer_id'] }}">
                <input type="hidden" name="shuffle" value="{{ $data['shuffle'] ?? 0 }}">
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition duration-200">Confirm</button>
            </form>
        </div>
    </div>
</div>
@endsection
