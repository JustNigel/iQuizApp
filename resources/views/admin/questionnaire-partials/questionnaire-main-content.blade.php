<div class="flex-1 p-4">
    <div class="bg-white p-6 rounded-lg border shadow-lg">
        <form id="questionForm" action="{{ route('questions.store', ['id' => $questionnaire->id]) }}" method="POST">
            @csrf
            <input type="text" name="question_text" placeholder="Question" class="w-full text-custom-black text-xl font-bold p-3 border-0 rounded-lg mb-4">
            <input type="hidden" name="questionnaire_id" value="{{ $questionnaire->id }}">
            <input type="hidden" name="points" id="points-hidden" value="1">
            <input type="hidden" name="question_type" id="question-type-hidden">
            <input type="hidden" name="selected_values" value='{}'>

            
        
            <div id="answers-container">
        </div>

        <div id="matching-key-container" class="hidden p-4 border rounded bg-gray-100">
            <div class="flex items-center mb-4">
                <h2 class="text-xl font-semibold">Matching Keys</h2>
                <span id="reload-matching-key" class="cursor-pointer text-gray-500 hover:text-gray-700">
                    <i class="fas fa-sync-alt"></i>
                </span>
            </div>
            <div id="matching-key-list" class="space-y-2">
            </div>
            <button id="save-matching-key" class="bg-blue-500 text-white p-2 rounded">Save</button>
        </div>

        <div id="file-inputs-container" class="mb-4 mt-4">
            <!-- File inputs will be added here -->
        </div>

            <button id="add-answer-btn" type="button" class="bg-gray-200 p-3 rounded-lg shadow-sm mb-2">+ Add Answer</button>
            <button id="add-file-btn" type="button" class="bg-gray-200 p-3 rounded-lg shadow-sm mb-2">+ Add File</button>
            <button id="submit-question-btn" type="submit" class="bg-blue-700 text-gray-100 p-3 rounded-lg shadow-lg hover:bg-blue-800">Submit Question</button>
        </form>
    </div>
</div>