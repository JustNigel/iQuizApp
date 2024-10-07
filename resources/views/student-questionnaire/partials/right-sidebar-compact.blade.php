<div class="w-64 bg-white border-l p-4 rounded-lg shadow-lg h-full overflow-y-auto">
    <h3 class="text-lg font-semibold mb-4 text-center">Questions</h3>
    <div class="grid grid-cols-5 gap-3">
        @for ($i = 1; $i <= 50; $i++)
            <button class="w-8 h-8 bg-gray-200 hover:bg-gray-300 text-md text-gray-800 rounded-lg shadow-md text-center transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                {{ $i }}
            </button>
        @endfor
    </div>
</div>
