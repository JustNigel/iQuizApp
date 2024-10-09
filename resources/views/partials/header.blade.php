<div class="bg-white shadow p-4 flex justify-between items-center font-satoshi">
    <div class="flex items-center border border-transparent rounded-lg p-1 w-1/2">
        <x-title :routeName="Route::currentRouteName()" :user="$user ?? auth()->user()" />
    </div>


    <!-- Notification Dropdown -->
    <div class="flex">
    <div class="relative mr-4 my-auto">
        <a href="#" id="notificationBell" class="text-blue-500 hover:text-blue-700 relative justify-self-end">
            <i class="fas fa-bell fa-lg"></i>
            @if($pendingExamRequests->count() + $pendingRegistrationRequests->count() > 0)
                <span class="absolute top-0 right-0 inline-block w-4 h-4 bg-red-500 text-white text-xs font-bold rounded-full text-center transform translate-x-1/2 -translate-y-1/2">
                    {{ $pendingExamRequests->count() + $pendingRegistrationRequests->count() }}
                </span>
            @endif
        </a>

        <div id="notificationDropdown" class="hidden absolute z-10 right-0 mt-2 w-64 bg-white border border-gray-200 rounded-lg shadow-lg">
            <div class="p-4 font-semibold border-b border-gray-200">Notifications</div>
            <ul class="max-h-60 overflow-y-auto p-2">
                @php
                    // Merge and sort the requests by created_at in descending order
                    $mergedRequests = $pendingRegistrationRequests->map(function($regRequest) {
                        return [
                            'type' => 'registration',
                            'name' => $regRequest->student_name,
                            'created_at' => $regRequest->created_at,
                        ];
                    })->concat($pendingExamRequests->map(function($examRequest) {
                        return [
                            'type' => 'exam',
                            'name' => $examRequest->student->name,
                            'questionnaire_title' => $examRequest->questionnaire->title,
                            'created_at' => $examRequest->created_at,
                        ];
                    }))->sortByDesc('created_at');
                @endphp

                @forelse($mergedRequests as $request)
                    <li class="p-2 hover:bg-gray-100">
                        <a href="{{ $request['type'] === 'registration' ? route('admin.all-registration-request') : route('admin.all-exam-request') }}" class="block text-sm text-gray-700">
                            @if ($request['type'] === 'registration')
                                {{ $request['name'] }} has registered their account.
                            @else
                                {{ $request['name'] }} has requested access to <span class="text-blue-500">{{ $request['questionnaire_title'] }}</span>.
                            @endif
                            <span class="block text-xs text-gray-500">{{ \Carbon\Carbon::parse($request['created_at'])->format('F j, Y') }}</span>
                        </a>
                    </li>
                @empty
                    <li class="p-2 text-center text-sm text-gray-500">No new notifications</li>
                @endforelse
            </ul>
        </div>
    </div>




    <a href="{{ route('profile') }}">
        <div class="flex items-center space-x-4 mr-4 relative">
            <span class="hidden text-right lg:block">
                <span class="block text-sm font-medium text-black dark:text-black">{{ auth()->user()->name }}</span>
                <span class="block text-xs font-medium">{{ auth()->user()->type_name }}</span>
            </span>
            @if(auth()->user()->image_profile)
                <img src="{{ asset('images/profiles/' . auth()->user()->image_profile) }}" alt="Profile Picture" class="rounded-full w-10 h-10 object-cover">
            @else
                <i class="fas fa-user-circle text-gray-400 text-4xl"></i>
            @endif
        </div>  
    </a>

    </div>


</div>

<script>
    document.getElementById('notificationBell').addEventListener('click', function(event) {
        event.preventDefault();
        var dropdown = document.getElementById('notificationDropdown');
        dropdown.classList.toggle('hidden');
    });
</script>
