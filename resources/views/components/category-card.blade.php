<div class="category-card relative bg-white p-6 rounded-lg shadow-lg transition transform hover:-translate-y-1 duration-300">
    <h5 class="mb-2 text-2xl font-bold tracking-tight text-[#261212]">
        {{ $title }}
    </h5>
    <hr class="my-4 border-gray-300">
    <p class="mb-6 font-normal text-[#261212]">
        {{ $description }}
    </p>
    <p class="mb-4 font-normal text-[#261212]">
        <strong>Questionnaire:</strong> {{ $questionnaireTitle }}
    </p>
    <p class="mb-4 font-normal text-[#261212]">
        <strong>Trainer:</strong> {{ $trainerName }}
    </p>

    <p class="mb-4 font-normal text-[#261212]">
        <strong>Time Interval:</strong> {{ $questionnaireTimeInterval }}
    </p>
    <p class="mb-10 font-normal text-[#261212] flex items-center">
        <strong class="mr-2">Passing Grade:</strong>
        <span class="text-[#006400]">{{ $passingGrade }}%</span>
    </p>

    <div class="absolute bottom-4 right-4">
        @if($requestStatus === 'accepted')
            <span class="text-green-500 font-semibold mr-3">Accepted</span>
        @elseif($requestStatus === 'pending')
            <form action="{{ route('exam.request.cancel', $requestId) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="mt-4 inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300">
                    Cancel Request &rarr;
                </button>
            </form>
        @else
            <form action="{{ route('exam.request.store') }}" method="POST">
                @csrf
                <input type="hidden" name="category_id" value="{{ $categoryId }}">
                <input type="hidden" name="trainer_id" value="{{ $trainerId }}">
                <input type="hidden" name="questionnaire_id" value="{{ $questionnaireId }}">
                <button type="submit" class="mt-4 inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                    Request to Join &rarr;
                </button>
            </form>
        @endif
    </div>
</div>
