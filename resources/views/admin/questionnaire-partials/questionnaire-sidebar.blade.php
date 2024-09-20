<div class="w-full bg-white rounded-lg p-6 h-full flex flex-col">
    <h4 class="text-xl font-semibold mb-4 border-b pb-2">Question List</h4>

    <div class="flex-grow overflow-y-auto mb-6">
        @if($questions->isEmpty())
            <p class="text-gray-500">No questions have been created.</p>
        @else
            <ul class="space-y-2 max-h-full">
                @foreach($questions as $question)
                    <li class="text-gray-700 bg-gray-50 p-3 rounded hover:bg-gray-100 border">
                        {{ $loop->iteration }}. {{ $question->question_text }}
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <button class="bg-blue-700 text-gray-100 p-3 rounded-md w-full hover:bg-custom-blue-800 sticky bottom-0">
        + Add Question
    </button>
</div>
