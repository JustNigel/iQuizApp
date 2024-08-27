<div class="w-64 bg-custombg-gray text-custom-gray min-h-screen font-satoshi w-custom-sidebar-width flex flex-col">

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
                        <a href="#" class="block p-2 text-sm text-sidebar-menu hover:text-gray-300 hover:bg-gray-700 rounded ease-in-out duration-200">Add a Questionnaire</a>
                        <a href="{{route('trainer.all-category')}}" class="block p-2 text-sm text-sidebar-menu hover:text-gray-300 hover:bg-gray-700 rounded ease-in-out duration-200">View All Category</a>

                    </div>
                </li>

                <!-- ADMIN SIDE BAR -->
                @elseif (Auth::user()->type_name === 'admin') 

                <!-- This is for the type_name column where 'admin' type can only access the following -->
                <!-- This serves as the middleware for each type name so it is easier to differentiate the routing making it clean and maintainable -->
                
                    <li class="py-2">
                        <a href="{{route('admin.dashboard.dashboard')}}" class="block rounded p-2 space-x-2 hover:bg-gray-700 ease-in-out duration-200">
                            <i class="fa-solid fa-calendar-days"></i>
                            <span>Dashboard</span>
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
                            <a href="{{route('admin.add-questionnaire')}}" class="block p-2 text-sm text-sidebar-menu hover:text-gray-300 hover:bg-gray-700 rounded ease-in-out duration-200">Add a questionnaire</a>
                            <a href="{{route('admin.add-category')}}" class="block p-2 text-sm text-sidebar-menu hover:text-gray-300 hover:bg-gray-700 rounded ease-in-out duration-200">Add a category</a>
                            <a href="{{route('admin.all-category')}}" class="block p-2 text-sm text-sidebar-menu hover:text-gray-300 hover:bg-gray-700 rounded ease-in-out duration-200">View all category</a>
                        </div>
                    </li>
                    <li x-data="{ open: false }" class="py-2">
                        <a href="#" @click="open = !open" class="block rounded flex items-center space-x-2 hover:bg-gray-700 p-2 ease-in-out duration-200">
                            <i class="fa-solid fa-gauge"></i>
                            <span>Manage Users</span>
                            <svg x-bind:class="{ 'rotate-180': open }" class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="margin-left:auto">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </a>
                        <div x-show="open" class="ml-4 my-4 space-y-2" x-cloak>
                            <a href="{{route('admin.add-trainer')}}" class="block p-2 text-sm text-sidebar-menu hover:text-gray-300 hover:bg-gray-700 rounded ease-in-out duration-200">Add a Trainers</a>
                            <a href="{{route('admin.all-trainers')}}" class="block p-2 text-sm text-sidebar-menu hover:text-gray-300 hover:bg-gray-700 rounded ease-in-out duration-200">View all Trainers</a>
                            <a href="{{route('admin.all-registration-request')}}" class="block p-2 text-sm text-sidebar-menu hover:text-gray-300 hover:bg-gray-700 rounded ease-in-out duration-200">View all Requests</a>
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
