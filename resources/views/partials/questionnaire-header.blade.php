<div class="bg-custombg-gray shadow p-4 flex items-center font-satoshi h-20">
    <a href="{{route('category.available-exams')}}" class="flex items-center space-x-2 mr-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        <a href="{{route('category.available-exams')}}" class="text-gray-200 text-sm font-medium">Back</a>
    </a>
    <div class="flex-1 flex justify-center">
        <h2 class="text-lg text-gray-100 font-semibold">{{$questionnaire->title}}</h2>
    </div>
    <a href="{{ route('profile') }}">
        <div class="flex items-center space-x-4 mr-4">
            <span class="hidden text-right lg:block">
                <span class="block text-sm font-medium text-gray-200 dark:text-gray-100">{{$user->name}} {{$user->last_name}}</span>
                <span class="block text-xs font-medium text-gray-200">{{$user -> type_name}}</span>
            </span>
            @if(auth()->user()->image_profile)
                <img src="{{ asset('images/profiles/' . auth()->user()->image_profile) }}" alt="Profile Picture" class="rounded-full w-10 h-10 object-cover">
            @else
                <i class="fas fa-user-circle text-gray-400 text-4xl"></i>
            @endif
        </div>
    </a>
</div>
