<div class="w-64 bg-white border-l p-4 rounded-lg shadow-lg h-full overflow-y-auto">
    <h3 class="text-lg font-semibold mb-4 text-center">Questions</h3>
    <ul class="space-y-2">
        @for ($i = 1; $i <= 50; $i++)
            <li>
                <button class="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 rounded-lg shadow-md text-center transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Question {{ $i }}
                </button>
            </li>
        @endfor
    </ul>
</div>
