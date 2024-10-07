@extends('layouts.app')

@section('title', 'Available Exams')

@section('content')

    <div class="container mt-6">
        @if($cards->count() > 0)
            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Questionnaire Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trainer Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Passing Grade</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time Interval</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($cards as $card)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $card->category_title }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $card->questionnaire_title }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $card->trainer_name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $card->passing_grade }}%</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $card->time_interval }} mins</td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                @if(!$card->is_visible && $card->request_status == 'accepted') <!-- Correct property name -->
                                    <!-- Eye Slash Icon for not visible questionnaire -->
                                    <span class="text-gray-500">
                                        <i class="fas fa-eye-slash"></i>
                                    </span>
                                @else
                                    <!-- Show View History and Start Exam buttons if questionnaire is visible -->
                                    <a href="#" class="text-blue-500 hover:text-blue-700">View History</a>
                                    <a href="{{ route('student.exam', $card->questionnaire_id) }}" class="text-green-500 hover:text-green-700 ml-2">Start Exam</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-center">No available exams found</p>
        @endif
    </div>

@endsection
