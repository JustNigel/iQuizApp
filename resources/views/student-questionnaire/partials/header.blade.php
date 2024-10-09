<div class="bg-custombg-gray shadow p-4 flex items-center font-satoshi h-12">
    <a href="{{route('student.exam', $questionnaire->id)}}" class="flex items-center space-x-2 mr-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        <span class="text-gray-200 text-sm font-medium">Back</span>
    </a>
    <div class="flex-1 flex justify-center">
        <h2 class="text-lg text-gray-100 font-semibold">MS Azure Fundamentals Exam</h2>
    </div>
    <a href="{{ route('profile') }}">
        <div class="flex items-center space-x-4 mr-4">
            <span class="hidden text-right lg:block">
                <span class="block text-sm font-medium text-gray-200 dark:text-gray-100">Jameer Aguilar</span>
                <span class="block text-xs font-medium text-gray-200">Video Editor</span>
            </span>
            <img src="{{ asset('images/jameer.jpg') }}" alt="User" class="rounded-full w-10 h-10">
        </div>
    </a>
</div>
