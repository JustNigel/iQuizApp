<div class="bg-white shadow p-4 flex justify-between items-center font-satoshi">
    
    <div class="flex items-center border border-transparent rounded-lg p-1 w-1/3">
        <h2 class="text-xl font-semibold">Title</h2>
    </div>

    <!-- Notification Dropdown -->
    <div id="notificationDropdown" class="hidden absolute right-0 mt-2 w-64 bg-white border border-gray-200 rounded-lg shadow-lg">
        <div class="p-4 font-semibold border-b border-gray-200">Notifications</div>
        <ul class="p-2">
            <li class="p-2 hover:bg-gray-100">
                <a href="#" class="block text-sm text-gray-700">Notification 1</a>
            </li>
            <li class="p-2 hover:bg-gray-100">
                <a href="#" class="block text-sm text-gray-700">Notification 2</a>
            </li>
            <li class="p-2 hover:bg-gray-100">
                <a href="#" class="block text-sm text-gray-700">Notification 3</a>
            </li>
            <li class="p-2 hover:bg-gray-100">
                <a href="#" class="block text-sm text-gray-700">View All Notifications</a>
            </li>
        </ul>
    </div>

    <a href="{{route('profile')}}">
        <div class="flex items-center space-x-4 mr-4 relative">
            <a href="#" id="notificationBell" class="text-blue-500 hover:text-blue-700 relative">
                <i class="fas fa-bell fa-lg"></i>
                <span class="absolute top-0 right-0 inline-block w-4 h-4 bg-red-500 text-white text-xs font-bold rounded-full text-center transform translate-x-1/2 -translate-y-1/2">2</span>
            </a>
            <span class="hidden text-right lg:block">
                <span class="block text-sm font-medium text-black dark:text-black">{{ $user->name }}</span>
                <span class="block text-xs font-medium">{{ $user->type_name }}</span>
            </span>
            <img src="{{ asset('images/jameer.jpg') }}" alt="User" class="rounded-full w-10 h-10">
        </div>
    </a>
    
</div>

<script> 
    document.getElementById('notificationBell').addEventListener('click', function(event) {
        event.preventDefault();
        var dropdown = document.getElementById('notificationDropdown');
        dropdown.classList.toggle('hidden');
    });
</script>
