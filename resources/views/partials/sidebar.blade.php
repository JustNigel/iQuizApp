<div x-data="{ openDropdown: null }" class="w-64 bg-custombg-gray text-custom-gray min-h-screen font-satoshi w-custom-sidebar-width flex flex-col">

    <div class="flex-grow">
        <div class="flex items-center justify-center mt-4 px-6 py-5.5 lg:py-6.5">
            <img src="{{ asset('/images/whitelogo2.png') }}" width="150" height="150" alt="logo">
        </div>
        <nav class="px-8 py-4 mt-8">
            <h3 class="mb-6 text-sm font-medium text-sidebar-menu">MENU</h3>
            <ul>
                
                <!-- STUDENT SIDE BAR -->
                @if (Auth::user()->type_name === 'student')

                <li class="py-2">
                    <a href="{{ route('dashboard') }}" class="block rounded p-2 space-x-2 hover:bg-gray-700 ease-in-out duration-200">
                        <i class="fa-solid fa-calendar-days"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="py-2">
                    <a href="{{ route('profile') }}" class="block rounded p-2 space-x-2 hover:bg-gray-700 ease-in-out duration-200">
                        <i class="fa-solid fa-user"></i>
                        <span>Profile</span>
                    </a>
                </li>
                <li x-data="{ open: false }" class="py-2">
                    <a href="#" @click="open = !open" class="block rounded flex items-center space-x-2 hover:bg-gray-700 p-2 ease-in-out duration-200">
                        <i class="fa-solid fa-gauge"></i>
                        <span>Category</span>
                        <svg x-bind:class="{ 'rotate-180': open }" class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="margin-left:auto">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </a>
                    <div x-show="open" class="ml-4 my-4 space-y-2" x-cloak>
                        <a href="{{ route('category.join') }}" class="block p-2 text-sm text-sidebar-menu hover:text-gray-300 hover:bg-gray-700 rounded ease-in-out duration-200">Join an exam</a>
                        <a href="{{ route('category.available-exams') }}" class="block p-2 text-sm text-sidebar-menu hover:text-gray-300 hover:bg-gray-700 rounded ease-in-out duration-200">Available Exams</a>
                    </div>
                </li>
                <li class="py-2">
                    <a href="{{ route('history') }}" class="block rounded p-2 space-x-2 hover:bg-gray-700 ease-in-out duration-200">
                        <i class="fa-solid fa-user"></i>
                        <span>History</span>
                    </a>
                </li>

                <!-- TRAINER SIDE BAR -->
                @elseif (Auth::user()->type_name === 'trainer')

                <li class="py-2">
                    <a href="{{ route('trainer.dashboard') }}" class="block rounded p-2 space-x-2 hover:bg-gray-700 ease-in-out duration-200">
                        <i class="fa-solid fa-calendar-days"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="py-2">
                    <a href="{{ route('profile') }}" class="block rounded p-2 space-x-2 hover:bg-gray-700 ease-in-out duration-200">
                        <i class="fa-solid fa-user"></i>
                        <span>Profile</span>
                    </a>
                </li>
                <li x-data="{ open: false }" class="py-2">
                    <a href="#" @click="open = !open" class="block rounded flex items-center space-x-2 hover:bg-gray-700 p-2 ease-in-out duration-200">
                        <i class="fa-solid fa-gauge"></i>
                        <span>Category</span>
                        <svg x-bind:class="{ 'rotate-180': open }" class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="margin-left:auto">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </a>
                    <div x-show="open" class="ml-4 my-4 space-y-2" x-cloak>
                        <a href="{{route('trainer.add-questionnaire')}}" class="block p-2 text-sm text-sidebar-menu hover:text-gray-300 hover:bg-gray-700 rounded ease-in-out duration-200">Add a Questionnaire</a>
                        <a href="{{route('trainer.all-category')}}" class="block p-2 text-sm text-sidebar-menu hover:text-gray-300 hover:bg-gray-700 rounded ease-in-out duration-200">View All Category</a>

                    </div>
                </li>
                <!-- ADMIN SIDE BAR -->
                @elseif (Auth::user()->type_name === 'admin')
                <!-- This is for the type_name column where 'admin' type can only access the following -->
                <!-- This serves as the middleware for each type name so it is easier to differentiate the routing making it clean and maintainable -->
                
                <li class="py-2">
                    <a href="{{route('admin.dashboard.dashboard')}}" class="block rounded p-2 space-x-2 hover:bg-gray-700 ease-in-out duration-200">
                        <i class="fa-solid fa-house"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="py-2">
                    <a href="#" @click="openDropdown === 1 ? openDropdown = null : openDropdown = 1" class="block rounded flex items-center space-x-2 hover:bg-gray-700 p-2 ease-in-out duration-200">
                        <i class="fa-solid fa-folder-open"></i>
                        <span>Categories</span>
                        <svg x-bind:class="{ 'rotate-180': openDropdown === 1 }" class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="margin-left:auto">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </a>
                    <div x-show="openDropdown === 1" class="ml-4 my-4 space-y-2" x-cloak>
                        <div class="flex items-center justify-between">
                            <a href="#" class="flex-grow block p-2 text-sm text-sidebar-menu hover:text-gray-300 hover:bg-gray-700 rounded-l ease-in-out duration-200">
                                Questionnaires
                            </a>
                            <a href="{{route('admin.add-questionnaire', ['from' => 'dashboard'])}}" class="p-2 text-sm text-sidebar-menu hover:text-gray-300 hover:bg-gray-700 rounded-r ease-in-out duration-200">
                                <i class="fa-solid fa-plus"></i>
                            </a>
                        </div>
                        <div class="flex items-center justify-between">
                            <a href="{{route('admin.all-category')}}" class="flex-grow block p-2 text-sm text-sidebar-menu hover:text-gray-300 hover:bg-gray-700 rounded-l ease-in-out duration-200">
                                Categories
                            </a>
                            <a href="{{route('admin.add-category', ['from' => 'dashboard'])}}" class="p-2 text-sm text-sidebar-menu hover:text-gray-300 hover:bg-gray-700 rounded-r ease-in-out duration-200">
                                <i class="fa-solid fa-plus"></i>
                            </a>
                        </div>

                        <a href="{{route('admin.all-exam-request')}}" class="block p-2 text-sm text-sidebar-menu hover:text-gray-300 hover:bg-gray-700 rounded ease-in-out duration-200 relative">
                            <span>Exam Requests</span>
                            <!-- Red dot for notification -->
                            @if ($pendingRequestsCount > 0)
                                <span class="absolute top-0 right-0 mt-2 mr-2 flex items-center justify-center w-5 h-5 bg-red-600 text-white text-xs rounded-full">
                                    {{ $pendingRequestsCount }}
                                </span>
                            @endif
                        </a>
                    </div>
                </li>
                <li class="py-2">
                    <a href="#" @click="openDropdown === 2 ? openDropdown = null : openDropdown = 2" class="block rounded flex items-center space-x-2 hover:bg-gray-700 p-2 ease-in-out duration-200">
                        <i class="fa-solid fa-gauge"></i>
                        <span>Manage Users</span>
                        <svg x-bind:class="{ 'rotate-180': openDropdown === 2 }" class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="margin-left:auto">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </a>
                    <div x-show="openDropdown === 2" class="ml-4 my-4 space-y-2" x-cloak>
                        <a href="{{route('admin.add-trainer')}}" class="block p-2 text-sm text-sidebar-menu hover:text-gray-300 hover:bg-gray-700 rounded ease-in-out duration-200"><i class="fa-solid fa-user-plus"></i> Add a Trainer</a>
                        <a href="{{route('admin.all-trainers')}}" class="block p-2 text-sm text-sidebar-menu hover:text-gray-300 hover:bg-gray-700 rounded ease-in-out duration-200">View all Trainers</a>
                        <a href="{{route('admin.all-registration-request')}}" class="block p-2 text-sm text-sidebar-menu hover:text-gray-300 hover:bg-gray-700 rounded ease-in-out duration-200 relative">
                            <span>View all Requests</span>
                            <!-- Red dot for notification -->
                            @if ($pendingRegRequestsCount > 0)
                                <span class="absolute top-0 right-0 mt-2 mr-2 flex items-center justify-center w-5 h-5 bg-red-600 text-white text-xs rounded-full">
                                    {{ $pendingRegRequestsCount }}
                                </span>
                            @endif
                        </a>
                        <a href="{{route('admin.all-students')}}" class="block p-2 text-sm text-sidebar-menu hover:text-gray-300 hover:bg-gray-700 rounded ease-in-out duration-200">View all Students</a>
                    </div>
                </li>
                @endif

            </ul>
        </nav>
    </div>

    <div class="w-64 bg-custombg-gray text-custom-gray py-4 shadow-md fixed bottom-0 left-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="block w-full rounded p-2 space-x-2 bg-red-400 text-white hover:bg-red-600 ease-in-out duration-200">
                <i class="fa-solid fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>

</div>
