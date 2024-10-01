<div class="bg-white shadow p-4 flex justify-between items-center font-satoshi">
    <div class="flex items-center border border-transparent rounded-lg p-1 w-1/2">
        <h2 class="text-1.2rem font-400 flex items-center">
            @php
                $titles = [
                    'admin.dashboard.dashboard' => '<i class="fa-solid fa-house mr-2"></i> Welcome to your Dashboard, Admin',
                    'admin.all-confirmed-students' => '<i class="fa-solid fa-file-lines mr-2"></i> Questionnaires: All Students',
                    'admin.all-exam-request' => '<i class="fa-solid fa-file-lines mr-2"></i> Questionnaires: All Exam Requests',
                    'admin.edit-trainer-profile' => '<i class="fa-solid fa-user-gear mr-2"></i> Users: Edit Trainer Profile',
                    'admin.all-trainers' => '<i class="fa-solid fa-user-gear mr-2"></i> Users: All Trainers',
                    'admin.all-questionnaires' => '<i class="fa-solid fa-file-lines mr-2"></i> Questionnaires: All Questionnaires',
                    'admin.delete-trainer' => '<i class="fa-solid fa-user-gear mr-2"></i> Users: Confirm Delete Trainer',
                    'admin.all-category' => '<i class="fa-solid fa-folder mr-2"></i> Categories: All Categories',
                    'admin.add-category' => '<i class="fa-solid fa-folder mr-2"></i> Categories: New Category',
                    'admin.confirm-delete-student' => '<i class="fa-solid fa-user-gear mr-2"></i> Users: Confirm Delete Student',
                    'admin.add-trainer' => '<i class="fa-solid fa-user-gear mr-2"></i> Users: Add Trainer',
                    'admin.all-students' => '<i class="fa-solid fa-user-gear mr-2"></i> Users: All Students',
                    'admin.all-registration-request' => '<i class="fa-solid fa-user-gear mr-2"></i> Users: All Registration Request',
                    'admin.filter-by-trainer' => '<i class="fa-solid fa-folder mr-2"></i> Categories: All Filtered Categories',
                    'admin.add-questionnaire' => '<i class="fa-solid fa-file-lines mr-2"></i> Questionnaires: New Questionnaire',
                    'admin.add-another-questionnaire' => '<i class="fa-solid fa-file-lines mr-2"></i> Questionnaires: New Questionnaire',
                    'trainer.dashboard' => '<i class="fa-solid fa-house-user mr-2"></i> Welcome to your Dashboard, Trainer',
                    
                    
                    
                    'trainer.all-category' => '<i class="fa-solid fa-th-list mr-2"></i> All Categories',
                    'trainer.all-students' => '<i class="fa-solid fa-user-gear mr-2"></i> Users: All Students',
                    'trainer.all-questionnaires' => '<i class="fa-solid fa-file-lines mr-2"></i> Questionnaires: All Questionnaires',
                    'trainer.all-confirmed-students' => '<i class="fa-solid fa-user-gear mr-2"></i> Questionnaires: All Students',
                    'trainer.all-registration-request' => '<i class="fa-solid fa-user-gear mr-2"></i> Users: All Registration Request',
                    'trainer.add-questionnaire' => '<i class="fa-solid fa-file-alt mr-2"></i> Add Questionnaire',
                    'profile' => '<i class="fa-solid fa-user-circle mr-2"></i>Your Profile'
                ];

                $currentRoute = Route::currentRouteName();
                $title = $titles[$currentRoute] ?? 'Dashboard';

                switch ($currentRoute) {
                    case 'trainer.dashboard':
                    case 'admin.dashboard.dashboard':
                    case 'student.dashboard':
                        $title .= ' ' . $user->name . '!';
                        break;
                }
            @endphp
            {!! $title !!}
        </h2>
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




        <a href="{{route('profile')}}">
            <div class="flex items-center space-x-4 mr-4 relative">
                <span class="hidden text-right lg:block">
                    <span class="block text-sm font-medium text-black dark:text-black">{{$user -> name}}</span>
                    <span class="block text-xs font-medium">{{$user -> type_name}}</span>
                </span>
                <img src="{{ asset('images/jameer.jpg') }}" alt="User" class="rounded-full w-10 h-10">
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
