<div class="w-full bg-white rounded-lg p-6">
    <h4 class="text-xl font-semibold mb-4 border-b pb-2">Settings</h4>

    <div class="mb-6">
        <label class="block text-gray-800 font-medium mb-2">Variants</label>
        <select id="variant-select" class="w-full p-3 border rounded focus:ring-2 focus:ring-blue-500">
            <option value="multiple-choice">Multiple Choice</option>
            <option value="checkboxes">Checkboxes</option>
            <option value="text">Text</option>
            <option value="paragraph">Paragraph</option>
            <option value="drag-drop">Drag and Drop</option>
            <option value="matching">Matching Type</option>

        </select>
    </div>

    <div class="mb-6">
        <label class="block text-gray-800 font-medium mb-2">Points</label>
        <input type="number" class="w-full p-3 border rounded focus:ring-2 focus:ring-blue-500" value="1">
    </div>

    <div class="mb-6">
        <label class="block text-gray-800 font-medium mb-2">Group</label>
        <input type="text" class="w-full p-3 border rounded focus:ring-2 focus:ring-blue-500" placeholder="Group name">
    </div>

    <div class="flex items-center">
        <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
        <label class="ml-3 text-gray-800 font-medium">Auto Check</label>
    </div>
</div>
