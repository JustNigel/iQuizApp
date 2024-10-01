@extends('layouts.admin')

@section('title', 'Confirm Deletion')

@section('content')
<div class="max-w-lg mx-auto mt-8">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold mb-4">Confirm Deletion</h2>
        <p>Are you sure you want to remove access for "<strong>{{ $exam->student_name }}</strong>" in {{$exam -> title}}?</p>
        
        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('trainer.all-confirmed-students') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition duration-200">Cancel</a>
            <form action="{{ route('trainer.delete-exam-request', $exam->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition duration-200">Confirm</button>
            </form>
        </div>
    </div>
</div>
@endsection
