<div class="bg-white shadow p-4 flex justify-between items-center font-satoshi">
    <div class="flex items-center border border-transparent rounded-lg p-1 w-1/2">
        <h2 class="text-1.2rem font-400 flex items-center">
            @php
                $titles = [
                    'admin.dashboard.dashboard' => '<i class="fa-solid fa-house mr-2"></i> Welcome to your Dashboard, Admin',
                    'admin.all-confirmed-students' => '<i class="fa-solid fa-file-lines mr-2"></i> Questionnaires: All Students',
                    'admin.all-exam-request' => '<i class="fa-solid fa-user-gear mr-2"></i> Questionnaires: All Exam Requests',
                    'admin.edit-trainer-profile' => '<i class="fa-solid fa-user-gear mr-2"></i> Users: Edit Trainer Profile',
                    'admin.all-trainers' => '<i class="fa-solid fa-user-gear mr-2"></i> Users: All Trainers',
                    'admin.delete-trainer' => '<i class="fa-solid fa-user-gear mr-2"></i> Users: Confirm Delete Trainer',
                    'admin.all-category' => '<i class="fa-solid fa-folder mr-2"></i> Categories: All Categories',
                    'admin.add-category' => '<i class="fa-solid fa-folder mr-2"></i> Categories: New Category',
                    'admin.add-trainer' => '<i class="fa-solid fa-user-gear mr-2"></i> Users: Add Trainer',
                    'admin.all-students' => '<i class="fa-solid fa-user-gear mr-2"></i> Users: All Students',
                    'admin.all-registration-request' => '<i class="fa-solid fa-user-gear mr-2"></i> Users: All Registration Request',
                    'admin.filter-by-trainer' => '<i class="fa-solid fa-folder mr-2"></i> Categories: All Filtered Categories',
                    'admin.add-questionnaire' => '<i class="fa-solid fa-file-lines mr-2"></i> Questionnaires: New Questionnaire',
                    'trainer.dashboard' => '<i class="fa-solid fa-house-user mr-2"></i> Welcome to your Dashboard, Trainer',
                    'trainer.all-category' => '<i class="fa-solid fa-th-list mr-2"></i> All Categories',
                    'trainer.add-questionnaire' => '<i class="fa-solid fa-file-alt mr-2"></i> Add Questionnaire',
                    'profile' => '<i class="fa-solid fa-user-circle mr-2"></i> Your Profile'
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
                <span class="absolute top-0 right-0 inline-block w-4 h-4 bg-red-500 text-white text-xs font-bold rounded-full text-center transform translate-x-1/2 -translate-y-1/2">2</span>
            </a>
            
            <div id="notificationDropdown" class="hidden absolute z-10 right-0 mt-2 w-64 bg-white border border-gray-200 rounded-lg shadow-lg">
                <div class="p-4 font-semibold border-b border-gray-200">Notifications</div>
                <ul class="max-h-60 overflow-y-auto p-2"> <!-- Add max-height and overflow -->
                    <li class="p-2 hover:bg-gray-100">
                        <a href="#" class="block text-sm text-gray-700">Notification 1</a>
                    </li>
                </ul>
            </div>
        </div>

        <a href="{{route('profile')}}">
            <div class="flex items-center space-x-4 mr-4 relative">
                <span class="hidden text-right lg:block">
                    <span class="block text-sm font-medium text-black dark:text-black">Nigel</span>
                    <span class="block text-xs font-medium">Admin</span>
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
