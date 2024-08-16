<div class="bg-white shadow p-4 flex justify-between items-center font-satoshi">
    
    <div class="flex items-center border border-transparent rounded-lg p-1 w-1/3">
        <h2 class="text-xl font-semibold">Title</h2>
    </div>

    <a href="{{route('profile')}}">
        <div class="flex items-center space-x-4 mr-4">
            <span class="hidden text-right lg:block">
                <span class="block text-sm font-medium text-black dark:text-black">{{ $user->name }}</span>
                <span class="block text-xs font-medium">{{ $user->type_name }}</span>
            </span>
            <img src="{{ asset('images/jameer.jpg') }}" alt="User" class="rounded-full w-10 h-10">
        </div>
    </a>
    
</div>
